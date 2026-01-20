@extends('layouts.app')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">

    <!-- Header Merah -->
    <div class="rounded-t-md py-4 px-6 mt-6">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('penerimaan_barang.index') }}"
                class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE]
                hover:bg-[#800000] hover:text-white transition-all text-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Penerimaan Barang</h1>
                <p class="text-[#FFEBEE]">Detail Data</p>
            </div>
        </div>
    </div>

    <!-- KONTEN -->
    <div class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            @php
                $fields = [
                    'Kode Penerimaan' => $data->kode_penerimaan,
                    'Supplier' => $data->supplier->nama_supplier,
                    'Kode PO' => $data->kode_po,
                    'Nama Produk' => $data->nama_produk,
                    'Harga' => $data->harga,
                    'Jumlah' => $data->jumlah,
                    'DP' => $data->dp,
                    'Diskon' => $data->diskon,
                    'Pajak' => $data->pajak,
                    'Subtotal' => $data->subtotal,
                    'Tanggal' => $data->tanggal,
                     'Status' => $data->status,
                ];
            @endphp

            @foreach($fields as $label => $value)
                <div>
                    <label class="text-sm font-bold">{{ $label }}</label>
                    <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">
                        {{ $value }}
                    </div>
                </div>
            @endforeach

            <div class="md:col-span-2">
                <label class="text-sm font-bold">Catatan</label>
                <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">
                    {{ $data->catatan ?? '-' }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
