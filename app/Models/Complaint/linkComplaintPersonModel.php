<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class linkComplaintPersonModel extends Model
{
    use HasFactory;
    protected $table = 'cr_linkcomplaint_person_category';
    protected $primaryKey = 'linkComplaintPersonCatID';

    public function linkcomplaint_person_categoryName()
    {
        return $this->hasOne('App\Models\Complaint\personCategoryModel', 'personCategoryID', 'personCatID');
    }

    public function complaint_details()
    {
        return $this->hasOne('App\Models\Complaint\complaintRegistrationModel', 'complaintID', 'complaintID');
    }
}
