<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Redirect;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class DepartmentController extends Controller
{

    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',30)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',30)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',30)->where('edit_option','Y')->first();

        $this->delete_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',30)->where('delete_option','Y')->first();


        
        return $next($request);
    });
  }


    public function index()
    {
        $permission = $this->view_option;
        $addpermission = $this->add_option;
        $editpermission = $this->edit_option;
        $deletepermission = $this->delete_option;
        if (@$permission && @$permission->view_option=="Y") {
        $data = [];
        $data['data'] = Department::where('is_delete','0')->get();

            if(@$addpermission->add_option=="Y")
            {
                $data['add'] = 'Y';
            }else{
                $data['add'] = 'N';
            }

            if(@$editpermission->edit_option=="Y")
            {
                $data['edit'] = 'Y';
            }else{
                $data['edit'] = 'N';
            }

            if(@$deletepermission->delete_option=="Y")
            {
                $data['delete'] = 'Y';
            }else{
                $data['delete'] = 'N';
            }


        return view('user.department',$data);

        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function insert(Request $request)
    {
        $new = new Department;
        $new->name = $request->name;
        $new->save();
        Alert::success('You\'ve Successfully Added A Department');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        Department::where('id',$request->id)->update([
            'name'=>$request->name,
            
        ]);
        Alert::success('You\'ve Successfully Updated A Department');
        return Redirect::back();
    }

    public function delete($id)
    {
        Department::where('id',$id)->update(['is_delete'=>'1']);
        Alert::success('You\'ve Successfully Deleted A Department');
        return Redirect::back();
    }
}
