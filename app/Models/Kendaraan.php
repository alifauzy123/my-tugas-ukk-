<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';

    protected $fillable = [
        'kode_kendaraan',
        'nama_kendaraan',
        'nomer_polisi',
        'supir',
        'catatan',
        'status'
    ];
}
