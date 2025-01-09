<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpCategory extends Model
{
    use HasFactory;

    protected $table = 'pl_tblempcategory';
    protected $primaryKey = 'empCategoryID';
}
