@extends('layouts.layoutkasir')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">
    <div class="rounded-t-md py-4 px-6 mt-6">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('pembayaran.index') }}" class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white text-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Transaksi Pembayaran</h1>
                <p class="text-[#FFEBEE]">Detail Data</p>
            </div>
        </div>
    </div>

    <div class="bg-white text-gray-700 px-6 py-6 rounded-b-md">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-sm font-bold">Kode Pembayaran</label>
                <input type="text" readonly value="{{ $pembayaran->kode_pembayaran }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>
            <div>
                <label class="text-sm font-bold">Pesanan</label>
                <input type="text" readonly value="{{ $pembayaran->pesanan->kode_pesanan ?? '-' }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>
            <div>
                <label class="text-sm font-bold">Total</label>
                <input type="text" readonly value="Rp{{ number_format($pembayaran->total, 0, ',', '.') }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>
            <div>
                <label class="text-sm font-bold">Metode</label>
                <input type="text" readonly value="{{ $pembayaran->metode }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>
            <div>
                <label class="text-sm font-bold">Tanggal</label>
                <input type="text" readonly value="{{ $pembayaran->tanggal }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>
            <div>
                <label class="text-sm font-bold">Status</label>
                <input type="text" readonly value="{{ $pembayaran->status }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>
            <div>
                <label class="text-sm font-bold">Keterangan</label>
                <textarea readonly class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">{{ $pembayaran->keterangan }}</textarea>
            </div>
        </div>
    </div>
</div>
@endsection
