<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_dokter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('booking')->onDelete('cascade');
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokter')->onDelete('cascade');
            $table->integer('rating_pelayanan');
            $table->integer('rating_komunikasi');
            $table->text('ulasan')->nullable();
            $table->timestamps();
            $table->unique('booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_dokter');
    }
};
