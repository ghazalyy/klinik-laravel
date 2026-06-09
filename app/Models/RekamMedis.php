<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'booking_id',
        'antrean_offline_id',
        'tanggal_periksa',
        'keluhan',
        'diagnosa',
        'tindakan',
        'resep_obat',
        'catatan',
    ];

    protected $casts = [
        'tanggal_periksa' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function antreanOffline()
    {
        return $this->belongsTo(AntreanOffline::class, 'antrean_offline_id');
    }
}
