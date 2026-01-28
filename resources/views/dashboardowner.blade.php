@extends('layouts.layoutowner')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6 mb-6 border border-red-100">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Owner</h1>
                <p class="text-sm text-gray-500">Tampilan sementara untuk uji coba akses owner.</p>
            </div>
            <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">TEST</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow p-5 border border-red-50">
            <p class="text-xs text-gray-500">Total Produk</p>
            <p class="text-lg font-semibold text-gray-800">{{ $totalProduk ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border border-red-50">
            <p class="text-xs text-gray-500">Total Stok</p>
            <p class="text-lg font-semibold text-gray-800">{{ $totalStok ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border border-red-50">
            <p class="text-xs text-gray-500">Pesanan Hari Ini</p>
            <p class="text-lg font-semibold text-gray-800">{{ $pesananHariIni ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border border-red-50">
            <p class="text-xs text-gray-500">Total Revenue</p>
            <p class="text-lg font-semibold text-gray-800">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>
</div>
@endsection
