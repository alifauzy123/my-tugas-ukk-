@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('kasir.index') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center text-gray-700 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-white text-lg"></i>
                </div>
                Tambah Data Kasir Baru
            </h1>
            <p class="text-gray-500 mt-2">Isi formulir di bawah untuk menambahkan kasir baru</p>
        </div>
    </div>
</div>

<!-- Form Container -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form action="{{ route('kasir.store') }}" method="POST" id="formKasir" class="bg-white rounded-lg shadow-lg overflow-hidden">
            @csrf
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 px-8 py-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Informasi Kasir
                </h2>
            </div>

            <!-- Form Body -->
            <div class="p-8 space-y-6">
                
                <!-- Kode Kasir -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-barcode text-cyan-500"></i>
                        Kode Kasir
                    </label>
                    <input type="text" name="kode_kasir" readonly placeholder="Auto Generated" 
                        class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-mono text-sm cursor-not-allowed">
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle"></i> Kode akan di-generate secara otomatis oleh sistem
                    </p>
                </div>

                <!-- Nama Kasir -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-user text-cyan-500"></i>
                        Nama Kasir <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_kasir" required placeholder="Masukkan nama kasir" 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all text-sm">
                    @error('nama_kasir')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-envelope text-cyan-500"></i>
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" required placeholder="Masukkan email kasir" 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all text-sm">
                    @error('email')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-phone text-cyan-500"></i>
                        No Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="no_telp" required placeholder="Masukkan nomor telepon" 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all text-sm">
                    @error('no_telp')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Shift -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-clock text-cyan-500"></i>
                        Shift <span class="text-red-500">*</span>
                    </label>
                    <select name="shift" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all text-sm">
                        <option value="">Pilih Shift</option>
                        <option value="Pagi">Pagi</option>
                        <option value="Sore">Sore</option>
                        <option value="Malam">Malam</option>
                    </select>
                    @error('shift')
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-toggle-on text-cyan-500"></i>
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all text-sm">
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
            </div>

            <!-- Form Footer -->
            <div class="bg-gray-50 px-8 py-6 flex justify-between gap-4 border-t-2 border-gray-100">
                <a href="{{ route('kasir.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="button" id="btnSubmit" class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white rounded-lg hover:from-cyan-600 hover:to-cyan-700 transition-all duration-200 font-semibold text-sm flex items-center gap-2 shadow-lg">
                    <i class="fas fa-save"></i> Simpan Kasir
                </button>
            </div>
        </form>
    </div>

    <!-- Info Sidebar -->
    <div class="lg:col-span-1">
        <!-- Tips Card -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb text-blue-500"></i>
                Tips Pengisian
            </h3>
            <ul class="space-y-3 text-sm text-blue-800">
                <li class="flex gap-2">
                    <span class="text-blue-500 font-bold">•</span>
                    <span>Gunakan nama lengkap kasir</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-blue-500 font-bold">•</span>
                    <span>Email harus valid dan aktif</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-blue-500 font-bold">•</span>
                    <span>Pilih shift kerja yang sesuai</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-blue-500 font-bold">•</span>
                    <span>Tentukan status kasir (Aktif/Nonaktif)</span>
                </li>
            </ul>
        </div>

        <!-- Info Card -->
        <div class="bg-cyan-50 border-2 border-cyan-200 rounded-lg p-6">
            <h3 class="font-bold text-cyan-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-cyan-500"></i>
                Informasi
            </h3>
            <p class="text-sm text-cyan-800">
                Data kasir ini akan digunakan untuk sistem manajemen kasir. Pastikan semua informasi sudah benar sebelum menyimpan.
            </p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('btnSubmit').addEventListener('click', function () {
        const form = document.getElementById('formKasir');
        const namaKasir = form.nama_kasir.value.trim();
        const email = form.email.value.trim();
        const noTelp = form.no_telp.value.trim();

        if (!namaKasir || !email || !noTelp) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Error',
                text: 'Semua field harus diisi!',
                confirmButtonColor: '#0891b2'
            });
            return;
        }

        Swal.fire({
            title: 'Simpan Data Kasir Baru?',
            text: 'Pastikan semua data sudah benar sebelum menyimpan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0891b2',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-lg',
                confirmButton: 'font-semibold',
                cancelButton: 'font-semibold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Enter key to submit
    document.getElementById('formKasir').addEventListener('keypress', function (e) {
        if (e.key === 'Enter' && !e.target.matches('textarea')) {
            e.preventDefault();
            document.getElementById('btnSubmit').click();
        }
    });
</script>
@endpush