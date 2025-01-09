<?php

namespace App\Models\Dare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrTeamMember extends Model
{
    use HasFactory;
    protected $table = "ir_form_team_member";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function ir_details()
    {
        return $this->hasOne('App\Models\Dare\IrForm','id','ir_id');
    }

    public function ip_details()
    {
        return $this->hasOne('App\Models\Dare\IntelProject','ir_id','ir_id');
    }


}
