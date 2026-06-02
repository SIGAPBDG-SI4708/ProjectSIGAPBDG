<?php

namespace App\Services;

use App\Models\AnalisisAi;
use App\Models\LaporanInfrastruktur;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class LayananSimulasiAi
{
    public static function prosesAnalisis($idLaporan, $pathFoto)
    {
        $laporanTarget = LaporanInfrastruktur::find($idLaporan);

        if (!$laporanTarget) {
            AnalisisAi::create([
                'id_laporan' => $idLaporan,
                'is_spam'    => true,
            ]);
            return;
        }

        $isiFileFoto   = Storage::disk('public')->get($pathFoto);
        $gambarBase64  = base64_encode($isiFileFoto);
        $tipeGambar    = 'image/jpeg';
        $dataUriGambar = 'data:' . $tipeGambar . ';base64,' . $gambarBase64;

        $promptAnalisis = 'Kamu AI pendeteksi infrastruktur jalan rusak. Cek gambar ini. Jika gambar ini adalah wajah manusia, selfie, hewan, pemandangan, atau ruangan, set is_spam = true. Jika gambar ini adalah jalan rusak/infrastruktur rusak sungguhan, set is_spam = false. Kembalikan JSON dengan key: is_spam (boolean), jenis_kerusakan (string), tingkat_keparahan (string: Ringan/Sedang/Berat), estimasi_biaya (integer harga Rupiah).';

        try {
            $responsOpenAi = Http::withToken(env('OPENAI_API_KEY'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model'           => 'gpt-4o',
                    'response_format' => ['type' => 'json_object'],
                    'messages'        => [
                        [
                            'role'    => 'user',
                            'content' => [
                                [
                                    'type'      => 'image_url',
                                    'image_url' => [
                                        'url' => $dataUriGambar,
                                    ],
                                ],
                                [
                                    'type' => 'text',
                                    'text' => $promptAnalisis,
                                ],
                            ],
                        ],
                    ],
                ]);

            $isiRespons    = $responsOpenAi->json();
            $teksJson      = $isiRespons['choices'][0]['message']['content'] ?? '{}';
            $hasilAnalisis = json_decode($teksJson, true) ?? [];

            $adaSpam          = $hasilAnalisis['is_spam'] ?? true;
            $jenisKerusakan   = $hasilAnalisis['jenis_kerusakan'] ?? null;
            $tingkatKeparahan = $hasilAnalisis['tingkat_keparahan'] ?? null;
            $estimasiBiaya    = $hasilAnalisis['estimasi_biaya'] ?? null;

            AnalisisAi::create([
                'id_laporan'        => $idLaporan,
                'is_spam'           => $adaSpam,
                'jenis_kerusakan'   => $jenisKerusakan,
                'tingkat_keparahan' => $tingkatKeparahan,
                'estimasi_biaya'    => $estimasiBiaya,
            ]);

            if ($adaSpam) {
                $laporanTarget->update(['status' => 'Ditolak']);
            }
        } catch (\Exception $e) {
            AnalisisAi::create([
                'id_laporan' => $idLaporan,
                'is_spam'    => true,
            ]);
            $laporanTarget->update(['status' => 'Ditolak']);
        }
    }
}