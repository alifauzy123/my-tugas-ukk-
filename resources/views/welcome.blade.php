<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Resto - Kuliner Lokal Berkualitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white text-gray-900">

    <!-- Navigation / Header -->
    <header class="fixed top-0 left-0 right-0 bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-100 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg border border-red-100">
                    <img src="{{ asset('logoresto.png') }}" alt="UMKM Resto" class="w-7 h-7 object-contain">
                </div>
                <h1 class="text-2xl font-bold text-red-600">UMKM Resto</h1>
            </div>
            
            <nav class="hidden md:flex items-center gap-8">
                <a href="#home" class="text-gray-700 hover:text-red-600 transition font-medium">Home</a>
                <a href="#menu" class="text-gray-700 hover:text-red-600 transition font-medium">Menu</a>
                <a href="#about" class="text-gray-700 hover:text-red-600 transition font-medium">Tentang</a>
                <a href="#contact" class="text-gray-700 hover:text-red-600 transition font-medium">Kontak</a>
                <a href="{{ route('login') }}" class="px-6 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition font-semibold shadow-sm">
                    Login
                </a>
            </nav>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <a href="{{ route('login') }}" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-semibold shadow-sm">
                    Login
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="pt-24 pb-16 bg-gradient-to-br from-red-50 via-rose-50 to-white">
        <div class="container mx-auto px-6 py-20">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    {{-- <div class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                        <i class="fas fa-star"></i>
                        <span>Favorit UMKM Kuliner Lokal</span>
                    </div> --}}
                    <h2 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Selamat Datang di <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-red-600">UMKM Resto</span>
                    </h2>
                    <p class="text-xl text-gray-600 mb-8">
                        Nikmati pengalaman kuliner yang hangat dan autentik dari UMKM lokal. Hidangan berkualitas, harga bersahabat, dan rasa yang selalu bikin rindu.
                    </p>
                    <div class="flex gap-4">
                        <a href="#menu" class="px-8 py-4 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition font-semibold text-lg inline-block shadow-lg shadow-red-200">
                            Lihat Menu
                        </a>
                        <a href="#contact" class="px-8 py-4 bg-white text-red-600 border border-red-200 rounded-xl hover:border-red-300 hover:bg-red-50 transition font-semibold text-lg inline-block">
                            Hubungi Kami
                        </a>
                    </div>
                    <div class="mt-8 grid grid-cols-3 gap-4 text-center">
                        <div class="bg-white rounded-2xl border border-red-100 py-4">
                            <p class="text-2xl font-bold text-red-600">{{ $menus->count() }}</p>
                            <p class="text-sm text-gray-500">Daftar Menu</p>
                        </div>
                        
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-400 to-red-600 rounded-3xl transform rotate-6 opacity-20"></div>
                        <div class="relative bg-white rounded-3xl p-12 flex items-center justify-center shadow-xl border border-red-100">
                            <div class="text-center">
                                <img src="{{ asset('logoresto.png') }}" alt="UMKM Resto" class="w-20 h-20 mx-auto mb-4 object-contain">
                                <p class="text-2xl font-bold text-gray-800">Makanan Lezat</p>
                                <p class="text-gray-500 mt-2">Segar • Higienis • Terjangkau</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-20 bg-gradient-to-br from-red-50 via-rose-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-bold text-gray-900 mb-4">Daftar Menu</h3>
                <p class="text-xl text-gray-600">Pilihan hidangan terbaik yang kami tawarkan</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($menus as $menu)
                    <div class="bg-white border border-red-100 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300">
                        <div class="h-48 flex items-center justify-center bg-gradient-to-br from-red-400 to-red-500">
                            @if($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-utensils text-6xl text-white"></i>
                            @endif
                        </div>
                        <div class="p-6">
                            <h4 class="text-2xl font-bold text-gray-900 mb-2">{{ $menu->nama_menu }}</h4>
                            <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit($menu->deskripsi ?? '-', 110) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-red-600">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                               
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-10">
                        Menu belum tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="bg-gradient-to-br from-red-400 to-red-600 rounded-3xl p-12 text-center text-white">
                        <i class="fas fa-award text-7xl mb-6"></i>
                        <h4 class="text-3xl font-bold">Resto Terpercaya</h4>
                        <p class="mt-4 text-lg">Melayani pelanggan dengan sepenuh hati sejak 2015</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-4xl font-bold text-gray-900 mb-6">Tentang UMKM Resto</h3>
                    <p class="text-lg text-gray-600 mb-4">
                        UMKM Resto adalah tempat istimewa untuk menikmati hidangan berkualitas tinggi dengan cita rasa autentik. Kami berkomitmen menghadirkan pengalaman kuliner terbaik untuk setiap pelanggan.
                    </p>
                    <p class="text-lg text-gray-600 mb-6">
                        Dengan tim chef berpengalaman dan bahan-bahan pilihan, setiap hidangan kami dibuat dengan penuh cinta dan perhatian terhadap detail.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-gray-700">
                            <i class="fas fa-check text-red-600 text-xl"></i>
                            <span>Bahan Pilihan Berkualitas</span>
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <i class="fas fa-check text-red-600 text-xl"></i>
                            <span>Chef Berpengalaman</span>
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <i class="fas fa-check text-red-600 text-xl"></i>
                            <span>Layanan Cepat dan Ramah</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-bold text-gray-900 mb-4">Hubungi Kami</h3>
                <p class="text-xl text-gray-600">Kami siap melayani Anda</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-red-50 rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Telepon</h4>
                    <p class="text-gray-700 text-lg">(+62) 857-8434-9860</p>
                </div>

                <div class="bg-red-50 rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Alamat</h4>
                    <p class="text-gray-700 text-lg">Jl. Merdeka No. 123, Mojokerto</p>
                </div>

                <div class="bg-red-50 rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Jam Operasional</h4>
                    <p class="text-gray-700 text-lg">18:00 - 00:00 WIB</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-red-500 mb-2">UMKM Resto</h2>
                <p class="text-gray-400 mb-6">Nikmati pengalaman kuliner terbaik bersama kami</p>
                <div class="flex justify-center gap-6 mb-8">
                    <a href="https://www.facebook.com/share/1AMG1xf9HY/" class="text-red-500 hover:text-red-400 text-2xl transition">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/alxcbum?igsh=ZWVpZHBzdGE4ZTVz" class="text-red-500 hover:text-red-400 text-2xl transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-red-500 hover:text-red-400 text-2xl transition">
                        <i class="fab fa-telegram"></i>
                    </a>
                </div>
               <p class="text-gray-500 text-sm">©2025 Copyright <a class="underline" href="https://wa.me/6285784349860">ADMIN GANTENG</a>. All Rights Reserved</p>
            </div>
        </div>
    </footer>

</body>
</html>
