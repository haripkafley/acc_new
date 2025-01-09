<?php

namespace App\Models\Legal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalReviewUpdate extends Model
{
    use HasFactory;
    protected $table = "legal_review_update";

    public function case_withdrawn_details()
    {
        return $this->hasOne('App\Models\FollowCaseReturnWithdrawn','id','case_withdrawn_id');
    }

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','assign_id_own');
    }

    public function judgement_user_details()
    {
        return $this->hasOne('App\Models\User','id','judgement_assign_id');
    }
}
