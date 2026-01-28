<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kasir extends Authenticatable
{
    protected $fillable = [
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'email',
        'no_hp',
        'username',
        'password',
        'status',
        'avatar',
        'bio',
        'telepon_kantor',
        'nama_bank',
        'nomor_rekening',
        'atas_nama_rekening',
    ];

    protected $hidden = [
        'password',
    ];

    public function loginLogs(): HasMany
    {
        return $this->hasMany(KasirLoginLog::class);
    }
}
