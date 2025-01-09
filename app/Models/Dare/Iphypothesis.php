<?php

namespace App\Models\Dare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iphypothesis extends Model
{
    use HasFactory;
    protected $table = "intel_hypothesis";

    public function report_hypo()
    {
        return $this->hasOne('App\Models\Dare\HypoReport','hypo_id','id');
    }
}
