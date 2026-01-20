@extends('layouts.app')

@section('content')
<div class="bg-white w-full rounded-lg shadow-xl p-6 md:p-12">

    <h2 class="text-xl font-bold mb-4">
        @if(isset($readonly) && $readonly)
            Detail Penerimaan Barang
        @elseif(isset($edit) && $edit)
            Edit Penerimaan Barang
        @else
            Form Penerimaan Barang
        @endif
    </h2>

    <form 
        @if(isset($edit) && $edit)
            action="{{ route('penerimaan_barang.update', $data->id) }}" 
        @else
            action="#"
        @endif 
        method="POST">

        @csrf
        @if(isset($edit) && $edit)
            @method('PUT')
        @endif

        {{-- KODE --}}
        <div class="mb-3">
            <label>Kode Penerimaan</label>
            <input type="text" name="kode_penerimaan" 
                value="{{ $data->kode_penerimaan ?? $kode ?? '' }}"
                class="form-control"
                readonly>
        </div>

        {{-- Supplier --}}
        <div class="mb-3">
            <label>Supplier</label>
            @if(isset($readonly) && $readonly)
                <input type="text" class="form-control" value="{{ $data->nama_supplier }}" readonly>
            @else
                <select name="supplier_id" class="form-control" {{ $readonly ? 'readonly' : '' }}>
                    <option value="">-- pilih --</option>
                    @foreach($supplier as $s)
                        <option value="{{ $s->id }}" 
                            {{ (isset($data) && $data->supplier_id == $s->id) ? 'selected' : '' }}>
                            {{ $s->nama_supplier }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        {{-- Nama Produk --}}
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control"
                value="{{ $data->nama_produk ?? '' }}"
                {{ isset($readonly) && $readonly ? 'readonly' : '' }}>
        </div>

        {{-- Harga --}}
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control"
                value="{{ $data->harga ?? '' }}"
                {{ isset($readonly) && $readonly ? 'readonly' : '' }}>
        </div>

        {{-- Jumlah --}}
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control"
                value="{{ $data->jumlah ?? '' }}"
                {{ isset($readonly) && $readonly ? 'readonly' : '' }}>
        </div>

        {{-- Subtotal --}}
        <div class="mb-3">
            <label>Subtotal</label>
            <input type="number" name="subtotal" class="form-control"
                value="{{ $data->subtotal ?? '' }}"
                {{ isset($readonly) && $readonly ? 'readonly' : '' }}>
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control"
                value="{{ $data->tanggal ?? '' }}"
                {{ isset($readonly) && $readonly ? 'readonly' : '' }}>
        </div>

        {{-- Catatan --}}
        <div class="mb-3">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control" 
                {{ isset($readonly) && $readonly ? 'readonly' : '' }}>{{ $data->catatan ?? '' }}</textarea>
        </div>

        {{-- Tombol --}}
        @if(!isset($readonly) || !$readonly)
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                Simpan
            </button>
        @else
            <a href="{{ route('penerimaan_barang.index') }}" 
                class="px-4 py-2 bg-gray-500 text-white rounded">
                Kembali
            </a>
        @endif

    </form>
</div>
@endsection
