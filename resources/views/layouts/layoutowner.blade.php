<!-- Redesigned Owner Layout (match admin styling) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>OWNER UMKM RESTO</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-red-50 min-h-screen text-gray-900">

  <div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside id="sidebar"
      class="w-64 bg-[#7a0000] text-white p-6 flex flex-col justify-between fixed inset-y-0 left-0 z-20 
             transition-transform duration-300 ease-in-out transform translate-x-0 shadow-xl">

      <!-- Search Menu -->
      <div class="relative mt-16 mb-4">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-300">
          <i class="fas fa-search text-sm"></i>
        </span>
        <input id="menuSearch" type="text" placeholder="Telusuri menu..."
          class="w-full pl-10 pr-3 py-2 rounded-md bg-gray-100 text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
      </div>

      <!-- Menu Content -->
      <nav id="sidebarMenu" class="space-y-2 flex-1 overflow-y-auto pr-1">

        <!-- Dashboard Kasir -->
        <a href="{{ route('dashboardowner') }}" data-label="Dashboard Kasir"
          class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-yellow-500 transition-all cursor-pointer">
          <i class="fas fa-home text-sm"></i>
          <span class="font-medium">Dashboard Kasir</span>
        </a>

        <!-- Daftar Menu -->
        <a href="{{ route('owner.menu.index') }}" data-label="Daftar Menu"
          class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-yellow-500 transition cursor-pointer">
          <i class="fas fa-utensils text-sm"></i>
          <span class="font-medium">Daftar Menu</span>
        </a>

        <!-- Daftar Transaksi -->
        <a href="{{ route('owner.transaksi.list') }}" data-label="Daftar Transaksi"
          class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-yellow-500 transition cursor-pointer">
          <i class="fas fa-list text-sm"></i>
          <span class="font-medium">Daftar Transaksi</span>
        </a>

        <!-- Kasir -->
        <a href="{{ route('owner.kasir.index') }}" data-label="Kasir"
          class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-yellow-500 transition cursor-pointer">
          <i class="fas fa-cash-register text-xs"></i>
          <span class="font-medium">Kasir</span>
        </a>

        <!-- Laporan -->
        <a href="{{ route('owner.laporan.kasir.index') }}" data-label="Laporan"
          class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-yellow-500 transition cursor-pointer">
          <i class="fas fa-file-alt text-sm"></i>
          <span class="font-medium">Laporan</span>
        </a>

      </nav>

    </aside>

    <!-- Content -->
    <div id="contentWrapper" class="flex-1 flex flex-col relative ml-64 transition-all duration-300 ease-in-out">

      <!-- Header -->
      <header class="fixed top-0 left-0 right-0 bg-white shadow-md px-6 py-4 flex items-center justify-between z-30 border-b border-red-200">
        <div class="flex items-center space-x-4">
          <button id="toggleSidebar" class="text-gray-700 text-2xl focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
        </div>

        <div class="flex items-center space-x-6">
          <div class="text-sm text-gray-700 font-mono" id="clock">WIB: 00:00:00</div>
          <form id="logoutForm" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="button" id="logoutBtn" class="text-red-600 hover:text-red-800 text-xl" title="Logout">
              <i class="fas fa-sign-out-alt"></i>
            </button>
          </form>
        </div>
      </header>

      <!-- Main Content -->
      <main class="flex-1 p-6 pt-20 bg-red-50">
        @yield('content')
      </main>

    </div>
  </div>

<script>
// Sidebar Toggle
const toggleBtn = document.getElementById('toggleSidebar');
const sidebar = document.getElementById('sidebar');
const contentWrapper = document.getElementById('contentWrapper');
let isClosed = false;

toggleBtn.addEventListener('click', () => {
  if (isClosed) {
    sidebar.classList.remove('-translate-x-full');
    sidebar.classList.add('translate-x-0');
    contentWrapper.style.marginLeft = '16rem';
  } else {
    sidebar.classList.remove('translate-x-0');
    sidebar.classList.add('-translate-x-full');
    contentWrapper.style.marginLeft = '0';
  }
  isClosed = !isClosed;
});

// Clock Update
function updateClock() {
  const now = new Date();
  const options = { timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' };
  const time = new Intl.DateTimeFormat('en-GB', options).format(now);
  document.getElementById('clock').textContent = `WIB: ${time}`;
}
setInterval(updateClock, 1000);
updateClock();

// Logout Confirmation
document.getElementById('logoutBtn').addEventListener('click', () => {
  Swal.fire({ title: 'Yakin ingin logout?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6', confirmButtonText: 'Logout', cancelButtonText: 'Batal' })
    .then((result) => { if (result.isConfirmed) document.getElementById('logoutForm').submit(); });
});
</script>
@stack('scripts')
</body>
</html>
