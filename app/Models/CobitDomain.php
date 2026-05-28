<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CobitDomain extends Model
{
    protected $table = 'cobit_domains';
    protected $fillable = ['id', 'name', 'description'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function processes()
    {
        return $this->hasMany(CobitProcess::class, 'domain_id', 'id');
    }
}
