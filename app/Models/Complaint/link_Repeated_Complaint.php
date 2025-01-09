<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class link_Repeated_Complaint extends Model
{
    use HasFactory;
    protected $table = 'cr_linktbl_repeated_complaint';
    protected $primaryKey = 'repeatedID';

    public function repeatedComplaint_registrationRelation()
    {
        //Extracting detail on repeatedComplaintID
        return $this->hasOne('App\Models\Complaint\complaintRegistrationModel', 'complaintID', 'repeatedComplaintID');
    }
}
