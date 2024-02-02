<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EssayQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "essay_question";
    protected $fillable=[
        'question_id',
        'user_id',
        'question',
        'answer'
    ];

    public function questions()
    {
        return $this->belongsTo(\App\Models\Question::class, 'question_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function userAnswer(){
        return $this->hasMany(UserAnswer::class);
    }

    public function explainingscore(){
        return $this->hasMany(ExplainingScore::class);
    }
}
