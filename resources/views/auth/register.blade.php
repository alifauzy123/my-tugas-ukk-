<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRASI UMKM RESTO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-red-50 via-rose-50 to-pink-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl">
        <!-- Card utama -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-t-4 border-red-600">
            
            <!-- Header dengan gradient -->
        <div class="bg-gradient-to-r from-red-600 to-rose-600 px-8 py-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full mb-4">
                <i class="fas fa-user-plus text-red-600 text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Buat Akun Baru</h1>
                <p class="text-indigo-100">Bergabunglah dengan kami sekarang dan mulai belanja</p>
            </div>

            <!-- Form content -->
            <div class="p-8 md:p-10">
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf

                    <!-- Biodata Section -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
                            <i class="fas fa-id-card text-red-600"></i> Biodata Pribadi
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            
                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user text-red-500 mr-1"></i>Nama Lengkap
                                </label>
                                <input type="text" name="nama_lengkap" required 
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                                    placeholder="Masukkan nama lengkap">
                                @error('nama_lengkap')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar text-red-500 mr-1"></i>Tanggal Lahir
                                </label>
                                <input type="date" name="tanggal_lahir" 
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all">
                                @error('tanggal_lahir')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-person text-red-500 mr-1"></i>Jenis Kelamin
                                </label>
                                <select name="jenis_kelamin" 
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                @error('jenis_kelamin')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-envelope text-red-500 mr-1"></i>Email
                                </label>
                                <input type="email" name="email" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                                    placeholder="nama@email.com">
                                @error('email')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            <!-- No HP -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-phone text-red-500 mr-1"></i>Nomor HP
                                </label>
                                <input type="text" name="no_hp" 
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                                    placeholder="08xx xxxx xxxx">
                                @error('no_hp')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-map-pin text-red-500 mr-1"></i>Alamat
                                </label>
                                <input type="text" name="alamat" 
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                                    placeholder="Masukkan alamat lengkap">
                                @error('alamat')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="flex items-center gap-3 mb-8">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="text-gray-400 text-sm">Keamanan Akun</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    <!-- Password Section -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
                            <i class="fas fa-lock text-red-600"></i> Password & Keamanan
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            <!-- Username -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-at text-red-500 mr-1"></i>Username
                                </label>
                                <input type="text" name="username" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                                    placeholder="Pilih username unik">
                                @error('username')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-key text-red-500 mr-1"></i>Password
                                </label>
                                <input type="password" name="password" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                                    placeholder="Minimal 6 karakter">
                                @error('password')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-check-circle text-red-500 mr-1"></i>Konfirmasi Password
                                </label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                                    placeholder="Masukkan ulang password Anda">
                                @error('password_confirmation')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-red-600 to-rose-600 text-white py-3 rounded-lg font-bold text-lg hover:from-red-700 hover:to-rose-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <i class="fas fa-user-check"></i> Daftar Akun
                    </button>

                    <!-- Login Link -->
                    <p class="text-center text-gray-600 mt-6">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-red-600 font-bold hover:text-rose-600 transition-colors">
                            Login di sini
                        </a>
                    </p>

                </form>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-center mt-8 text-gray-600 text-sm">
            <p>Dengan mendaftar, Anda setuju dengan Syarat & Ketentuan kami</p>
        </div>
    </div>

</body>
</html>
