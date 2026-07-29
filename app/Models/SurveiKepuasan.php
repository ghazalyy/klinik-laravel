<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveiKepuasan extends Model
{
    protected $table = 'survei_kepuasan';

    protected $fillable = [
        'pasien_id',
        'rating_pendaftaran',
        'rating_fasilitas',
        'rating_pelayanan_staf',
        'rating_kebersihan',
        'rekomendasi_nps',
        'saran_masukan',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }
}
