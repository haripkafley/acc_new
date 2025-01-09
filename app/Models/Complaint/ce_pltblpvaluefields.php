<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ce_pltblpvaluefields extends Model
{
    use HasFactory;
    protected $table = 'ce_pltblpvaluefields';
    protected $primaryKey = 'pValueFieldID';

    public function sub_category_name()
    {
        return $this->hasOne('App\Models\Complaint\ce_pltblpvsubcategory','pValueSubCategoryID','pValueSubCategoryID');
    }
}
