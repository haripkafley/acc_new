<?php

namespace App\Http\Controllers\RoleManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoleCims;
use App\Models\Module;
use App\Models\Components;
use Redirect;
use Alert;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\RolePermission;
use App\Models\UserToRole;

class RoleController extends Controller
{

    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',8)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',8)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',8)->where('edit_option','Y')->first();


        
        return $next($request);
    });
  }



    public function index()
    {
        $permission = $this->view_option;
        $addpermission = $this->add_option;
        $editpermission = $this->edit_option;

        if (@$permission && @$permission->view_option=="Y") {
        $data = [];
        $data['data'] = RoleCims::where('isDelete','0')->get();

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


        return view('role.role',$data);

        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function insert(Request $request)
    {
        $new = new RoleCims;
        $new->role_name = $request->role_name;
        $new->role_description = $request->role_description;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('You\'ve Successfully Added A Role');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        RoleCims::where('id',$request->id)->update([
            'role_name'=>$request->role_name,
            'role_description'=>$request->role_description,
            
        ]);
        Alert::success('You\'ve Successfully Updated A Role');
        return Redirect::back();
    }

    public function delete($id)
    {
        $check = UserToRole::where('role_id',$id)->where('is_delete','0')->first();
        if (@$check!="") {
           Alert::error('Role Can Not Be Deleted.As It Is Associated With User');
           return Redirect::back();
        }
        RoleCims::where('id',$id)->update(['isDelete'=>'1']);
        Alert::success('You\'ve Successfully Deleted A Role');
        return Redirect::back();
    }

    public function role_permission(Request $request,$id)
    {
        $data = [];
        
        $data['components'] = Components::get();
        $data['id'] = $id;
        if (@$request->component && @$request->module) {
            $menu_ids = Menu::where('module_id',@$request->module)->pluck('id')->toArray();
            $data['data'] = SubMenu::whereIn('menu_id',$menu_ids)->get();
            $data['component'] = @$request->component;
            $data['module'] = @$request->module;
            $data['module_data'] = Module::where('component_id',@$request->component)->get();
        }
        $data['selected'] = RolePermission::where('is_delete','0')->where('role_id',$id)->pluck('sub_menu_id')->toArray();
        return view('role.role_permission',$data);
    }

    public function role_permission_insert(Request $request)
    {
        $check = RolePermission::where('role_id',$request->role_id)->where('sub_menu_id',$request->sub_menu_id)->where('is_delete',0)->first();
        if (@$check!="") {
             Alert::error('Duplicate entry.This menu access already added');
             return Redirect::back();
        }
        $new = new RolePermission;
        $new->role_id = $request->role_id;
        $new->menu_id = $request->menu_id;
        $new->sub_menu_id = $request->sub_menu_id;
        $new->view_option = $request->view_option;
        $new->edit_option = $request->edit_option;
        $new->add_option = $request->add_option;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('You\'ve Successfully Added A Permission');
        return Redirect::back();
    }

    public function getSubmenu(Request $request)
    {

        $data = Module::where('component_id',$request->id)->get();
       
        $response=array();
        $result="<option value=''>Select</option>";
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
                
                $result.="<option value='".$rows->id."' >".$rows->module_name."</option>";
            }
        }
        $response['submenu']=$result;
        return response()->json($response);
    }

    public function permission_delete($id)
    {
        RolePermission::where('id',$id)->update(['is_delete'=>'1']);
        Alert::success('You\'ve Successfully Deleted A Permission');
        return Redirect::back();
    }

    public function role_permission_edit($id)
    {
        $data = [];
        $data['data'] = RolePermission::where('id',$id)->first();
        $data['menu'] = Menu::get();
        $data['submenu'] = SubMenu::where('menu_id',$data['data']->menu_id)->get();
        return view('role.edit_permission',$data);
    }

    public function role_permission_update(Request $request)
    {
        $check = RolePermission::where('role_id',$request->role_id)->where('sub_menu_id',$request->sub_menu_id)->where('is_delete',0)->where('id','!=',$request->id)->first();
        if (@$check!="") {
             Alert::error('Duplicate entry.This menu access already added');
             return Redirect::back();
        }

        RolePermission::where('id',$request->id)->update([
            'menu_id'=>$request->menu_id,
            'sub_menu_id'=>$request->sub_menu_id,
            'view_option'=>$request->view_option,
            'add_option'=>$request->add_option,
            'edit_option'=>$request->edit_option,
        ]);

        Alert::success('You\'ve Successfully Updated A Permission');
        return Redirect::route('manage.permission',$request->role_id);

    }

    public function role_permission_update_permission(Request $request)
    {
        if (@$request->addmore) {
            
            foreach(@$request->addmore as $value){

                if(@$value['view_option'] || @$value['edit_option'] || @$value['add_option'])
                {
                 
                 if (@$value['view_option']) {
                     $view_option = 'Y';
                 }else{
                     $view_option = 'N';
                 }

                 if (@$value['add_option']) {
                     $add_option = 'Y';
                 }else{
                     $add_option = 'N';
                 }

                 if (@$value['edit_option']) {
                     $edit_option = 'Y';
                 }else{
                     $edit_option = 'N';
                 }

                 if (@$value['delete_option']) {
                     $delete_option = 'Y';
                 }else{
                     $delete_option = 'N';
                 }


                 $serach = RolePermission::where('role_id',@$value['role_id'])->where('sub_menu_id',@$value['sub_menu_id'])->first();

                 
                 if (@$serach==""  ) {
                     $new = new RolePermission;
                    $new->role_id = @$value['role_id'];
                    $new->menu_id = @$value['menu_id'];
                    $new->sub_menu_id = @$value['sub_menu_id'];
                    $new->view_option = $view_option;
                    $new->edit_option = $edit_option;
                    $new->add_option = $add_option;
                    $new->delete_option = $delete_option;
                    $new->created_by = auth()->user()->id;
                    $new->save();
                 }else{

                    RolePermission::where('id',$serach->id)->update([
                    'menu_id'=>@$value['menu_id'],
                    'sub_menu_id'=>@$value['sub_menu_id'],
                    'view_option'=>$view_option,
                    'add_option'=>$add_option,
                    'edit_option'=>$edit_option,
                    'delete_option'=>$delete_option,
                    'is_delete'=>0,
                   ]);

                 }


                }else{

                $serach = RolePermission::where('role_id',@$value['role_id'])->where('sub_menu_id',@$value['sub_menu_id'])->first();
                if (@$serach!="") {
                    RolePermission::where('id',$serach->id)->update(['is_delete'=>1]);
                }   


                }
           

           }
        }

        Alert::success('You\'ve Successfully Updated A Permission');
        return Redirect::back();




    }


}
