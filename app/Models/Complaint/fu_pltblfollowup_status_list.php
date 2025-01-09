<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fu_pltblfollowup_status_list extends Model
{
    use HasFactory;

    protected $table = 'fu_pltblfollowup_status_list';
    protected $primaryKey = 'followupstatusID';
}
