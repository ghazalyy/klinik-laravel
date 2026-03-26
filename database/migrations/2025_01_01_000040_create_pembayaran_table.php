<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('booking')->onDelete('cascade');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->string('metode_pembayaran', 50)->default('Transfer Bank');
            $table->string('bukti_transfer', 255)->nullable();
            $table->string('midtrans_order_id', 100)->nullable();
            $table->string('midtrans_status', 50)->nullable();
            $table->foreignId('verifikasi_oleh_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
