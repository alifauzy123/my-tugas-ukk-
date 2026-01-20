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
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('email');
        $table->string('username')->unique()->after('id');
        $table->enum('role', ['admin','kasir'])->default('kasir')->after('password');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['username','role']);
        $table->string('email')->unique()->after('id');
    });
}


};
