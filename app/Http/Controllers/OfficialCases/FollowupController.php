<?php

namespace App\Http\Controllers\OfficialCases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CasetaskAssignOfficial;
use App\Models\FollowOagProsecutor;
use App\Models\FollowCaseReturnWithdrawn;
use App\Models\FollowCaseClosure;
use App\Models\FollowClosureDetails;
use App\Models\FollowCaseJuridiction;
use App\Models\FollowCharges;
use App\Models\FollowRestitutionPrayed;
use App\Models\FollowConfiscation;
use App\Models\FollowOtherPrayed;
use Alert;
use DB;
class FollowupController extends Controller
{
    public function index($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['oag'] = FollowOagProsecutor::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->get();
        $data['close_details'] = FollowCaseClosure::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->first();
        // return $data['oag'];
        return view('followup.index',$data);
    }

    public function insert(Request $request)
    {
        $new = new FollowOagProsecutor;
        $new->case_id = $request->case_id;
        $new->assign_official_id = $request->assign_official_id;
        $new->name = $request->name;
        $new->eid = $request->eid;
        $new->date = $request->date;
        $new->save();
        Alert::success('Prosecutor Details Added Successfully');  
        return redirect()->back();
    }

    public function delete($id)
    {
        FollowOagProsecutor::where('id',$id)->delete();
        Alert::success('Prosecutor Details Deleted Successfully');  
        return redirect()->back();
    }

    public function caseWithdrawn($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['people_accused'] = DB::table('tbl_case_entities')->where('case_no_id',$data['case_id'])->get();
        $data['lists'] = FollowCaseReturnWithdrawn::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->get();
        $data['close_details'] = FollowCaseClosure::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->first();
        return view('followup.case_status',$data);
    }

    public function caseWithdrawnInsert(Request $request)
    {
        $new = new FollowCaseReturnWithdrawn;
        if (@$request->case_or_accused=="Accused") {
            $new->accused_name = $request->accused_name;
            $new->cid = $request->cid;
            $new->accused_id = $request->accused_id;
        }
        $new->type = $request->type;
        $new->date = $request->date;
        $new->reason = $request->reason;
        $new->case_id = $request->case_id;
        $new->assign_official_id = $request->assign_official_id;
        $new->case_or_accused = $request->case_or_accused;
        if (@$request->hasFile('file')) {

            $file = $request->file;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/case_followup/',$filename);
            $new->attachment = $filename;
        }
        $new->save();
        Alert::success('Details Added Successfully');  
        return redirect()->back();

    }

    public function caseWithdrawndelete($id)
    {
        FollowCaseReturnWithdrawn::where('id',$id)->delete();
        Alert::success('Details Deleted Successfully');
        return redirect()->back();
    }

    public function caseClosure($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['data'] = FollowCaseClosure::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->first();
        $data['details'] = FollowClosureDetails::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->get();
        return view('followup.closure',$data);
    }

    public function caseClosureUpdateDecision(Request $request)
    {
        $new = new FollowCaseClosure;
        $new->judgement_date = $request->judgement_date;
        $new->judgement_no = $request->judgement_no;
        $new->court = $request->court;
        $new->case_id = $request->case_id;
        $new->assign_official_id = $request->assign_official_id;
        $new->date_of_closing = $request->date_of_closing;
        if (@$request->hasFile('file')) {

            $file = $request->file;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/case_followup/',$filename);
            $new->court_verdict = $filename;
        }
        $new->save();
        Alert::success('Details Updated Successfully');  
        return redirect()->back();
    }


    public function caseClosureDetailsInsert(Request $request)
    {

        $new = new FollowClosureDetails;
        $new->type = $request->type;
        
        if(@$request->type=="Individual"){
            $new->cid_document_no = $request->cid_document_no;
            $new->name_of_accused = $request->name_of_accused;
        }else{
            $new->license_no = $request->license_no;
            $new->name_organization = $request->name_organization;
        }

        $new->sentense = $request->sentense;
        $new->restitution = $request->restitution;
        $new->recovery_order = $request->recovery_order;
        $new->penalty_imposed = $request->penalty_imposed;
        $new->others = $request->others;
        $new->remarks = $request->remarks;
        $new->case_id = $request->case_id;
        $new->assign_official_id = $request->assign_official_id;
        $new->save();
        Alert::success('Closure Details Added Successfully');  
        return redirect()->back();
       
    }

    public function caseClosureDelete($id)
    {
        FollowClosureDetails::where('id',$id)->delete();
        Alert::success('Closure Details Deleted Successfully');  
        return redirect()->back();
    }

