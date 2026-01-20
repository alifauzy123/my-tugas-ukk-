@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('produk.index') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center text-gray-700 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-violet-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-edit text-white text-lg"></i>
                </div>
                Edit Produk
            </h1>
            <p class="text-gray-500 mt-2">Perbarui informasi produk</p>
        </div>
    </div>
</div>

<!-- Form Container -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" id="formProduk" class="bg-white rounded-lg shadow-lg overflow-hidden">
            @csrf
            @method('PUT')
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-violet-500 to-violet-600 px-8 py-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit Informasi Produk
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
                    <input type="text" name="kode_produk" value="{{ $produk->kode_produk }}" readonly
                        class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-mono text-sm cursor-not-allowed">
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle"></i> Kode tidak dapat diubah
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
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ $produk->kategori_id == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
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
                    <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" required
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
                    <input type="number" name="harga" value="{{ $produk->harga }}" required min="0"
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
                    <input type="number" name="stok" value="{{ $produk->stok }}" required min="0"
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
                        <option value="Aktif" {{ $produk->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ $produk->status === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle"></i> Biarkan kosong jika tidak ingin mengubah gambar
                    </p>
                    <button type="button" onclick="openPreviewPopup()" class="mt-2 text-sm text-violet-600 hover:text-violet-700 flex items-center gap-1">
                        <i class="fas fa-eye"></i> Pratinjau Gambar
                    </button>
                    @error('gambar')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                    @if($produk->gambar)
                        <input type="hidden" id="existingImage" value="{{ asset('storage/' . $produk->gambar) }}">
                    @endif
                </div>
            </div>

            <!-- Form Footer -->
            <div class="bg-gray-50 px-8 py-6 flex justify-between gap-4 border-t-2 border-gray-100">
                <a href="{{ route('produk.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="button" id="btnSubmit" class="px-6 py-2 bg-gradient-to-r from-violet-500 to-violet-600 text-white rounded-lg hover:from-violet-600 hover:to-violet-700 transition-all duration-200 font-semibold text-sm flex items-center gap-2 shadow-lg">
                    <i class="fas fa-save"></i> Update Produk
                </button>
            </div>
        </form>
    </div>

    <!-- Info Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-violet-500"></i>Informasi Data
            </h3>
            <div class="space-y-4">
                <div class="bg-gray-50 rounded-lg p-3 border-l-4 border-violet-500">
                    <p class="text-xs font-semibold text-gray-600 mb-1">DIBUAT PADA</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $produk->created_at?->format('d M Y H:i') ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 border-l-4 border-violet-500">
                    <p class="text-xs font-semibold text-gray-600 mb-1">DIUBAH TERAKHIR</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $produk->updated_at?->format('d M Y H:i') ?? '-' }}</p>
                </div>
                <div class="bg-violet-50 border-l-4 border-violet-500 p-3 rounded">
                    <p class="text-sm font-semibold text-violet-700 mb-1"><i class="fas fa-tag mr-1"></i>ID Produk</p>
                    <p class="text-sm font-mono text-violet-600">{{ $produk->id }}</p>
                </div>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded">
                    <p class="text-sm font-semibold text-blue-700 mb-1"><i class="fas fa-warning mr-1"></i>Perhatian</p>
                    <p class="text-xs text-blue-600">Perubahan data akan langsung disimpan ke sistem. Pastikan semua informasi sudah benar.</p>
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
    let selectedFile = null;

    function setPreviewImage(input) {
        if (input.files && input.files[0]) {
            selectedFile = input.files[0];
        }
    }

    function openPreviewPopup() {
        let imageSrc = '';
        
        if (selectedFile) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('popupImage').src = e.target.result;
            };
            reader.readAsDataURL(selectedFile);
        } else if (document.getElementById('existingImage')) {
            imageSrc = document.getElementById('existingImage').value;
            document.getElementById('popupImage').src = imageSrc;
        }
        
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('imageModal').classList.add('flex');
    }

    function closePreviewPopup() {
        document.getElementById('imageModal').classList.add('hidden');
        document.getElementById('imageModal').classList.remove('flex');
    }

    document.getElementById('btnSubmit').addEventListener('click', function() {
        Swal.fire({
            title: 'Konfirmasi Update',
            text: 'Apakah Anda yakin ingin memperbarui produk ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Update',
            cancelButtonText: 'Batal',
            customClass: {
                container: 'swal2-custom',
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-btn-custom',
                cancelButton: 'swal2-cancel-btn-custom'
            },
            buttonsStyling: false,
            confirmButtonColor: '#7c3aed'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formProduk').submit();
            }
        });
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePreviewPopup();
        }
    });
</script>
@endpush


