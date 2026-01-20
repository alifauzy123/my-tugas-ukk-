<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TUGAS UKK BERBASIS ERP</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="bg-gray-200 min-h-screen text-gray-800">

  <div class="flex min-h-screen">

    <!-- Sidebar -->
<aside id="sidebar"
  class="w-64 bg-[#800000] text-white p-6 flex flex-col justify-between fixed inset-y-0 left-0 z-20 transition-transform duration-300 ease-in-out transform translate-x-0">

  <!-- Logo atau Branding (opsional) -->
  <div class="relative mt-14 mb-4">
  <!-- Ikon Search -->
  <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
    <i class="fas fa-search"></i>
  </span>

  <!-- Input -->
  <input id="menuSearch" type="text" placeholder="Telusuri..."
    class="w-full pl-10 pr-3 py-2 rounded-md bg-gray-100 text-gray-800 focus:outline-none text-sm">
</div>


  <!-- Menu -->
   <nav class="space-y-2 flex-1 overflow-y-auto">

  <!-- Dashboard -->
  <a href="{{ route('dashboard') }}" data-label="Dashboard"
    class="flex items-center gap-3 py-2 px-3 rounded hover:bg-yellow-500 transition w-full">
    <i class="fas fa-home"></i>
    <span>Dashboard</span>
  </a>

  <!-- Notifikasi -->
  {{-- <a href="{{ route('notifikasi') }}" data-label="Notifikasi"
    class="flex items-center gap-3 py-2 px-3 rounded hover:bg-yellow-500 transition w-full">
    <i class="fas fa-bell"></i>
    <span>Notifikasi</span>
  </a> --}}

  <!-- Master -->
  <div>
    <button id="toggleMaster" class="flex justify-between items-center gap-3 w-full text-left py-2 px-3 rounded hover:bg-yellow-500 transition">
      <span class="flex items-center gap-3">
        <i class="fas fa-database"></i>
        <span>Master</span>
      </span>
      <i class="fas fa-chevron-down text-sm"></i>
    </button>

    <div id="menuMaster" class="pl-7 space-y-1 hidden mt-1 border-l-2 border-gray-300">

      <a href="{{ route('kategori.index') }}" class="flex items-center gap-2 py-1 px-3 hover:bg-yellow-500 rounded transition">
        <i class="fas fa-layer-group text-xs"></i>
        <span>Kategori Produk</span>
      </a>

      <a href="{{ route('produk.index') }}" class="flex items-center gap-2 py-1 px-3 hover:bg-yellow-500 rounded transition">
        <i class="fas fa-box text-xs"></i>
        <span>Produk</span>
      </a>

      {{-- <a href="{{ route('pelanggan.index') }}" class="flex items-center gap-2 py-1 px-3 hover:bg-yellow-500 rounded transition">
        <i class="fas fa-users text-xs"></i>
        <span>Pelanggan</span>
      </a> --}}

      <a href="{{ route('kasir.index') }}" class="flex items-center gap-2 py-1 px-3 hover:bg-yellow-500 rounded transition">
        <i class="fas fa-cash-register text-xs"></i>
        <span>Kasir</span>
      </a>

      {{-- <a href="{{ route('kendaraan.index') }}" class="flex items-center gap-2 py-1 px-3 hover:bg-yellow-500 rounded transition">
        <i class="fas fa-car text-xs"></i>
        <span>Kendaraan</span>
      </a> --}}

      {{-- <a href="#" class="flex items-center gap-2 py-1 px-3 hover:bg-yellow-500 rounded transition">
        <i class="fas fa-undo-alt text-xs"></i>
        <span>Retur Barang</span>
      </a> --}}

      {{-- <a href="#" class="flex items-center gap-2 py-1 px-3 hover:bg-yellow-500 rounded transition">
        <i class="fas fa-warehouse text-xs"></i>
        <span>Gudang</span>
      </a>

      <a href="#" class="flex items-center gap-2 py-1 px-3 hover:bg-yellow-500 rounded transition">
        <i class="fas fa-trash text-xs"></i>
        <span>Trash</span>
      </a> --}}

    </div>
  </div>

  <!-- Pembelian (Dropdown Baru) -->
  <div>
    <button id="togglePembelian" class="flex justify-between items-center gap-3 w-full text-left py-2 px-3 rounded hover:bg-yellow-500 transition">
      <span class="flex items-center gap-3">
        <i class="fas fa-shopping-basket"></i>
        <span>Purchasing</span>
      </span>
      <i class="fas fa-chevron-down text-sm"></i>
    </button>

    <div id="menuPembelian" class="pl-7 space-y-1 hidden mt-1 border-l-2 border-gray-300">

      <a href="{{ route('supplier.index') }}" class="flex items-center gap-2 py-1 px-3 hover:bg-yellow-500 rounded transition">
        <i class="fas fa-truck text-xs"></i>
        <span>Supplier</span>
      </a>

      <a href="{{ route('purchase_order.index') }}" class="flex items-center gap-2 py-1 px-3 hover:bg-yellow-500 rounded transition">
        <i class="fas fa-file-invoice text-xs"></i>
        <span>Purchase Order</span>
      </a>

      <a href="{{ route('penerimaan_barang.index') }}" class="flex items-center gap-2 py-1 px-3 hover:bg-yellow-500 rounded transition">
        <i class="fas fa-box-open text-xs"></i>
        <span>Penerimaan Barang</span>
      </a>

    </div>
  </div>

  <!-- Laporan -->
  <a href="{{ route('ulasan.index') }}" data-label="Laporan"
    class="flex items-center gap-3 py-2 px-3 rounded hover:bg-yellow-500 transition w-full">
    <i class="fas fa-file-alt"></i>
    <span>Laporan</span>
  </a>

  {{-- <!-- Ulasan -->
  <a href="{{ route('ulasan.index') }}" data-label="Ulasan"
    class="flex items-center gap-3 py-2 px-3 rounded hover:bg-yellow-500 transition w-full">
    <i class="fas fa-star"></i>
    <span>Ulasan</span>
  </a> --}}

