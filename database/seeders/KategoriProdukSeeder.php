<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_produk')->insert([
            [
                'kode_kategori' => 'KTG001',
                'nama_kategori' => 'Beras & Tepung',
                'deskripsi' => 'Berbagai jenis beras, tepung terigu, tepung tapioka, dan produk serupa lainnya',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'KTG002',
                'nama_kategori' => 'Minyak & Lemak',
                'deskripsi' => 'Minyak goreng, mentega, margarin, dan lemak masak lainnya',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'KTG003',
                'nama_kategori' => 'Gula & Pemanis',
                'deskripsi' => 'Gula pasir, gula merah, gula kristal, dan pemanis buatan',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'KTG004',
                'nama_kategori' => 'Garam & Bumbu',
                'deskripsi' => 'Garam meja, bumbu dapur, rempah-rempah, dan penyedap masakan',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'KTG005',
                'nama_kategori' => 'Kopi & Teh',
                'deskripsi' => 'Kopi bubuk, kopi instant, teh celup, teh loose leaf, dan minuman serupa',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'KTG006',
                'nama_kategori' => 'Susu & Dairy',
                'deskripsi' => 'Susu segar, susu kental manis, susu bubuk, yogurt, dan produk dairy lainnya',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'KTG007',
                'nama_kategori' => 'Makanan Kaleng',
                'deskripsi' => 'Ikan kaleng, daging kaleng, sayuran kaleng, dan makanan kaleng lainnya',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'KTG008',
                'nama_kategori' => 'Mie & Pasta',
                'deskripsi' => 'Mie instan, mie telur, pasta, bihun, dan produk serupa lainnya',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'KTG009',
                'nama_kategori' => 'Snack & Gorengan',
                'deskripsi' => 'Kerupuk, kacang goreng, keripik, snack ringan, dan camilan lainnya',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'KTG010',
                'nama_kategori' => 'Minuman Kemasan',
                'deskripsi' => 'Air mineral, minuman bersoda, minuman jus, minuman olahraga, dan minuman kemasan lainnya',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
