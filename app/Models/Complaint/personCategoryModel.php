<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personCategoryModel extends Model
{
    use HasFactory;
    protected $table = 'cr_pltblpersoncategory';
    protected $primaryKey = 'personCategoryID';
}
