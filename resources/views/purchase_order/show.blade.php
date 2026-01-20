@extends('layouts.app')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">

  <!-- Header Merah -->
  <div class="rounded-t-md py-4 px-6 mt-6">
    <div class="flex items-center gap-x-3">
      <a href="{{ route('purchase_order.index') }}"
         class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
        <i class="fas fa-arrow-left text-sm"></i>
      </a>
      <div>
        <h1 class="text-2xl font-bold">Purchase Order</h1>
        <p class="text-[#FFEBEE]">Detail Data</p>
      </div>
    </div>
  </div>

  <!-- Konten -->
  <div class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

      <div>
        <label class="text-sm font-bold">Kode PO</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $po->kode_po }}</div>
      </div>

      <div>
        <label class="text-sm font-bold">Status</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $po->status }}</div>
      </div>

      <div>
        <label class="text-sm font-bold">Kategori Produk</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $po->kategori->nama_kategori }}</div>
      </div>

      <div>
        <label class="text-sm font-bold">Nama Supplier</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $po->supplier->nama_supplier }}</div>
      </div>
   <div>
    <label class="text-sm font-bold">Produk (jika produk sudah ada)</label>
    <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">
        {{ $po->produk?->nama_produk ?? '-' }}
    </div>
</div>

<div>
    <label class="text-sm font-bold">Nama Produk</label>
    <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">
        {{ $po->nama_produk }}
    </div>
</div>

      <div>
        <label class="text-sm font-bold">Harga Produk</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">Rp {{ number_format($po->harga_produk) }}</div>
      </div>

      <div>
        <label class="text-sm font-bold">Tanggal</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $po->tanggal }}</div>
      </div>

      <div>
        <label class="text-sm font-bold">Jumlah</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $po->jumlah }}</div>
      </div>

      <div>
  <label class="text-sm font-bold">DP</label>
  <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">
    Rp {{ number_format($po->dp ?? 0) }}
  </div>
</div>

<div>
  <label class="text-sm font-bold">Diskon</label>
  <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">
    Rp {{ number_format($po->diskon ?? 0) }}
  </div>
</div>

<div>
  <label class="text-sm font-bold">Pajak</label>
  <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">
    Rp {{ number_format($po->pajak ?? 0) }}
  </div>
</div>

<div>
  <label class="text-sm font-bold">Subtotal</label>
  <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">
    Rp {{ number_format($po->subtotal ?? 0) }}
  </div>
</div>

<div>
  <label class="text-sm font-bold">Grand Total</label>
  <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">
    Rp {{ number_format($po->grand_total ?? 0) }}
  </div>
</div>


      <div>
    <label class="text-sm font-bold">Catatan</label>
    <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm min-h-[45px]">
        {{ $po->catatan ?: '-' }}
    </div>
</div>

    </div>
  </div>
</div>
@endsection
