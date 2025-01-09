<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasetaskAssignOfficial extends Model
{
    use HasFactory;
    protected $table = 'case_task_assign_official';

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }


}
