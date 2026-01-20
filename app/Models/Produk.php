<?php

// app/Models/Produk.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Produk.php
class Produk extends Model
{
    protected $table = 'produk';
    protected $fillable = ['kode_produk', 'nama_produk', 'harga', 'stok', 'kategori_id', 'status', 'gambar'];

    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }

    public function riwayatHarga()
    {
        return $this->hasMany(RiwayatHarga::class);
    }

    public function mutasiStok()
    {
        return $this->hasMany(MutasiStok::class, 'produk_id');
    }
}

