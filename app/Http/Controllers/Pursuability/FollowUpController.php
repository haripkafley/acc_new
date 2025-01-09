<?php

namespace App\Http\Controllers\Pursuability;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\fu_pltblfollowup_status_list;
use Redirect;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class FollowUpController extends Controller
{


    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',29)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',29)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',29)->where('edit_option','Y')->first();

        $this->delete_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',29)->where('delete_option','Y')->first();


        
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
       $data['data'] = fu_pltblfollowup_status_list::where('isDelete',0)->get();
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
       return view('follow_status.list',$data);

       }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function add(Request $request)
    {
        $new = new fu_pltblfollowup_status_list;
        $new->followupstatusname  = $request->followupstatusname;
        $new->save();
        Alert::success('You\'ve Successfully Added A Follow Status');
        return Redirect::back();
    }

    public function delete($id)
    {
        fu_pltblfollowup_status_list::where('followupstatusID',$id)->update(['isDelete'=>1]);
        Alert::success('You\'ve Successfully Deleted A Follow Status');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        fu_pltblfollowup_status_list::where('followupstatusID',$request->id)->update([
            'followupstatusname'=>$request->followupstatusname,
        ]);
        Alert::success('You\'ve Successfully Updated A Follow Status');
        return Redirect::back();
    }
}
