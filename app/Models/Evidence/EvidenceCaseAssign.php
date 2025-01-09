<?php

namespace App\Models\Evidence;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenceCaseAssign extends Model
{
    use HasFactory;

    protected $table = 'evidence_case_assign_official';

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
