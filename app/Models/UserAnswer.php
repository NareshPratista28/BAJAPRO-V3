<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAnswer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "user_answer";
    protected $fillable=[
        'essay_question_id',
        'user_id',
        'answer'
    ];

    public function essay()
    {
        return $this->belongsTo(\App\Models\EssayQuestion::class, 'essay_question_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function explainingscore(){
        return $this->hasMany(ExplainingScore::class);
    }
}
