<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CobitQuestion extends Model
{
    protected $table = 'cobit_questions';
    protected $fillable = ['practice_code', 'level', 'question_text', 'expected_evidence'];

    public function practice()
    {
        return $this->belongsTo(CobitPractice::class, 'practice_code', 'code');
    }
}
