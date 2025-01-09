<?php

namespace App\Models\Ti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TackticalMember extends Model
{
    use HasFactory;
    protected $table = "tactical_inteligence_team_member";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function tacktical_details()
    {
        return $this->hasOne('App\Models\Ti\TackticalInteligence','id','tacktical_id');
    }
}
