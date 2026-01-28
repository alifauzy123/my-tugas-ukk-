@extends('layouts.app')

@section('content')

<!-- Header -->
<div class="mb-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('produk.index') }}" 
            class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center text-gray-700 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-700 rounded-lg flex items-center justify-center">
                    <i class="fas fa-boxes text-white text-lg"></i>
                </div>
                Tambah Produk Baru
            </h1>
            <p class="text-gray-500 mt-2">Isi formulir berikut untuk menambahkan produk baru.</p>
        </div>
    </div>
</div>

<!-- Layout Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- MAIN FORM -->
    <div class="lg:col-span-2">
        <form action="{{ route('produk.store') }}" method="POST" id="formProduk" enctype="multipart/form-data"
            class="bg-white rounded-lg shadow-lg overflow-hidden">
            @csrf

            <!-- Form Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Informasi Produk
                </h2>
            </div>

            <!-- Form Body -->
            <div class="p-8 space-y-6">

                <!-- Kode Produk -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-barcode text-red-500"></i>
                        Kode Produk
                    </label>
                    <input type="text" name="kode_produk" readonly placeholder="Auto Generated"
                        class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-mono text-sm cursor-not-allowed">

                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle"></i> Kode otomatis diset oleh sistem.
                    </p>
                </div>

                <!-- Kategori Produk -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-tags text-red-500"></i>
                        Kategori Produk <span class="text-red-500">*</span>
                    </label>

                    <select name="kategori_id" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all text-sm">
                        <option disabled selected hidden>Pilih Kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-box text-red-500"></i>
                        Nama Produk <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="nama_produk" required placeholder="Masukkan nama produk"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all text-sm">
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-money-bill-wave text-red-500"></i>
                        Harga <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="harga" required min="0" placeholder="Masukkan harga"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all text-sm">
                </div>

                <!-- Stok -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-boxes-stacked text-red-500"></i>
                        Stok <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="stok" required min="0" placeholder="Masukkan stok"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all text-sm">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-toggle-on text-red-500"></i>
                        Status <span class="text-red-500">*</span>
                    </label>

                    <div class="flex gap-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="status" value="Aktif" checked
                                class="w-4 h-4 text-red-600 focus:ring-2 focus:ring-red-200">
                            <span class="ml-3 text-sm font-medium text-gray-700">Aktif</span>
                        </label>

                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="status" value="Nonaktif"
                                class="w-4 h-4 text-red-600 focus:ring-2 focus:ring-red-200">
                            <span class="ml-3 text-sm font-medium text-gray-700">Nonaktif</span>
                        </label>
                    </div>
                </div>

                <!-- Gambar Produk -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-image text-red-500"></i>
                        Gambar Produk
                    </label>

                    <div class="relative">
                        <input type="file" name="gambar" accept="image/*" onchange="setPreviewImage(this)"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm">

                        <button type="button" onclick="openPreviewPopup()"
                            class="absolute top-3 right-3 text-gray-500 hover:text-black">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-6 flex justify-between gap-4 border-t-2 border-gray-100">
                <a href="{{ route('produk.index') }}"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>

                <button type="button" id="btnSubmit"
                    class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 shadow-lg transition-all duration-200 font-semibold text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Produk
                </button>
            </div>

        </form>
    </div>

    <!-- SIDEBAR INFO -->
    <div class="lg:col-span-1">

        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb text-blue-500"></i>
                Tips Pengisian
            </h3>

            <ul class="space-y-3 text-sm text-blue-800">
                <li class="flex gap-2"><span class="text-blue-500 font-bold">•</span>Gunakan nama produk yang jelas</li>
                <li class="flex gap-2"><span class="text-blue-500 font-bold">•</span>Isi harga & stok dengan benar</li>
                <li class="flex gap-2"><span class="text-blue-500 font-bold">•</span>Upload gambar yang jelas</li>
                <li class="flex gap-2"><span class="text-blue-500 font-bold">•</span>Pilih kategori yang sesuai</li>
            </ul>
        </div>

        <div class="bg-red-50 border-2 border-red-200 rounded-lg p-6">
            <h3 class="font-bold text-red-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-red-500"></i>
                Informasi
            </h3>

            <p class="text-sm text-red-800">
                Produk harus memiliki nama unik, harga valid, dan jumlah stok yang bisa dikelola.
            </p>
        </div>

    </div>

</div>

<!-- MODAL PREVIEW GAMBAR -->
<div id="imageModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded shadow-lg p-4 max-w-lg w-full relative">
        <button onclick="closePreviewPopup()" class="absolute top-2 right-2 text-gray-600 hover:text-black">
            <i class="fas fa-times"></i>
        </button>
        <img id="popupImage" src="#" alt="Preview" class="max-w-full max-h-[70vh] mx-auto">
    </div>
</div>

@endsection


@push('scripts')
<script>
let currentPreviewImage = null;

function setPreviewImage(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => currentPreviewImage = e.target.result;
        reader.readAsDataURL(file);
    }
}

function openPreviewPopup() {
    if (currentPreviewImage) {
        document.getElementById('popupImage').src = currentPreviewImage;
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('imageModal').classList.add('flex');
    } else {
        alert('Belum ada gambar dipilih.');
    }
}

function closePreviewPopup() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
}

document.getElementById('btnSubmit').addEventListener('click', function () {
    Swal.fire({
        title: 'Simpan Produk Baru?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById('formProduk').submit();
    });
});

document.getElementById('formProduk').addEventListener('keypress', function (e) {
    if (e.key === 'Enter' && !e.target.matches('textarea')) {
        e.preventDefault();
        document.getElementById('btnSubmit').click();
    }
});
</script>
@endpush
