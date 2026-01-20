@extends('layouts.layoutkasir')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">
    <div class="rounded-t-md py-4 px-6 mt-6">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('detail_pesanan.index') }}" class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Transaksi Detail Pesanan</h1>
                <p class="text-[#FFEBEE]">Edit Data</p>
            </div>
        </div>
    </div>

    <form action="{{ route('detail_pesanan.update', $detail->id) }}" method="POST" class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="text-sm font-bold">Kode Detail Pesanan</label>
                <input type="text" value="{{ $detail->kode_detail_pesanan }}" readonly
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Pesanan</label>
                <select name="pesanan_id" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="">-- Pilih Pesanan --</option>
                    @foreach ($pesanan as $p)
                        <option value="{{ $p->id }}" {{ $detail->pesanan_id == $p->id ? 'selected' : '' }}>
                            {{ $p->kode_pesanan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-bold">Produk</label>
                <select id="produk_id" name="produk_id" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($produk as $prd)
                        <option value="{{ $prd->id }}" data-harga="{{ $prd->harga }}"
                            {{ $detail->produk_id == $prd->id ? 'selected' : '' }}>
                            {{ $prd->kode_produk }} - {{ $prd->nama_produk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-bold">Qty</label>
                <input type="number" id="qty" name="qty" value="{{ $detail->qty }}" required
                    class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
            </div>

            <div>
                <label class="text-sm font-bold">Harga</label>
                <input type="number" id="harga" name="harga" value="{{ $detail->harga }}" readonly required
                    class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2 bg-gray-100 text-gray-600">
            </div>

            <div>
                <label class="text-sm font-bold">Diskon</label>
                <input type="number" id="diskon" name="diskon" value="{{ $detail->diskon ?? 0 }}"
                    class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
            </div>

            <div>
                <label class="text-sm font-bold">Subtotal (otomatis)</label>
                <input type="text" id="subtotal" readonly value="{{ number_format(($detail->qty * $detail->harga) - ($detail->diskon ?? 0), 2) }}"
                    class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2 bg-gray-100 text-gray-600">
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
document.addEventListener('DOMContentLoaded', function () {
    const produkSelect = document.getElementById('produk_id');
    const hargaInput = document.getElementById('harga');
    const qtyInput = document.getElementById('qty');
    const diskonInput = document.getElementById('diskon');
    const subtotalInput = document.getElementById('subtotal');

    function hitungSubtotal() {
        const harga = parseFloat(hargaInput.value) || 0;
        const qty = parseFloat(qtyInput.value) || 0;
        const diskon = parseFloat(diskonInput.value) || 0;
        const subtotal = (harga * qty) - diskon;
        subtotalInput.value = subtotal.toFixed(2);
    }

    produkSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const harga = selectedOption.getAttribute('data-harga');
        if (harga) {
            hargaInput.value = harga;
            hitungSubtotal();
        }
    });

    [hargaInput, qtyInput, diskonInput].forEach(input => {
        input.addEventListener('input', hitungSubtotal);
    });
});

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
