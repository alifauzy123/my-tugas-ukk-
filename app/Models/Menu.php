<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MenuRiwayatHarga;

class Menu extends Model
{
    protected $table = 'menus';
    
    protected $fillable = [
        'nama_menu',
        'deskripsi',
        'harga',
        'kategori_id',
        'gambar',
        'status',
    ];
    
    protected $casts = [
        'harga' => 'decimal:2',
    ];

    // Relationship with KategoriProduk
    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id', 'id');
    }

    public function riwayatHarga()
    {
        return $this->hasMany(MenuRiwayatHarga::class, 'menu_id');
    }
}
