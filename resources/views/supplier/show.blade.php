@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Detail Section -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-8 py-6 flex items-center gap-4">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Detail Supplier</h1>
                    <p class="text-teal-100 text-sm mt-1">Informasi lengkap supplier</p>
                </div>
            </div>

            <!-- Detail Content -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode Supplier -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            <i class="fas fa-barcode text-teal-500 mr-2"></i>Kode Supplier
                        </label>
                        <div class="flex items-center gap-2">
                            <span class="bg-teal-100 text-teal-700 px-4 py-2 rounded-lg font-bold text-lg">
                                {{ $supplier->kode_supplier }}
                            </span>
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            <i class="fas fa-toggle-on text-teal-500 mr-2"></i>Status
                        </label>
                        @if(strtolower($supplier->status) === 'aktif')
                            <span class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold inline-flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>Aktif
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-lg font-semibold inline-flex items-center gap-2">
                                <i class="fas fa-times-circle"></i>Nonaktif
                            </span>
                        @endif
                    </div>

                    <!-- Nama Supplier -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            <i class="fas fa-store text-teal-500 mr-2"></i>Nama Supplier
                        </label>
                        <p class="text-gray-900 font-semibold text-lg">{{ $supplier->nama_supplier }}</p>
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            <i class="fas fa-phone text-teal-500 mr-2"></i>Telepon
                        </label>
                        <p class="text-gray-900 font-semibold">
                            @if($supplier->telepon)
                                <a href="tel:{{ $supplier->telepon }}" class="text-teal-600 hover:text-teal-700 transition-all">
                                    {{ $supplier->telepon }}
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </p>
                    </div>

                    <!-- Alamat (Full Width) -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            <i class="fas fa-map-marker-alt text-teal-500 mr-2"></i>Alamat
                        </label>
                        <p class="text-gray-900 leading-relaxed">{{ $supplier->alamat ?? '-' }}</p>
                    </div>

                    <!-- Catatan (Full Width) -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            <i class="fas fa-sticky-note text-teal-500 mr-2"></i>Catatan
                        </label>
                        <p class="text-gray-900 leading-relaxed">{{ $supplier->catatan ?? '-' }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mt-8 pt-6 border-t-2 border-gray-200">
                    <a href="{{ route('supplier.index') }}" class="flex-1 px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all duration-200 text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <a href="{{ route('supplier.edit', $supplier->id) }}" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl text-center">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <button onclick="deleteSupplier({{ $supplier->id }})" class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-teal-500"></i>Informasi Sistem
            </h3>
            <div class="space-y-4">
                <div class="bg-gray-50 rounded-lg p-3 border-l-4 border-teal-500">
                    <p class="text-xs font-semibold text-gray-600 mb-1">DIBUAT PADA</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $supplier->created_at?->format('d M Y H:i') ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 border-l-4 border-teal-500">
                    <p class="text-xs font-semibold text-gray-600 mb-1">DIUBAH TERAKHIR</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $supplier->updated_at?->format('d M Y H:i') ?? '-' }}</p>
                </div>
                <div class="bg-teal-50 border-l-4 border-teal-500 p-3 rounded">
                    <p class="text-sm font-semibold text-teal-700 mb-1"><i class="fas fa-tag mr-1"></i>ID</p>
                    <p class="text-sm font-mono text-teal-600">{{ $supplier->id }}</p>
                </div>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded">
                    <p class="text-sm font-semibold text-blue-700 mb-1"><i class="fas fa-edit mr-1"></i>Aksi</p>
                    <p class="text-xs text-blue-600">Gunakan tombol edit untuk mengubah data atau hapus untuk menghapus supplier</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Form DELETE --}}
<form id="formDelete" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteSupplier(id) {
    Swal.fire({
        title: 'Hapus Supplier?',
        text: 'Data supplier akan dihapus dan tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'px-6 py-2 rounded-lg font-semibold transition-all duration-200',
            cancelButton: 'px-6 py-2 rounded-lg font-semibold transition-all duration-200'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formDelete').action = '{{ route("supplier.destroy", ":id") }}'.replace(':id', id);
            document.getElementById('formDelete').submit();
        }
    });
}
</script>
@endpush
