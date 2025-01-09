<?php

namespace App\Models\Ti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TackticalInteligence extends Model
{
    use HasFactory;
    protected $table = "tactical_inteligence";

    public function request_type_details()
    {
        return $this->hasOne('App\Models\Ti\RequestType','id','request_type');
    }

    public function relation_details()
    {
        return $this->hasOne('App\Models\Ti\RelationTi','id','relation_to');
    }

    public function officer_details()
    {
        return $this->hasOne('App\Models\User','id','requesting_officer');
    }

    public function recommend_details()
    {
        return $this->hasOne('App\Models\User','id','recommend_by');
    }

    public function offence_details()
    {
        return $this->hasOne('App\Models\Offence','offence_id','corruption');
    }

    public function submit_details()
    {
        return $this->hasOne('App\Models\User','id','submitted_by');
    }

    public function review_details()
    {
        return $this->hasOne('App\Models\User','id','review_by');
    }


}
