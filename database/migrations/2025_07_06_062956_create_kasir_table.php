<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('kasirs', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lengkap');
        $table->date('tanggal_lahir');
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->text('alamat');
        $table->string('email')->unique();
        $table->string('no_hp');
        $table->string('username')->unique();
        $table->string('password');
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->timestamps();
    });
}


    public function down(): void {
        Schema::dropIfExists('kasirs');
    }
};
