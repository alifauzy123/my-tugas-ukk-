@extends('layouts.app')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">

    <!-- Header Merah -->
    <div class="rounded-t-md py-4 px-6 mt-6">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('pelanggan.index') }}" 
                class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Master Pelanggan</h1>
                <p class="text-[#FFEBEE]">New Data</p>
            </div>
        </div>
    </div>

    <!-- Form Putih -->
    <form action="{{ route('pelanggan.store') }}" method="POST" class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="text-sm font-bold">Kode Pelanggan</label>
                <input type="text" name="kode_pelanggan" required readonly class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2" placeholder="Kode Generate By System">
            </div>


            <div>
                <label class="text-sm font-bold">Nama Pelanggan <span class="text-red-500">*</span></label>
                <input type="text" name="nama_pelanggan" required class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2" placeholder="Nama pelanggan">
            </div>

            <div>
                <label class="text-sm font-bold">Email<span class="text-red-500">*</span></label>
                <input type="email" name="email" class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2" placeholder=" Masukkan Email ">
            </div>

            <div>
                <label class="text-sm font-bold">No Telepon<span class="text-red-500">*</span></label>
                <input type="text" name="no_telp" class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2" placeholder="Masukkan No Telepon">
            </div>

            <div>
                <label class="text-sm font-bold">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <div>
                <label class="text-sm font-bold">Alamat</label>
                <textarea name="alamat" rows="3" class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2" placeholder="Masukkan Alamat"></textarea>
            </div>

        </div>

        <div class="flex justify-end items-center gap-4 mt-6">
            <button type="button" id="btnSwall" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition duration-200">
                <i class="fas fa-save mr-1"></i> Simpan
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