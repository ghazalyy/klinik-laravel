<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'booking_id',
        'jumlah_bayar',
        'metode_pembayaran',
        'bukti_transfer',
        'midtrans_order_id',
        'midtrans_status',
        'verifikasi_oleh_admin_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'verifikasi_oleh_admin_id');
    }
}
