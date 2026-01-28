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
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-white text-lg"></i>
                </div>
                Detail Produk
            </h1>
            <p class="text-gray-500 mt-2">Informasi lengkap tentang produk</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Detail Card -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">

            <!-- Card Header -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-8 py-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-box-open"></i>
                    {{ $produk->nama_produk }}
                </h2>
                <p class="text-purple-100 text-sm mt-1">
                    Kode Produk: <span class="font-mono">{{ $produk->kode_produk }}</span>
                </p>
            </div>

            <!-- Card Body -->
            <div class="p-8 space-y-6">

                <!-- Kategori -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                        <i class="fas fa-tags text-purple-500"></i>
                        Kategori Produk
                    </p>
                    <p class="text-lg font-bold text-gray-900">
                        {{ $produk->kategori->nama_kategori }}
                    </p>
                </div>

                <!-- Nama Produk -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                        <i class="fas fa-box text-purple-500"></i>
                        Nama Produk
                    </p>
                    <p class="text-lg font-bold text-gray-900">{{ $produk->nama_produk }}</p>
                </div>

                <!-- Harga -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                        <i class="fas fa-money-bill text-purple-500"></i>
                        Harga
                    </p>
                    <p class="text-lg font-bold text-gray-900">
                        Rp{{ number_format($produk->harga, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Stok -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                        <i class="fas fa-cubes text-purple-500"></i>
                        Stok
                    </p>
                    <p class="text-lg font-bold text-gray-900">{{ $produk->stok }}</p>
                </div>

                <!-- Status -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-3 flex items-center gap-2">
                        <i class="fas fa-toggle-on text-purple-500"></i>
                        Status
                    </p>

                    @if(strtolower($produk->status) === 'aktif')
                        <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold text-sm">
                            <i class="fas fa-check-circle"></i> Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-4 py-2 rounded-lg font-semibold text-sm">
                            <i class="fas fa-times-circle"></i> Nonaktif
                        </span>
                    @endif
                </div>

                <!-- Gambar Produk -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-3 flex items-center gap-2">
                        <i class="fas fa-image text-purple-500"></i>
                        Gambar Produk
                    </p>

                    @if($produk->gambar)
                        <img src="{{ asset('storage/'.$produk->gambar) }}" 
                             onclick="openPreviewPopup()"
                             class="w-40 h-40 object-cover rounded-lg shadow cursor-pointer hover:opacity-90 transition">
                    @else
                        <p class="text-gray-500 italic">Tidak ada gambar</p>
                    @endif
                </div>

                <!-- Timestamp -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 -mx-8 -mb-8 px-8 py-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Dibuat pada</p>
                        <p class="text-sm font-medium">{{ $produk->created_at?->format('d M Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $produk->created_at?->format('H:i:s') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Diperbarui pada</p>
                        <p class="text-sm font-medium">{{ $produk->updated_at?->format('d M Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $produk->updated_at?->format('H:i:s') }}</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex gap-4">
            <a href="{{ route('produk.edit', $produk->id) }}" 
               class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold text-sm flex items-center justify-center gap-2 shadow-lg">
                <i class="fas fa-edit"></i> Edit Produk
            </a>

            <button onclick="deleteProduk({{ $produk->id }})" 
                    class="flex-1 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 font-semibold text-sm flex items-center justify-center gap-2 shadow-lg">
                <i class="fas fa-trash"></i> Hapus Produk
            </button>

            <a href="{{ route('produk.index') }}" 
               class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1">

        <!-- Informasi Produk -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-purple-500"></i>
                Informasi Produk
            </h3>

            <div class="space-y-3 text-sm text-gray-700">
                <div>
                    <p class="text-gray-500 text-xs font-semibold mb-1">ID Produk</p>
                    <p class="font-mono">{{ $produk->id }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs font-semibold mb-1">Jenis Data</p>
                    <p>Data Produk</p>
                </div>
            </div>
        </div>

        <!-- Tips -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6">
            <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb text-blue-500"></i>
                Aksi yang dapat dilakukan
            </h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li class="flex gap-2"><span class="text-blue-500 font-bold">✓</span>Edit produk</li>
                <li class="flex gap-2"><span class="text-blue-500 font-bold">✓</span>Mengedit harga</li>
                <li class="flex gap-2"><span class="text-blue-500 font-bold">✓</span>Lihat riwayat harga</li>
                <li class="flex gap-2"><span class="text-blue-500 font-bold">✓</span>Lihat mutasi stok</li>
            </ul>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
function deleteProduk(id) {
    Swal.fire({
        title: 'Hapus Produk?',
        text: 'Data yang dihapus tidak dapat dipulihkan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((res) => {
        if(res.isConfirmed){
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/produk/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function openPreviewPopup(){
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageModal').classList.add('flex');
}
function closePreviewPopup(){
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
}
</script>
@endpush
