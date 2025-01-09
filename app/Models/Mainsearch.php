<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mainsearch extends Model
{
    public $timestamps=false;
     protected $table = 'tbl_case_mainsearches';
    protected $fillable = [
        'search_id',
        'case_no_id',
        'seizureStatus',
        'typeofsearch',
        'suspect',
        'location',
        'pcause',
        'searchtarget',
        'applicationdate',
        'identification_no',
        'owner_name',
        'public_premise_name',
        'public_premise_location',
        'private_premise_location',

        'commissionStatus',
        'commissionReview',

        'warrantNo',
        'warrantDate',
        'warrantRemark',
        'fileY',
        'fileX',
    ];
}
