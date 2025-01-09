<?php

namespace App\Http\Controllers\ChiefLegal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Alert;
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
use App\Models\Legal\FormalCharge;
use App\Models\Legal\ProsecutionAssign;
use App\Models\Legal\ProsecutionStatus;
use App\Models\Legal\LegalReviewUpdate;
use App\Models\UserToRole;
use App\Models\RolePermission;
class ProsecutionController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',42)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }


        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->get();
        return view('legal_prosecution.index',$data);
    }

    public function viewDetails($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['id'] = $id;
        $data['data'] = CaseEntity::where('case_no_id',$id)->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('legal_prosecution.details',$data);
    }

    public function dropView($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['case_id'] = $id;
        $data['people_accused'] = DB::table('tbl_case_entities')->where('case_no_id',$data['case_id'])->get();
        $data['lists'] = FollowCaseReturnWithdrawn::where('case_id',$id)->get();
        return view('legal_prosecution.case_status',$data);
    }

    public function reviewOag($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['case_id'] = $id;
        $data['lists'] = ProsecutionStatus::where('case_id',$id)->where('type','W')->get();
        return view('legal_prosecution.review',$data);
    }

    public function assignOfficial($id)
    {
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['assignOfficial'] = ProsecutionAssign::where('case_id',$id)->first();
        return view('legal_prosecution.assign',$data);
    }


    public function updateAssign(Request $request)
    {
        $check = ProsecutionAssign::where('case_id',$request->id)->first();
        if (@$check=="") {
            $new = new ProsecutionAssign;
            $new->user_id = $request->user_id;
            $new->case_id = $request->id;
            $new->instruction = $request->instruction;
            $new->save();

        }else{
            ProsecutionAssign::where('case_id',$request->id)->update([
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
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',47)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }


        $data = [];
        $data['data'] = ProsecutionAssign::where('user_id',auth()->user()->id)->get();
        return view('legal_prosecution.get_index',$data);
    }


    public function getCaseDetails($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['id'] = $id;
        $data['data'] = CaseEntity::where('case_no_id',$id)->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('legal_prosecution.details_dashboard',$data);
    }

    public function formalCharge(Request $request)
    {
        // return $request;
        $new = new FormalCharge;
        $new->case_id = $request->case_id;
        $new->user_id = $request->user_id;
        $new->formal_charge = $request->formal_charge;
        $new->save();
        Alert::success('Formal Charge Added Successfully');  
        return redirect()->back();
    }

    public function updateStatus(Request $request)
    {
        // return $request;
        $check = ProsecutionStatus::where('case_id',$request->case_id)->where('user_id',$request->user_id_status)->first();
        if(@$check=="")
        {
            $new = new ProsecutionStatus;
            $new->case_id = $request->case_id;
            $new->user_id = $request->user_id_status;
            $new->agency_name = $request->agency_name;
            $new->status = $request->status;
            $new->date = $request->date;
            $new->remarks = $request->remarks;
            $new->type = 'R';
            
            if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_prosecution/',$filename);
            $new->attachment = $filename;
            }
            $new->save();


        }else{

            $upd = [];
            $upd['agency_name'] = $request->agency_name;
            $upd['status'] = $request->status;
            $upd['date'] = $request->date;
            $upd['remarks'] = $request->remarks;
            
            if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_prosecution/',$filename);
            $upd['attachment'] = $filename;
            }

            ProsecutionStatus::where('case_id',$request->case_id)->where('user_id',$request->user_id_status)->update($upd);

        }

        Alert::success('Status updated successfully');
        return redirect()->back();
    }


    public function caseWithdrawnDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['case_id'] = $id;
        $data['people_accused'] = DB::table('tbl_case_entities')->where('case_no_id',$data['case_id'])->get();
        $data['lists'] = FollowCaseReturnWithdrawn::where('case_id',$id)->get();
        return view('legal_prosecution.case_status_dashboard',$data);
    }

    public function caseWithdrawnUpdate(Request $request)
    {
        $check = ProsecutionStatus::where('case_withdrawn_id',$request->case_withdrawn_id)->first();
        if (@$check=="") {
            $new = new ProsecutionStatus;
            $new->case_id = $request->case_id;
            $new->status = $request->status;
            $new->date = $request->date;
            $new->reason = $request->reason;
            $new->case_withdrawn_id  = $request->case_withdrawn_id;
            $new->type = 'W';
            if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_prosecution/',$filename);
            $new->attachment = $filename;
            }
            $new->save();
        }else{


            $upd = [];
            $upd['reason'] = $request->reason;
            $upd['status'] = $request->status;
            $upd['date'] = $request->date;
            
            
            if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_prosecution/',$filename);
            $upd['attachment'] = $filename;
            }

            ProsecutionStatus::where('case_withdrawn_id',$request->case_withdrawn_id)->update($upd);


        }

        Alert::success('Details updated successfully');
        return redirect()->back();
    }


    public function reviewDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['case_id'] = $id;
        $data['lists'] = ProsecutionStatus::where('case_id',$id)->where('type','W')->get();
        return view('legal_prosecution.review_dashboard',$data);
    }


    public function reviewDecision(Request $request)
    {
        $check = LegalReviewUpdate::where('case_withdrawn_id',$request->case_withdrawn_id)->where('pros_status_id',$request->pros_status_id)->where('case_id',$request->case_id)->first();
        if(@$check=="")
        {

            $new = new LegalReviewUpdate;
            $new->case_withdrawn_id = $request->case_withdrawn_id;
            $new->pros_status_id = $request->pros_status_id;
            $new->case_id = $request->case_id;
            $new->investigation_finding = $request->investigation_finding;
            $new->analysis  = $request->analysis;
            $new->recomendation  = $request->recomendation;
            $new->decision = $request->decision;
            $new->created_by = auth()->user()->id;
            if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_prosecution/',$filename);
            $new->attachment = $filename;
            }
            $new->save();


        }else{

            $upd = [];
            $upd['investigation_finding'] = $request->investigation_finding;
            $upd['analysis'] = $request->analysis;
            $upd['recomendation'] = $request->recomendation;
            $upd['decision'] = $request->decision;
            
            
            if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_prosecution/',$filename);
            $upd['attachment'] = $filename;
            }

            LegalReviewUpdate::where('case_withdrawn_id',$request->case_withdrawn_id)->where('pros_status_id',$request->pros_status_id)->where('case_id',$request->case_id)->update($upd);


        }

        Alert::success('Details updated successfully');
        return redirect()->back();
    }

}
