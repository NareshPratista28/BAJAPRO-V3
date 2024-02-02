<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Explains extends Model
{
    use HasFactory;
    protected $table = 'explains';
    protected $fillable =[
        'description',
        'level_id',
        'user_id',
        'edited_admin',
        'code',
        'question_id'
    ];

    public function level(){
        return $this->belongsTo(\App\Models\Level::class, 'level_id');
    }

    public function users(){
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function question(){
        return $this->belongsTo(\App\Models\Question::class, 'question_id');
    }
}
