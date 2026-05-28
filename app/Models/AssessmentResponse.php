<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentResponse extends Model
{
    protected $table = 'assessment_responses';
    protected $fillable = ['project_id', 'question_id', 'answer', 'notes', 'evidence_file'];

    public function project()
    {
        return $this->belongsTo(AuditProject::class, 'project_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(CobitQuestion::class, 'question_id', 'id');
    }
}
