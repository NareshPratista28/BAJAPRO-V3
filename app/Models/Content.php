<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Content
 * @package App\Models
 * @version May 30, 2022, 2:15 pm UTC
 *
 * @property \App\Models\lesson $lesson
 * @property string $title
 * @property integer $lesson_id
 * @property string $description
 * @property string $url_video
 * @property integer $published
 */
class Content extends Model
{
    use SoftDeletes;


    public $table = 'contents';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'lesson_id',
        'description',
        'prompt_llm',
        'url_video',
        'published'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'lesson_id' => 'integer',
        'description' => 'string',
        'prompt_llm' => 'string',
        'url_video' => 'string',
        'published' => 'integer'
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
    public function lesson()
    {
        return $this->belongsTo(\App\Models\Lesson::class, 'lesson_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function wondering()
    {
        return $this->hasMany(WonderingScore::class);
    }

    public function explainingscore()
    {
        return $this->hasMany(ExplainingScore::class);
    }
}
