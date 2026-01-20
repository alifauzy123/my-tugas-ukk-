<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TUGAS UKK BERBASIS ERP</title>
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

      <!-- Transaksi (Dropdown) -->
      <div class="space-y-1">
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
      </div>
    </nav>
  </div>

  <!-- User Profile Section -->
  <div class="border-t border-gray-700 pt-4">
    <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-700/50 hover:bg-gray-700 transition-colors">
      <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
        {{ substr(Auth::guard('kasir')->user()->nama_kasir ?? 'K', 0, 1) }}
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-sm font-semibold text-white truncate">{{ Auth::guard('kasir')->user()->nama_kasir ?? 'Kasir' }}</p>
        <p class="text-xs text-gray-400">Kasir</p>
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
          <img src="{{ asset('logo.jpg') }}" alt="Logo" class="h-10 w-auto rounded">

          <!-- Page Title -->
          <div>
            <h1 class="text-lg font-bold text-gray-800 hidden sm:block">ERP System</h1>
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

});
</script>

 @stack('scripts')
</body>
</html>