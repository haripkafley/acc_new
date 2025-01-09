<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationEnrichmentTeam extends Model
{
    use HasFactory;
    protected $table = "information_enrichment_team";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function information_details()
    {
        return $this->hasOne('App\Models\Complaint\CompalintEveOffence','id','ir_id');
    }

}
