<?php

namespace App\Models\Evidence;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenceTask extends Model
{
    use HasFactory;
    protected $table = "evidence_case_task_manage";

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
