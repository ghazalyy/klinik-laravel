<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewDokter extends Model
{
    protected $table = 'review_dokter';

    protected $fillable = [
        'booking_id',
        'pasien_id',
        'dokter_id',
        'rating_pelayanan',
        'rating_komunikasi',
        'ulasan',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
}
