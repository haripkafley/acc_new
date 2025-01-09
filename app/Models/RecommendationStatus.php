<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendationStatus extends Model
{
    use HasFactory;
    protected $table = 'tbl_recommendationstatuses_lookup';
    public $timestamps = true;

    protected $primaryKey = 'recommendationstatus_id';

    protected $fillable = [
        'recommendationstatus_type',
    ];
}
