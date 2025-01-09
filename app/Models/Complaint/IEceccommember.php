<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IEceccommember extends Model
{
    use HasFactory;
    protected $table = "information_enrichment_cec_com";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','member_id');
    }

    public function information_details()
    {
        return $this->hasOne('App\Models\Complaint\CompalintEveOffence','id','ie_id');
    }
}
