<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\DetailPesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\MutasiStokController;
use App\Http\Controllers\RegisterController;
use App\Models\Kendaraan;
use App\Models\PenerimaanBarang;
use App\Models\PurchaseOrder;

Route::get('/', function () {
    return redirect()->route('login');
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
    Route::get('/notifikasi', fn() => view('notifikasi'))->name('notifikasi');

    Route::resource('kategori', KategoriProdukController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('kasir', KasirController::class);
    Route::resource('kendaraan', KendaraanController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('purchase_order', PurchaseOrderController::class);
    Route::resource('ulasan', UlasanController::class);
    Route::get('/mutasi-stok/{produk_id}', [MutasiStokController::class, 'getByProduk']);
    Route::post('/produk/{id}/edit-harga', [ProdukController::class, 'editHarga']);
    Route::get('/produk/{id}/history-harga', [ProdukController::class, 'historyHarga']);
    Route::get('/produk/{id}/history-stok', [ProdukController::class, 'historyStok']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // route penerimaan barang taek 
    Route::get('/penerimaan-barang/get-po/{kode_po}', [PenerimaanBarangController::class, 'getDataPO'])->name('penerimaan_barang.get_po');
    Route::get('penerimaan-barang', [PenerimaanBarangController::class, 'index'])->name('penerimaan_barang.index');
    Route::get('penerimaan-barang/create', [PenerimaanBarangController::class, 'create'])->name('penerimaan_barang.create');
    Route::post('penerimaan-barang/store', [PenerimaanBarangController::class, 'store'])->name('penerimaan_barang.store');
    Route::get('penerimaan-barang/{id}', [PenerimaanBarangController::class, 'show'])->name('penerimaan_barang.show');
    Route::get('penerimaan-barang/{id}/edit', [PenerimaanBarangController::class, 'edit'])->name('penerimaan_barang.edit');
    Route::put('penerimaan-barang/{id}', [PenerimaanBarangController::class, 'update'])->name('penerimaan_barang.update');
    Route::delete('penerimaan-barang/{id}', [PenerimaanBarangController::class, 'destroy'])->name('penerimaan_barang.destroy');


});



// Dashboard Kasir
Route::middleware(['auth:kasir', 'role:kasir'])->group(function () {
    Route::get('/dashboardkasir', function () {
        $kasir = Auth::guard('kasir')->user();
        return view('dashboardkasir', compact('kasir'));
    })->name('dashboardkasir');

    Route::resource('pesanan', PesananController::class);
    Route::resource('detail_pesanan', DetailPesananController::class);
    Route::resource('pembayaran', PembayaranController::class);
});






