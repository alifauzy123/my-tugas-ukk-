@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="mb-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('purchase_order.index') }}" 
           class="w-10 h-10 bg-red-100 hover:bg-red-200 rounded-lg flex items-center justify-center text-red-700 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-plus text-white text-lg"></i>
                </div>
                Tambah Purchase Order Baru
            </h1>
            <p class="text-gray-500 mt-2">
                Isi formulir di bawah untuk menambahkan data Purchase Order
            </p>
        </div>
    </div>
</div>

<!-- GRID -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- FORM UTAMA -->
    <div class="lg:col-span-2">
        <form action="{{ route('purchase_order.store') }}" 
              method="POST" 
              id="formPO" 
              class="bg-white rounded-lg shadow-lg overflow-hidden">

            @csrf

            <!-- FORM HEADER -->
            <div class="bg-gradient-to-r from-red-600 to-red-800 px-8 py-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-file-invoice"></i>
                    Informasi Purchase Order
                </h2>
            </div>

            <div class="p-8 space-y-6">

                <!-- KODE PO -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode PO</label>
                    <input type="text" name="kode_po" readonly value="{{ $kode_po }}"
                           class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-mono text-sm">
                </div>

                <!-- KATEGORI -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Produk <span class="text-red-500">*</span></label>
                    <select name="kategori_produk_id" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-600 focus:ring-red-300">
                        <option value="">— Pilih Kategori —</option>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- SUPPLIER -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Supplier <span class="text-red-500">*</span></label>
                    <select name="supplier_id" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-600">
                        <option value="">— Pilih Supplier —</option>
                        @foreach ($supplier as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- PRODUK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Produk (opsional)</label>
                    <select name="produk_id"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-600">
                        <option value="">— Pilih Produk —</option>
                        @foreach ($produk as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- NAMA PRODUK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_produk" required placeholder="Masukkan nama produk"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg">
                </div>

                <!-- HARGA -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Produk <span class="text-red-500">*</span></label>
                    <input type="number" name="harga_produk" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg calc-field">
                </div>

                <!-- JUMLAH -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg calc-field">
                </div>

                <!-- DP -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">DP</label>
                    <input type="number" name="dp" value="0"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg calc-field">
                </div>

                <!-- DISKON -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Diskon</label>
                    <input type="number" name="diskon" value="0"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg calc-field">
                </div>

                <!-- PAJAK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pajak</label>
                    <input type="number" name="pajak" value="0"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg calc-field">
                </div>

                <!-- SUBTOTAL -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subtotal</label>
                    <input type="number" name="subtotal" readonly
                           class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg">
                </div>

                <!-- GRAND TOTAL -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Grand Total</label>
                    <input type="number" name="grand_total" readonly
                           class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg">
                </div>

                <!-- CATATAN -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                    <textarea name="catatan" rows="3"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg resize-none"></textarea>
                </div>

                <!-- STATUS -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="bg-gray-50 px-8 py-6 flex justify-end">
                <button type="button" id="btnSubmit"
                    class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-800 text-white rounded-lg hover:from-red-700 hover:to-red-900 transition-all shadow-lg flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan PO
                </button>
            </div>

        </form>
    </div>

    <!-- SIDEBAR -->
    <div class="lg:col-span-1">

        <!-- Tips -->
        <div class="bg-red-50 border-2 border-red-200 rounded-lg p-6 mb-6">
            <h3 class="font-bold text-red-900 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb text-red-600"></i>
                Tips Pengisian
            </h3>

            <ul class="text-sm text-red-800 space-y-3">
                <li>• Pastikan data supplier benar</li>
                <li>• Harga & jumlah harus sesuai invoice</li>
                <li>• Gunakan DP hanya jika ada uang muka</li>
                <li>• Pajak dihitung otomatis</li>
            </ul>
        </div>

        <!-- Informasi -->
        <div class="bg-red-100 border-2 border-red-300 rounded-lg p-6">
            <h3 class="font-bold text-red-900 mb-3 flex items-center gap-2">
                <i class="fas fa-info-circle"></i>
                Informasi
            </h3>
            <p class="text-sm text-red-900">
                Purchase Order digunakan untuk mencatat pengadaan barang dari supplier. Pastikan semua data benar sebelum disimpan.
            </p>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('btnSubmit').addEventListener('click', function () {
    Swal.fire({
        title: 'Simpan Purchase Order?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#b91c1c',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formPO').submit();
        }
    });
});

function calculateTotals() {
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

document.querySelectorAll('.calc-field').forEach(input => {
    input.addEventListener('input', calculateTotals);
});
</script>
@endpush
