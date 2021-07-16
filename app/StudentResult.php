<?php

namespace App;

use App\Exam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'exam_id',
        'result'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}
