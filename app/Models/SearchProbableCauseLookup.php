<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchProbableCauseLookup extends Model
{
    use HasFactory;
    protected $table = 'tbl_search_probable_causes_lookup';
    protected $primaryKey = 'id';
    protected $fillable = ['cause_name'];
    public $timestamps = true;
}
