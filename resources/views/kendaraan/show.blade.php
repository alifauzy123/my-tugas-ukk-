@extends('layouts.app')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">

  <!-- Header Merah -->
  <div class="rounded-t-md py-4 px-6 mt-6">
    <div class="flex items-center gap-x-3">
      <a href="{{ route('kendaraan.index') }}"
         class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
        <i class="fas fa-arrow-left text-sm"></i>
      </a>
      <div>
        <h1 class="text-2xl font-bold">Master Kendaraan</h1>
        <p class="text-[#FFEBEE]">Detail Data</p>
      </div>
    </div>
  </div>

  <!-- Konten -->
  <div class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

      <div>
        <label class="text-sm font-bold">Kode Kendaraan</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $kendaraan->kode_kendaraan }}</div>
      </div>

      <div>
        <label class="text-sm font-bold">Nama Kendaraan</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $kendaraan->nama_kendaraan }}</div>
      </div>

      <div>
        <label class="text-sm font-bold">Nomor Polisi</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $kendaraan->nomer_polisi }}</div>
      </div>

      <div>
        <label class="text-sm font-bold">Supir</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $kendaraan->supir ?? '-' }}</div>
      </div>

      <div>
        <label class="text-sm font-bold">Status</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $kendaraan->status }}</div>
      </div>

      <div>
        <label class="text-sm font-bold">Catatan</label>
        <div class="mt-2 px-3 py-2 border rounded-md bg-gray-100 text-sm">{{ $kendaraan->catatan ?? '-' }}</div>
      </div>

    </div>
  </div>
</div>
@endsection
