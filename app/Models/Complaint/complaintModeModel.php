<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class complaintModeModel extends Model
{
    use HasFactory;
    protected $table = 'cr_pltblcomplaintmode';
    protected $primaryKey = 'complaintmodeID';
}
