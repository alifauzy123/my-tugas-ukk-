<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasirLoginLog extends Model
{
    protected $fillable = [
        'kasir_id',
        'action',
        'logged_at',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
    ];

    public function kasir(): BelongsTo
    {
        return $this->belongsTo(Kasir::class);
    }
}
