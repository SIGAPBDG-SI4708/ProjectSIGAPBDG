@extends('admin.layout')

@section('judulHalaman', 'Beranda')
@section('subjudulHalaman', 'Ringkasan aktivitas laporan di wilayah Anda')

@section('konten')
    <div class="space-y-6">

        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 bg-brand-50 dark:bg-brand-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $totalLaporan }}</div>
                <div class="text-xs text-slate-400 dark:text-slate-500 mt-1 font-medium">Total Laporan</div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-amber-500">{{ $totalMenunggu }}</div>
                <div class="text-xs text-slate-400 dark:text-slate-500 mt-1 font-medium">Menunggu</div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 bg-brand-50 dark:bg-brand-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-brand-500">{{ $totalProses }}</div>
                <div class="text-xs text-slate-400 dark:text-slate-500 mt-1 font-medium">Diproses</div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-emerald-500">{{ $totalSelesai }}</div>
                <div class="text-xs text-slate-400 dark:text-slate-500 mt-1 font-medium">Selesai</div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-red-500">{{ $totalDitolak }}</div>
                <div class="text-xs text-slate-400 dark:text-slate-500 mt-1 font-medium">Ditolak</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                    Tren Laporan Masuk (7 Hari)
                </h3>
                <div class="relative w-full h-64">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Rekap Keuangan Pengajuan Dana
                </h3>
                <div class="relative w-full h-64 flex justify-center">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <div class="text-sm font-bold text-slate-800 dark:text-white">Laporan Terbaru</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">5 laporan infrastruktur terkini</div>
                </div>
                <a href="{{ route('admin.laporan.indeks') }}"
                    class="text-xs text-brand-600 dark:text-brand-400 hover:text-brand-700 font-semibold transition flex items-center gap-1">
                    Lihat semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if($laporanTerbaru->isEmpty())
                <div class="py-14 text-center">
                    <div
                        class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="text-slate-500 dark:text-slate-400 text-sm font-medium">Belum ada laporan</div>
                    <div class="text-slate-400 dark:text-slate-600 text-xs mt-1">Laporan baru dari warga akan muncul di sini
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                                <th
                                    class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3">
                                    Tracking ID</th>
                                <th
                                    class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3">
                                    Daerah</th>
                                <th
                                    class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3">
                                    Status</th>
                                <th
                                    class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3">
                                    Waktu</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($laporanTerbaru as $laporan)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="px-5 py-3.5">
                                        <span
                                            class="font-mono text-xs text-brand-600 dark:text-brand-400 font-bold bg-brand-50 dark:bg-brand-900/30 px-2 py-1 rounded-lg">{{ $laporan->tracking_id }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 text-xs">
                                        {{ $laporan->daerah->nama_daerah ?? '-' }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span
                                            class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                                                                                            {{ $laporan->status === 'Menunggu' ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-800' : '' }}
                                                                                            {{ $laporan->status === 'Proses' ? 'bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400 border border-brand-100 dark:border-brand-800' : '' }}
                                                                                            {{ $laporan->status === 'Selesai' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800' : '' }}
                                                                                            {{ $laporan->status === 'Ditolak' ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800' : '' }}">
                                            <span
                                                class="w-1.5 h-1.5 rounded-full
                                                                                                {{ $laporan->status === 'Menunggu' ? 'bg-amber-400 animate-pulse' : '' }}
                                                                                                {{ $laporan->status === 'Proses' ? 'bg-brand-400' : '' }}
                                                                                                {{ $laporan->status === 'Selesai' ? 'bg-emerald-400' : '' }}
                                                                                                {{ $laporan->status === 'Ditolak' ? 'bg-red-400' : '' }}">
                                            </span>
                                            {{ $laporan->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-slate-400 dark:text-slate-500 text-xs">
                                        {{ $laporan->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <a href="{{ route('admin.laporan.detail', $laporan->id) }}"
                                            class="text-xs text-brand-600 dark:text-brand-400 hover:text-brand-700 font-semibold transition">Detail
                                            →</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#94a3b8' : '#64748b';
            const gridColor = isDark ? '#1e293b' : '#f1f5f9';

            Chart.defaults.color = textColor;
            Chart.defaults.font.family = "'Outfit', sans-serif";

            const trendCtx = document.getElementById('trendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartTrendLabels) !!},
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: {!! json_encode($chartTrendData) !!},
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: '#ea580c',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#f97316',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, precision: 0 },
                            grid: { color: gridColor, drawBorder: false }
                        },
                        x: {
                            grid: { display: false, drawBorder: false }
                        }
                    }
                }
            });

            const financeCtx = document.getElementById('financeChart').getContext('2d');
            new Chart(financeCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Disetujui', 'Menunggu', 'Ditolak'],
                    datasets: [{
                        data: [{!! $danaDisetujui !!}, {!! $danaMenunggu !!}, {!! $danaDitolak !!}],
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });


        });
    </script>
@endsection