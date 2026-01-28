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
        // Clear existing data
        DB::table('kategori_produk')->truncate();

        DB::table('kategori_produk')->insert([
            [
                'kode_kategori' => 'MKN001',
                'nama_kategori' => 'Makanan',
                'deskripsi' => 'Berbagai macam makanan lezat seperti nasi goreng, ayam, ikan, dan masakan lainnya',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'MNM001',
                'nama_kategori' => 'Minuman',
                'deskripsi' => 'Minuman segar seperti jus, air mineral, kopi, teh, dan minuman lainnya',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'DES001',
                'nama_kategori' => 'Dessert',
                'deskripsi' => 'Hidangan penutup lezat seperti es krim, pudding, kue, dan dessert lainnya',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'SNK001',
                'nama_kategori' => 'Snack',
                'deskripsi' => 'Makanan ringan seperti keripik, kacang, gorengan, dan snack lainnya',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
