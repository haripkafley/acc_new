<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appraise extends Model
{
    use HasFactory;
    protected $table = 'appraise_table';

    public function complaint_details()
    {
        return $this->hasOne('App\Models\Complaint\complaintRegistrationModel','complaintID','complaint_id');
    }

    public function eve_offence_details()
    {
        return $this->hasOne('App\Models\Complaint\CompalintEveOffence','id','eve_offence_id');
    }
}
