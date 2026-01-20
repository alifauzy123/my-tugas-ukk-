@extends('layouts.app')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">

  <!-- Header Merah -->
  <div class="rounded-t-md py-4 px-6 mt-6">
    <div class="flex items-center gap-x-3">
      <a href="{{ route('penerimaan_barang.index') }}"
         class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
        <i class="fas fa-arrow-left text-sm"></i>
      </a>
      <div>
        <h1 class="text-2xl font-bold">Penerimaan Barang</h1>
        <p class="text-[#FFEBEE]">New Data</p>
      </div>
    </div>
  </div>

  <!-- FORM PUTIH -->
  <form action="{{ route('penerimaan_barang.store') }}" method="POST"
        class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
    @csrf

   <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <!-- KODE -->
    <div>
        <label class="text-sm font-bold">
            Kode Penerimaan <span class="text-red-500">*</span>
        </label>
        <input type="text" name="kode_penerimaan" value="{{ $kode }}" readonly
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-600 text-sm px-3 py-2">
    </div>

    <!-- Supplier (Auto) -->
    <div>
        <label class="text-sm font-bold">
            Supplier <span class="text-red-500">*</span>
        </label>
        <select name="supplier_id" id="supplier_id"
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
            <option value="">-- Pilih Supplier --</option>
            @foreach ($supplier as $s)
                <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
            @endforeach
        </select>
    </div>

    <input type="hidden" id="nama_supplier" name="nama_supplier">

    <!-- Kode PO -->
    <div>
        <label class="text-sm font-bold">
            Kode PO <span class="text-red-500">*</span>
        </label>
        <select id="purchase_order_id"
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
            <option>-- Pilih Kode PO --</option>
            @foreach ($po as $p)
                <option value="{{ $p->kode_po }}">{{ $p->kode_po }}</option>
            @endforeach
        </select>

        <input type="hidden" name="kode_po" id="kode_po">
    </div>

    <!-- Nama Produk -->
    <div>
        <label class="text-sm font-bold">
            Nama Produk <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nama_produk" name="nama_produk" readonly
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm bg-gray-100 text-sm px-3 py-2">
    </div>

    <input type="hidden" id="produk_id" name="produk_id">


    <!-- Harga -->
    <div>
        <label class="text-sm font-bold">Harga <span class="text-red-500">*</span></label>
        <input type="number" id="harga" name="harga" readonly
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm bg-gray-100 text-sm px-3 py-2">
    </div>

    <!-- Jumlah -->
    <div>
        <label class="text-sm font-bold">
            Jumlah <span class="text-red-500">*</span>
        </label>
        <input type="number" id="jumlah" name="jumlah" required
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
    </div>

    <!-- DP -->
    <div>
        <label class="text-sm font-bold">DP</label>
        <input type="number" id="dp" name="dp"
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
    </div>

    <!-- Diskon -->
    <div>
        <label class="text-sm font-bold">Diskon</label>
        <input type="number" id="diskon" name="diskon"
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
    </div>

    <!-- Pajak -->
    <div>
        <label class="text-sm font-bold">
            Pajak <span class="text-red-500">*</span>
        </label>
        <input type="number" id="pajak" name="pajak" readonly
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm bg-gray-100 text-sm px-3 py-2">
    </div>

    <!-- Subtotal -->
    <div>
        <label class="text-sm font-bold">Subtotal <span class="text-red-500">*</span></label>
        <input type="number" id="subtotal" name="subtotal" readonly
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm bg-gray-100 text-sm px-3 py-2">
    </div>

    <!-- Tanggal -->
    <div>
        <label class="text-sm font-bold">
            Tanggal <span class="text-red-500">*</span>
        </label>
        <input type="date" name="tanggal"
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
    </div>

  

    <!-- STATUS -->
    <div>
        <label class="text-sm font-bold">
            Status <span class="text-red-500">*</span>
        </label>
        <select name="status"
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
        </select>
    </div>

      <!-- Catatan -->
    <div>
        <label class="text-sm font-bold">Catatan</label>
        <textarea name="catatan" rows="3"
            class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2"></textarea>
    </div>

</div>


    <!-- Tombol -->
    <div class="flex justify-end items-center gap-4 mt-6">
      <button type="button" id="btnSwall"
        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition duration-200">
        <i class="fas fa-save mr-1"></i> Simpan
      </button>
    </div>

  </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('purchase_order_id').addEventListener('change', function () {
    let kode_po = this.value;

    fetch(`/penerimaan-barang/get-po/${kode_po}`)
        .then(res => res.json())
        .then(res => {
            if (res.status) {

                document.getElementById('supplier_id').value = res.data.supplier_id;
                document.getElementById('nama_supplier').value = res.data.nama_supplier;
                document.getElementById('kode_po').value = res.data.kode_po;
                document.getElementById('produk_id').value = res.data.produk_id;
                document.getElementById('nama_produk').value = res.data.nama_produk;
                document.getElementById('harga').value = res.data.harga;
                document.getElementById('dp').value = res.data.dp;
                document.getElementById('diskon').value = res.data.diskon;
                document.getElementById('pajak').value = res.data.pajak;

                hitungSubtotal();
            }
        });
});


function hitungSubtotal() {
    let harga = parseInt(document.getElementById('harga').value) || 0;
    let jumlah = parseInt(document.getElementById('jumlah').value) || 0;
    let dp = parseInt(document.getElementById('dp').value) || 0;
    let diskon = parseInt(document.getElementById('diskon').value) || 0;
    let pajak = parseInt(document.getElementById('pajak').value) || 0;

    let subtotal = (harga * jumlah) - dp - diskon + pajak;

    document.getElementById('subtotal').value = subtotal;
}

document.getElementById('jumlah').addEventListener('input', hitungSubtotal);
document.getElementById('dp').addEventListener('input', hitungSubtotal);
document.getElementById('diskon').addEventListener('input', hitungSubtotal);


document.getElementById('btnSwall').addEventListener('click', function () {
    Swal.fire({
      title: 'Apakah Anda Yakin?',
      icon: 'warning',
      showCancelButton: true,
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
