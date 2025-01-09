<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlValueScore extends Model
{
    use HasFactory;
    protected $table = 'ce_linkpvalues_compdecisions';
    protected $primaryKey = 'lpvalueCompDecisionID';
}
