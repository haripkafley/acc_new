<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employeeCategoryModel extends Model
{
    use HasFactory;
    protected $table = 'pl_tblempcategory';
    protected $primaryKey = 'empCategoryID';
}
