<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('kendaraan', function (Blueprint $table) {
        $table->id();
        $table->string('kode_kendaraan')->unique();
        $table->string('nama_kendaraan');
        $table->string('nomer_polisi')->unique();
        $table->string('supir')->nullable(); // nanti bisa relasi ke tabel supir
        $table->text('catatan')->nullable();
        $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('kendaraan');
}

};
