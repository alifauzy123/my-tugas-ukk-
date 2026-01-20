@extends('layouts.app')

@section('content')
<div class="bg-white w-full rounded-lg shadow-xl p-6 md:p-12 border-t-[6px] border-red-700">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('produk.index') }}" class="px-3 py-1 border-2 border-gray-400 text-gray-700 rounded hover:bg-gray-100 text-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2 class="text-2xl font-bold">Detail Produk</h2>
    </div>

    {{-- Data Display --}}
    <table class="w-full border-2 border-gray-400 mb-6">
        <tr>
            <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100 w-48 font-semibold">Kode Produk</td>
            <td class="px-4 py-2 border-2 border-gray-400">{{ $produk->kode_produk }}</td>
        </tr>
        <tr>
            <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100 font-semibold">Nama Produk</td>
            <td class="px-4 py-2 border-2 border-gray-400">{{ $produk->nama_produk }}</td>
        </tr>
        <tr>
            <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100 font-semibold">Kategori</td>
            <td class="px-4 py-2 border-2 border-gray-400">{{ $produk->kategori->nama_kategori ?? '-' }}</td>
        </tr>
        <tr>
            <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100 font-semibold">Harga</td>
            <td class="px-4 py-2 border-2 border-gray-400">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100 font-semibold">Stok</td>
            <td class="px-4 py-2 border-2 border-gray-400">{{ $produk->stok }}</td>
        </tr>
        <tr>
            <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100 font-semibold">Status</td>
            <td class="px-4 py-2 border-2 border-gray-400">
                @if(strtolower($produk->status) === 'aktif')
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded">Aktif</span>
                @else
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded">Nonaktif</span>
                @endif
            </td>
        </tr>
        @if($produk->gambar)
        <tr>
            <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100 font-semibold">Gambar</td>
            <td class="px-4 py-2 border-2 border-gray-400">
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Product Image" class="h-32 w-32 object-cover rounded border">
            </td>
        </tr>
        @endif
        <tr>
            <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100 font-semibold">Dibuat</td>
            <td class="px-4 py-2 border-2 border-gray-400">{{ $produk->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
        </tr>
        <tr>
            <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100 font-semibold">Diperbarui</td>
            <td class="px-4 py-2 border-2 border-gray-400">{{ $produk->updated_at?->format('d/m/Y H:i') ?? '-' }}</td>
        </tr>
    </table>

    {{-- Action Buttons --}}
    <div class="flex gap-2">
        <a href="{{ route('produk.edit', $produk->id) }}" class="px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">Edit</a>
        <button onclick="deleteProduk({{ $produk->id }})" class="px-4 py-2 bg-red-700 text-white rounded hover:bg-red-800">Hapus</button>
        <a href="{{ route('produk.index') }}" class="px-4 py-2 border-2 border-gray-400 rounded hover:bg-gray-100">Kembali</a>
    </div>
</div>

{{-- Form DELETE --}}
<form id="formDelete" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
function deleteProduk(id) {
    Swal.fire({
        title: 'Hapus Produk?',
        text: 'Data produk akan dihapus dan tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formDelete').action = '/produk/' + id;
            document.getElementById('formDelete').submit();
        }
    });
}
</script>
@endpush
