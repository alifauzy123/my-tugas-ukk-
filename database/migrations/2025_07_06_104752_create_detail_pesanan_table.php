<?php

// database/migrations/xxxx_xx_xx_create_detail_pesanan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_detail_pesanan', 10)->unique();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->integer('qty');
            $table->decimal('harga', 12, 2);
            $table->decimal('diskon', 12, 2)->nullable();
            $table->decimal('subtotal', 14, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('detail_pesanan');
    }
};
