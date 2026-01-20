@extends('layouts.layoutkasir')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">

    <!-- Header Merah -->
    <div class="rounded-t-md py-4 px-6 mt-6">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('detail_pesanan.index') }}" class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Transaksi Pesanan</h1>
                <p class="text-[#FFEBEE]">Detail Data</p>
            </div>
        </div>
    </div>

    <!-- Form Putih (Read-Only) -->
    <div class="bg-white text-gray-700 px-6 py-6 rounded-b-md">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="text-sm font-bold">Kode Detail Pesanan</label>
                <input type="text" readonly value="{{ $detail->kode_detail_pesanan }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Kode Pesanan</label>
                <input type="text" readonly value="{{ $detail->pesanan->kode_pesanan ?? '-' }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Kode Produk</label>
                <input type="text" readonly value="{{ $detail->produk->kode_produk ?? '-' }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Jumlah (Qty)</label>
                <input type="text" readonly value="{{ $detail->qty }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Harga</label>
                <input type="text" readonly value="Rp{{ number_format($detail->harga, 0, ',', '.') }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Diskon</label>
                <input type="text" readonly value="Rp{{ number_format($detail->diskon, 0, ',', '.') }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Subtotal</label>
                <input type="text" readonly value="Rp{{ number_format($detail->subtotal, 0, ',', '.') }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

        </div>
    </div>
</div>
@endsection
