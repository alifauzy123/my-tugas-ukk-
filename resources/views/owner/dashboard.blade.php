@extends('layouts.layoutowner')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Owner</h1>
        <p class="text-gray-500 mt-2">Ringkasan transaksi berdasarkan rentang tanggal.</p>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <x-stat-card 
            title="Total Menu" 
            value="{{ $totalMenu }}" 
            icon="fa-utensils"
            color="blue"
            trend="{{ round($trendMenu, 2) }}" />
        
        <x-stat-card 
            title="Transaksi Hari Ini" 
            value="{{ $transaksiHariIni }}" 
            icon="fa-receipt"
            color="purple"
            trend="{{ round($trendTransaksi, 2) }}" />
        
        <x-stat-card 
            title="Pendapatan Hari Ini" 
            value="Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}" 
            icon="fa-money-bill-wave"
            color="amber"
            trend="{{ round($trendPendapatan, 2) }}" />
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Grafik Transaksi</h2>
                <p class="text-gray-500 text-sm mt-1">Tren transaksi sesuai filter</p>
            </div>
        </div>

        <form method="GET" action="{{ route('dashboardowner') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="text-xs text-gray-500">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate ?? '' }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="text-xs text-gray-500">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate ?? '' }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div class="flex items-end gap-2">
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">Tampilkan</button>
                <a href="{{ route('dashboardowner') }}" class="px-4 py-2 border border-red-600 text-red-600 rounded-lg text-sm hover:bg-red-50">Reset</a>
            </div>
        </form>

        <canvas id="transaksiChart" height="100"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const data = {
        labels: {!! json_encode($transaksiChart->pluck('tanggal')) !!},
        datasets: [{
            label: 'Jumlah Transaksi',
            data: {!! json_encode($transaksiChart->pluck('jumlah')) !!},
            backgroundColor: 'rgba(37, 99, 235, 0.35)',
            borderColor: 'rgba(37, 99, 235, 1)',
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

    new Chart(document.getElementById('transaksiChart'), config);
</script>
@endpush
