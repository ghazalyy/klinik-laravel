<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survei_kepuasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating_pendaftaran');
            $table->integer('rating_fasilitas');
            $table->integer('rating_pelayanan_staf');
            $table->integer('rating_kebersihan');
            $table->integer('rekomendasi_nps');
            $table->text('saran_masukan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survei_kepuasan');
    }
};
