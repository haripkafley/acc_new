<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrativeOfficialTeam extends Model
{
    use HasFactory;
    protected $table = "administrative_official_team";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function appraise_details()
    {
        return $this->hasOne('App\Models\Appraise','id','appraise_id');
    }
}
