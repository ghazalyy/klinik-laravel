<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('spesialisasi', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_sesi', 10, 2)->default(0.00);
            $table->string('foto_profil', 255)->default('default.png');
            $table->enum('status_online', ['Online', 'Offline'])->default('Offline');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};
