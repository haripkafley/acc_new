<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewType extends Model
{
    use HasFactory;
    protected $table = 'tbl_interviewtypes_lookup';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'interview_type',
    ];
}
