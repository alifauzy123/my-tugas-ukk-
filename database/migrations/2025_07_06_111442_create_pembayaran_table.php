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
       Schema::create('pembayaran', function (Blueprint $table) {
        $table->id();
        $table->string('kode_pembayaran', 10)->unique(); // Contoh: BYR001
        $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
        $table->decimal('total', 15, 2); // total maksimal 999 triliun, dengan 2 angka desimal
        $table->string('metode'); // Tunai, Transfer, dsb
        $table->date('tanggal');
        $table->enum('status', ['Dibayar', 'Menunggu', 'Gagal'])->default('Menunggu');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
