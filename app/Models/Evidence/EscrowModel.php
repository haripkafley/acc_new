<?php

namespace App\Models\Evidence;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscrowModel extends Model
{
    use HasFactory;
    protected $table = "escrow_account";
}
