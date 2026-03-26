<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokter')->onDelete('cascade');
            $table->foreignId('jadwal_id')->nullable()->constrained('jadwal_dokter')->onDelete('set null');
            $table->date('tanggal_booking');
            $table->enum('status_pembayaran', ['pending', 'lunas', 'ditolak'])->default('pending');
            $table->enum('status_sesi', ['menunggu', 'aktif', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->dateTime('waktu_mulai_sesi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
