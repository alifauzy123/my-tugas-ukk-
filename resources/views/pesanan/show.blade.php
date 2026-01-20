@extends('layouts.layoutkasir')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('pesanan.index') }}" class="p-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan</h1>
            <p class="text-gray-500 mt-2">{{ $pesanan->kode_pesanan }}</p>
        </div>
    </div>

    {{-- Status Badge --}}
    <div class="mb-6">
        @php
            $statusColor = match($pesanan->status) {
                'Pending' => 'bg-amber-100 text-amber-800',
                'Diproses' => 'bg-blue-100 text-blue-800',
                'Selesai' => 'bg-green-100 text-green-800',
                default => 'bg-gray-100 text-gray-800'
            };
        @endphp
        <span class="px-4 py-2 rounded-full font-semibold text-sm {{ $statusColor }}">
            <i class="fas fa-info-circle mr-2"></i>{{ $pesanan->status }}
        </span>
    </div>

    {{-- Detail Card --}}
    <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Kode Pesanan --}}
            <div class="pb-6 border-b md:border-b-0 md:border-r border-gray-200">
                <p class="text-gray-500 text-sm mb-2">Kode Pesanan</p>
                <p class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-barcode text-blue-500"></i>
                    {{ $pesanan->kode_pesanan }}
                </p>
            </div>

            {{-- Tanggal --}}
            <div class="pb-6 border-b md:border-b-0 border-gray-200">
                <p class="text-gray-500 text-sm mb-2">Tanggal Pesanan</p>
                <p class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-calendar text-green-500"></i>
                    {{ \Carbon\Carbon::parse($pesanan->tanggal)->format('d M Y') }}
                </p>
            </div>

            {{-- Pelanggan --}}
            <div class="pb-6 border-b md:border-b-0 md:border-r border-gray-200">
                <p class="text-gray-500 text-sm mb-2">Pelanggan</p>
                <p class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-user text-purple-500"></i>
                    {{ $pesanan->pelanggan->nama_pelanggan }}
                </p>
            </div>

            {{-- Kasir --}}
            <div class="pb-6 border-b md:border-b-0 border-gray-200">
                <p class="text-gray-500 text-sm mb-2">Kasir</p>
                <p class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-cash-register text-orange-500"></i>
                    {{ $pesanan->kasir->nama_kasir }}
                </p>
            </div>
        </div>

        {{-- Catatan Section --}}
        @if($pesanan->catatan)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-gray-500 text-sm mb-3">Catatan</p>
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded">
                    <p class="text-gray-700">{{ $pesanan->catatan }}</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Action Buttons --}}
    <div class="flex gap-3 justify-end">
        <x-button variant="secondary" href="{{ route('pesanan.index') }}">
            <i class="fas fa-arrow-left"></i> Kembali
        </x-button>
        <x-button variant="primary" href="{{ route('pesanan.edit', $pesanan->id) }}">
            <i class="fas fa-edit"></i> Edit
        </x-button>
    </div>
</div>
@endsection
 