</nav>



</aside>


    <!-- Konten -->
    <div id="contentWrapper" class="flex-1 flex flex-col relative ml-64 transition-all duration-300 ease-in-out">

     <!-- Header -->
<header class="fixed top-0 left-0 right-0 bg-white shadow px-6 py-4 flex items-center justify-between z-30">

  <div class="flex items-center space-x-4">
    <!-- Sidebar Toggle Button -->
    <button id="toggleSidebar" class="text-gray-700 text-2xl focus:outline-none">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Logo Image -->
    {{-- <img src="{{ asset('logo.jpg') }}" alt="Logo" class="h-10 w-auto"> --}}
  </div>

  <div class="flex items-center space-x-6">
  <div class="text-sm text-gray-600 font-mono" id="clock">WIB: 00:00:00</div>

  <form id="logoutForm" method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="button" id="logoutBtn" class="text-red-600 hover:text-red-800 text-xl" title="Logout">
      <i class="fas fa-sign-out-alt"></i>
    </button>
  </form>
</div>

</header>


      <!-- Main Content -->
      <main class="flex-1 p-6 pt-20 bg-gray-200">
        @yield('content')
      </main>

    </div>
  </div>

  <script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const contentWrapper = document.getElementById('contentWrapper');

    let isClosed = false;

    toggleBtn.addEventListener('click', () => {
      if (isClosed) {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        contentWrapper.style.marginLeft = '16rem'; // 16rem = 4 * 4rem = w-64
      } else {
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('-translate-x-full');
        contentWrapper.style.marginLeft = '0';
      }
      isClosed = !isClosed;
    });

  function updateClock() {
    const clock = document.getElementById('clock');
    const now = new Date();

    // Ambil waktu lokal (Indonesia Barat: GMT+7)
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

    const jam = timeParts.hour;
    const menit = timeParts.minute;
    const detik = timeParts.second;

    clock.textContent = `WIB: ${jam}:${menit}:${detik}`;
  }

  setInterval(updateClock, 1000);
  updateClock();


    setInterval(updateClock, 1000);
    updateClock();

  document.getElementById('toggleMaster').addEventListener('click', function () {
    const submenu = document.getElementById('menuMaster');
    submenu.classList.toggle('hidden');
  });

  document.getElementById('togglePembelian').addEventListener('click', function () {
  const submenu = document.getElementById('menuPembelian');
  submenu.classList.toggle('hidden');
});


  // Logic search menu sidebar
// Logic search menu sidebar
const searchInput = document.getElementById('menuSearch');
searchInput.addEventListener('input', function () {
  const keyword = this.value.toLowerCase();
  
  const menuLinks = document.querySelectorAll('#sidebar nav a');
  const dropdowns = document.querySelectorAll('#sidebar nav div'); // master, pembelian

  if (keyword === "") {
    // Jika search dikosongkan → tampilkan semuanya kembali
    menuLinks.forEach(link => link.classList.remove('hidden'));
    dropdowns.forEach(drop => drop.classList.remove('hidden'));
    return;
  }

  // Kalau searching, sembunyikan semua dulu
  menuLinks.forEach(link => {
    const label = link.dataset.label?.toLowerCase() || "";
    if (label.includes(keyword)) {
      link.classList.remove('hidden');
    } else {
      link.classList.add('hidden');
    }
  });

  // Biarkan dropdown (Master, Pembelian, Transaksi) tetap tampil
  dropdowns.forEach(drop => drop.classList.remove('hidden'));
});


document.getElementById('logoutBtn').addEventListener('click', function (e) {
    Swal.fire({
      title: 'Yakin ingin logout?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'logout',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('logoutForm').submit();
      }
    });
  });

  
  </script>
 @stack('scripts')
</body>
</html>