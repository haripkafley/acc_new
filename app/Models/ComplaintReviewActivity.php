<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintReviewActivity extends Model
{
    use HasFactory;
    protected $table = 'complaint_review_activity';

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
