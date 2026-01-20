@extends('layouts.app')

@section('content')
<div class="bg-white w-full rounded-lg shadow-xl p-6 md:p-12 border-t-[6px] border-red-700">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('produk.index') }}" class="px-3 py-1 border-2 border-gray-400 text-gray-700 rounded hover:bg-gray-100 text-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2 class="text-2xl font-bold">Edit Produk</h2>
    </div>

    {{-- Form --}}
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" id="formProduk">
        @csrf
        @method('PUT')
        <table class="w-full border-2 border-gray-400">
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100 w-48">Kode Produk</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <input type="text" readonly class="border rounded p-2 w-full bg-gray-100" value="{{ $produk->kode_produk }}">
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100">Kategori Produk</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <select name="kategori_id" required class="border rounded p-2 w-full">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ $produk->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100">Nama Produk</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <input type="text" name="nama_produk" required class="border rounded p-2 w-full" value="{{ $produk->nama_produk }}">
                    @error('nama_produk')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100">Harga</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <input type="number" name="harga" required class="border rounded p-2 w-full" value="{{ $produk->harga }}">
                    @error('harga')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100">Stok</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <input type="number" name="stok" required class="border rounded p-2 w-full" value="{{ $produk->stok }}">
                    @error('stok')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100">Status</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <select name="status" required class="border rounded p-2 w-full">
                        <option value="">-- Pilih Status --</option>
                        <option value="Aktif" {{ $produk->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ $produk->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100">Gambar</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    @if($produk->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Current Image" class="h-24 w-24 object-cover rounded border">
                        </div>
                    @endif
                    <input type="file" name="gambar" accept="image/*" class="border rounded p-2 w-full">
                    <small class="text-gray-500">Biarkan kosong jika tidak ingin mengubah gambar</small>
                    @error('gambar')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td colspan="2" class="px-4 py-3 border-2 border-gray-400 text-right bg-gray-50">
                    <a href="{{ route('produk.index') }}" class="px-4 py-2 border-2 border-gray-400 rounded hover:bg-gray-200 mr-2">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-red-700 text-white rounded hover:bg-red-800">Update</button>
                </td>
            </tr>
        </table>
    </form>
</div>

@endsection
