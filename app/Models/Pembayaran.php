<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = ['kode_pembayaran', 'pesanan_id', 'total', 'metode', 'tanggal', 'status', 'keterangan'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}

