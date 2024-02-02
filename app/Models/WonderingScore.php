<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WonderingScore extends Model
{
    use HasFactory;
    protected $table = "wondering_score";
    protected $fillable=[
        'content_id',
        'user_id',
        'score',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function content()
    {
        return $this->belongsTo(\App\Models\Content::class, 'content_id');
    }
}
