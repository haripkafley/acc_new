<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seizures extends Model
{
    public $timestamps=false;
    protected $table = 'allseziures';

    protected $fillable = [
        'Id',	
        'CaseNo',	
        'SeziureDate',	
        'SeizureTime',	
        'BankName',	
        'BranchName',
        'AccountNo',
        	
        'DateofDeposit',	
        'BankReciept',
        'SeizedName',
        'SeizedCid',
        'SeizureDoc',

        'Created_at',	
        'Updated_at'
        
    ];
}
