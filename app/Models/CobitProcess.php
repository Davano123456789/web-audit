<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CobitProcess extends Model
{
    protected $table = 'cobit_processes';
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['code', 'domain_id', 'name', 'description'];

    public function domain()
    {
        return $this->belongsTo(CobitDomain::class, 'domain_id', 'id');
    }

    public function practices()
    {
        return $this->hasMany(CobitPractice::class, 'process_code', 'code');
    }
}
