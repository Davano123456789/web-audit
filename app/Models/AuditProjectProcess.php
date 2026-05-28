<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditProjectProcess extends Model
{
    protected $table = 'audit_project_processes';
    protected $fillable = ['project_id', 'process_code', 'target_level', 'computed_capability_level', 'status'];

    public function project()
    {
        return $this->belongsTo(AuditProject::class, 'project_id', 'id');
    }

    public function cobitProcess()
    {
        return $this->belongsTo(CobitProcess::class, 'process_code', 'code');
    }
}
