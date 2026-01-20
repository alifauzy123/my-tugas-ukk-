@extends('layouts.app')

@section('content')
<div class="bg-white w-full rounded-lg shadow-xl p-6 md:p-12 border-t-[6px] border-red-700">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('produk.index') }}" class="px-3 py-1 border-2 border-gray-400 text-gray-700 rounded hover:bg-gray-100 text-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2 class="text-2xl font-bold">Create New Produk</h2>
    </div>

    {{-- Form --}}
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" id="formProduk">
        @csrf
        <table class="w-full border-2 border-gray-400">
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100 w-48">Kategori Produk</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <select name="kategori_id" required class="border rounded p-2 w-full">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100">Nama Produk</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <input type="text" name="nama_produk" required class="border rounded p-2 w-full" value="{{ old('nama_produk') }}">
                    @error('nama_produk')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100">Harga</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <input type="number" name="harga" required class="border rounded p-2 w-full" value="{{ old('harga') }}">
                    @error('harga')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100">Stok</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <input type="number" name="stok" required class="border rounded p-2 w-full" value="{{ old('stok') }}">
                    @error('stok')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100">Status</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <select name="status" required class="border rounded p-2 w-full">
                        <option value="">-- Pilih Status --</option>
                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 border-2 border-gray-400 bg-gray-100">Gambar</td>
                <td class="px-4 py-2 border-2 border-gray-400">
                    <input type="file" name="gambar" accept="image/*" class="border rounded p-2 w-full">
                    @error('gambar')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </td>
            </tr>
            <tr>
                <td colspan="2" class="px-4 py-3 border-2 border-gray-400 text-right bg-gray-50">
                    <a href="{{ route('produk.index') }}" class="px-4 py-2 border-2 border-gray-400 rounded hover:bg-gray-200 mr-2">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-red-700 text-white rounded hover:bg-red-800">Simpan</button>
                </td>
            </tr>
        </table>
    </form>
</div>

@endsection
