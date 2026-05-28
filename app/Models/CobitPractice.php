<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CobitPractice extends Model
{
    protected $table = 'cobit_practices';
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['code', 'process_code', 'name', 'description'];

    public function process()
    {
        return $this->belongsTo(CobitProcess::class, 'process_code', 'code');
    }

    public function questions()
    {
        return $this->hasMany(CobitQuestion::class, 'practice_code', 'code');
    }
}
