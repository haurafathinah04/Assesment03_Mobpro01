<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // PASTIKAN user_id ADA DI DALAM SINI
    protected $fillable = [
        'judul', 
        'penulis', 
        'genre', 
        'status', 
        'image_url', 
        'user_id' 
    ];

    // Opsional: Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}