<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tbl_complaints';
    protected $fillable = [
        'complaint_no',
        'complaint_title',
        'complaint_status',
        'case_substatus',
        'complaint_reg_date',
    ];
}
