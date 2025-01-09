<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementGoodService extends Model
{
    use HasFactory;
    protected $table = 'procurement_good_service';

    public function dzongkhagrelation()
    {
        return $this->hasOne('App\Models\Dzongkhag','dzoID','dzongkhag_id');
    }

    public function gewogrelation()
    {
        return $this->hasOne('App\Models\Gewog','gewogID','gewog_id');
    }
}
