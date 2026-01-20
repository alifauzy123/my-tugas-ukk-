@extends('layouts.app')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">
    <div class="rounded-t-md py-4 px-6 mt-6">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('ulasan.index') }}" class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
            
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Transaksi Ulasan</h1>
                <p class="text-[#FFEBEE]">Edit Data</p>
            </div>
        </div>
    </div>

    <form action="{{ route('ulasan.update', $ulasan->id) }}" method="POST" class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-sm font-bold">Produk</label>
                <select name="produk_id" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($produk as $p)
                        <option value="{{ $p->id }}" {{ $ulasan->produk_id == $p->id ? 'selected' : '' }}>
                            {{ $p->kode_produk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-bold">Pelanggan</label>
                <select name="pelanggan_id" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach ($pelanggan as $plg)
                        <option value="{{ $plg->id }}" {{ $ulasan->pelanggan_id == $plg->id ? 'selected' : '' }}>
                            {{ $plg->kode_pelanggan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-bold">Rating (1–10)</label>
                <input type="number" name="rating" min="1" max="10" value="{{ old('rating', $ulasan->rating) }}" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
            </div>

            <div>
                <label class="text-sm font-bold">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $ulasan->tanggal) }}" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
            </div>

            <div>
                <label class="text-sm font-bold">Status</label>
                <select name="status" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="Aktif" {{ $ulasan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ $ulasan->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div>
                <label class="text-sm font-bold">Komentar</label>
                <textarea name="komentar" rows="4" class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">{{ old('komentar', $ulasan->komentar) }}</textarea>
            </div>
        </div>

        <div class="flex justify-end items-center gap-4 mt-6">
            <button type="button" id="btnSwall" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition duration-200">
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