<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;
    protected $table = 'tbl_sources_lookup';
    public $timestamps = true;
    protected $fillable = ['source_type', 'source_name'];
}
