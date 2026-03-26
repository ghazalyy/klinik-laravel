<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama_lengkap',
        'no_telepon',
        'alamat',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke profil dokter
    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'user_id');
    }

    // Booking sebagai pasien
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'pasien_id');
    }

    // Antrean offline sebagai pasien
    public function antreanOffline()
    {
        return $this->hasMany(AntreanOffline::class, 'pasien_id');
    }

    // Helper: apakah user ini adalah dokter
    public function isDokter(): bool
    {
        return $this->role === 'dokter';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPasien(): bool
    {
        return $this->role === 'pasien';
    }
}
