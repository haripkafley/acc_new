<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchProbableCause extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_search_probable_causes';
    public $timestamps = true;
    protected $fillable = [
        'search_id',
        'name',
    ];
}
