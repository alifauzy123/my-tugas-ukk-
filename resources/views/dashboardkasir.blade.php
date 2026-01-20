@extends('layouts.layoutkasir')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    dd(Auth::guard('kasir')->user());

    {{-- Grafik Pesanan --}}
    {{-- <div class="bg-white rounded shadow p-4 mb-6">
      <h1 class="text-xl font-bold mb-4">Grafik Pesanan</h1>
        <canvas id="pesananChart" height="120"></canvas>
    </div> --}}

    {{-- Statistik --}}
    {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-white">
        <div class="bg-[#b31616] p-4 rounded shadow">
            <h2 class="text-lg font-bold">Total Produk</h2>
            <p class="text-2xl">{{ $totalProduk }}</p>
        </div>
        <div class="bg-[#b31616] p-4 rounded shadow">
            <h2 class="text-lg font-bold">Total Stok</h2>
            <p class="text-2xl">{{ $totalStok }}</p>
        </div>
        <div class="bg-[#b31616] p-4 rounded shadow">
            <h2 class="text-lg font-bold">Pesanan Hari Ini</h2>
            <p class="text-2xl">{{ $pesananHariIni }}</p>
        </div>
    </div> --}}
    <p>mas amba</p>
</div>

<style>
    body {
        overflow-x: hidden;
    }
</style>

@endsection

{{-- @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const data = {
        labels: {!! json_encode($pesananChart->pluck('tanggal')) !!},
        datasets: [{
            label: 'Jumlah Pesanan',
            data: {!! json_encode($pesananChart->pluck('jumlah')) !!},
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            fill: true,
            tension: 0.4
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    };

    new Chart(document.getElementById('pesananChart'), config);
</script>
@endpush
   --}}