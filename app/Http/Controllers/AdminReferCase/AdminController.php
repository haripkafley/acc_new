<?php

namespace App\Http\Controllers\AdminReferCase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseEntity;
use App\Models\AdminReferCaseSanction;
use App\Models\AdminReferCaseFines;
use App\Models\AdminReferCaseReferLetter;
use App\Models\AdminReferCaseAgencyRefer;
use App\Models\AdminReferCaseStatus;
use App\Models\AdminReferFollowReview;
use App\Models\AdminReferFollowAgencyAction;
use App\Models\AdminReferFollowOwnAction;
use App\Models\AdminReferFollowFurtherAction;
use App\Models\AdminReferFollowClose;
use Alert;
use DB;
use App\Models\UserToRole;
use App\Models\User;
use App\Models\RolePermission;
class AdminController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',39)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->get();
        return view('admin_refer_case.index',$data);
    }

    public function caseDetials($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['data'] = CaseEntity::where('case_no_id',$id)->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_case.registration',$data);
    }

    public function registerDetails($case_id,$user_id)
    {
        $data = [];
        $data['case_id'] = $case_id;
        $data['user_details'] = User::where('id',$user_id)->first();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$case_id)->first();
        $data['probable_charge'] = DB::table('admin_refer_case_sanction')->where('user_id',$user_id)->where('case_id',@$case_id)->get();
        $data['fines'] = AdminReferCaseFines::where('user_id',$user_id)->where('case_id',@$case_id)->get();
        $data['confiscation_prayed'] = AdminReferCaseAgencyRefer::where('user_id',$user_id)->where('case_id',@$case_id)->get();
        $data['other_prayed'] = AdminReferCaseReferLetter::where('user_id',$user_id)->where('case_id',@$case_id)->get();
        $data['status'] = AdminReferCaseStatus::where('user_id',$user_id)->where('case_id',@$case_id)->first();
        return view('admin_refer_case.register_details',$data);
    }

    public function adminSanctionInsert(Request $request)
    {
        $new = new AdminReferCaseSanction;
        $new->case_id = $request->case_id;
        $new->user_id = $request->user_id;
        $new->sanction = $request->sanction;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('Administrative Sanction Added Successfully');  
        return redirect()->back();
    }

    public function adminSanctiondelete($id)
    {
        AdminReferCaseSanction::where('id',$id)->delete();
        Alert::success('Administrative Sanction Deleted Successfully');  
        return redirect()->back();
    }


    public function adminFinesInsert(Request $request)
    {
        $new = new AdminReferCaseFines;
        $new->case_id = $request->case_id;
        $new->user_id = $request->user_id_restitution_value;
        $new->fines = $request->fines;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('Fines and Penalties Added Successfully');  
        return redirect()->back();
    }

    public function adminFinesdelete($id)
    {
        AdminReferCaseFines::where('id',$id)->delete();
        Alert::success('Fines and Penalties Deleted Successfully');  
        return redirect()->back();
    }

    public function adminReferenceInsert(Request $request)
    {
        $new = new AdminReferCaseReferLetter;
        $new->case_id = $request->case_id;
        $new->user_id = $request->user_id_other_value;
        $new->description = $request->description;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('Reference Letter Added Successfully');  
        return redirect()->back();
    }


    public function adminReferencedelete($id)
    {
        AdminReferCaseReferLetter::where('id',$id)->delete();
        Alert::success('Reference Letter Deleted Successfully');  
        return redirect()->back();
    }

    public function adminAgencyRefer(Request $request)
    {
        $new = new AdminReferCaseAgencyRefer;
        $new->case_id = $request->case_id;
        $new->user_id = $request->user_id_confiscation_value;
        $new->organization = $request->organization;
        $new->department = $request->department;
        $new->division = $request->division;
        $new->remarks = $request->remarks;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('Agency Refer Added Successfully');  
        return redirect()->back();
    }


    public function adminAgencyReferDelete($id)
    {
        AdminReferCaseAgencyRefer::where('id',$id)->delete();
        Alert::success('Agency Refer Deleted Successfully');  
        return redirect()->back();

    }

    public function updateStatus(Request $request)
    {
        $status = AdminReferCaseStatus::where('user_id',$request->user_id_status_value)->where('case_id',@$request->case_id)->first();
        if (@$status=="") {
            $new = new AdminReferCaseStatus;
            $new->case_id = $request->case_id;
            $new->user_id = $request->user_id_status_value;
            $new->created_by = auth()->user()->id;
            $new->status = $request->status;
            $new->remarks = $request->remarks;
            $new->save();
        }else{
            AdminReferCaseStatus::where('user_id',$request->user_id_status_value)->where('case_id',@$request->case_id)->update([
                'status'=>$request->status,
                'remarks'=>$request->remarks
            ]);
        }
        Alert::success('Status Updated Successfully');  
        return redirect()->back();
    }


    public function followUp($id)
    {
        $data = [];
        $data['data'] = AdminReferFollowReview::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_follow.index',$data);
    }

    public function insertReview(Request $request)
    {
        $new = new AdminReferFollowReview;
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

    public function followUpDelete($id)
    {
        AdminReferFollowReview::where('id',$id)->delete();
        Alert::success('Review Deleted Successfully');  
        return redirect()->back();
    }


    public function actionTakenIndex($id)
    {
        $data = [];
        $data['data'] = AdminReferFollowAgencyAction::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_follow.action_agency',$data);
    }

    public function actionTakenInsert(Request $request)
    {
        $new = new AdminReferFollowAgencyAction;
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


    public function actionTakenupdate(Request $request)
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

        AdminReferFollowAgencyAction::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }


    public function actionTakenupdatestatus(Request $request)
    {
        AdminReferFollowAgencyAction::where('id',$request->id)->update([
            'status'=>$request->status,
            'status_remark'=>$request->status_remark,
        ]);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }

    public function actionTakenupdateappraise(Request $request)
    {
        // return $request;
        AdminReferFollowAgencyAction::where('id',$request->id)->update([
            'recomendation_cfd'=>$request->recomendation_cfd,
            'comission_decision'=>$request->comission_decision,
            'comission_remark'=>$request->comission_remark,
        ]);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }

    public function actionTakendelete($id)
    {
        AdminReferFollowAgencyAction::where('id',$id)->delete();
        Alert::success('Data Deleted Successfully');  
        return redirect()->back();
    }

    public function ownIndex($id)
    {
        $data = [];
        $data['data'] = AdminReferFollowOwnAction::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_follow.own_action',$data);
    }



    public function actionTakenInsertOwn(Request $request)
    {
        $new = new AdminReferFollowOwnAction;
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


    public function actionTakenupdateOwn(Request $request)
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

        AdminReferFollowOwnAction::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }


    public function actionTakenupdateOwnStatus(Request $request)
    {
        AdminReferFollowOwnAction::where('id',$request->id)->update([
            'status'=>$request->status,
            'status_remark'=>$request->status_remark,
        ]);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }

    public function actionTakenupdateOwnappraise(Request $request)
    {
        AdminReferFollowOwnAction::where('id',$request->id)->update([
            'recomendation_cfd'=>$request->recomendation_cfd,
            'comission_decision'=>$request->comission_decision,
            'comission_remark'=>$request->comission_remark,
        ]);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }

    public function actionTakendeleteOwn($id)
    {
        AdminReferFollowOwnAction::where('id',$id)->delete();
        Alert::success('Data Deleted Successfully');  
        return redirect()->back();
    }

    // futher-action
    public function furtherIndex($id)
    {
        $data = [];
        $data['data'] = AdminReferFollowFurtherAction::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_follow.futher_action',$data);
    }

    public function actionTakenInsertFurther(Request $request)
    {
        $new = new AdminReferFollowFurtherAction;
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

    public function actionTakenupdateFurther(Request $request)
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

        AdminReferFollowFurtherAction::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }


    public function actionTakendeleteFurther($id)
    {
        AdminReferFollowFurtherAction::where('id',$id)->delete();
        Alert::success('Data Deleted Successfully');  
        return redirect()->back();
    }

    public function actionTakenupdateFurtherStatus(Request $request)
    {
        AdminReferFollowFurtherAction::where('id',$request->id)->update([
            'status'=>$request->status,
            'status_remark'=>$request->status_remark,
        ]);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }


    public function actionTakenupdateFurtherappraise(Request $request)
    {
        AdminReferFollowFurtherAction::where('id',$request->id)->update([
            'recomendation_cfd'=>$request->recomendation_cfd,
            'comission_decision'=>$request->comission_decision,
            'comission_remark'=>$request->comission_remark,
        ]);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }


    public function closeIndex($id)
    {
        $data = [];
        $data['data'] = AdminReferFollowClose::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_follow.close_action',$data);
    }

    public function actionTakenInsertclose(Request $request)
    {
        $new = new AdminReferFollowClose;
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

        AdminReferFollowClose::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }

    public function actionTakendeleteclose($id)
    {
        AdminReferFollowClose::where('id',$id)->delete();
        Alert::success('Data Deleted Successfully');  
        return redirect()->back();
    }

    public function actionTakenupdatecloseStatus(Request $request)
    {
        AdminReferFollowClose::where('id',$request->id)->update([
            'status'=>$request->status,
            'status_remark'=>$request->status_remark,
        ]);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }

    public function actionTakenupdatecloseappraise(Request $request)
    {
        AdminReferFollowClose::where('id',$request->id)->update([
            'recomendation_cfd'=>$request->recomendation_cfd,
            'comission_decision'=>$request->comission_decision,
            'comission_remark'=>$request->comission_remark,
        ]);
        Alert::success('Data Updated Successfully');  
        return redirect()->back();
    }
}
