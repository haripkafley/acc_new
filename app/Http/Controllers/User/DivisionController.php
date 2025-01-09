<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Department;
use Redirect;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class DivisionController extends Controller
{

    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',32)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',32)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',32)->where('edit_option','Y')->first();

        $this->delete_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',32)->where('delete_option','Y')->first();


        
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
        $data['data'] = Division::where('is_delete','0')->get();
        $data['department'] = Department::where('is_delete',0)->get();

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

        return view('user.division',$data);

        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function insert(Request $request)
    {
        $new = new Division;
        $new->department_id = $request->department_id;
        $new->name = $request->name;
        $new->save();
        Alert::success('Division Successfully Added');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        Division::where('id',$request->id)->update([
            'name'=>$request->name,
            'department_id'=>$request->department_id,
        ]);
        Alert::success('Division Successfully Updated');
        return Redirect::back();
    }

    public function delete($id)
    {
        Division::where('id',$id)->update(['is_delete'=>'1']);
        Alert::success('Division Successfully Deleted');
        return Redirect::back();
    }

    public function getDivision(Request $request)
    {
        $data = Division::where('department_id',$request->id)->where('is_delete',0)->get();
        $response=array();
        $result="<option value=''>Select</option>";
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
                
                $result.="<option value='".$rows->id."' >".$rows->name."</option>";
            }
        }
        $response['division']=$result;
        return response()->json($response);
    }
}
