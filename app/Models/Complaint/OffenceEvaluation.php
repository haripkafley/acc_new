<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffenceEvaluation extends Model
{
    use HasFactory;
    protected $table = "tbl_offences_lookup";
}
