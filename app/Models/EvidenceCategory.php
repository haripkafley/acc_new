<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenceCategory extends Model
{
    use HasFactory;
    protected $table = 'tbl_evidence_category_lookup';
    public $timestamps = true;

    protected $fillable = [
        'name', 'id'
    ];
}
