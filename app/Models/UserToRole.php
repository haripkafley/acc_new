<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToRole extends Model
{
    use HasFactory;
    protected $table = 'tbl_mst_user_role';

    public function role_name()
    {
        return $this->hasOne('App\Models\RoleCims','id','role_id');
    }
}
