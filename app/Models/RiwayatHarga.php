<?php

// app/Models/RiwayatHarga.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatHarga extends Model
{
    protected $table = 'riwayat_harga';
    protected $fillable = ['produk_id', 'harga_lama', 'harga_baru'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
