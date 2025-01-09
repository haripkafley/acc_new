<?php

namespace App\Models\Legal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalRequest extends Model
{
    use HasFactory;
    protected $table = "legal_service_request";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','assign_official_id');
    }
}
