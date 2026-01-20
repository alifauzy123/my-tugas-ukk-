@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('kategori.index') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center text-gray-700 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-white text-lg"></i>
                </div>
                Detail Kategori
            </h1>
            <p class="text-gray-500 mt-2">Informasi lengkap kategori produk</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Detail Card -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-8 py-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-folder-open"></i>
                    {{ $kategori->nama_kategori }}
                </h2>
                <p class="text-purple-100 text-sm mt-1">Kode: <span class="font-mono">{{ $kategori->kode_kategori }}</span></p>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-6">
                
                <!-- Kode Kategori -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                        <i class="fas fa-barcode text-purple-500"></i>
                        Kode Kategori
                    </p>
                    <p class="text-lg font-mono font-bold text-gray-900">{{ $kategori->kode_kategori }}</p>
                </div>

                <!-- Nama Kategori -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                        <i class="fas fa-tag text-purple-500"></i>
                        Nama Kategori
                    </p>
                    <p class="text-lg font-bold text-gray-900">{{ $kategori->nama_kategori }}</p>
                </div>

                <!-- Deskripsi -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                        <i class="fas fa-align-left text-purple-500"></i>
                        Deskripsi
                    </p>
                    <p class="text-base text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $kategori->deskripsi ?? '—' }}
                    </p>
                </div>

                <!-- Status -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-3 flex items-center gap-2">
                        <i class="fas fa-toggle-on text-purple-500"></i>
                        Status
                    </p>
                    @if(strtolower($kategori->status) === 'aktif')
                        <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold text-sm">
                            <i class="fas fa-check-circle"></i>
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-4 py-2 rounded-lg font-semibold text-sm">
                            <i class="fas fa-times-circle"></i>
                            Nonaktif
                        </span>
                    @endif
                </div>

                <!-- Timestamp -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 -mx-8 -mb-8 px-8 py-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                            <i class="fas fa-calendar-plus text-purple-500"></i>
                            Dibuat pada
                        </p>
                        <p class="text-sm font-medium text-gray-900">{{ $kategori->created_at?->format('d M Y') ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $kategori->created_at?->format('H:i:s') ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                            <i class="fas fa-sync-alt text-purple-500"></i>
                            Diperbarui pada
                        </p>
                        <p class="text-sm font-medium text-gray-900">{{ $kategori->updated_at?->format('d M Y') ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $kategori->updated_at?->format('H:i:s') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex gap-4">
            <a href="{{ route('kategori.edit', $kategori->id) }}" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 font-semibold text-sm flex items-center justify-center gap-2 shadow-lg">
                <i class="fas fa-edit"></i>
                Edit Kategori
            </a>
            <button onclick="deleteKategori({{ $kategori->id }})" class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 font-semibold text-sm flex items-center justify-center gap-2 shadow-lg">
                <i class="fas fa-trash"></i>
                Hapus Kategori
            </button>
            <a href="{{ route('kategori.index') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1">
        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-purple-500"></i>
                Status Kategori
            </h3>
            <div class="space-y-3">
                @if(strtolower($kategori->status) === 'aktif')
                    <div class="bg-green-50 border-l-4 border-green-500 p-3 rounded">
                        <p class="text-sm text-green-800">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            Kategori ini <span class="font-bold">aktif</span> dan dapat digunakan untuk produk baru.
                        </p>
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-exclamation-circle text-yellow-600 mr-2"></i>
                            Kategori ini <span class="font-bold">nonaktif</span> dan tidak dapat digunakan untuk produk baru.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Info Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-list text-purple-500"></i>
                Informasi
            </h3>
            <div class="space-y-3 text-sm text-gray-700">
                <div>
                    <p class="text-gray-500 text-xs font-semibold mb-1">ID Kategori</p>
                    <p class="font-mono text-gray-900">{{ $kategori->id }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs font-semibold mb-1">Jenis Data</p>
                    <p class="text-gray-900">Kategori Produk</p>
                </div>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6">
            <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb text-blue-500"></i>
                Aksi yang dapat dilakukan
            </h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li class="flex gap-2">
                    <span class="text-blue-500 font-bold">✓</span>
                    <span>Edit informasi kategori</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-blue-500 font-bold">✓</span>
                    <span>Ubah status kategori</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-blue-500 font-bold">✓</span>
                    <span>Hapus kategori</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-blue-500 font-bold">✓</span>
                    <span>Kembali ke daftar</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function deleteKategori(id) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: 'Data yang dihapus tidak dapat dipulihkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-lg',
                confirmButton: 'font-semibold',
                cancelButton: 'font-semibold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/kategori/${id}`;
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endpush
