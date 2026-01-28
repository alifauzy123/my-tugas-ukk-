<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>KASIR UMKM RESTO</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100 min-h-screen text-gray-800">

  <div class="flex min-h-screen">

    <!-- Sidebar -->
<aside id="sidebar"
  class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white p-6 flex flex-col justify-between fixed inset-y-0 left-0 z-20 transition-all duration-300 ease-in-out transform translate-x-0 shadow-2xl">

  <!-- Logo/Branding Section -->
  <div>
    <!-- Search Input -->
    <div class="relative mb-6">
      <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
        <i class="fas fa-search text-sm"></i>
      </span>
      <input id="menuSearch" type="text" placeholder="Cari menu..." 
        class="w-full pl-10 pr-3 py-2.5 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all text-sm">
    </div>

    <!-- Menu Navigation -->
    <nav class="space-y-1 flex-1 overflow-y-auto">
      <!-- Dashboard -->
      <a href="{{ route('dashboardkasir') }}" 
        class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboardkasir') ? 'bg-blue-600 shadow-lg' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}"
        data-route="dashboardkasir">
        <i class="fas fa-chart-line {{ request()->routeIs('dashboardkasir') ? 'text-blue-300' : 'text-gray-400' }}"></i>
        <span class="font-medium">Dashboard</span>
        @if(request()->routeIs('dashboardkasir'))
          <span class="ml-auto inline-flex h-2 w-2 rounded-full bg-blue-300"></span>
        @endif
      </a>

      <!-- Transaksi -->
      <a href="{{ url('/transaksi') }}"
        class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-lg transition-all duration-200 {{ request()->routeIs('kasir.transaksi') ? 'bg-blue-600 shadow-lg' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}"
        data-route="transaksi">
        <i class="fas fa-exchange-alt {{ request()->routeIs('kasir.transaksi') ? 'text-blue-300' : 'text-gray-400' }}"></i>
        <span class="font-medium">Transaksi</span>
        @if(request()->routeIs('kasir.transaksi'))
          <span class="ml-auto inline-flex h-2 w-2 rounded-full bg-blue-300"></span>
        @endif
      </a>

      <a href="{{ url('/transaksi/daftar') }}"
        class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-lg transition-all duration-200 {{ request()->routeIs('kasir.transaksi.list') ? 'bg-blue-600 shadow-lg' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}"
        data-route="transaksi-list">
        <i class="fas fa-list {{ request()->routeIs('kasir.transaksi.list') ? 'text-blue-300' : 'text-gray-400' }}"></i>
        <span class="font-medium">Daftar Transaksi</span>
        @if(request()->routeIs('kasir.transaksi.list'))
          <span class="ml-auto inline-flex h-2 w-2 rounded-full bg-blue-300"></span>
        @endif
      </a>

      <!-- Transaksi (Dropdown) -->
      {{-- <div class="space-y-1">
        <button id="toggleTransaksi" 
          class="sidebar-dropdown flex justify-between items-center gap-3 w-full text-left py-3 px-4 rounded-lg transition-all duration-200 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('pesanan.*', 'detail_pesanan.*', 'pembayaran.*') ? 'bg-gray-700 text-white' : '' }}"
          data-route="transaksi">
          <span class="flex items-center gap-3">
            <i class="fas fa-exchange-alt text-gray-400"></i>
            <span class="font-medium">Transaksi</span>
          </span>
          <i class="fas fa-chevron-down text-xs transition-transform duration-300" id="chevronTransaksi"></i>
        </button>   
        
        <div id="menuTransaksi" class="pl-8 space-y-1 {{ request()->routeIs('pesanan.*', 'detail_pesanan.*', 'pembayaran.*') ? '' : 'hidden' }} border-l-2 border-gray-700">
          <a href="{{ route('pesanan.index') }}" 
            class="sidebar-submenu flex items-center gap-2 py-2 px-3 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('pesanan.*') ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Pesanan</span>
            @if(request()->routeIs('pesanan.*'))
              <span class="ml-auto inline-flex h-2 w-2 rounded-full bg-blue-300"></span>
            @endif
          </a>

          <a href="{{ route('detail_pesanan.index') }}" 
            class="sidebar-submenu flex items-center gap-2 py-2 px-3 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('detail_pesanan.*') ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}">
            <i class="fas fa-list-ul"></i>
            <span>Detail Pesanan</span>
            @if(request()->routeIs('detail_pesanan.*'))
              <span class="ml-auto inline-flex h-2 w-2 rounded-full bg-blue-300"></span>
            @endif
          </a>

          <a href="{{ route('pembayaran.index') }}" 
            class="sidebar-submenu flex items-center gap-2 py-2 px-3 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('pembayaran.*') ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}">
            <i class="fas fa-money-bill-wave"></i>
            <span>Pembayaran</span>
            @if(request()->routeIs('pembayaran.*'))
              <span class="ml-auto inline-flex h-2 w-2 rounded-full bg-blue-300"></span>
            @endif
          </a>
        </div>
      </div> --}}
    </nav>
  </div>

  <!-- User Profile Section (Bottom Left) -->
  <div id="profileButton" class="border-t border-gray-700 pt-4 cursor-pointer">
    <div class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-br from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 transition-colors shadow-lg">
      <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-sm overflow-hidden">
        @if(Auth::guard('kasir')->user()->avatar)
          <img src="{{ asset('storage/' . Auth::guard('kasir')->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
        @else
          {{ substr(Auth::guard('kasir')->user()->nama_lengkap ?? 'K', 0, 1) }}
        @endif
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-sm font-semibold text-white truncate">{{ Auth::guard('kasir')->user()->nama_lengkap ?? 'Kasir' }}</p>
        <p class="text-xs text-blue-100">{{ Auth::guard('kasir')->user()->username ?? 'user' }}</p>
      </div>
    </div>
  </div>
</aside>

    <!-- Konten -->
    <div id="contentWrapper" class="flex-1 flex flex-col relative ml-64 transition-all duration-300 ease-in-out">

      <!-- Header -->
      <header class="fixed top-0 left-0 right-0 bg-white shadow-md px-6 py-4 flex items-center justify-between z-30 ml-64 transition-all duration-300" id="header">
        <div class="flex items-center space-x-4">
          <!-- Sidebar Toggle Button -->
          <button id="toggleSidebar" class="text-gray-700 hover:text-gray-900 text-2xl focus:outline-none transition-colors">
            <i class="fas fa-bars"></i>
          </button>

          <!-- Logo -->
          <img src="{{ asset('logoresto.png') }}" alt="Logo" class="h-10 w-auto rounded">

          <!-- Page Title -->
          <div>
            <h1 class="text-lg font-bold text-gray-800 hidden sm:block">UMKM Resto</h1>
          </div> 
        </div>

        <div class="flex items-center space-x-6">
          <!-- Clock -->
          <div class="text-sm text-gray-600 font-mono hidden sm:block" id="clock">WIB: 00:00:00</div>

          <!-- Logout Button -->
          <form id="logoutForm" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="button" id="logoutBtn" class="text-red-600 hover:text-red-800 text-xl transition-colors" title="Logout">
              <i class="fas fa-sign-out-alt"></i>
            </button>
          </form>
        </div>
      </header>

      <!-- Main Content -->
      <main class="flex-1 p-6 pt-24 bg-gray-100">
        @yield('content')
      </main>

    </div>
  </div>

<!-- Modal Profile Kasir -->
<div id="profileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-start justify-center pt-20 overflow-y-auto">
  <div class="bg-white rounded-lg shadow-2xl w-full max-w-lg mx-4 mb-10">
    <!-- Modal Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-6 text-white flex justify-between items-center rounded-t-lg">
      <h2 class="text-2xl font-bold">Profil Kasir</h2>
      <button id="closeModal" class="text-white hover:text-gray-200 text-2xl">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Modal Body -->
    <form id="profileForm" class="p-6 space-y-6">
      @csrf
      
      <!-- Avatar Section -->
      <div class="text-center">
        <div class="relative inline-block mb-4">
          <img id="avatarPreview" src="{{ Auth::guard('kasir')->user()->avatar ? asset('storage/' . Auth::guard('kasir')->user()->avatar) : 'https://via.placeholder.com/120' }}" 
            alt="Avatar" class="w-32 h-32 rounded-full border-4 border-blue-300 object-cover">
          <label for="avatarInput" class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 cursor-pointer transition-colors shadow-lg">
            <i class="fas fa-camera text-lg"></i>
          </label>
          <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden">
        </div>
        <p class="text-sm text-gray-500">Klik kamera untuk mengubah avatar</p>
      </div>

      <!-- Data Pribadi Section -->
      <div class="border-t pt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Pribadi</h3>
        
        <!-- Nama Lengkap (Read-only) -->
        <div class="mb-4">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
          <input type="text" value="{{ Auth::guard('kasir')->user()->nama_lengkap }}" readonly 
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg bg-gray-100 text-gray-600">
        </div>

        <!-- Username (Read-only) -->
        <div class="mb-4">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
          <input type="text" value="{{ Auth::guard('kasir')->user()->username }}" readonly 
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg bg-gray-100 text-gray-600">
        </div>

        <!-- Email (Read-only) -->
        <div class="mb-4">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
          <input type="email" value="{{ Auth::guard('kasir')->user()->email }}" readonly 
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg bg-gray-100 text-gray-600">
        </div>

        <!-- No HP (Read-only) -->
        <div class="mb-4">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
          <input type="text" value="{{ Auth::guard('kasir')->user()->no_hp }}" readonly 
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg bg-gray-100 text-gray-600">
        </div>

        <!-- Bio -->
        <div class="mb-4">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Bio</label>
          <textarea name="bio" rows="3" placeholder="Tuliskan bio singkat Anda..." 
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">{{ Auth::guard('kasir')->user()->bio }}</textarea>
        </div>

        <!-- Telepon Kantor -->
        <div class="mb-4">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Telepon Kantor</label>
          <input type="text" name="telepon_kantor" placeholder="Nomor telepon kantor" 
            value="{{ Auth::guard('kasir')->user()->telepon_kantor }}"
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
        </div>
      </div>

      <!-- Data Bank Section -->
      <div class="border-t pt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Bank</h3>
        
        <!-- Nama Bank -->
        <div class="mb-4">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bank</label>
          <input type="text" name="nama_bank" placeholder="Contoh: BCA, Mandiri, BNI" 
            value="{{ Auth::guard('kasir')->user()->nama_bank }}"
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
        </div>

        <!-- Nomor Rekening -->
        <div class="mb-4">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Rekening</label>
          <input type="text" name="nomor_rekening" placeholder="Nomor rekening" 
            value="{{ Auth::guard('kasir')->user()->nomor_rekening }}"
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
        </div>

        <!-- Atas Nama Rekening -->
        <div class="mb-4">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Atas Nama Rekening</label>
          <input type="text" name="atas_nama_rekening" placeholder="Nama pemilik rekening" 
            value="{{ Auth::guard('kasir')->user()->atas_nama_rekening }}"
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
        </div>
      </div>

      <!-- Buttons -->
      <div class="border-t pt-6 flex gap-3">
        <button type="button" id="cancelBtn" class="flex-1 px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold transition-colors">
          Batal
        </button>
        <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-lg font-semibold transition-colors">
          <i class="fas fa-save mr-2"></i>Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // SIDEBAR TOGGLE
    // =========================
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const contentWrapper = document.getElementById('contentWrapper');
    const header = document.getElementById('header');
    let isClosed = false;

    toggleBtn.addEventListener('click', () => {
        if (isClosed) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            contentWrapper.style.marginLeft = '16rem';
            header.style.marginLeft = '16rem';
        } else {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
            contentWrapper.style.marginLeft = '0';
            header.style.marginLeft = '0';
        }
        isClosed = !isClosed;
    });

    // =========================
    // DROPDOWN TRANSAKSI
    // =========================
    const toggleTransaksi = document.getElementById("toggleTransaksi");
    const menuTransaksi = document.getElementById("menuTransaksi");
    const chevronTransaksi = document.getElementById("chevronTransaksi");

    if (toggleTransaksi && menuTransaksi) {
        toggleTransaksi.addEventListener("click", () => {
            menuTransaksi.classList.toggle("hidden");
            chevronTransaksi.classList.toggle("rotate-180");
        });

        // Auto-open if current route is in transaksi
        if (!menuTransaksi.classList.contains("hidden")) {
            chevronTransaksi.classList.add("rotate-180");
        }
    }

    // =========================
    // MENU SEARCH
    // =========================
    const searchInput = document.getElementById('menuSearch');
    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const menuItems = document.querySelectorAll('.sidebar-link, .sidebar-dropdown, .sidebar-submenu');

        menuItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(keyword)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    });

    // =========================
    // CLOCK (WIB)
    // =========================
    function updateClock() {
        const clock = document.getElementById('clock');
        const now = new Date();

        const options = {
            timeZone: 'Asia/Jakarta',
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };

        const formatter = new Intl.DateTimeFormat('en-GB', options);
        const timeParts = formatter.formatToParts(now).reduce((acc, part) => {
            if (part.type !== 'literal') acc[part.type] = part.value;
            return acc;
        }, {});

        clock.textContent = `WIB: ${timeParts.hour}:${timeParts.minute}:${timeParts.second}`;
    }

    setInterval(updateClock, 1000);
    updateClock();

    // =========================
    // LOGOUT CONFIRM
    // =========================
    const logoutBtn = document.getElementById('logoutBtn');
    logoutBtn.addEventListener('click', function () {
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: 'Anda akan keluar dari sistem.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });

    // =========================
    // PROFILE MODAL
    // =========================
    const profileButton = document.getElementById('profileButton');
    const profileModal = document.getElementById('profileModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const profileForm = document.getElementById('profileForm');
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');

    // Open modal
    profileButton.addEventListener('click', () => {
        profileModal.classList.remove('hidden');
    });

    // Close modal
    const closeProfileModal = () => {
        profileModal.classList.add('hidden');
    };

    closeModal.addEventListener('click', closeProfileModal);
    cancelBtn.addEventListener('click', closeProfileModal);
    profileModal.addEventListener('click', (e) => {
        if (e.target === profileModal) closeProfileModal();
    });

    // Avatar preview
    avatarInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                avatarPreview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Submit form
    profileForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(profileForm);
        const saveBtn = profileForm.querySelector('button[type="submit"]');
        saveBtn.disabled = true;

        try {
            const response = await fetch('{{ route("kasir-profile.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menyimpan profil',
                    icon: 'error'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan: ' + error.message,
                icon: 'error'
            });
        } finally {
            saveBtn.disabled = false;
        }
    });

});
</script>

 @stack('scripts')
</body>
</html>