<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'jadwal_id',
        'tanggal_booking',
        'status_pembayaran',
        'status_sesi',
        'waktu_mulai_sesi',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'waktu_mulai_sesi' => 'datetime',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalDokter::class, 'jadwal_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'booking_id');
    }

    public function chat()
    {
        return $this->hasMany(Chat::class, 'booking_id');
    }

    public function reviewDokter()
    {
        return $this->hasOne(ReviewDokter::class, 'booking_id');
    }
}
