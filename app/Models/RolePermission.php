<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    protected $table = 'tbl_mst_role_permission';

    public function menu_name()
    {
        return $this->hasOne('App\Models\Menu','id','menu_id');
    }

    public function submenu_name()
    {
        return $this->hasOne('App\Models\SubMenu','id','sub_menu_id');
    }
}