    public function caseJurisdiction($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['data'] = FollowCaseJuridiction::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->get();
        $data['close_details'] = FollowCaseClosure::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->first();
        return view('followup.jurisdiction',$data);   
    }

    public function caseJurisdictionInsert(Request $request)
    {
        $new = new FollowCaseJuridiction;
        $new->date_registration = $request->date_registration;
        $new->jurisdiction = $request->jurisdiction;
        $new->case_id = $request->case_id;
        $new->assign_official_id = $request->assign_official_id;
        $new->save();
        Alert::success('Data Added Successfully');  
        return redirect()->back();
    }

    public function caseJurisdictiondelete($id)
    {
        
        FollowCaseJuridiction::where('id',$id)->delete();
        Alert::success('Data Deleted Successfully');  
        return redirect()->back();
    }

    public function caseJurisdictionDetails($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['probable_charges'] = FollowCharges::where('status','!=','D')->get();
        $data['data'] = FollowCaseJuridiction::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->get();
        $data['close_details'] = FollowCaseClosure::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->first();
        return view('followup.jurisdiction_details',$data);
    }

    public function caseJurisdictionDetailsView($id)
    {
        $data = [];
        $data['details'] = FollowCaseJuridiction::where('id',$id)->first();
        $data['probable_charge'] = DB::table('follow_charges')->where('follow_jurisdiction_id',$id)->where('status','!=','D')->get();
        $data['restitution_prayed'] = FollowRestitutionPrayed::where('follow_jurisdiction_id',$id)->with('probable_charge_details')->get();
        $data['confiscation_prayed'] = FollowConfiscation::where('follow_jurisdiction_id',$id)->with('probable_charge_details')->get();
        $data['other_prayed'] = FollowOtherPrayed::where('follow_jurisdiction_id',$id)->with('probable_charge_details')->get();
        return view('followup.juri_details',$data);


    }

    public function caseJurisdictionInsertCharges(Request $request)
    {
        $new = new FollowCharges;
        $new->follow_jurisdiction_id   = $request->user_id;
        $new->probable_charge = $request->probable_charge;
        $new->save();
        Alert::success('Probable Charge Added Successfully');  
        return redirect()->back();
    }


    public function caseJurisdictiondeleteCharges($id)
    {
        FollowCharges::where('id',$id)->update(['status'=>'D']);
        Alert::success('Probable Charge Deleted Successfully');  
        return redirect()->back();
    }



    public function caseJurisdictionInsertrestitution(Request $request)
    {
        $new = new FollowRestitutionPrayed;
        $new->follow_jurisdiction_id = $request->user_id_restitution_value;
        $new->probable_charge_id = $request->probable_charge_id;
        $new->restitution_prayed = $request->restitution_prayed;
        $new->save();
        Alert::success('Restitution Prayed Added Successfully');  
        return redirect()->back();
    }

    public function caseJurisdictiondeleterestitution($id)
    {
        FollowRestitutionPrayed::where('id',$id)->delete();
        Alert::success('Restitution Prayed Deleted Successfully');  
        return redirect()->back();
    }


    public function caseJurisdictionInsertconfiscation(Request $request)
    {
        $new = new FollowConfiscation;
        $new->follow_jurisdiction_id = $request->user_id_confiscation_value;
        $new->probable_charge_id = $request->probable_charge_id;
        $new->confiscation_prayed = $request->confiscation_prayed;
        $new->save();
        Alert::success('Confiscation / Recovery Prayed Added Successfully');  
        return redirect()->back();
    }


    public function caseJurisdictiondeleteconfiscation($id)
    {
        FollowConfiscation::where('id',$id)->delete();
        Alert::success('Confiscation / Recovery Prayed Deleted Successfully');  
        return redirect()->back();
    }

    public function caseJurisdictionInsertother(Request $request)
    {
        $new = new FollowOtherPrayed;
        $new->follow_jurisdiction_id = $request->user_id_other_value;
        $new->probable_charge_id = $request->probable_charge_id;
        $new->other_prayers = $request->other_prayers;
        $new->save();
        Alert::success('Confiscation / Recovery Prayed Added Successfully');  
        return redirect()->back();
    }

    public function caseJurisdictiondeleteother($id)
    {
        FollowOtherPrayed::where('id',$id)->delete();
        Alert::success('Other Prayed Deleted Successfully');  
        return redirect()->back();
    }

    public function caseJurisdictionUnderAppeal($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['close_details'] = FollowCaseClosure::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->first();
        return view('followup.under_under_trial',$data);
    }

}
