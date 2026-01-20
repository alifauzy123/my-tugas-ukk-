@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500 mt-2">Selamat datang kembali! Berikut ringkasan data Anda hari ini.</p>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Produk" 
            value="{{ $totalProduk }}" 
            icon="fa-box"
            color="blue"
            trend="12" />
        
        <x-stat-card 
            title="Total Stok" 
            value="{{ $totalStok }}" 
            icon="fa-cubes"
            color="green"
            trend="8" />
        
        <x-stat-card 
            title="Pesanan Hari Ini" 
            value="{{ $pesananHariIni }}" 
            icon="fa-shopping-cart"
            color="purple"
            trend="15" />
        
        <x-stat-card 
            title="Total Revenue" 
            value="Rp 45.2M" 
            icon="fa-money-bill-wave"
            color="amber"
            trend="-5" />
    </div>

    {{-- Grafik Pesanan --}}
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Grafik Pesanan</h2>
                <p class="text-gray-500 text-sm mt-1">Tren pesanan 7 hari terakhir</p>
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">7 Hari</button>
                <button class="px-3 py-1.5 text-xs font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg">30 Hari</button>
            </div>
        </div>
        <canvas id="pesananChart" height="100"></canvas>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:scale-105 cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-blue-100 rounded-lg">
                    <i class="fas fa-plus text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Tambah Produk</h3>
                    <p class="text-gray-500 text-sm">Buat produk baru</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:scale-105 cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-green-100 rounded-lg">
                    <i class="fas fa-receipt text-green-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Pesanan Baru</h3>
                    <p class="text-gray-500 text-sm">Buat pesanan</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:scale-105 cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-purple-100 rounded-lg">
                    <i class="fas fa-file-excel text-purple-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Export Laporan</h3>
                    <p class="text-gray-500 text-sm">Unduh data</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        overflow-x: hidden;
    }
</style>

@endsection

@push('scripts')
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
  