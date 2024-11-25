<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $fillable = ['exam_result_id', 'question_id', 'answer_id'];

    public function examResult()
    {
        return $this->belongsTo(ExamResult::class);
    }
}

