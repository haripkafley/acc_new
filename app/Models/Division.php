<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $table = 'division';

    public function department_name()
    {
        return $this->hasOne('App\Models\Department','id','department_id');
    }
}
