<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{
    protected $table = 'penerimaan_barangs';

    protected $fillable = [
        'kode_penerimaan',
        'kode_po',
        'supplier_id',
        'nama_supplier',
        'nama_produk',
         'produk_id',
        'harga',
        'jumlah',
        'tanggal',
        'dp',
        'diskon',
        'pajak',
        'subtotal',
        'catatan',
        'status'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'kode_po', 'kode_po');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function produk()
{
    return $this->belongsTo(Produk::class);
}

}
