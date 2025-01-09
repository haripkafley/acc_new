<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseArrestProbableCause extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_arrest_probable_causes';
    protected $fillable = ['arrest_id', 'name'];
    public $timestamps = true;
}
