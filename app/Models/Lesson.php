<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



/**
 * Class lesson
 * @package App\Models
 * @version May 30, 2022, 12:03 pm UTC
 *
 * @property \App\Models\Course $course
 * @property string $title
 * @property string $description
 * @property integer $course_id
 * @property integer $position
 * @property integer $published
 */
class Lesson extends Model
{


    public $table = 'lessons';




    public $fillable = [
        'title',
        'description',
        'prompt_llm',
        'course_id',
        'level_id',
        'position',
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
        'description' => 'string',
        'prompt_llm' => 'string',
        'course_id' => 'integer',
        'position' => 'integer',
        'published' => 'integer',
        'level_id'  => 'integer'
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
    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class, 'course_id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function level()
    {
        return $this->belongsTo(\App\Models\Level::class, 'level_id');
    }
}
