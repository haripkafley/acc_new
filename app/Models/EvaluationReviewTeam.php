<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationReviewTeam extends Model
{
    use HasFactory;
    protected $table = 'compalint_evaluation_review_team';

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function eve_offence_details()
    {
        return $this->hasOne('App\Models\Complaint\CompalintEveOffence','id','eve_offence_id');
    }
}
