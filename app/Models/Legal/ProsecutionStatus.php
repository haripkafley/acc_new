<?php

namespace App\Models\Legal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsecutionStatus extends Model
{
    use HasFactory;
    protected $table = "legal_prosecution_status";

    public function with_drawn_details()
    {
        return $this->hasOne('App\Models\FollowCaseReturnWithdrawn','id','case_withdrawn_id');
    }

    public function review_details()
    {
        return $this->hasOne('App\Models\Legal\LegalReviewUpdate','pros_status_id','id');
    }
}
