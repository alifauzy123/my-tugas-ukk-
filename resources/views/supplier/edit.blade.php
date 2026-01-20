@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Section -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-6 flex items-center gap-4">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-edit text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Edit Supplier</h1>
                    <p class="text-blue-100 text-sm mt-1">ID: <span class="font-semibold">{{ $supplier->id }}</span></p>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" class="p-8" id="formSupplier">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Kode Supplier -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-barcode text-blue-500 mr-2"></i>Kode Supplier
                        </label>
                        <input type="text" readonly value="{{ $supplier->kode_supplier }}"
                            class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-semibold">
                        <p class="text-xs text-gray-500 mt-1">Kode tidak dapat diubah</p>
                    </div>

                    <!-- Nama Supplier -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-store text-blue-500 mr-2"></i>Nama Supplier <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_supplier" required value="{{ $supplier->nama_supplier }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('nama_supplier') border-red-500 @enderror">
                        @error('nama_supplier')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone text-blue-500 mr-2"></i>Telepon
                        </label>
                        <input type="text" name="telepon" value="{{ $supplier->telepon }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('telepon') border-red-500 @enderror">
                        @error('telepon')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>Alamat
                        </label>
                        <textarea name="alamat" rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all resize-none @error('alamat') border-red-500 @enderror">{{ $supplier->alamat }}</textarea>
                        @error('alamat')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-toggle-on text-blue-500 mr-2"></i>Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" required 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('status') border-red-500 @enderror">
                            <option value="Aktif" {{ $supplier->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ $supplier->status === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-sticky-note text-blue-500 mr-2"></i>Catatan
                        </label>
                        <textarea name="catatan" rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all resize-none @error('catatan') border-red-500 @enderror">{{ $supplier->catatan }}</textarea>
                        @error('catatan')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 mt-8 pt-6 border-t-2 border-gray-200">
                    <a href="{{ route('supplier.index') }}" class="flex-1 px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all duration-200 text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="button" id="btnSubmit" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>Update Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500"></i>Informasi Data
            </h3>
            <div class="space-y-4">
                <div class="bg-gray-50 rounded-lg p-3 border-l-4 border-blue-500">
                    <p class="text-xs font-semibold text-gray-600 mb-1">DIBUAT PADA</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $supplier->created_at?->format('d M Y H:i') ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 border-l-4 border-blue-500">
                    <p class="text-xs font-semibold text-gray-600 mb-1">DIUBAH TERAKHIR</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $supplier->updated_at?->format('d M Y H:i') ?? '-' }}</p>
                </div>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded">
                    <p class="text-sm font-semibold text-blue-700 mb-1"><i class="fas fa-warning mr-1"></i>Perhatian</p>
                    <p class="text-xs text-blue-600">Perubahan data akan langsung disimpan ke sistem. Pastikan semua informasi sudah benar.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('btnSubmit').addEventListener('click', function() {
    Swal.fire({
        title: 'Update Data Supplier?',
        text: 'Perubahan akan langsung disimpan ke sistem',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#d1d5db',
        confirmButtonText: 'Ya, Update',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'px-6 py-2 rounded-lg font-semibold transition-all duration-200',
            cancelButton: 'px-6 py-2 rounded-lg font-semibold transition-all duration-200'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formSupplier').submit();
        }
    });
});
</script>
@endpush

