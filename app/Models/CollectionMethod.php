<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionMethod extends Model
{
    use HasFactory;
     public $timestamps = true;
     protected $table = 'tbl_collection_methods_lookup';
    protected $fillable = ['method','id'];
}
