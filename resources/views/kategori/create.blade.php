    @extends('layouts.app')

    @section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-6">
          
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-white text-lg"></i>
                    </div>
                    Tambah Kategori Baru
                </h1>
                <p class="text-gray-500 mt-2">Isi formulir di bawah untuk membuat kategori produk baru</p>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('kategori.store') }}" method="POST" id="formKategori" class="bg-white rounded-lg shadow-lg overflow-hidden">
                @csrf
                
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-6">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        Informasi Kategori
                    </h2>
                </div>

                <!-- Form Body -->
                <div class="p-8 space-y-6">
                    
                    <!-- Kode Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-barcode text-red-500"></i>
                            Kode Kategori
                        </label>
                        <input type="text" name="kode_kategori" readonly placeholder="Auto Generated" 
                            class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-mono text-sm cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle"></i> Kode akan di-generate secara otomatis oleh sistem
                        </p>
                    </div>

                    <!-- Nama Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-tag text-red-500"></i>
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_kategori" required placeholder="Contoh: Elektronik, Fashion, Makanan" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all text-sm"
                            @error('nama_kategori') class="border-red-500 focus:border-red-500 focus:ring-red-200" @enderror>
                        @error('nama_kategori')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-align-left text-red-500"></i>
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" rows="4" placeholder="Jelaskan kategori ini secara singkat dan jelas..." 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-green-200 transition-all text-sm resize-none"
                            @error('deskripsi') class="border-red-500 focus:border-red-500 focus:ring-red-200" @enderror></textarea>
                        <p class="text-xs text-gray-500 mt-2">Maksimal 500 karakter</p>
                        @error('deskripsi')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-toggle-on text--500"></i>
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
                </div>

                <!-- Form Footer -->
                <div class="bg-gray-50 px-8 py-6 flex justify-between gap-4 border-t-2 border-gray-100">
                    <a href="{{ route('kategori.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm flex items-center gap-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="button" id="btnSubmit" class="px-6 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 font-semibold text-sm flex items-center gap-2 shadow-lg">
                        <i class="fas fa-save"></i> Simpan Kategori
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
                        <span>Gunakan nama kategori yang jelas dan deskriptif</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-500 font-bold">•</span>
                        <span>Hindari nama kategori yang terlalu panjang</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-500 font-bold">•</span>
                        <span>Berikan deskripsi yang memudahkan identifikasi</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-500 font-bold">•</span>
                        <span>Pilih status "Aktif" agar kategori bisa digunakan</span>
                    </li>
                </ul>
            </div>

            <!-- Info Card -->
            <div class="bg-green-50 border-2 border-red-200 rounded-lg p-6">
                <h3 class="font-bold text-red-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-red-500"></i>
                    Informasi
                </h3>
                <p class="text-sm text-red-800">
                    Kategori adalah pengelompokan produk yang membantu organisasi dan pencarian produk lebih mudah. Setiap kategori harus memiliki nama unik.
                </p>
            </div>
        </div>
    </div>

    @endsection

    @push('scripts')
    <script>
        document.getElementById('btnSubmit').addEventListener('click', function () {
            const form = document.getElementById('formKategori');
            const namKategori = form.nama_kategori.value.trim();

            if (!namKategori) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Error',
                    text: 'Nama kategori harus diisi!',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            Swal.fire({
                title: 'Simpan Kategori Baru?',
                text: 'Pastikan semua data sudah benar sebelum menyimpan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#22c55e',
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
        document.getElementById('formKategori').addEventListener('keypress', function (e) {
            if (e.key === 'Enter' && !e.target.matches('textarea')) {
                e.preventDefault();
                document.getElementById('btnSubmit').click();
            }
        });
    </script>
    @endpush