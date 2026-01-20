<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_po',
        'kategori_produk_id',
        'supplier_id',
        'nama_produk',
        'produk_id', 
        'harga_produk',
        'tanggal',
        'jumlah',
        'diskon',
        'pajak',
        'dp',
        'subtotal',
        'grand_total',
        'catatan',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function produk()
{
    return $this->belongsTo(Produk::class, 'produk_id');
}

}
