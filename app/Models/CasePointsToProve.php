<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasePointsToProve extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_pointstoprove';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'interviewplanid',
        'pointstoprove',
    ];
}
