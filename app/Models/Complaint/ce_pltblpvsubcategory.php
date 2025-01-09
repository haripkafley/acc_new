<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ce_pltblpvsubcategory extends Model
{
    use HasFactory;
    protected $table = 'ce_pltblpvsubcategory';
    protected $primaryKey = 'pValueSubCategoryID';

    public function category_name()
    {
        return $this->hasOne('App\Models\Complaint\ce_pltblpvaluecategory','pValueCategoryID','pValueCategoryID');
    }
}
