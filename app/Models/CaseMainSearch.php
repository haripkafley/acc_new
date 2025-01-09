<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseMainSearch extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_mainsearches';
    public $timestamps = true;
    protected $primaryKey = 'search_id';
    protected $fillable = [
        'seizureStatus',
        'case_no_id',
        'typeofsearch',
        'suspect',
        'ownership_type',
        'location',
        'searchtarget',
        'pcause',
        'applicationdate',
        'commissionStatus',
        'commissionReview',
        'warrantNo',
        'warrantDate',
        'warrantRemark',
        'fileY',
        'fileX',
        'identification_no',
        'owner_name',
        'public_premise_name',
        'public_premise_location',
        'private_premise_location',
    ];
}
