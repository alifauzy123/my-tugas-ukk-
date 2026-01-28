<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kasir_login_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasir_id')->constrained('kasirs')->onDelete('cascade');
            $table->enum('action', ['login', 'logout']);
            $table->dateTime('logged_at');
            $table->timestamps();

            $table->index(['kasir_id', 'logged_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasir_login_logs');
    }
};
