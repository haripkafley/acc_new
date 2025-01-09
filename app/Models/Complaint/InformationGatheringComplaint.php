<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationGatheringComplaint extends Model
{
    use HasFactory;
    protected $table = "information_gathering_complaint";

    public function eve_offence_details()
    {
        return $this->hasOne('App\Models\Complaint\CompalintEveOffence','id','evidence_allegation');
    }

    public function tacktical_details()
    {
        return $this->hasOne('App\Models\Ti\TackticalInteligence','id','tacktical_id');
    }
}
