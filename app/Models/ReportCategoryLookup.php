<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCategoryLookup extends Model
{
    use HasFactory;
    protected $table = 'tbl_report_category_lookup';
    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $fillable = [
        'report_name',
        'created_at',
        'updated_at',
    ];
}
