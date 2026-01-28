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
        Schema::table('kasirs', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('password');
            $table->text('bio')->nullable()->after('avatar');
            $table->string('telepon_kantor')->nullable()->after('bio');
            $table->string('nama_bank')->nullable()->after('telepon_kantor');
            $table->string('nomor_rekening')->nullable()->after('nama_bank');
            $table->string('atas_nama_rekening')->nullable()->after('nomor_rekening');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kasirs', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'bio', 'telepon_kantor', 'nama_bank', 'nomor_rekening', 'atas_nama_rekening']);
        });
    }
};
