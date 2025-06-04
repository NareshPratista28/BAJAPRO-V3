<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntaxConversionHistory extends Model
{
    use HasFactory;

    protected $table = 'syntax_conversion_history';
    
    protected $fillable = [
        'user_id',
        'title',
        'java_code',
        'python_code',
        'explanation',
    ];

    /**
     * Get the user that owns the conversion.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
