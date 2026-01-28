<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 20)->unique();
            $table->foreignId('kasir_id')->constrained('kasirs')->onDelete('cascade');
            $table->decimal('total', 15, 2);
            $table->decimal('uang_dibayar', 15, 2);
            $table->decimal('kembalian', 15, 2)->default(0);
            $table->dateTime('tanggal');
            $table->string('status')->default('Dibayar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
