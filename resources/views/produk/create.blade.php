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
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">

<!-- Form Container -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" id="formProduk" class="bg-white rounded-lg shadow-lg overflow-hidden">
            @csrf
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-violet-500 to-violet-600 px-8 py-6">
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
                        <i class="fas fa-barcode text-violet-500"></i>
                        Kode Produk
                    </label>
                    <input type="text" name="kode_produk" readonly placeholder="Auto Generated" 
                        class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-mono text-sm cursor-not-allowed">
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle"></i> Kode akan di-generate secara otomatis oleh sistem
                    </p>
                </div>

                <!-- Kategori Produk -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-layer-group text-violet-500"></i>
                        Kategori Produk <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori_id" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200 transition-all text-sm @error('kategori_id') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-cube text-violet-500"></i>
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_produk" required placeholder="Masukkan nama produk" 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200 transition-all text-sm @error('nama_produk') border-red-500 @enderror">
                    @error('nama_produk')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-tag text-violet-500"></i>
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="harga" required placeholder="Masukkan harga produk" min="0"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200 transition-all text-sm @error('harga') border-red-500 @enderror">
                    @error('harga')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-boxes text-violet-500"></i>
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stok" required placeholder="Masukkan jumlah stok" min="0"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200 transition-all text-sm @error('stok') border-red-500 @enderror">
                    @error('stok')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-toggle-on text-violet-500"></i>
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200 transition-all text-sm @error('status') border-red-500 @enderror">
                        <option value="">Pilih Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Gambar Produk -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-image text-violet-500"></i>
                        Gambar Produk
                    </label>
                    <input type="file" name="gambar" accept="image/*" onchange="setPreviewImage(this)"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200 transition-all text-sm @error('gambar') border-red-500 @enderror">
                    <button type="button" onclick="openPreviewPopup()" class="mt-2 text-sm text-violet-600 hover:text-violet-700 flex items-center gap-1">
                        <i class="fas fa-eye"></i> Pratinjau Gambar
                    </button>
                    @error('gambar')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Form Footer -->
            <div class="bg-gray-50 px-8 py-6 flex justify-between gap-4 border-t-2 border-gray-100">
                <a href="{{ route('produk.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="button" id="btnSubmit" class="px-6 py-2 bg-gradient-to-r from-violet-500 to-violet-600 text-white rounded-lg hover:from-violet-600 hover:to-violet-700 transition-all duration-200 font-semibold text-sm flex items-center gap-2 shadow-lg">
                    <i class="fas fa-save"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>

    <!-- Info Sidebar -->
    <div class="lg:col-span-1">
        <!-- Tips Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb text-violet-500"></i>Tips Berguna
            </h3>
            <div class="space-y-4">
                <div class="bg-violet-50 border-l-4 border-violet-500 p-3 rounded">
                    <p class="text-sm font-semibold text-violet-700 mb-1"><i class="fas fa-cube mr-1"></i>Produk</p>
                    <p class="text-xs text-violet-600">Nama produk harus unik dan deskriptif untuk memudahkan pencarian</p>
                </div>
                <div class="bg-green-50 border-l-4 border-green-500 p-3 rounded">
                    <p class="text-sm font-semibold text-green-700 mb-1"><i class="fas fa-layer-group mr-1"></i>Kategori</p>
                    <p class="text-xs text-green-600">Pilih kategori yang sesuai untuk organisasi data yang lebih baik</p>
                </div>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded">
                    <p class="text-sm font-semibold text-blue-700 mb-1"><i class="fas fa-tag mr-1"></i>Harga</p>
                    <p class="text-xs text-blue-600">Masukkan harga jual produk dalam format rupiah tanpa pemisah</p>
                </div>
                <div class="bg-orange-50 border-l-4 border-orange-500 p-3 rounded">
                    <p class="text-sm font-semibold text-orange-700 mb-1"><i class="fas fa-boxes mr-1"></i>Stok</p>
                    <p class="text-xs text-orange-600">Stok kurang dari 10 unit akan ditampilkan sebagai stok rendah</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Gambar -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
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
        reader.onload = function (e) {
            currentPreviewImage = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function openPreviewPopup() {
    if (currentPreviewImage) {
        document.getElementById('popupImage').src = currentPreviewImage;
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('imageModal').classList.add('flex');
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Belum ada gambar',
            text: 'Silakan pilih gambar terlebih dahulu',
            confirmButtonColor: '#7c3aed'
        });
    }
}

function closePreviewPopup() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
}

document.getElementById('btnSubmit').addEventListener('click', function() {
    Swal.fire({
        title: 'Simpan Produk Baru?',
        text: 'Pastikan semua data sudah benar',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#7c3aed',
        cancelButtonColor: '#d1d5db',
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'px-6 py-2 rounded-lg font-semibold transition-all duration-200',
            cancelButton: 'px-6 py-2 rounded-lg font-semibold transition-all duration-200'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formProduk').submit();
        }
    });
});
</script>
@endpush

