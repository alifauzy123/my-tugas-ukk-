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
                    <i class="fas fa-eye text-white text-lg"></i>
                </div>
                Detail Produk
            </h1>
            <p class="text-gray-500 mt-2">Informasi lengkap produk</p>
        </div>
    </div>
</div>

<!-- Main Container -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-violet-500 to-violet-600 px-8 py-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-box"></i>
                    Informasi Produk
                </h2>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-6">
                <!-- Kode Produk -->
                <div>
                    <label class="text-xs font-bold text-gray-600 mb-2 flex items-center gap-2 uppercase tracking-wider">
                        <i class="fas fa-barcode text-violet-500"></i> Kode Produk
                    </label>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-violet-100 text-violet-700 rounded-full text-sm font-semibold font-mono">
                            {{ $produk->kode_produk }}
                        </span>
                    </div>
                </div>

                <!-- Kategori -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-bold text-gray-600 mb-2 flex items-center gap-2 uppercase tracking-wider">
                            <i class="fas fa-layer-group text-violet-500"></i> Kategori
                        </label>
                        <p class="text-base font-semibold text-gray-900">
                            {{ $produk->kategori?->nama_kategori ?? '-' }}
                        </p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="text-xs font-bold text-gray-600 mb-2 flex items-center gap-2 uppercase tracking-wider">
                            <i class="fas fa-toggle-on text-violet-500"></i> Status
                        </label>
                        @if($produk->status === 'Aktif')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold inline-block">
                                <i class="fas fa-check-circle mr-1"></i> Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold inline-block">
                                <i class="fas fa-times-circle mr-1"></i> Nonaktif
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="text-xs font-bold text-gray-600 mb-2 flex items-center gap-2 uppercase tracking-wider">
                        <i class="fas fa-cube text-violet-500"></i> Nama Produk
                    </label>
                    <p class="text-base font-semibold text-gray-900">{{ $produk->nama_produk }}</p>
                </div>

                <!-- Harga dan Stok -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-bold text-gray-600 mb-2 flex items-center gap-2 uppercase tracking-wider">
                            <i class="fas fa-tag text-violet-500"></i> Harga
                        </label>
                        <p class="text-base font-semibold text-gray-900">
                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-600 mb-2 flex items-center gap-2 uppercase tracking-wider">
                            <i class="fas fa-boxes text-violet-500"></i> Stok
                        </label>
                        @if($produk->stok < 10)
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold inline-block">
                                {{ $produk->stok }} unit (Rendah)
                            </span>
                        @else
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold inline-block">
                                {{ $produk->stok }} unit
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Gambar Produk -->
                <div>
                    <label class="text-xs font-bold text-gray-600 mb-2 flex items-center gap-2 uppercase tracking-wider">
                        <i class="fas fa-image text-violet-500"></i> Gambar Produk
                    </label>
                    @if($produk->gambar)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}"
                                onclick="openPreviewPopup()"
                                class="w-full max-w-sm h-64 object-cover rounded-lg border-2 border-gray-200 hover:border-violet-500 cursor-pointer transition-all duration-200 hover:shadow-lg">
                            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i> Klik untuk memperbesar
                            </p>
                        </div>
                    @else
                        <div class="w-full max-w-sm h-64 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                            <p class="text-gray-400 text-center">
                                <i class="fas fa-image text-2xl mb-2 block"></i>
                                Tidak ada gambar
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-8 py-6 border-t-2 border-gray-100 flex justify-between gap-4">
                <a href="{{ route('produk.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-3">
                    <a href="{{ route('produk.edit', $produk->id) }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-200 font-semibold text-sm flex items-center gap-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" onclick="deleteProduk({{ $produk->id }})" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-200 font-semibold text-sm flex items-center gap-2">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-violet-500"></i> Informasi Sistem
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
                    <p class="text-sm font-semibold text-blue-700 mb-1"><i class="fas fa-layer-group mr-1"></i>ID Kategori</p>
                    <p class="text-sm font-mono text-blue-600">{{ $produk->kategori_id }}</p>
                </div>
                @if($produk->stok < 10)
                    <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded">
                        <p class="text-sm font-semibold text-red-700 mb-1"><i class="fas fa-exclamation-triangle mr-1"></i>Peringatan Stok</p>
                        <p class="text-xs text-red-600">Stok produk ini rendah, segera lakukan pengadaan ulang.</p>
                    </div>
                @endif
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
        <img id="popupImage" src="{{ asset('storage/' . $produk->gambar ?? '') }}" alt="Preview" class="max-w-full max-h-[70vh] mx-auto">
    </div>
</div>

<!-- Delete Form -->
<form id="formDelete" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
    function openPreviewPopup() {
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('imageModal').classList.add('flex');
    }

    function closePreviewPopup() {
        document.getElementById('imageModal').classList.add('hidden');
        document.getElementById('imageModal').classList.remove('flex');
    }

    function deleteProduk(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                container: 'swal2-custom',
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-btn-custom',
                cancelButton: 'swal2-cancel-btn-custom'
            },
            buttonsStyling: false,
            confirmButtonColor: '#ef4444'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formDelete').action = '{{ route("produk.destroy", ":id") }}'.replace(':id', id);
                document.getElementById('formDelete').submit();
            }
        });
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePreviewPopup();
        }
    });
</script>
@endpush
