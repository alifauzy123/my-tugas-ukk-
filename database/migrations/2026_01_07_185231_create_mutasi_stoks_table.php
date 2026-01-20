<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mutasi_stoks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produk_id');

            // IN = barang masuk
            // OUT = barang keluar
            // ADJUST = koreksi stok manual
            $table->enum('jenis_mutasi', ['IN', 'OUT', 'ADJUST']);

            $table->integer('qty_mutasi');      // jumlah perubahan
            $table->integer('stok_sebelum');    // stok sebelum mutasi
            $table->integer('stok_sesudah');    // stok setelah mutasi

            $table->string('keterangan')->nullable(); // contoh: "Penerimaan barang", "Pesanan 123"
            $table->timestamps();

            // relasi
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mutasi_stoks');
    }
};
