<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtLookup extends Model
{
    use HasFactory;
    protected $table = 'tbl_courts_lookup';
    protected $primaryKey = 'court_id';
    public $timestamps = true;

    protected $fillable = [
        'court_type',
    ];
}
