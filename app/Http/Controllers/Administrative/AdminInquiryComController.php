<?php

namespace App\Http\Controllers\Administrative;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\AdminInquiryCommittee;
use App\Models\User;
use App\Models\Department;
use Alert;
use Redirect;
class AdminInquiryComController extends Controller
{
    public function index()
    {
        $data = [];
        $data['deparment'] = Department::where('is_delete',0)->get();
        $data['data'] = AdminInquiryCommittee::where('status','A')->get();
        return view('administrative_inquiry.index',$data);
    }

    public function insert(Request $request)
    {
        $check = AdminInquiryCommittee::where('user_id',$request->user_id)->where('status','!=','D')->first();
        if (@$check!="") {
            Alert::error('Duplicate Entry');
            return Redirect::back();
        }
        $new = new AdminInquiryCommittee;
        $new->user_id = $request->user_id;
        $new->status = "A";
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('User Added Successfully');
        return Redirect::back();
    }

    public function delete($id)
    {
        AdminInquiryCommittee::where('id',$id)->update(['status'=>'D']);
        Alert::success('User Deleted Successfully');
        return Redirect::back();
    }

}
