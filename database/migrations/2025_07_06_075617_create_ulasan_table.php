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
        Schema::create('ulasan', function (Blueprint $table) {
        $table->id();
        $table->string('kode_ulasan', 10)->unique(); // ULS001
        $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
        $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
        $table->unsignedTinyInteger('rating');
        $table->text('komentar')->nullable();
        $table->date('tanggal');
        $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
