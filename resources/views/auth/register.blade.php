<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sekarang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 min-h-screen flex items-center justify-center">

    <div class="bg-white w-full max-w-3xl rounded-xl shadow-md p-10">

        <h1 class="text-center text-2xl font-bold mb-2">Daftar Sekarang!</h1>
        <p class="text-center text-sm text-gray-500 mb-8">
            Lengkapi form berikut untuk membuat akun baru
        </p>

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <!-- Biodata -->
            <h2 class="font-semibold mb-3">Biodata</h2>

            <div class="grid grid-cols-2 gap-4">
                
                <div>
                    <label class="text-sm">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="input">
                </div>

                <div>
                    <label class="text-sm">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="input">
                </div>

                <div>
                    <label class="text-sm">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="input">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm">Email</label>
                    <input type="email" name="email" class="input">
                </div>

                <div>
                    <label class="text-sm">No HP</label>
                    <input type="text" name="no_hp" class="input">
                </div>

                <div>
                    <label class="text-sm">Alamat</label>
                    <input type="text" name="alamat" class="input">
                </div>

            </div>

            <!-- Password -->
            <h2 class="font-semibold mt-10 mb-3">Password</h2>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="text-sm">Username</label>
                    <input type="text" name="username" class="input">
                </div>

                <div>
                    <label class="text-sm">Password</label>
                    <input type="password" name="password" class="input">
                </div>

                <div>
                    <label class="text-sm">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="input">
                </div>

            </div>

            <button
                class="w-full bg-gray-500 text-white py-2 mt-8 rounded hover:bg-gray-600 transition">
                Daftar
            </button>

            <p class="text-center text-sm mt-4">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login disini</a>
            </p>

        </form>
    </div>

    <style>
        .input {
            @apply w-full border rounded px-3 py-2 mt-1;
        }
    </style>

</body>
</html>
