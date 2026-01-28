# Sistem Manajemen Kasir & Menu

>Aplikasi kasir berbasis Laravel dengan peran Admin, Owner, dan Kasir. Fokus utama: manajemen menu, transaksi kasir, laporan, serta manajemen data master.

## Ringkasan Alur Sistem

1. **Pengguna membuka aplikasi**
	- Halaman awal menampilkan daftar menu aktif.
2. **Login sesuai peran**
	- Admin/Owner/Kasir login melalui halaman login.
3. **Akses dashboard per peran**
	- Admin: dashboard admin + manajemen data master.
	- Owner: dashboard owner + monitoring & laporan.
	- Kasir: dashboard kasir + transaksi harian.
4. **Kelola data sesuai peran**
	- Admin: kategori_menu, menu, kasir, laporan kasir.
	- Owner: kasir, menu, laporan kasir, daftar transaksi.
	- Kasir: transaksi, item transaksi, profil.
5. **Proses transaksi kasir**
	- Kasir memilih menu → sistem hitung total → pembayaran → transaksi & item tersimpan.

## Skema Database (ERD)

> Catatan: tabel **kategori_produk** diganti menjadi **kategori_menu**.

```plantuml
@startuml
' ERD - Sistem Manajemen Kasir & Daftar Menu (Revisi)
' Tabel yang disertakan: users, kasirs, kategori_menu, menus, menu_riwayat_harga, transaksis

entity users {
  * id : bigint <<PK>>
  --
  name : varchar
  username : varchar
  password : varchar
  role : varchar
  created_at : timestamp
  updated_at : timestamp
}

entity kasirs {
  * id : bigint <<PK>>
  --
  nama_lengkap : varchar
  tanggal_lahir : date
  jenis_kelamin : enum
  alamat : text
  email : varchar
  no_hp : varchar
  username : varchar
  password : varchar
  status : enum
  avatar : varchar
  bio : text
  telepon_kantor : varchar
  nama_bank : varchar
  nomor_rekening : varchar
  atas_nama_rekening : varchar
  created_at : timestamp
  updated_at : timestamp
}

entity kategori_menu {
  * id : bigint <<PK>>
  --
  nama_kategori : varchar
  status : enum
  created_at : timestamp
  updated_at : timestamp
}

entity menus {
  * id : bigint <<PK>>
  --
  nama_menu : varchar
  deskripsi : text
  harga : decimal
  kategori_id : bigint <<FK>>
  gambar : varchar
  status : enum
  created_at : timestamp
  updated_at : timestamp
}

entity menu_riwayat_harga {
  * id : bigint <<PK>>
  --
  menu_id : bigint <<FK>>
  harga_lama : integer
  harga_baru : integer
  created_at : timestamp
  updated_at : timestamp
}

entity transaksis {
  * id : bigint <<PK>>
  --
  kode_transaksi : varchar
  kasir_id : bigint <<FK>>
  total : decimal
  uang_dibayar : decimal
  kembalian : decimal
  tanggal : datetime
  status : varchar
  created_at : timestamp
  updated_at : timestamp
}

' Relationships
kategori_menu ||--o{ menus : "kategori_id"
menus ||--o{ menu_riwayat_harga : "menu_id"
kasirs ||--o{ transaksis : "kasir_id"

' Note: "users" digunakan untuk admin/owner accounts (role field).
' If you want users linked to created_by/updated_by on other tables, we can add those FK fields.

@enduml
```

### Catatan Penghapusan Tabel

Tabel berikut dihapus dari skema dokumentasi:
`produk`, `suppliers`, `purchase_orders`, `riwayat_harga`, `mutasi_stoks`, `ulasan`, `detail_pesanan`, `pesanan`, `penerimaa_barang`, `kendaraan`, `pelanggan`, `pembayaran`.

## Use Case Diagram

```plantuml
@startuml
left to right direction

actor Admin
actor Owner
actor Kasir

rectangle "Sistem Manajemen Kasir & Menu" {
  usecase "Login" as UC_Login
  usecase "Kelola Kategori Menu" as UC_Kategori
  usecase "Kelola Menu" as UC_Menu
  usecase "Kelola Kasir" as UC_Kasir
  usecase "Lihat Riwayat Harga Menu" as UC_RiwayatHarga
  usecase "Lihat Laporan Kasir" as UC_Laporan
  usecase "Lihat Dashboard" as UC_Dashboard
  usecase "Proses Transaksi" as UC_Transaksi
  usecase "Lihat Transaksi" as UC_LihatTransaksi
  usecase "Kelola Profil Kasir" as UC_Profil
}

Admin --> UC_Login
Admin --> UC_Dashboard
Admin --> UC_Kategori
Admin --> UC_Menu
Admin --> UC_Kasir
Admin --> UC_Laporan
Admin --> UC_RiwayatHarga

Owner --> UC_Login
Owner --> UC_Dashboard
Owner --> UC_Kasir
Owner --> UC_Menu
Owner --> UC_RiwayatHarga
Owner --> UC_Laporan
Owner --> UC_LihatTransaksi

Kasir --> UC_Login
Kasir --> UC_Dashboard
Kasir --> UC_Transaksi
Kasir --> UC_LihatTransaksi
Kasir --> UC_Profil

@enduml
```

## Peran & Hak Akses

- **Admin**
  - Kelola kategori_menu, menu, kasir.
  - Lihat dan ekspor laporan kasir.

- **Owner**
  - Lihat ringkasan dashboard owner.
  - Kelola kasir (lihat/edit).
  - Lihat menu dan riwayat harga menu.
  - Lihat dan ekspor laporan kasir.

- **Kasir**
  - Dashboard kasir (omset, transaksi hari ini, dsb.).
  - Proses transaksi dan checkout.
  - Lihat transaksi & item transaksi.
  - Update profil kasir.

## Modul Utama

- **Autentikasi**: login, logout, register (admin/kasir/owner).
- **Master Data**: kategori_menu, kasir.
- **Menu**: CRUD menu + riwayat harga menu.
- **Transaksi**: kasir checkout, daftar transaksi, item transaksi.
- **Laporan**: laporan kasir + ekspor.

## Rute Penting (Ringkas)

- **Umum**
  - `/` (landing menu aktif)
  - `/login`, `/logout`, `/register`

- **Admin (auth + role:admin)**
  - `/dashboard`
  - `/kategori`, `/kasir`, `/menu`
  - `/laporan/kasir`

- **Owner (auth + role:owner)**
  - `/dashboardowner`
  - `/owner/kasir/*`
  - `/owner/menu`
  - `/owner/laporan/kasir`

- **Kasir (auth:kasir + role:kasir)**
  - `/dashboardkasir`
  - `/transaksi`, `/transaksi/checkout`
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
