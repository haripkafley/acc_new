<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummonDocument extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_summon_documents';
    public $timestamps = true;
    protected $fillable = [
        'summon_id',
        'document_name',
        'quantity',
        'remarks',
    ];
}
