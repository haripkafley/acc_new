<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agencyModel extends Model
{
    use HasFactory;
    protected $table = 'pl_tblagency';
    protected $primaryKey = 'agencyID';

    public function getEmpCatDetails(){
        return $this->hasOne('App\Models\EmpCategory', 'empCategoryID', 'agencyCategoryID');
    }
}
