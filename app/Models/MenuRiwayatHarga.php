<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuRiwayatHarga extends Model
{
    protected $table = 'menu_riwayat_harga';
    protected $fillable = ['menu_id', 'harga_lama', 'harga_baru'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
