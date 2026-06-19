<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_code',
        'category_id',
        'reporter_id',
        'finder_id',
        'name',
        'description',
        'image1',
        'image2',
        'image3',
        'location_found',
        'location_lost',
        'date_found',
        'date_lost',
        'status',
        'is_confidential',
        'hidden_details',
        'drop_off_location',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'date_found' => 'date',
        'date_lost' => 'date',
        'date_reported' => 'datetime',
        'is_confidential' => 'boolean',
        'verified_at' => 'datetime',
    ];

    // Relasi: Kategori barang
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: User yang melaporkan barang hilang
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    // Relasi: User yang menemukan barang
    public function finder()
    {
        return $this->belongsTo(User::class, 'finder_id');
    }

    // Relasi: User yang memverifikasi barang
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Relasi: Klaim-klaim untuk barang ini
    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    // Relasi: Notifikasi terkait barang ini
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'related_item_id');
    }

    // Scope: Hanya barang yang ditemukan
    public function scopeFound($query)
    {
        return $query->where('status', 'ditemukan');
    }

    // Scope: Hanya barang yang hilang
    public function scopeLost($query)
    {
        return $query->where('status', 'hilang');
    }

    // Scope: Barang yang sedang diklaim
    public function scopeClaimed($query)
    {
        return $query->where('status', 'diklaim');
    }

    // Helper: Cek apakah barang sudah diklaim
    public function isClaimed()
    {
        return $this->status === 'diklaim';
    }

    // Helper: Cek apakah barang sudah selesai
    public function isCompleted()
    {
        return $this->status === 'selesai';
    }

    // Helper: Dapatkan URL gambar pertama
    public function getFirstImageAttribute()
    {
        return $this->image1 ? asset('storage/' . $this->image1) : null;
    }

    // Helper: Dapatkan semua gambar
    public function getImagesAttribute()
    {
        $images = [];
        if ($this->image1) $images[] = asset('storage/' . $this->image1);
        if ($this->image2) $images[] = asset('storage/' . $this->image2);
        if ($this->image3) $images[] = asset('storage/' . $this->image3);
        return $images;
    }
}
