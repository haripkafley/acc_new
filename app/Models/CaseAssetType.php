<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseAssetType extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_assettypes';
    protected $primaryKey = 'at_id';
    public $timestamps = true;

    protected $fillable = ['asset_Type'];
}
