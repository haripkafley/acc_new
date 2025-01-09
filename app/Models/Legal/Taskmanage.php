<?php

namespace App\Models\Legal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taskmanage extends Model
{
    use HasFactory;
    protected $table = "legal_task_manage";

    public function task_type()
    {
        return $this->hasOne('App\Models\TaskType','id','type_of_task');
    }

    public function task_name()
    {
        return $this->hasOne('App\Models\inv_pltbltask','invtaskID','task');
    }

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
