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
    Schema::table('penerimaan_barangs', function (Blueprint $table) {
        $table->unsignedBigInteger('produk_id')->nullable()->after('kode_po');
    });
}

public function down()
{
    Schema::table('penerimaan_barangs', function (Blueprint $table) {
        $table->dropColumn('produk_id');
    });
}

};
