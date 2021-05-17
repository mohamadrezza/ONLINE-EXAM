<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'teacher_id',
        'description'
    ];
    function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }


}
