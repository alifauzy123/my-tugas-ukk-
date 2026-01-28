# Sistem Manajemen Kasir & Menu

>Aplikasi kasir berbasis Laravel dengan peran Admin, Owner, dan Kasir. Fokus utama: manajemen menu, transaksi kasir, laporan, serta manajemen data master.

## Ringkasan Alur Sistem

1. **Pengguna membuka aplikasi**
	- Halaman awal menampilkan daftar menu aktif.
2. **Login sesuai peran**
	- Admin/Owner/Kasir login melalui halaman login.
3. **Akses dashboard per peran**
	- Admin: dashboard admin + manajemen data.
	- Owner: dashboard owner + laporan dan monitoring.
	- Kasir: dashboard kasir + transaksi harian.
4. **Kelola data sesuai peran**
	- Admin: kategori, produk, kasir, menu, laporan kasir.
	- Owner: kasir, menu, laporan kasir, daftar transaksi.
	- Kasir: transaksi, pesanan, detail pesanan, pembayaran, profil.

## Peran & Hak Akses

- **Admin**
  - Kelola kategori, produk, kasir, menu.
  - Lihat dan ekspor laporan kasir.

- **Owner**
  - Lihat ringkasan dashboard owner.
  - Kelola kasir (lihat/edit).
  - Lihat menu dan riwayat harga.
  - Lihat dan ekspor laporan kasir.

- **Kasir**
  - Dashboard kasir (omset, transaksi hari ini, dsb.).
  - Proses transaksi dan checkout.
  - Kelola pesanan, detail pesanan, pembayaran.
  - Update profil kasir.

## Modul Utama

- **Autentikasi**: login, logout, register (admin/kasir).
- **Master Data**: kategori, produk, kasir.
- **Menu**: CRUD menu + riwayat harga.
- **Transaksi**: kasir checkout, daftar transaksi, pembayaran.
- **Laporan**: laporan kasir + ekspor.

## Rute Penting (Ringkas)

- **Umum**
  - `/` (landing menu aktif)
  - `/login`, `/logout`, `/register`

- **Admin (auth + role:admin)**
  - `/dashboard`
  - `/kategori`, `/produk`, `/kasir`, `/menu`
  - `/laporan/kasir`

- **Owner (auth + role:owner)**
  - `/dashboardowner`
  - `/owner/kasir/*`
  - `/owner/menu`
  - `/owner/laporan/kasir`

- **Kasir (auth:kasir + role:kasir)**
  - `/dashboardkasir`
  - `/transaksi`, `/transaksi/checkout`
  - `/pesanan`, `/detail_pesanan`, `/pembayaran`
  - `/kasir-profile`

## Teknologi

- Laravel
- Tailwind CSS
- MySQL/MariaDB

## Cara Menjalankan (Lokal)

1. Install dependensi:
	- `composer install`
	- `npm install`
2. Copy env:
	- `cp .env.example .env`
3. Generate key:
	- `php artisan key:generate`
4. Konfigurasi database di `.env`
5. Migrasi & seeder:
	- `php artisan migrate --seed`
6. Build asset:
	- `npm run build` (atau `npm run dev`)
7. Jalankan server:
	- `php artisan serve`

## Dokumen Pendukung

- ARCHITECTURE_OVERVIEW.md
- MENU_SYSTEM_DOCS.md
- COMPLETION_REPORT.md
- DEPLOYMENT_SUMMARY.md
