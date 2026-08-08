<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            if (Schema::hasColumn('pembayaran', 'midtrans_order_id')) {
                $table->renameColumn('midtrans_order_id', 'paymentku_reference');
            }
            if (Schema::hasColumn('pembayaran', 'midtrans_status')) {
                $table->renameColumn('midtrans_status', 'paymentku_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            if (Schema::hasColumn('pembayaran', 'paymentku_reference')) {
                $table->renameColumn('paymentku_reference', 'midtrans_order_id');
            }
            if (Schema::hasColumn('pembayaran', 'paymentku_status')) {
                $table->renameColumn('paymentku_status', 'midtrans_status');
            }
        });
    }
};
