<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'exam_id', 'score', 'total_questions'];

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

