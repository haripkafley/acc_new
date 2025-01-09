<?php

namespace App\Http\Controllers\Pursuability;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\ce_pltblpvaluecategory;
use App\Models\Complaint\ce_pltblpvsubcategory;
use Redirect;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class CategoryController extends Controller
{

        public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',24)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',24)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',24)->where('edit_option','Y')->first();

        $this->delete_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',24)->where('delete_option','Y')->first();


        
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
        $data['data'] = ce_pltblpvaluecategory::where('isDelete','0')->get();

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

        return view('pursuability.category',$data);

        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function delete($id)
    {
        $check = ce_pltblpvsubcategory::where('pValueCategoryID',$id)->where('isDelete','0')->first();
        if (@$check!="") {
            Alert::error('Category can not be deleted as it is associated with subcategory');
            return Redirect::back();
        }
        ce_pltblpvaluecategory::where('pValueCategoryID',$id)->update(['isDelete'=>'1']);
        Alert::success('You\'ve Successfully Deleted A Category');
        return Redirect::back();
    }

    public function insert(Request $request)
    {
        $new = new ce_pltblpvaluecategory;
        $new->pValueName = $request->pValueName;
        $new->pValueRemarks = $request->pValueRemarks;
        $new->save();
        Alert::success('You\'ve Successfully Added A Category');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        ce_pltblpvaluecategory::where('pValueCategoryID',$request->id)->update([
            'pValueName'=>$request->pValueName,
            'pValueRemarks'=>$request->pValueRemarks,
        ]);
        Alert::success('You\'ve Successfully Updated A Category');
        return Redirect::back();
    }
}
