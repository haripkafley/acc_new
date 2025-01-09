<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pl_complaintProcessingType_Model extends Model
{
    use HasFactory;
    protected $table = 'cr_plcomplaintprocessingtype';
    protected $primaryKey = 'complaintProcessingTypeID';
}
