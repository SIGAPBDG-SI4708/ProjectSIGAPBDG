<?php

/**
 * ============================================================
 * Skenario 1: Pelaporan & AI (Warga Publik)
 * ============================================================
 *
 * Test suite ini mencakup alur pelaporan infrastruktur oleh
 * warga publik, termasuk integrasi AI (OpenAI) dan Geocoding
 * (Nominatim API). Semua panggilan HTTP eksternal di-mock
 * menggunakan Http::fake() agar tidak memakan kuota asli.
 */

use App\Models\Daerah;
use App\Models\LaporanInfrastruktur;
use App\Models\AnalisisAi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

// ─────────────────────────────────────────────────────────────
// Helper: Respon Nominatim palsu (geocoding sukses)
// ─────────────────────────────────────────────────────────────
function nominatimResponseFake(string $kecamatan = 'Coblong'): array
{
    return [
        'address' => [
            'subdistrict' => 'Kecamatan ' . $kecamatan,
            'city'        => 'Bandung',
            'country'     => 'Indonesia',
        ],
    ];
}

// ─────────────────────────────────────────────────────────────
// Helper: Respon OpenAI palsu untuk BUKAN spam
// ─────────────────────────────────────────────────────────────
function openAiResponseValid(): array
{
    return [
        'choices' => [
            [
                'message' => [
                    'content' => json_encode([
                        'is_spam'           => false,
                        'jenis_kerusakan'   => 'Jalan Berlubang',
                        'tingkat_keparahan' => 'Sedang',
                        'estimasi_biaya'    => 5000000,
                    ]),
                ],
            ],
        ],
    ];
}

// ─────────────────────────────────────────────────────────────
// Helper: Respon OpenAI palsu untuk SPAM
// ─────────────────────────────────────────────────────────────
function openAiResponseSpam(): array
{
    return [
        'choices' => [
            [
                'message' => [
                    'content' => json_encode([
                        'is_spam'           => true,
                        'jenis_kerusakan'   => null,
                        'tingkat_keparahan' => null,
                        'estimasi_biaya'    => null,
                    ]),
                ],
            ],
        ],
    ];
}

// ─────────────────────────────────────────────────────────────
// SETUP: Fake disk & fake event/notification untuk semua test
// ─────────────────────────────────────────────────────────────
beforeEach(function () {
    Storage::fake('public');
    Event::fake();
    Notification::fake();
});

// ─────────────────────────────────────────────────────────────
// TEST 1: Halaman beranda publik bisa diakses
// ─────────────────────────────────────────────────────────────
it('can load beranda publik', function () {
    $response = $this->get(route('beranda'));

    $response->assertStatus(200);
});

// ─────────────────────────────────────────────────────────────
// TEST 2: Submit laporan valid → tracking ID berhasil dibuat
// OpenAI mock: bukan spam
// Nominatim mock: mengembalikan nama kecamatan yang cocok di DB
// ─────────────────────────────────────────────────────────────
it('can submit valid laporan and generate tracking id', function () {
    // Buat data daerah yang cocok dengan respon Nominatim
    $daerah = Daerah::factory()->create(['nama_daerah' => 'Coblong']);

    Http::fake([
        // Mock Nominatim → kembalikan kecamatan Coblong
        'nominatim.openstreetmap.org/*' => Http::response(nominatimResponseFake('Coblong'), 200),
        // Mock OpenAI → bukan spam
        'api.openai.com/*' => Http::response(openAiResponseValid(), 200),
    ]);

    $fotoFake = UploadedFile::fake()->image('jalan-rusak.jpg', 640, 480);

    $response = $this->post(route('proses.laporan'), [
        'foto'      => $fotoFake,
        'latitude'  => -6.8921,
        'longitude' => 107.6107,
    ]);

    // Harus redirect back dengan session flash trackingBerhasil
    $response->assertSessionHas('trackingBerhasil');

    // Tracking ID harus tersimpan di database
    $trackingId = session('trackingBerhasil');
    expect($trackingId)->toStartWith('SIGAP-');

    $this->assertDatabaseHas('laporan_infrastruktur', [
        'tracking_id' => $trackingId,
        'id_daerah'   => $daerah->id,
        'status'      => 'Menunggu',
    ]);

    // Analisis AI harus tersimpan dengan is_spam = false
    $laporan = LaporanInfrastruktur::where('tracking_id', $trackingId)->first();
    $this->assertDatabaseHas('analisis_ai', [
        'id_laporan'      => $laporan->id,
        'is_spam'         => false,
        'jenis_kerusakan' => 'Jalan Berlubang',
    ]);

    // Poin kontribusi harus tercatat
    $this->assertDatabaseHas('poin_kontribusi_daerah', [
        'id_daerah' => $daerah->id,
        'poin'      => 10,
        'kategori'  => 'Laporan Baru',
    ]);
});

// ─────────────────────────────────────────────────────────────
// TEST 3: Submit laporan dengan foto spam → status ditolak
// OpenAI mock: is_spam = true
// ─────────────────────────────────────────────────────────────
it('rejects spam photo submission', function () {
    $daerah = Daerah::factory()->create(['nama_daerah' => 'Antapani']);

    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response(nominatimResponseFake('Antapani'), 200),
        // Mock OpenAI → spam!
        'api.openai.com/*' => Http::response(openAiResponseSpam(), 200),
    ]);

    $fotoFake = UploadedFile::fake()->image('selfie.jpg', 640, 480);

    $response = $this->post(route('proses.laporan'), [
        'foto'      => $fotoFake,
        'latitude'  => -6.9,
        'longitude' => 107.6,
    ]);

    // Harus redirect back dengan session flash trackingBerhasil
    $response->assertSessionHas('trackingBerhasil');

    $trackingId = session('trackingBerhasil');

    // Status laporan harus "Ditolak" setelah AI mendeteksi spam
    $this->assertDatabaseHas('laporan_infrastruktur', [
        'tracking_id' => $trackingId,
        'status'      => 'Ditolak',
    ]);

    // Analisis AI harus tercatat sebagai spam
    $laporan = LaporanInfrastruktur::where('tracking_id', $trackingId)->first();
    $this->assertDatabaseHas('analisis_ai', [
        'id_laporan' => $laporan->id,
        'is_spam'    => true,
    ]);
});

// ─────────────────────────────────────────────────────────────
// TEST 4: Warga bisa mencari laporan berdasarkan tracking ID
// ─────────────────────────────────────────────────────────────
it('can search tracking id', function () {
    $daerah  = Daerah::factory()->create();
    $laporan = LaporanInfrastruktur::create([
        'id_daerah'   => $daerah->id,
        'tracking_id' => 'SIGAP-ABCDEF',
        'latitude'    => -6.9,
        'longitude'   => 107.6,
        'foto_awal'   => 'laporan/dummy.jpg',
        'hash_foto'   => md5('dummy'),
        'status'      => 'Menunggu',
    ]);

    $response = $this->post(route('proses.lacak'), [
        'tracking_id' => 'SIGAP-ABCDEF',
    ]);

    $response->assertStatus(200);
    $response->assertViewHas('dataLaporan', function ($data) use ($laporan) {
        return $data !== null && $data->id === $laporan->id;
    });
    $response->assertViewHas('kodeLacak', 'SIGAP-ABCDEF');
});
