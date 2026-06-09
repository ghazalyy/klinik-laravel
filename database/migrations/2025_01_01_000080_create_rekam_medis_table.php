<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokter')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained('booking')->onDelete('cascade');
            $table->foreignId('antrean_offline_id')->nullable()->constrained('antrean_offline')->onDelete('cascade');
            $table->date('tanggal_periksa');
            $table->text('keluhan');
            $table->text('diagnosa');
            $table->text('tindakan');
            $table->text('resep_obat');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
