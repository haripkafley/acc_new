<?php

namespace App\Http\Controllers\ComplaintMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\personCategoryModel;
use Redirect;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class PersonCategory extends Controller
{
    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',20)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',20)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',20)->where('edit_option','Y')->first();

        $this->delete_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',20)->where('delete_option','Y')->first();


        
        return $next($request);
    });
  }


    public function list()
    {
        $permission = $this->view_option;
        $addpermission = $this->add_option;
        $editpermission = $this->edit_option;
        $deletepermission = $this->delete_option;
        if (@$permission && @$permission->view_option=="Y") {
       $data = [];
       $data['data'] = personCategoryModel::where('isDelete',0)->get();
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
       return view('person_category.list',$data);
       }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function add(Request $request)
    {
        $new = new personCategoryModel;
        $new->categoryName  = $request->categoryName;
        $new->save();
        Alert::success('You\'ve Successfully Added A Person Category');
        return Redirect::back();
    }

    public function delete($id)
    {
        personCategoryModel::where('personCategoryID',$id)->update(['isDelete'=>1]);
        Alert::success('You\'ve Successfully Deleted A Person Category');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        personCategoryModel::where('personCategoryID',$request->id)->update([
            'categoryName'=>$request->categoryName,
        ]);
        Alert::success('You\'ve Successfully Updated A Person Category');
        return Redirect::back();
    }
}
