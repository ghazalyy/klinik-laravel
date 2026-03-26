<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';

    protected $fillable = [
        'user_id',
        'spesialisasi',
        'deskripsi',
        'harga_sesi',
        'foto_profil',
        'status_online',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jadwalDokter()
    {
        return $this->hasMany(JadwalDokter::class, 'dokter_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'dokter_id');
    }

    public function reviewDokter()
    {
        return $this->hasMany(ReviewDokter::class, 'dokter_id');
    }

    public function antreanOffline()
    {
        return $this->hasMany(AntreanOffline::class, 'dokter_id');
    }

    // Hitung rata-rata rating
    public function getRataRatingAttribute(): float
    {
        $reviews = $this->reviewDokter;
        if ($reviews->isEmpty()) return 0;
        $total = $reviews->sum(fn($r) => ($r->rating_pelayanan + $r->rating_komunikasi) / 2);
        return round($total / $reviews->count(), 2);
    }
}
