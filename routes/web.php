<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\DetailPesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KasirProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KasirTransaksiController;
use App\Http\Controllers\OwnerKasirController;
use App\Http\Controllers\OwnerMenuController;
use App\Http\Controllers\OwnerLaporanKasirController;
use App\Http\Controllers\OwnerDashboardController;
use App\Models\Transaksi;
use Carbon\Carbon;
use App\Models\Menu;
use App\Http\Controllers\LaporanKasirController;

Route::get('/', function () {
    $menus = Menu::whereIn('status', ['aktif', 'Aktif'])
        ->orderBy('nama_menu')
        ->get();

    return view('welcome', compact('menus'));
});


Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); // GET: tampilkan form login
Route::post('/login', [LoginController::class, 'login']); // POST: proses login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
//register
Route::get('/registrasi', [KasirController::class, 'showRegisterForm'])->name('registrasi');
Route::post('/registrasi', [KasirController::class, 'register']);



// Dashboard umum
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifikasi', fn() => view('notifikasi'))->name('notifikasi');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    //registrasi
    Route::post('/kasir/acc/{id}', [KasirController::class, 'acc'])->name('kasir.acc');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/kasir-aktivitas/export', [DashboardController::class, 'exportKasirAktivitas'])->name('dashboard.kasir-aktivitas.export');
    Route::get('/notifikasi', fn() => view('notifikasi'))->name('notifikasi');

    Route::resource('kategori', KategoriProdukController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('kasir', KasirController::class);
    Route::resource('menu', MenuController::class);

    Route::get('/laporan/kasir', [LaporanKasirController::class, 'index'])->name('laporan.kasir.index');
    Route::get('/laporan/kasir/export', [LaporanKasirController::class, 'export'])->name('laporan.kasir.export');

    Route::post('/produk/{id}/edit-harga', [ProdukController::class, 'editHarga']);
    Route::get('/produk/{id}/history-harga', [ProdukController::class, 'historyHarga']);
    Route::get('/produk/{id}/history-stok', [ProdukController::class, 'historyStok']);

    Route::post('/menu/{id}/edit-harga', [MenuController::class, 'editHarga']);
    Route::get('/menu/{id}/history-harga', [MenuController::class, 'historyHarga']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // route sementara tidak dipakai 
    // Route::resource('kendaraan', KendaraanController::class);
    // Route::resource('supplier', SupplierController::class);
    // Route::resource('purchase_order', PurchaseOrderController::class);
    // Route::resource('ulasan', UlasanController::class);
    // Route::get('/mutasi-stok/{produk_id}', [MutasiStokController::class, 'getByProduk']); 
    // Route::get('/penerimaan-barang/get-po/{kode_po}', [PenerimaanBarangController::class, 'getDataPO'])->name('penerimaan_barang.get_po');
    // Route::get('penerimaan-barang', [PenerimaanBarangController::class, 'index'])->name('penerimaan_barang.index');
    // Route::get('penerimaan-barang/create', [PenerimaanBarangController::class, 'create'])->name('penerimaan_barang.create');
    // Route::post('penerimaan-barang/store', [PenerimaanBarangController::class, 'store'])->name('penerimaan_barang.store');
    // Route::get('penerimaan-barang/{id}', [PenerimaanBarangController::class, 'show'])->name('penerimaan_barang.show');
    // Route::get('penerimaan-barang/{id}/edit', [PenerimaanBarangController::class, 'edit'])->name('penerimaan_barang.edit');
    // Route::put('penerimaan-barang/{id}', [PenerimaanBarangController::class, 'update'])->name('penerimaan_barang.update');
    // Route::delete('penerimaan-barang/{id}', [PenerimaanBarangController::class, 'destroy'])->name('penerimaan_barang.destroy');


});

// Dashboard Owner
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/dashboardowner', [OwnerDashboardController::class, 'index'])->name('dashboardowner');

    Route::get('/owner/transaksi/daftar', [KasirTransaksiController::class, 'ownerList'])->name('owner.transaksi.list');
    Route::get('/owner/laporan/kasir', [OwnerLaporanKasirController::class, 'index'])->name('owner.laporan.kasir.index');
    Route::get('/owner/laporan/kasir/export', [OwnerLaporanKasirController::class, 'export'])->name('owner.laporan.kasir.export');

    Route::get('/owner/menu', [OwnerMenuController::class, 'index'])->name('owner.menu.index');
    Route::get('/owner/menu/{id}/history-harga', [OwnerMenuController::class, 'historyHarga'])->name('owner.menu.history');

    Route::resource('owner/kasir', OwnerKasirController::class)->names('owner.kasir')->only(['index', 'show', 'edit', 'update', 'destroy']);
});



// Dashboard Kasir
Route::middleware(['auth:kasir', 'role:kasir'])->group(function () {
    Route::get('/dashboardkasir', function () {
        $kasir = Auth::guard('kasir')->user();
        $todayStart = Carbon::now('Asia/Jakarta')->startOfDay();
        $todayEnd = Carbon::now('Asia/Jakarta')->endOfDay();

        $transaksiHariIni = Transaksi::where('kasir_id', $kasir->id)
            ->whereBetween('tanggal', [$todayStart, $todayEnd])
            ->count();

        $omsetHariIni = Transaksi::where('kasir_id', $kasir->id)
            ->whereBetween('tanggal', [$todayStart, $todayEnd])
            ->sum('total');

        $transaksiPending = Transaksi::where('kasir_id', $kasir->id)
            ->where('status', '!=', 'Dibayar')
            ->count();

        $transaksiTerbaru = Transaksi::where('kasir_id', $kasir->id)
            ->orderByDesc('tanggal')
            ->limit(10)
            ->get();

        return view('dashboardkasir', compact(
            'kasir',
            'transaksiHariIni',
            'omsetHariIni',
            'transaksiPending',
            'transaksiTerbaru'
        ));
    })->name('dashboardkasir');

    Route::resource('pesanan', PesananController::class);
    Route::resource('detail_pesanan', DetailPesananController::class);
    Route::resource('pembayaran', PembayaranController::class);

    Route::get('/transaksi', [KasirTransaksiController::class, 'index'])->name('kasir.transaksi');
    Route::get('/transaksi/daftar', [KasirTransaksiController::class, 'list'])->name('kasir.transaksi.list');
    Route::post('/transaksi/checkout', [KasirTransaksiController::class, 'checkout'])->name('kasir.transaksi.checkout');

    // Profile Kasir
    Route::get('/kasir-profile', [KasirProfileController::class, 'show'])->name('kasir-profile.show');
    Route::post('/kasir-profile/update', [KasirProfileController::class, 'update'])->name('kasir-profile.update');
});






