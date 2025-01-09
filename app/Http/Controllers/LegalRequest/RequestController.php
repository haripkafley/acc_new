<?php

namespace App\Http\Controllers\LegalRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Legal\LegalRequest;
use App\Models\Legal\LegalRequestActivity;
use App\Models\User;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class RequestController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',45)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = LegalRequest::get();
        return view('legal_request.index',$data);
    }

    public function addRequest()
    {
        return view('legal_request.add');
    }

    public function insertRequest(Request $request)
    {
        $new = new LegalRequest;
        $new->created_by = auth()->user()->id;
        $new->service_request = $request->service_request;
        $new->description = $request->description;
        $new->date = $request->date;
        $new->from_duration = $request->from_duration;
        $new->to_duration = $request->to_duration;
        $new->purpose = $request->purpose;
        if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_request/',$filename);
            $new->attachment = $filename;
        }

        $new->save();
        Alert::success('Request inserted successfully');
        return redirect()->route('legal.service.request.page');

    }


    public function editRequest($id)
    {
        $data = [];
        $data['data'] = LegalRequest::where('id',$id)->first();
        $data['activities'] = LegalRequestActivity::where('legal_request_id',$id)->first();
        return view('legal_request.edit',$data);
    }

    public function updateRequest(Request $request)
    {
        $upd = [];
        $upd['service_request'] = $request->service_request;
        $upd['description'] = $request->description;
        $upd['date'] = $request->date;
        $upd['from_duration'] = $request->from_duration;
        $upd['to_duration'] = $request->to_duration;
        $upd['purpose'] = $request->purpose;
        if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_request/',$filename);
            $upd['attachment'] = $filename;
        }

        LegalRequest::where('id',$request->id)->update($upd);
        Alert::success('Request updated successfully');
        return redirect()->route('legal.service.request.page');

    }

    public function deleteRequest($id)
    {
        LegalRequest::where('id',$id)->delete();
        Alert::success('Request deleted successfully');
        return redirect()->back();
    }

    public function assignUser($id)
    {
        $data = [];
        $data['data'] = LegalRequest::where('id',$id)->first();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['activities'] = LegalRequestActivity::where('legal_request_id',$id)->first();
        return view('legal_request.assign',$data);
    }

    public function insertUser(Request $request)
    {
        LegalRequest::where('id',$request->id)->update([
            'assign_official_id'=>$request->user_id,
            'instruction'=>$request->instruction
        ]);
        Alert::success('User assigned successfully');
        return redirect()->route('legal.service.request.page');
    }


    public function getCase()
    {

        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',50)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }


        $data = [];
        $data['data'] = LegalRequest::where('assign_official_id',auth()->user()->id)->get();
        return view('legal_request.index_dashboard',$data);
    }

    public function review($id)
    {
        $data = [];
        $data['data'] = LegalRequest::where('id',$id)->first();
        if(@$data['data']->assign_official_id==auth()->user()->id)
        {
            $data['id'] = $id;
            $data['activities'] = LegalRequestActivity::where('legal_request_id',$id)->get();
            return view('legal_request.review',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function activityInsert(Request $request)
    {
        $new = new LegalRequestActivity;
        $new->legal_request_id = $request->legal_request_id;
        $new->activity_date = $request->activity_date;
        $new->description = $request->description;
        $new->status = $request->status;
        if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_request/',$filename);
            $new->attachment = $filename;
        }
        $new->save();
        Alert::success('Activity inserted successfully');
        return redirect()->back();
    }

    public function activityupdate(Request $request)
    {
        LegalRequestActivity::where('id',$request->id)->update([
            'activity_date'=>$request->activity_date,
            'description'=>$request->description,
            'status'=>$request->status,
        ]);
        $upd = [];

        if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_request/',$filename);
            $upd['attachment'] = $filename;
            LegalRequestActivity::where('id',$request->id)->update($upd);
        }

        Alert::success('Activity updated successfully');
        return redirect()->back();

    }


    public function activitydelete($id)
    {
        LegalRequestActivity::where('id',$id)->delete();
        Alert::success('Activity deleted successfully');
        return redirect()->back();
    }
}
