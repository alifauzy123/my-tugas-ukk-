<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';

    protected $fillable = [
        'kode_ulasan',
        'produk_id',
        'pelanggan_id',
        'rating',
        'komentar',
        'tanggal',
        'status',
    ];

    public function produk()
{
    return $this->belongsTo(Produk::class, 'produk_id');
}

public function pelanggan()
{
    return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
}

}

