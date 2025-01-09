<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserToRole;
use App\Models\RoleCims;
use App\Models\Department;
use App\Models\Division;
use App\Models\Complaint\RegionalOffice;
use Alert;
use App\Models\RolePermission;
class UserController extends Controller
{

    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',1)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',1)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',1)->where('edit_option','Y')->first();
        
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
        $data['data'] = User::where('is_delete',0)->get();

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


        return view('user.index',$data);

        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function add()
    {
        $addpermission = $this->add_option;
        if (@$addpermission && @$addpermission->add_option=="Y") {
        $data = [];
        $data['department'] = Department::where('is_delete',0)->get();
        $data['regional'] = RegionalOffice::where('is_delete',0)->get();
        return view('user.add',$data);
        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function insert(Request $request)
    {
        $check = User::where('email',$request->email)->first();
        if (@$check!="") {
            Alert::error('Email already added.Please try another one.');
            return redirect()->back();
        }
        $new = new User;
        $new->name  = $request->name;
        $new->cid  = $request->cid;
        $new->eid  = $request->eid;
        $new->email  = $request->email;
        $new->password  = \Hash::make($request->password);
        $new->mobile  = $request->mobile;
        $new->department  = $request->department;
        $new->office  = $request->Nationlityradio;
        $new->unit  = $request->unit;
        if(@$request->Nationlityradio=="H")
        {
            $new->position  = $request->position;
            $new->regional_id  = '';
        }else{
            $new->position  = '';
            $new->regional_id  = $request->regional_id;
        }
        
        $new->save();
        Alert::success('You\'ve Successfully Added A User ');
        return redirect()->route('manage.user');
    }

    public function edit($id)
    {
        $editpermission = $this->edit_option;
        if (@$editpermission && @$editpermission->edit_option=="Y") {
        $data = [];
        $data['data'] = User::where('id',$id)->first();
        $data['department'] = Department::where('is_delete',0)->get();
        $data['regional'] = RegionalOffice::where('is_delete',0)->get();
        if ($data['data']->office=="H") {
           $data['division'] =  Division::where('department_id',$data['data']->department)->get();
        }
        return view('user.edit',$data);
        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        $check = User::where('email',$request->email)->where('id','!=',$request->id)->first();
        if (@$check!="") {
            Alert::error('Email already added.Please try another one.');
            return redirect()->back();
        }

        if(@$request->Nationlityradio=="H")
        {
            $position  = $request->position;
            $regional_id  = '';
        }else{
            $position  = '';
            $regional_id  = $request->regional_id;
        }


        User::where('id',$request->id)->update([
            'name'=>$request->name,
            'cid'=>$request->cid,
            'eid'=>$request->eid,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'department'=>$request->department,
            'office'=>$request->Nationlityradio,
            'position'=>$position,
            'regional_id'=>$regional_id,
            'unit'=>$request->unit,
        ]);
        Alert::success('You\'ve Successfully Updated A User ');
        return redirect()->route('manage.user');
    }

    public function delete($id)
    {
        User::where('id',$id)->update(['is_delete'=>1]);
        Alert::success('You\'ve Successfully Deleted A User ');
        return redirect()->route('manage.user');
    }

    public function assign($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = UserToRole::where('user_id',$id)->get();
        $data['role'] = RoleCims::get();
        return view('user.assign',$data);
    }

    public function insertRole(Request $request)
    {
        $check = UserToRole::where('user_id',$request->id)->where('role_id',$request->role_id)->first();
        if (@$check!="") {
            Alert::error('This role already added to that user.');
            return redirect()->back();
        }
        $new = new UserToRole;
        $new->user_id = $request->id;
        $new->role_id = $request->role_id;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('You\'ve Successfully Updated A Role To User ');
        return redirect()->back();
    }

    public function assignDelete($id)
    {
        UserToRole::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Role To User ');
        return redirect()->back();
    }
}
