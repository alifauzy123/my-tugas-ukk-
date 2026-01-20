@extends('layouts.app')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">

  <!-- Header -->
  <div class="rounded-t-md py-4 px-6 mt-6">
    <div class="flex items-center gap-x-3">
      <a href="{{ route('purchase_order.index') }}"
         class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
        <i class="fas fa-arrow-left text-sm"></i>
      </a>
      <div>
        <h1 class="text-2xl font-bold">Purchase Order</h1>
        <p class="text-[#FFEBEE]">Edit Data</p>
      </div>
    </div>
  </div>

  <!-- Form -->
  <form action="{{ route('purchase_order.update', $po->id) }}" method="POST"
        class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

      <!-- Kode PO -->
      <div>
        <label class="text-sm font-bold">Kode PO</label>
        <input type="text" readonly value="{{ $po->kode_po }}"
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 text-sm px-3 py-2">
      </div>

     

      <!-- Kategori -->
      <div>
        <label class="text-sm font-bold">Kategori Produk</label>
        <select name="kategori_produk_id"
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2" required>
          <option value="">-- Pilih Kategori --</option>
          @foreach ($kategori as $k)
            <option value="{{ $k->id }}" {{ $po->kategori_produk_id == $k->id ? 'selected' : '' }}>
              {{ $k->nama_kategori }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
    <label class="text-sm font-bold">Nama Supplier <span class="text-red-500">*</span></label>
    <select name="supplier_id" required
        class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-red-500">

        <option value="">-- Pilih Supplier --</option>

        @foreach ($supplier as $s)
            <option value="{{ $s->id }}"
                {{ $po->supplier_id == $s->id ? 'selected' : '' }}>
                {{ $s->nama_supplier }}
            </option>
        @endforeach
    </select>
</div>
<div>
    <label class="text-sm font-bold">Produk (jika produk sudah ada)<span class="text-red-500">*</span></label>
    <select name="produk_id" required
        class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm">

        <option value="">-- Pilih Produk --</option>
        @foreach ($produk as $p)
            <option value="{{ $p->id }}" {{ $po->produk_id == $p->id ? 'selected' : '' }}>
                {{ $p->nama_produk }}
            </option>
        @endforeach
    </select>
</div>



      <!-- Nama Produk -->
      <div>
        <label class="text-sm font-bold">Nama Produk</label>
        <input type="text" name="nama_produk" value="{{ $po->nama_produk }}" required
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
      </div>

      <!-- Harga -->
      <div>
        <label class="text-sm font-bold">Harga Produk</label>
        <input type="number" name="harga_produk" value="{{ $po->harga_produk }}" required
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
      </div>

      <!-- Tanggal -->
      <div>
        <label class="text-sm font-bold">Tanggal</label>
        <input type="date" name="tanggal" value="{{ $po->tanggal }}" required
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
      </div>

      <!-- Jumlah -->
      <div>
        <label class="text-sm font-bold">Jumlah</label>
        <input type="number" name="jumlah" value="{{ $po->jumlah }}" required
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
      </div>

      {{-- DP --}}
<div>
    <label class="text-sm font-bold">DP</label>
    <input type="number" name="dp" value="{{ $po->dp ?? 0 }}"
        class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm calc-field">
</div>

{{-- Diskon --}}
<div>
    <label class="text-sm font-bold">Diskon</label>
    <input type="number" name="diskon" value="{{ $po->diskon ?? 0 }}"
        class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm calc-field">
</div>

{{-- Pajak --}}
<div>
    <label class="text-sm font-bold">Pajak</label>
    <input type="number" name="pajak" value="{{ $po->pajak ?? 0 }}"
        class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm calc-field">
</div>

{{-- Subtotal --}}
<div>
    <label class="text-sm font-bold">Subtotal</label>
    <input type="number" name="subtotal" readonly value="{{ $po->subtotal ?? 0 }}"
        class="mt-2 w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2 text-sm">
</div>

{{-- Grand Total --}}
<div>
    <label class="text-sm font-bold">Grand Total</label>
    <input type="number" name="grand_total" readonly value="{{ $po->grand_total ?? 0 }}"
        class="mt-2 w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2 text-sm">
</div>


       <!-- CATATAN -->
            <div>
                <label class="text-sm font-bold">Catatan</label>
                <textarea name="catatan"    
                    class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 h-12 resize-none focus:ring-1 focus:ring-red-500"
                    placeholder="Catatan untuk supplier"></textarea>
            </div>
         <!-- Status -->
      <div>
        <label class="text-sm font-bold">Status</label>
        <select name="status"
          class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
          <option value="aktif" {{ $po->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="nonaktif" {{ $po->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
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

function calculateTotalsEdit() {
    let harga = parseFloat(document.querySelector('input[name="harga_produk"]').value) || 0;
    let jumlah = parseFloat(document.querySelector('input[name="jumlah"]').value) || 0;

    let dp = parseFloat(document.querySelector('input[name="dp"]').value) || 0;
    let diskon = parseFloat(document.querySelector('input[name="diskon"]').value) || 0;
    let pajak = parseFloat(document.querySelector('input[name="pajak"]').value) || 0;

    let total = harga * jumlah;
    document.querySelector('input[name="grand_total"]').value = total;

    let subtotal = total - dp - diskon + pajak;
    if (subtotal < 0) subtotal = 0;

    document.querySelector('input[name="subtotal"]').value = subtotal;
}

// Event realtime
document.querySelectorAll('.calc-field, input[name="harga_produk"], input[name="jumlah"]').forEach(e => {
    e.addEventListener('input', calculateTotalsEdit);
});
</script>
@endpush
