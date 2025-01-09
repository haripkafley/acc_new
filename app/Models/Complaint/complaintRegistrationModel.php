<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class complaintRegistrationModel extends Model
{
    use HasFactory;
    protected $table = 'cr_tblcomplaintregistration';
    protected $primaryKey = 'complaintID';

    public function complaintmoderelation()
    {
        return $this->hasOne('App\Models\Complaint\complaintModeModel', 'complaintmodeID', 'modeID');
    }


    public function complaintTyperelation()
    {
        return $this->hasOne('App\Models\Complaint\complaintTypeModel', 'id', 'complainantType');
    }

    public function complaintreceivedByRelation()
    {
        return $this->hasMany('App\Models\Complaint\complaintReceivedByModel', 'complaintID', 'complaintID');
    }

     public function complaintProcessingTypeRelation()
    {
        return $this->hasOne('App\Models\Complaint\pl_complaintProcessingType_Model', 'complaintProcessingTypeID', 'complaintProcessingTypeID');
    }

    public function dzongkhagrelation()
    {
        return $this->hasOne('App\Models\Dzongkhag', 'dzoID', 'placeOfOccurrenceDzongkhagID');
    }


    public function gewogrelation()
    {
        return $this->hasOne('App\Models\Gewog', 'gewogID', 'placeOfOccurrenceGewogID');
    }

    public function villagerelation()
    {
        return $this->hasOne('App\Models\Village', 'villageID', 'placeOfOccurrenceVillageID');
    }

    public function action_atr_list()
    {
        return $this->hasMany('App\Models\ActionList', 'complaint_id', 'complaintID');
    }

    public function sensi_atr_list()
    {
        return $this->hasMany('App\Models\SensitizationActionList', 'complaint_id', 'complaintID');
    }

    public function user_details_head()
    {
        return $this->hasOne('App\Models\User', 'id', 'headquater_user_id');
    }

    public function user_details_regional()
    {
        return $this->hasOne('App\Models\User', 'id', 'regional_user_id');
    }

    public function region_name()
    {
        return $this->hasOne('App\Models\Complaint\RegionalOffice', 'id', 'regional_office');
    }

    public function appraise_details()
    {
        return $this->hasOne('App\Models\Appraise','complaint_id','complaintID');
    }
    
}
