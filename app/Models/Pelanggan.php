<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $fillable = [
        'kode_pelanggan', 'nama_pelanggan', 'email', 'no_telp', 'alamat', 'status'
    ];

    public function pesanan()
{
    return $this->hasMany(Pesanan::class);
}


}




