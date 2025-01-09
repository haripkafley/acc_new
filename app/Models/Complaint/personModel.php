<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personModel extends Model
{
    use HasFactory;
    protected $table = 'tblperson';
    protected $primaryKey = 'personID';

    public function genderRelation()
    {
        return $this->hasOne('App\Models\Complaint\GenderModel', 'id', 'gender');
    }

    public function dzongkhagrelation()
    {
        return $this->hasOne('App\Models\Dzongkhag', 'dzoID', 'permAddDzongkhag');
    }


    public function gewogrelation()
    {
        return $this->hasOne('App\Models\Gewog', 'gewogID', 'permAddGewog');
    }

    public function villagerelation()
    {
        return $this->hasOne('App\Models\Village', 'villageID', 'permAddVillage');
    }
}
