<?php

namespace App\Http\Controllers\Systemic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemicFollowReview;
use App\Models\SystemAgencyFurther;
use App\Models\SystemicFollowClose;
use Alert;
use DB;
class FollowController extends Controller
{
    public function followView($id)
    {
        $data = [];
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['data'] = SystemicFollowReview::where('case_id',$id)->orderBy('id','desc')->get();
        $data['case_id'] = $id;
        return view('systemic.review',$data);
    }

    public function registerReview(Request $request)
    {
        $new = new SystemicFollowReview;
        $new->case_id = $request->case_id;
        $new->due_date = $request->due_date;
        $new->date_of_follow = $request->date_of_follow;
        $new->remarks = $request->remarks;
        if (@$request->hasFile('attachment')) {

            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/case_followup/',$filename);
            $new->attachment = $filename;
        }
        $new->save();
        Alert::success('Review Inserted Successfully');  
        return redirect()->back();
    }

    public function deleteReview($id)
    {
        SystemicFollowReview::where('id',$id)->delete();
        Alert::success('Review Deleted Successfully');  
        return redirect()->back();
    }

    public function actionView($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['data'] = SystemAgencyFurther::where('type','AG')->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('systemic.action_agency',$data);
    }

    public function actionViewInsert(Request $request)
    {
        $new  = new SystemAgencyFurther;
        $new->case_id = $request->case_id;
        $new->date_receipt = $request->date_receipt;
        $new->systemic_chage = $request->systemic_chage;
        $new->action_taken = $request->action_taken;
        $new->action_date = $request->action_date;
        $new->created_by = auth()->user()->id;
        if (@$request->hasFile('attachment')) {

            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/case_followup/',$filename);
            $new->attachment = $filename;
        }

        $new->save();
        Alert::success('Data Inserted Successfully');  
        return redirect()->back();

    }

    public function actionViewupdate(Request $request)
    {
        $upd = [];
        $upd['case_id'] = $request->case_id;
        $upd['date_receipt'] = $request->date_receipt;
        $upd['systemic_chage'] = $request->systemic_chage;
        $upd['action_taken'] = $request->action_taken;
        $upd['action_date'] = $request->action_date;
        $upd['created_by'] = auth()->user()->id;
        if (@$request->hasFile('attachment')) {

            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/case_followup/',$filename);
            $upd['attachment'] = $filename;
        }

        SystemAgencyFurther::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }

    public function actionViewdelete($id)
    {
        SystemAgencyFurther::where('id',$id)->delete();
        Alert::success('Data Deleted Successfully');  
        return redirect()->back();
    }

    public function actionViewupdatestatus(Request $request)
    {
        SystemAgencyFurther::where('id',$request->id)->update([
            'status'=>$request->status,
            'status_remark'=>$request->status_remark,
        ]);
        Alert::success('Status Updated Successfully');  
        return redirect()->back();
    }


    public function futherView($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['data'] = SystemAgencyFurther::where('type','FA')->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('systemic.further',$data);   
    }

    public function insertFurther(Request $request)
    {
        $new  = new SystemAgencyFurther;
        $new->case_id = $request->case_id;
        $new->date_receipt = $request->date_receipt;
        $new->systemic_chage = $request->systemic_chage;
        $new->action_taken = $request->action_taken;
        $new->action_date = $request->action_date;
        $new->created_by = auth()->user()->id;
        $new->type = 'FA';
        if (@$request->hasFile('attachment')) {

            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/case_followup/',$filename);
            $new->attachment = $filename;
        }

        $new->save();
        Alert::success('Data Inserted Successfully');  
        return redirect()->back();
    }

    public function closeModel($id)
    {
        $data = [];
        $data['data'] = SystemicFollowClose::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('systemic.close_action',$data);
    }

    public function actionTakenInsertclose(Request $request)
    {
        $new = new SystemicFollowClose;
        $new->case_id = $request->case_id;
        $new->date_receipt = $request->date_receipt;
        $new->action_taken_against = $request->action_taken_against;
        if(@$request->action_taken_against=="Individual"){
            $new->cid_document = $request->cid_document;
            $new->name = $request->name;
        }else{
            $new->license_no = $request->license_no;
            $new->agency_name = $request->agency_name;
        }

        $new->action_type = $request->action_type;
        $new->sanction = $request->sanction;
        $new->action_taken = $request->action_taken;
        $new->fines = $request->fines;
        $new->action_taken_date = $request->action_taken_date;
        $new->created_by = auth()->user()->id;
        if (@$request->hasFile('attachment')) {

            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/case_followup/',$filename);
            $new->attachment = $filename;
        }

        $new->save();
        Alert::success('Data Inserted Successfully');  
        return redirect()->back();
    }

    public function actionTakenupdateclose(Request $request)
    {
        $upd = [];
        $upd['date_receipt'] = $request->date_receipt;
        $upd['action_taken_against'] = $request->action_taken_against;

        if(@$request->action_taken_against=="Individual"){
            $upd['cid_document'] = $request->cid_document;
            $upd['name'] = $request->name;
        }else{
            $upd['license_no'] = $request->license_no;
            $upd['agency_name'] = $request->agency_name;
        }    

        $upd['action_type'] = $request->action_type;
        $upd['sanction'] = $request->sanction;
        $upd['action_taken'] = $request->action_taken;
        $upd['fines'] = $request->fines;
        $upd['action_taken_date'] = $request->action_taken_date;

        if (@$request->hasFile('attachment')) {

            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/case_followup/',$filename);
            $upd['attachment'] = $filename;
        }

        SystemicFollowClose::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }

    public function actionTakendeleteclose($id)
    {
        SystemicFollowClose::where('id',$id)->delete();
        Alert::success('Data Deleted Successfully');  
        return redirect()->back();
    }

    public function actionTakenupdatecloseStatus(Request $request)
    {
        SystemicFollowClose::where('id',$request->id)->update([
            'status'=>$request->status,
            'status_remark'=>$request->status_remark,
        ]);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }

    public function actionTakenupdatecloseappraise(Request $request)
    {
        SystemicFollowClose::where('id',$request->id)->update([
            'recomendation_cfd'=>$request->recomendation_cfd,
            'comission_decision'=>$request->comission_decision,
            'comission_remark'=>$request->comission_remark,
        ]);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }

    public function updateAppriase(Request $request)
    {
        SystemAgencyFurther::where('id',$request->id)->update([
            'recomendation_cfd'=>$request->recomendation_cfd,
            'comission_decision'=>$request->comission_decision,
            'comission_remark'=>$request->comission_remark,
        ]);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }


}
