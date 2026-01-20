<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerimaan_barangs', function (Blueprint $table) {
            $table->id();
            
            $table->string('kode_penerimaan')->unique();

            // relasi ke purchase_order
            $table->string('kode_po'); 
            $table->foreign('kode_po')
                ->references('kode_po')
                ->on('purchase_orders')
                ->onDelete('cascade');

            // relasi ke supplier
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('cascade');

            $table->string('nama_supplier');   // dari supplier
            $table->string('nama_produk');     // dari PO
            $table->integer('harga');          // dari PO
            $table->integer('jumlah');         // input manual

            $table->date('tanggal');           // input manual

            $table->integer('dp')->nullable()->default(0);
            $table->integer('diskon')->nullable()->default(0);
            $table->integer('pajak')->nullable()->default(0);
            $table->integer('subtotal')->default(0);

            $table->text('catatan')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerimaan_barangs');
    }
};
