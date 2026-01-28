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
        Schema::table('menus', function (Blueprint $table) {
            // Drop the old kategori string column if it exists
            if (Schema::hasColumn('menus', 'kategori')) {
                $table->dropColumn('kategori');
            }
            // Add new kategori_id foreign key
            $table->unsignedBigInteger('kategori_id')->nullable()->after('harga');
            $table->foreign('kategori_id')->references('id')->on('kategori_produk')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
            $table->string('kategori')->nullable();
        });
    }
};
