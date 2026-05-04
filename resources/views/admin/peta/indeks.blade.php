@extends('admin.layout')

@section('judulHalaman', 'Peta Kerawanan')
@section('subjudulHalaman', 'Heatmap titik kejahatan di wilayah Kota Bandung')

@section('konten')
<div class="space-y-5">

    <div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-white/5 flex items-center justify-between">
            <div>
                <div class="text-sm font-bold text-white">Heatmap Titik Kejahatan</div>
                <div class="text-xs text-gray-500 mt-0.5">Data real-time dari laporan panic button warga</div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                    <span class="w-3 h-3 rounded-full bg-blue-400 opacity-60"></span> Rendah
                </div>
                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                    <span class="w-3 h-3 rounded-full bg-yellow-400"></span> Sedang
                </div>
                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span> Tinggi
                </div>
            </div>
        </div>
        <div id="kotakPeta" style="height: 580px; width: 100%;"></div>
    </div>

    <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
        <div class="text-xs text-gray-500 text-center">
            Data kejahatan diperbarui setiap kali warga menekan tombol panic button dari halaman utama. Koordinat tercatat otomatis via GPS.
        </div>
    </div>

</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>

<style>
    #kotakPeta .leaflet-container { background: #0f172a; }
</style>

<script>
(function() {
    var petaBandung = L.map('kotakPeta', {
        center: [-6.917464, 107.619123],
        zoom: 12,
        zoomControl: true
    });

    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://carto.com/">CARTO</a>',
        maxZoom: 19
    }).addTo(petaBandung);

    var lapisanPanas = L.heatLayer([], {
        radius: 28,
        blur: 18,
        maxZoom: 15,
        gradient: { 0.3: '#3b82f6', 0.6: '#f59e0b', 1.0: '#ef4444' }
    }).addTo(petaBandung);

    fetch('{{ route("admin.api.titik-kejahatan") }}', {
        headers: { 'Accept': 'application/json' }
    })
    .then(function(responApi) { return responApi.json(); })
    .then(function(daftarTitik) {
        var titikPanas = daftarTitik.map(function(titik) {
            return [parseFloat(titik.latitude), parseFloat(titik.longitude), 1.0];
        });
        lapisanPanas.setLatLngs(titikPanas);

        if (titikPanas.length > 0) {
            var batasPeta = L.latLngBounds(titikPanas.map(function(t) { return [t[0], t[1]]; }));
            petaBandung.fitBounds(batasPeta, { padding: [40, 40] });
        }
    });
})();
</script>
@endsection