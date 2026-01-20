@extends('layouts.app')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">

    <!-- Header Merah -->
    <div class="rounded-t-md py-4 px-6 mt-6">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('ulasan.index') }}" class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Transaksi Ulasan</h1>
                <p class="text-[#FFEBEE]">Detail data</p>
            </div>
        </div>
    </div>

    <!-- Form Putih (Read-Only) -->
    <div class="bg-white text-gray-700 px-6 py-6 rounded-b-md">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="text-sm font-bold">Kode Ulasan</label>
                <input type="text" readonly value="{{ $ulasan->kode_ulasan }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Produk</label>
                <input type="text" readonly value="{{ $ulasan->produk->kode_produk ?? '-' }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Pelanggan</label>
                <input type="text" readonly value="{{ $ulasan->pelanggan->kode_pelanggan ?? '-' }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Rating</label>
                <input type="text" readonly value="{{ $ulasan->rating }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Tanggal</label>
                <input type="text" readonly value="{{ $ulasan->tanggal }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Status</label>
                <input type="text" readonly value="{{ $ulasan->status }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Komentar</label>
                <textarea readonly class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600" rows="4">{{ $ulasan->komentar }}</textarea>
            </div>

        </div>
    </div>
</div>
@endsection
