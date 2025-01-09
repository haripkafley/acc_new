<?php

namespace App\Http\Controllers\Systemic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemRegistration;
use App\Models\SystemRecommendation;
use Alert;
use DB;
use App\Models\UserToRole;
use App\Models\RolePermission;
class SystemicController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',40)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->get();
        return view('systemic.index',$data);
    }

    public function registrationView($id)
    {
        $data = [];
        $data['data'] = SystemRegistration::where('case_id',$id)->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('systemic.registration',$data);
    }

    public function addView($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('systemic.add',$data);
    }

    public function insertData(Request $request)
    {
        // return $request;
        $new = new SystemRegistration;
        $new->agency_type = $request->agency_type;
        $new->agency_name = $request->agency_name;
        $new->letter_date = $request->letter_date;
        $new->case_id = $request->id;
        if (@$request->hasFile('letter')) {

            $file = $request->letter;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/case_followup/',$filename);
            $new->letter = $filename;
        }

        $new->save();
        Alert::success('Data added successfully.Now you can add recommendation');
        return redirect()->route('systemic.recommendations.registration.edit.view',$new->id);
    }

    public function editView($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = SystemRegistration::where('id',$id)->first();
        $data['recommendations'] = SystemRecommendation::where('register_id',$id)->get();
        return view('systemic.edit',$data);
    }

    public function updateData(Request $request)
    {
        $upd = [];
        $upd['agency_type'] = $request->agency_type;
        $upd['agency_name'] = $request->agency_name;
        $upd['letter_date'] = $request->letter_date;  
        if (@$request->hasFile('letter')) {

            $file = $request->letter;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/case_followup/',$filename);
            $upd['letter'] = $filename;
        }  
        SystemRegistration::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }

    public function insertrecommendation(Request $request)
    {
        $new = new SystemRecommendation;
        $new->recommendation = $request->recommendation;
        $new->register_id = $request->register_id;
        $new->save();
        Alert::success('Recommendation Added Successfully');  
        return redirect()->back();
    }

    public function updaterecommendation(Request $request)
    {
        SystemRecommendation::where('id',$request->id)->update(['recommendation'=>$request->recommendation]);
        Alert::success('Recommendation Updated Successfully');  
        return redirect()->back();
    }

    public function deleterecommendation($id)
    {
        SystemRecommendation::where('id',$id)->delete();
        Alert::success('Recommendation Deleted Successfully');  
        return redirect()->back();
    }

    public function updateStatus(Request $request)
    {
        SystemRegistration::where('id',$request->id)->update([
            'status'=>$request->status,
            'status_remark'=>$request->status_remark,
        ]);
        Alert::success('Status Updated Successfully');  
        return redirect()->back();
    }

    public function deleteView($id)
    {
        SystemRegistration::where('id',$id)->delete();
        SystemRecommendation::where('register_id',$id)->delete();
        Alert::success('Data Deleted Successfully');  
        return redirect()->back();
    }



}
