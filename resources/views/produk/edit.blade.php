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
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box-open text-white text-lg"></i>
                </div>
                Edit Produk
            </h1>
            <p class="text-gray-500 mt-2">Ubah informasi produk barang</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" 
              id="formProduk" class="bg-white rounded-lg shadow-lg overflow-hidden">

            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-pencil-alt"></i>
                    Edit Informasi Produk
                </h2>
                <p class="text-blue-100 text-sm mt-1">
                    ID: <span class="font-mono">{{ $produk->id }}</span>
                </p>
            </div>

            <!-- Form Body -->
            <div class="p-8 space-y-6">

                {{-- Kode Produk --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Kode Produk</label>
                    <input type="text" name="kode_produk" readonly value="{{ $produk->kode_produk }}"
                        class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-mono text-sm cursor-not-allowed">
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Kategori</label>
                    <select name="kategori_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm">
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ $produk->kategori_id == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Produk --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm" required>
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Harga</label>
                    <input type="number" name="harga" value="{{ $produk->harga }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm" required>
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Stok</label>
                    <input type="number" name="stok" value="{{ $produk->stok }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm" required>
                </div>

                {{-- Gambar Produk --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Gambar Produk</label>
                    <div class="relative">
                        <input type="file" name="gambar" accept="image/*" onchange="setPreviewImage(this)"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm">

                        <button type="button" onclick="openPreviewPopup()"
                            class="absolute top-3 right-3 text-gray-500 hover:text-black">
                            <i class="fas fa-eye"></i>
                        </button>

                        @if($produk->gambar)
                            <input type="hidden" id="existingImage" value="{{ asset('storage/' . $produk->gambar) }}">
                        @endif
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Status</label>
                    <select name="status" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm">
                        <option value="Aktif" {{ $produk->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ $produk->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                {{-- Timestamp Info --}}
                <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4 text-xs">
                    <p class="text-gray-600">
                        <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                        <strong>Dibuat:</strong> {{ $produk->created_at?->format('d M Y H:i') }}
                    </p>
                    <p class="text-gray-600 mt-2">
                        <i class="fas fa-sync-alt text-gray-400 mr-2"></i>
                        <strong>Diperbarui:</strong> {{ $produk->updated_at?->format('d M Y H:i') }}
                    </p>
                </div>

            </div>

            <!-- Form Footer -->
            <div class="bg-gray-50 px-8 py-6 flex justify-between gap-4 border-t-2 border-gray-100">
                <a href="{{ route('produk.index') }}"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>

                <button type="button" id="btnSubmit"
                    class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 font-semibold text-sm flex items-center gap-2 shadow-lg">
                    <i class="fas fa-check"></i> Update Produk
                </button>
            </div>

        </form>
    </div>

    <!-- Sidebar Tips -->
    <div class="lg:col-span-1">

        <div class="bg-amber-50 border-2 border-amber-200 rounded-lg p-6 mb-6">
            <h3 class="font-bold text-amber-900 mb-4 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-amber-500"></i>
                Perhatian
            </h3>
            <ul class="space-y-3 text-sm text-amber-800">
                <li>Kode produk tidak dapat diubah</li>
                <li>Harga mempengaruhi laporan dan transaksi</li>
                <li>Pastikan kategori sesuai dengan produk</li>
            </ul>
        </div>

        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6">
            <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb text-blue-500"></i>
                Tips Produk
            </h3>
            <ul class="space-y-3 text-sm text-blue-800">
                <li>Isi deskripsi yang jelas pada produk</li>
                <li>Gunakan gambar berkualitas agar mudah dikenali</li>
                <li>Nonaktifkan produk yang sudah tidak dijual</li>
            </ul>
        </div>

    </div>
</div>

<!-- Modal Preview Gambar -->
<div id="imageModal" 
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
     
    <div class="bg-white rounded shadow-lg p-4 max-w-lg w-full relative">
        <button onclick="closePreviewPopup()" 
                class="absolute top-2 right-2 text-gray-600 hover:text-black">
            <i class="fas fa-times"></i>
        </button>

        <img id="popupImage" 
             src="{{ asset('storage/' . $produk->gambar) }}" 
             class="max-w-full max-h-[70vh] mx-auto">
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentPreviewImage = document.getElementById('existingImage')?.value || null;

function setPreviewImage(input) {
    if (input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => currentPreviewImage = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}

function openPreviewPopup() {
    if (!currentPreviewImage) {
        return Swal.fire('Tidak ada gambar', '', 'info');
    }
    document.getElementById('popupImage').src = currentPreviewImage;
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageModal').classList.add('flex');
}

function closePreviewPopup() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
}

document.getElementById('btnSubmit').addEventListener('click', function () {
    Swal.fire({
        title: 'Update Produk?',
        text: 'Perubahan akan disimpan.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Update!'
    }).then(r => {
        if (r.isConfirmed) document.getElementById('formProduk').submit();
    });
});
</script>
@endpush
