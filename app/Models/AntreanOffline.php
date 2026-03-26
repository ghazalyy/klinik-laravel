<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntreanOffline extends Model
{
    protected $table = 'antrean_offline';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'nomor_antrean',
        'tanggal_kunjungan',
        'tujuan_kunjungan',
        'status',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
}
