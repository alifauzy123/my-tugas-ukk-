<?php

// app/Models/Pesanan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $fillable = ['kode_pesanan', 'pelanggan_id', 'kasir_id', 'tanggal', 'status', 'catatan'];

    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class);
    }

    public function kasir() {
        return $this->belongsTo(Kasir::class);
    }
    
    public function detailPesanan() {
    return $this->hasMany(DetailPesanan::class);
    }

}
