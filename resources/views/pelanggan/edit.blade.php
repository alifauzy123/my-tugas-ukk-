@extends('layouts.app')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">
    <div class="rounded-t-md py-4 px-6 mt-6">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('pelanggan.index') }}" 
                class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Edit Pelanggan</h1>
                <p class="text-[#FFEBEE]">Edit Data</p>
            </div>
        </div>
    </div>

    <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST" class="bg-white text-gray-700 px-6 py-6 rounded-b-md">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-sm font-bold">Kode</label>
                <input type="text" name="kode_pelanggan" readonly value="{{ $pelanggan->kode_pelanggan }}" class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 text-gray-600">
            </div>
            <div>
                <label class="text-sm font-bold">Nama</label>
                <input type="text" name="nama_pelanggan" required value="{{ $pelanggan->nama_pelanggan }}" class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
            </div>
            <div>
                <label class="text-sm font-bold">Email</label>
                <input type="email" name="email" required value="{{ $pelanggan->email }}" class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
            </div>
            <div>
                <label class="text-sm font-bold">No Telepon</label>
                <input type="text" name="no_telp" required value="{{ $pelanggan->no_telp }}" class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
            </div>
            <div>
                <label class="text-sm font-bold">Status</label>
                <select name="status" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="Aktif" {{ $pelanggan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ $pelanggan->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-bold">Alamat</label>
                <textarea name="alamat" rows="3" required class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">{{ $pelanggan->alamat }}</textarea>
            </div>
            
        </div>

        <div class="flex justify-end mt-6">
            <button type="button" id="btnSwall" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500 transition">
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
            const form = this.closest('form') || document.querySelector('form');
            if (form) {
                form.submit();
            } else {
                Swal.fire('Error', 'Form tidak ditemukan', 'error');
            }
        }
    });
});

</script>
@endpush