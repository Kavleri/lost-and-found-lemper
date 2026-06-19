<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

    // Relasi: Barang-barang dalam kategori ini
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
