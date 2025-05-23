<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerationHistory extends Model
{
    use HasFactory;

    protected $table = 'generation_history';

    // Tidak menggunakan timestamps Laravel
    public $timestamps = false;

    // Konversi tipe data
    protected $casts = [
        'result' => 'array',
        'generation_time' => 'float',
        'created_at' => 'datetime',
    ];

    // Relasi ke Content
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}
