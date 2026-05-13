<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Question
 * @package App\Models
 * @version May 30, 2022, 3:00 pm UTC
 *
 * @property \App\Models\Content $content
 * @property integer $content_id
 * @property string $question
 * @property string $image
 * @property integer $score
 */
class Question extends Model
{
    use SoftDeletes;


    public $table = 'questions';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'content_id',
        'question',
        'question_name',
        'image',
        'score',
        'is_essay',
        'timer',
        'hint',
        'test_cases_data',
        'solution_template',
        'junit_tests',
        'class_name',
        'test_description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */    protected $casts = [
        'id' => 'integer',
        'content_id' => 'integer',
        'question' => 'string',
        'test_cases_data' => 'string',
        'solution_template' => 'string',
        'junit_tests' => 'string',
        'question_name' => 'string',
        'image' => 'string',
        'score' => 'integer',
        'is_essay' => 'integer',
        'timer' => 'integer',
        'hint' => 'string',
        'class_name' => 'string',
        'test_description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function content()
    {
        return $this->belongsTo(\App\Models\Content::class, 'content_id');
    }

    public function answers()
    {
        return $this->hasMany(\App\Models\Answer::class);
    }

    public function explains()
    {
        return $this->hasMany(Explains::class);
    }

    public function essay()
    {
        return $this->hasMany(EssayQuestion::class);
    }
    public function total()
    {
        return $this->hasMany(TotalScore::class);
    }
}
