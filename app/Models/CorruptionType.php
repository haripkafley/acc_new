<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorruptionType extends Model
{
    use HasFactory;

    protected $table = 'ce_pltblcorruptiontype';
    protected $primaryKey = 'corruptionTypeID';
}
