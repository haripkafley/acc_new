<?php

namespace App\Models\Dare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;
    protected $table = "dare_source_master";
    public function agency_name()
    {
        return $this->hasOne('App\Models\Complaint\agencyModel','agencyID','agency') ;
    }
}
