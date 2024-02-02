<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalScore extends Model
{
    use HasFactory;
    protected $table = "total_score";
    protected $fillable=[
        'wondering_score_id',
        'user_score_id',
        'score',
        'user_id',
        'content_id',
        'question_id'
    ];

    public function question()
    {
        return $this->belongsTo(\App\Models\Question::class, 'question_id');
    }
}
