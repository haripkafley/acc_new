<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummonOrder extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tbl_case_summonorders';
    protected $fillable = [
        'interviewplan_id',
        'case_no_id',
        'interviewee',
        'report_to',
        'summondate',
        'summontime',
        'summonvenue',
        'summonorderstatus',
    ];
}
