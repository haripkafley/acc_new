<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorruptionArea extends Model
{
    use HasFactory;

    protected $table = 'ce_pltblareaofcorruption';
    protected $primaryKey = 'corruptionAreaID';
}
