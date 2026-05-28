<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditProject extends Model
{
    protected $table = 'audit_projects';
    protected $fillable = ['name', 'description', 'asesor_id', 'status', 'maturity_index'];

    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id', 'id');
    }

    public function projectProcesses()
    {
        return $this->hasMany(AuditProjectProcess::class, 'project_id', 'id');
    }

    public function responses()
    {
        return $this->hasMany(AssessmentResponse::class, 'project_id', 'id');
    }
}
