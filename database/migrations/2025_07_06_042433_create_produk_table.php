<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
    $table->id();
    $table->string('kode_produk', 10)->unique();
    $table->string('nama_produk', 100);
    $table->integer('harga');
    $table->integer('stok')->default(0);
    $table->unsignedBigInteger('kategori_id');
    $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
    $table->string('gambar')->nullable();
    $table->timestamps();

    $table->foreign('kategori_id')->references('id')->on('kategori_produk')->onDelete('cascade');
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
