<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProbableCause extends Model
{
    use HasFactory;
    protected $table = 'tbl_probable_causes';
    public $timestamps = true;

    protected $fillable = [
        'name',
    ];
}
