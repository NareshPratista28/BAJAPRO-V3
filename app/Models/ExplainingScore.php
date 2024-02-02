<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExplainingScore extends Model
{
    use HasFactory;
    protected $table = "explaining_score";
    protected $fillable=[
        'content_id',
        'user_id',
        'konteks_penjelasan',
        'keruntutan',
        'kebenaran',
        'user_answer_id',
        'essay_question_id',
        'question_id',
        'total_score_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function content()
    {
        return $this->belongsTo(\App\Models\Content::class, 'content_id');
    }

    public function essay()
    {
        return $this->belongsTo(\App\Models\EssayQuestion::class, 'essay_question_id');
    }

    public function answer()
    {
        return $this->belongsTo(\App\Models\UserAnswer::class, 'user_answer_id');
    }

    public function total()
    {
        return $this->belongsTo(\App\Models\TotalScore::class, 'total_score_id');
    }

}
