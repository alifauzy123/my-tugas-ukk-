    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Login - ERP</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="min-h-screen bg-red-100 flex flex-col justify-center sm:py-12 relative">

        {{-- Card Background Effect --}}
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div
                class="absolute inset-0 bg-gradient-to-r from-red-400 via-red-600 to-red-900 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
            </div>

            {{-- Login Card --}}
            <form method="POST" action="{{ url('/login') }}"
                class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-12 z-10">
                @csrf
                <div class="max-w-md mx-auto">
                    {{-- Logo --}}
                    <div class="text-center mb-4">
                        <img src="{{ asset('logo.jpg') }}" alt="Logo" class="inline-block h-20">
                    </div>
                    <h2 class="text-md text-gray-400 text-center mb-6">Masuk untuk melanjutkan</h2>
                    {{-- Alert error jika login gagal --}}
                    @if (session('error'))
                        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm">
                            {{ session('error') }}
                        </div>
                    @endif


                    {{-- Input Fields --}}
                    <div class="space-y-5 text-gray-700">
                        {{-- Username --}}
                        <div class="space-y-5 text-gray-700">
                            {{-- Username --}}
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" name="username" placeholder="Username"
                                    class="pl-10 w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 text-[11pt]"
                                    required>
                            </div>

                            {{-- Password --}}
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" id="password" placeholder="Password"
                                    class="pl-10 pr-10 w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 text-[11pt]"
                                    required>

                                {{-- Tombol preview --}}
                                <button type="button" id="togglePassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500 focus:outline-none">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>



                        {{-- Submit --}}
                        <div class="relative">
                            <button type="submit"
                                class="bg-red-500 w-full text-white rounded-md px-2 py-3 hover:bg-red-800 transition font-semibold">
                                Masuk
                            </button>
                        </div>
                        {{-- Link Daftar --}}
                        <div class="text-center mt-4">
                            <p class="text-sm text-gray-600">
                                Belum punya akun?
                                <a href="{{ url('/register') }}" class="text-red-600 font-semibold hover:underline">
                                    Daftar disini
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <footer class="absolute bottom-0 right-0 p-4 text-sm text-black">
            ©2025 Copyright <a class="underline" href="https://www.instagram.com/alxcbum?igsh=ZWVpZHBzdGE4ZTVz">MASAMBA</a>.
            All Rights Reserved
        </footer>

        <script>
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function() {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                eyeIcon.classList.toggle('fa-eye');
                eyeIcon.classList.toggle('fa-eye-slash');
            });
        </script>

    </body>

    </html>
