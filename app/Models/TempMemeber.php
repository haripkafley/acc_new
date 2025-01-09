<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempMemeber extends Model
{
    use HasFactory;
    protected $table = 'cec_temp_member';

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','member_id');
    }
}
