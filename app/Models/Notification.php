<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
        'related_item_id',
        'related_claim_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Relasi: User yang menerima notifikasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Barang terkait (jika ada)
    public function item()
    {
        return $this->belongsTo(Item::class, 'related_item_id');
    }

    // Relasi: Klaim terkait (jika ada)
    public function claim()
    {
        return $this->belongsTo(Claim::class, 'related_claim_id');
    }

    // Scope: Notifikasi yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope: Notifikasi yang sudah dibaca
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    // Helper: Tandai sebagai sudah dibaca
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    // Helper: Cek apakah belum dibaca
    public function isUnread()
    {
        return !$this->is_read;
    }

    // Helper: Dapatkan tipe notifikasi dalam bahasa Indonesia
    public function getTypeLabelAttribute()
    {
        $labels = [
            'email' => 'Email',
            'in_app' => 'Dalam Aplikasi',
            'both' => 'Email & Aplikasi',
        ];

        return $labels[$this->type] ?? $this->type;
    }
}
