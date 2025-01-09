<?php

namespace App\Http\Controllers\TaskManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\CasetaskAssignOfficial;
use App\Models\CaseEntity;
use App\Models\CaseProbableCharge;
use App\Models\RestitutionPrayed;
use App\Models\ConfiscationPrayed;
use App\Models\OtherPrayers;

use App\Models\FollowOagProsecutor;
use App\Models\FollowCaseReturnWithdrawn;
use App\Models\FollowCaseClosure;
use App\Models\FollowClosureDetails;
use App\Models\FollowCaseJuridiction;
use App\Models\FollowCharges;
use App\Models\FollowRestitutionPrayed;
use App\Models\FollowConfiscation;
use App\Models\FollowOtherPrayed;
use App\Models\CaseAssignStatus;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class AssignOfficial extends Controller
{
    public function index()
    {

        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',34)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }


        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->get();
        return view('case_assign_official.index',$data);
    }

    public function assignOfficial($id)
    {
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['assignOfficial'] = CasetaskAssignOfficial::where('case_id',$id)->first();
        $data['users'] = User::where('is_delete',0)->get();
        $data['id'] = $id;
        return view('case_assign_official.assign',$data);
    }

    public function insertOfficial(Request $request)
    {
        // return $request;
        $check = CasetaskAssignOfficial::where('case_id',$request->id)->first();
        if (@$check=="") {
            $new = new CasetaskAssignOfficial;
            $new->user_id = $request->user_id;
            $new->case_id = $request->id;
            $new->instruction = $request->instruction;
            $new->save();

        }else{
            CasetaskAssignOfficial::where('case_id',$request->id)->update([
                'user_id'=>$request->user_id,
                'instruction'=>$request->instruction,
            ]);
        }
        Alert::success('Official assgined successfully');
        return redirect()->back();
    }


    public function getCase()
    {

        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',38)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }


        $data = [];
        $data['data'] = CasetaskAssignOfficial::where('user_id',auth()->user()->id)->get();
        return view('case_assign_official.get_case',$data);
    }

    public function caseRegistration($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['data'] = CaseEntity::where('case_no_id',$data['details']->case_id)->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['probable_charges'] = CaseProbableCharge::where('status','!=','D')->where('case_id',$id)->get();
        // return $data['probable_charge'];
        return view('case_assign_official.case_registration',$data);
    }

    public function caseRegistrationDetails($case_id,$user_id)
    {
        $data = [];

        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$case_id)->first();
        $data['user_details'] = CaseEntity::where('id',$user_id)->first();
        $data['probable_charge'] = DB::table('case_probable_charge')->where('user_id',$user_id)->where('case_id',@$case_id)->where('status','!=','D')->get();
        $data['restitution_prayed'] = RestitutionPrayed::where('user_id',$user_id)->where('case_id',@$case_id)->with('probable_charge_details')->get();
        $data['confiscation_prayed'] = ConfiscationPrayed::where('user_id',$user_id)->where('case_id',@$case_id)->with('probable_charge_details')->get();
        $data['other_prayed'] = OtherPrayers::where('user_id',$user_id)->where('case_id',@$case_id)->with('probable_charge_details')->get();
        $data['status'] = CaseAssignStatus::where('user_id',$user_id)->where('case_id',@$case_id)->first();  
        return view('case_assign_official.register_details',$data);
    }

    public function probableCharge(Request $request)
    {
        $new = new CaseProbableCharge;
        $new->case_id = $request->case_id;
        $new->user_id = $request->user_id;
        $new->probable_charge = $request->probable_charge;
        $new->save();
        Alert::success('Probable Charge Added Successfully');  
        return redirect()->back();

    }

    public function probableChargeDelete($id)
    {
        CaseProbableCharge::where('id',$id)->update(['status'=>'D']);
        Alert::success('Probable Charge Deleted Successfully');  
        return redirect()->back();
    }


    public function restitutionPrayed(Request $request)
    {
        $new = new RestitutionPrayed;
        $new->case_id = $request->case_id;
        $new->user_id = $request->user_id_restitution_value;
        $new->probable_charge_id = $request->probable_charge_id;
        $new->restitution_prayed = $request->restitution_prayed;
        $new->save();
        Alert::success('Restitution Prayed Added Successfully');  
        return redirect()->back();
    }

    public function restitutionPrayedDelete($id)
    {
        RestitutionPrayed::where('id',$id)->delete();
        Alert::success('Restitution Prayed Deleted Successfully');  
        return redirect()->back();
    }

    public function confiscationPrayed(Request $request)
    {
        $new = new ConfiscationPrayed;
        $new->case_id = $request->case_id;
        $new->user_id = $request->user_id_confiscation_value;
        $new->probable_charge_id = $request->probable_charge_id;
        $new->confiscation_prayed = $request->confiscation_prayed;
        $new->save();
        Alert::success('Confiscation / Recovery Prayed Added Successfully');  
        return redirect()->back();
    }


    public function confiscationPrayedDelete($id)
    {
        ConfiscationPrayed::where('id',$id)->delete();
        Alert::success('Confiscation / Recovery Prayed Deleted Successfully');  
        return redirect()->back();
    }

    public function otherPrayed(Request $request)
    {
        $new = new OtherPrayers;
        $new->case_id = $request->case_id;
        $new->user_id = $request->user_id_other_value;
        $new->probable_charge_id = $request->probable_charge_id;
        $new->other_prayers = $request->other_prayers;
        $new->save();
        Alert::success('Confiscation / Recovery Prayed Added Successfully');  
        return redirect()->back();
    }

    public function otherPrayedDelete($id)
    {
        OtherPrayers::where('id',$id)->delete();
        Alert::success('Other Prayed Deleted Successfully');  
        return redirect()->back();
    }


    public function viewDetails($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['data'] = CaseEntity::where('case_no_id',$data['details']->case_id)->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['probable_charges'] = CaseProbableCharge::where('status','!=','D')->get();
        return view('case_assign_official.view_registration',$data);
    }

    public function viewDetailsFollowUp($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['oag'] = FollowOagProsecutor::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->get();
        return view('case_assign_official.view_follow',$data);
    }

    public function viewDetailsFollowUpWithdrawn($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['people_accused'] = DB::table('tbl_case_entities')->where('case_no_id',$data['case_id'])->get();
        $data['lists'] = FollowCaseReturnWithdrawn::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->get();
        return view('case_assign_official.case_status',$data);
    }

    public function viewDetailsFollowUpJuridiction($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['data'] = FollowCaseJuridiction::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->get();
        return view('case_assign_official.jurisdiction',$data); 
    }

    public function viewDetailsFollowUpJuridictionDetails($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['probable_charges'] = FollowCharges::where('status','!=','D')->get();
        $data['data'] = FollowCaseJuridiction::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->get();
        return view('case_assign_official.jurisdiction_details',$data);
    }


    public function viewDetailsFollowUpClosure($id)
    {
        $data = [];
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        $data['case_id'] = $data['details']->case_id;
        $data['data'] = FollowCaseClosure::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->first();
        $data['details'] = FollowClosureDetails::where('case_id',$data['details']->case_id)->where('assign_official_id',$id)->get();
        return view('case_assign_official.closure',$data);
    }

    public function updateStatus(Request $request)
    {
        $check = CaseAssignStatus::where('case_id',$request->case_id)->where('user_id',$request->id)->first();
        if(@$check!=""){
           CaseAssignStatus::where('case_id',$request->case_id)->where('user_id',$request->id)->update([
            'status'=>$request->status,
            'remarks'=>$request->status_remark
            ]); 
        }else{
            $new = new CaseAssignStatus;
            $new->status=$request->status;
            $new->remarks=$request->status_remark;
            $new->case_id=$request->case_id;
            $new->user_id=$request->id;
            $new->save();
        }
        
        Alert::success('Status Updated Successfully');  
        return redirect()->back();   
    }

    public function viewDetailsFollowUpUnderUnderTrial($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = CasetaskAssignOfficial::where('id',$id)->first();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['details']->case_id)->first();
        return view('case_assign_official.under_under',$data);
    }

}
