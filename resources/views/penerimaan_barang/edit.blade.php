@extends('layouts.app')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">

    <!-- Header Merah -->
    <div class="rounded-t-md py-4 px-6 mt-6">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('penerimaan_barang.index') }}"
                class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE]
                hover:bg-[#800000] hover:text-white transition-all text-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Penerimaan Barang</h1>
                <p class="text-[#FFEBEE]">Edit Data</p>
            </div>
        </div>
    </div>

    <!-- FORM PUTIH -->
    <form action="{{ route('penerimaan_barang.update', $data->id) }}" method="POST"
        class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <!-- Kode -->
            <div>
                <label class="text-sm font-bold">Kode Penerimaan</label>
                <input readonly name="kode_penerimaan" value="{{ $data->kode_penerimaan }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2">
            </div>

            <!-- Supplier -->
            <div>
                <label class="text-sm font-bold">Supplier</label>
                <select disabled class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2">
                    <option>{{ $data->supplier->nama_supplier }}</option>
                </select>
                <input type="hidden" name="supplier_id" value="{{ $data->supplier_id }}">
            </div>

            <!-- Kode PO -->
            <div>
                <label class="text-sm font-bold">Kode PO</label>
                <input readonly value="{{ $data->kode_po }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2">
                <input type="hidden" name="kode_po" value="{{ $data->kode_po }}">
            </div>

            <!-- Nama Produk -->
            <div>
                <label class="text-sm font-bold">Nama Produk</label>
                <input readonly name="nama_produk" value="{{ $data->nama_produk }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2">
            </div>

            <!-- Harga -->
            <div>
                <label class="text-sm font-bold">Harga</label>
                <input readonly name="harga" id="harga" value="{{ $data->harga }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2">
            </div>

            <!-- Jumlah -->
            <div>
                <label class="text-sm font-bold">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" value="{{ $data->jumlah }}" required
                    class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
            </div>

            <!-- DP -->
            <div>
                <label class="text-sm font-bold">DP</label>
                <input type="number" id="dp" name="dp" value="{{ $data->dp }}"
                    class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
            </div>

            <!-- Diskon -->
            <div>
                <label class="text-sm font-bold">Diskon</label>
                <input type="number" id="diskon" name="diskon" value="{{ $data->diskon }}"
                    class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
            </div>

            <!-- Pajak -->
            <div>
                <label class="text-sm font-bold">Pajak</label>
                <input readonly id="pajak" name="pajak" value="{{ $data->pajak }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2">
            </div>

            <!-- Subtotal -->
            <div>
                <label class="text-sm font-bold">Subtotal</label>
                <input readonly id="subtotal" name="subtotal" value="{{ $data->subtotal }}"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2">
            </div>

            <!-- Tanggal -->
            <div>
                <label class="text-sm font-bold">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $data->tanggal }}"
                    class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
            </div>

            <!-- Status -->
            <div>
                <label class="text-sm font-bold">Status</label>
                <select name="status"
                    class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="aktif" {{ $data->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $data->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- Catatan -->
            <div>
                <label class="text-sm font-bold">Catatan</label>
                <textarea name="catatan" rows="3"
                    class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">{{ $data->catatan }}</textarea>
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
    // Confirm swal
    document.getElementById('btnSwall').addEventListener('click', function () {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ok',
            cancelButtonText: 'No'
        }).then((res) => {
            if (res.isConfirmed) this.closest('form').submit();
        });
    });

    // Hitung subtotal
    function hitungSubtotal() {
        let harga = parseInt(document.getElementById("harga").value) || 0;
        let jumlah = parseInt(document.getElementById("jumlah").value) || 0;
        let dp = parseInt(document.getElementById("dp").value) || 0;
        let diskon = parseInt(document.getElementById("diskon").value) || 0;
        let pajak = parseInt(document.getElementById("pajak").value) || 0;

        let subtotal = (harga * jumlah) - diskon - dp + pajak;
        document.getElementById("subtotal").value = subtotal;
    }

    ["jumlah","dp","diskon"].forEach(id => {
        document.getElementById(id).addEventListener("input", hitungSubtotal);
    });
</script>
@endpush
