<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'claimant_id',
        'description',
        'proof_details',
        'status',
        'verified_by',
        'verified_at',
        'rejection_reason',
        'notes',
    ];

    protected $casts = [
        'claim_date' => 'datetime',
        'verified_at' => 'datetime',
    ];

    // Relasi: Barang yang diklaim
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi: User yang mengajukan klaim
    public function claimant()
    {
        return $this->belongsTo(User::class, 'claimant_id');
    }

    // Relasi: User yang memverifikasi klaim
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Relasi: Notifikasi terkait klaim ini
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'related_claim_id');
    }

    // Scope: Klaim yang pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope: Klaim yang disetujui
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope: Klaim yang ditolak
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Helper: Cek apakah klaim pending
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // Helper: Cek apakah klaim disetujui
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    // Helper: Cek apakah klaim ditolak
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Helper: Dapatkan status dalam bahasa Indonesia
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            'approved' => 'Disetujui',
        ];

        return $labels[$this->status] ?? $this->status;
    }
}
