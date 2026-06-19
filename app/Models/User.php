<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nim_nip',
        'name',
        'email',
        'password',
        'role',
        'phone',
        'department',
        'is_verified',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    // Relasi: Barang yang dilaporkan oleh user ini
    public function reportedItems()
    {
        return $this->hasMany(Item::class, 'reporter_id');
    }

    // Relasi: Barang yang ditemukan oleh user ini
    public function foundItems()
    {
        return $this->hasMany(Item::class, 'finder_id');
    }

    // Relasi: Klaim yang diajukan oleh user ini
    public function claims()
    {
        return $this->hasMany(Claim::class, 'claimant_id');
    }

    // Relasi: Notifikasi untuk user ini
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Relasi: Barang yang diverifikasi oleh user ini (admin/satpam)
    public function verifiedItems()
    {
        return $this->hasMany(Item::class, 'verified_by');
    }

    // Relasi: Klaim yang diverifikasi oleh user ini
    public function verifiedClaims()
    {
        return $this->hasMany(Claim::class, 'verified_by');
    }

    // Helper: Cek apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Helper: Cek apakah user adalah satpam
    public function isSatpam()
    {
        return $this->role === 'satpam';
    }

    // Helper: Cek apakah user adalah mahasiswa
    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }
}
