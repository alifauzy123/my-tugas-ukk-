<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('suppliers', function (Blueprint $table) {
        $table->id();
        $table->string('kode_supplier')->unique();
        $table->string('nama_supplier');
        $table->string('alamat')->nullable();
        $table->string('telepon')->nullable();
        $table->text('catatan')->nullable();
        $table->string('status')->default('aktif'); // contoh: aktif / nonaktif
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('suppliers');
}

};
