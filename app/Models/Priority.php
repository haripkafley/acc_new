<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;
    protected $table = 'tbl_priorities_lookup';
    public $timestamps = true;

    protected $fillable = [
        'priority_type',
        'active_status',
    ];
}
