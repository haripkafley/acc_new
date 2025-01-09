<?php

namespace App\Models\Dare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntelPlan extends Model
{
    use HasFactory;
    protected $table = "ip_intel_plan";

    public function collected_details()
    {
        return $this->hasOne('App\Models\User','id','collected_from');
    }

    public function source_name()
    {
        return $this->hasOne('App\Models\Dare\Source','id','source');
    }

    public function status_details()
    {
        return $this->hasOne('App\Models\Dare\IpStatus','id','status');
    }

    public function ir_details()
    {
        return $this->hasOne('App\Models\Dare\IrForm','id','ip_id');
    }

    public function hypo_details()
    {
        return $this->hasOne('App\Models\Dare\Iphypothesis','id','hypo_id');
    }
}
