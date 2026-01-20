<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiStok extends Model
{
    protected $table = 'mutasi_stoks';

    protected $fillable = [
        'produk_id',
        'jenis_mutasi',
        'qty_mutasi',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
