<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $hidden = array('correct_answer');

    function question()
    {
        return $this->belongsTo(Question::class);
    }

    function category()
    {
        return $this->belongsTo(Category::class);
    }
}
