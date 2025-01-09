<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintSource extends Model
{
    use HasFactory;
    protected $table = 'cr_pltblsourceofcomplaints';
    protected $primaryKey = 'sourceOfcomplaintsID';
}
