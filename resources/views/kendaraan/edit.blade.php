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
        <p class="text-[#FFEBEE]">Edit Data</p>
      </div>
    </div>
  </div>

  <!-- Form Putih -->
  <form action="{{ route('kendaraan.update', $kendaraan->id) }}" method="POST" class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

      <!-- Kode Kendaraan -->
      <div>
        <label class="text-sm font-bold">Kode Kendaraan</label>
        <input type="text" name="kode_kendaraan" readonly value="{{ $kendaraan->kode_kendaraan }}"
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-600 text-sm px-3 py-2">
      </div>

      <!-- Nama Kendaraan -->
      <div>
        <label class="text-sm font-bold">Nama Kendaraan <span class="text-red-500">*</span></label>
        <input type="text" name="nama_kendaraan" value="{{ $kendaraan->nama_kendaraan }}" required
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:ring-1 focus:ring-red-500">
      </div>

      <!-- Nomor Polisi -->
      <div>
        <label class="text-sm font-bold">Nomor Polisi <span class="text-red-500">*</span></label>
        <input type="text" name="nomer_polisi" value="{{ $kendaraan->nomer_polisi }}" required
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:ring-1 focus:ring-red-500">
      </div>

      <!-- Supir -->
      <div>
        <label class="text-sm font-bold">Supir</label>
        <input type="text" name="supir" value="{{ $kendaraan->supir }}"
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:ring-1 focus:ring-red-500">
      </div>

      <!-- Status -->
      <div>
        <label class="text-sm font-bold">Status <span class="text-red-500">*</span></label>
        <select name="status" required
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:ring-1 focus:ring-red-500">
          <option value="aktif" {{ $kendaraan->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="nonaktif" {{ $kendaraan->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
      </div>

      <!-- Catatan -->
      <div>
        <label class="text-sm font-bold">Catatan</label>
        <textarea name="catatan" rows="3"
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:ring-1 focus:ring-red-500">{{ $kendaraan->catatan }}</textarea>
      </div>

    </div>

    <!-- Tombol -->
    <div class="flex justify-end items-center gap-4 mt-6">
      <button type="button" id="btnSwall"
        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition duration-200">
        <i class="fas fa-save mr-1"></i> Update
      </button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
 document.getElementById('btnSwall').addEventListener('click', function () {
    Swal.fire({
      title: 'Apakah Anda Yakin?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',    
      confirmButtonText: 'Ok',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
        this.closest('form').submit();
      }
    });
  });
</script>
@endpush
