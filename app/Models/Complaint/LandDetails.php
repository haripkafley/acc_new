<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandDetails extends Model
{
    use HasFactory;

    protected $table = 'land_details';

    public function dzongkhagrelation()
    {
        return $this->hasOne('App\Models\Dzongkhag','dzoID','dzongkhag_id');
    }

    public function gewogrelation()
    {
        return $this->hasOne('App\Models\Gewog','gewogID','gewog_id');
    }
}
