<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalOpinioActivity extends Model
{
    use HasFactory;
    protected $table = "legal_opinion_activity";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
