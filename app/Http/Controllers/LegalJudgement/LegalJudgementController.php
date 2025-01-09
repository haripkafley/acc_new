<?php

namespace App\Http\Controllers\LegalJudgement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Legal\LegalReviewUpdate;
use App\Models\Legal\LegalConvicted;
use App\Models\Legal\LegalAppraisal;
use App\Models\Offence;

use App\Models\Legal\OffenceLegal;
use App\Models\Legal\LegalOffenceCount;
use App\Models\Legal\LegalSections;
use App\Models\Legal\LegalRestitution;
use App\Models\Legal\LegalRecovery;
use App\Models\UserToRole;
use App\Models\RolePermission;

use App\Models\User;
use DB;
use Alert;
class LegalJudgementController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',44)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = LegalReviewUpdate::where('judge_decision','Yes')->get();
        return view('legal_judgement.index',$data);
    }

    public function assign($id)
    {
        $data = [];
        $data['users'] = User::where('is_delete',0)->get();
        $data['data'] = LegalReviewUpdate::where('judge_decision','Yes')->where('id',$id)->first();
        return view('legal_judgement.assign',$data);
    }

    public function insertOfficial(Request $request)
    {
        LegalReviewUpdate::where('id',$request->id)->update([
            'judgement_assign_id'=>$request->user_id,
            'judgement_assign_instruction'=>$request->judgement_assign_instruction
        ]);
        Alert::success('Official assgined successfully');
        return redirect()->route('judgement.chief.list');
    }

    public function chiefJudgementDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = LegalReviewUpdate::where('id',$id)->first();
        $data['decision_data'] = LegalAppraisal::where('legal_review_id',$id)->first();
        return view('legal_judgement.details',$data);
    }

    public function chiefJudgementReviewDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = LegalReviewUpdate::where('id',$id)->first();
        $data['decision_data'] = LegalAppraisal::where('legal_review_id',$id)->first();
        return view('legal_judgement.review_chief',$data);
    }

    public function chiefJudgementconvictedDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = LegalReviewUpdate::where('id',$id)->first();
        $data['covicted'] = LegalConvicted::where('legal_review_id',$id)->get();
        $data['decision_data'] = LegalAppraisal::where('legal_review_id',$id)->first();
        return view('legal_judgement.convicted_chief',$data);
    }

    public function chiefJudgementappraisalDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = LegalReviewUpdate::where('id',$id)->first();
        $data['decision_data'] = LegalAppraisal::where('legal_review_id',$id)->first();
        return view('legal_judgement.appraisal',$data);

    }

    public function chiefJudgementappealDetails($id)
    {
        $data = [];
        $data['decision_data'] = LegalAppraisal::where('legal_review_id',$id)->first();
        $data['id'] = $id;
        $data['off'] = Offence::get();
        $data['data'] = LegalReviewUpdate::where('decision','Own Prosecution')->where('id',$id)->first();
        $data['offences'] = OffenceLegal::where('legal_review_id',$id)->where('type','A')->get();
        $data['offence_count'] = LegalOffenceCount::where('legal_review_id',$id)->where('type','A')->get();
        $data['sections'] = LegalSections::where('legal_review_id',$id)->where('type','A')->get();
        $data['restitution'] = LegalRestitution::where('legal_review_id',$id)->where('type','A')->get();
        $data['recovery'] = LegalRecovery::where('legal_review_id',$id)->where('type','!=','other')->where('type_type','A')->get();
        $data['other'] = LegalRecovery::where('legal_review_id',$id)->where('type','other')->where('type_type','A')->get();
        return view('legal_judgement.appeal_chief',$data);
    }

    public function getCase()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',49)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = LegalReviewUpdate::where('judge_decision','Yes')->where('judgement_assign_id',auth()->user()->id)->get();
        return view('legal_judgement.index_dashboard',$data);
    }

    public function judgementDetails($id)
    {
        $data = [];
        $data['data'] = LegalReviewUpdate::where('id',$id)->first();
        if(@$data['data']->judgement_assign_id==auth()->user()->id)
        {
            return view('legal_judgement.details_dashboard',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function reviewPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = LegalReviewUpdate::where('id',$id)->first();
        $data['decision_data'] = LegalReviewUpdate::where('id',$id)->first();
        if(@$data['data']->judgement_assign_id==auth()->user()->id)
        {
            return view('legal_judgement.review',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }


    public function reviewUpdateJudgement(Request $request)
    {
        $upd = [];
        $upd['review_judgement'] = $request->review_judgement;
        if ($request->review_judgement!="Convicted") {
            $upd['review_reason_def_acq'] = $request->review_reason_def_acq;
        }
        LegalReviewUpdate::where('id',$request->id)->update($upd);
        Alert::success('Review judgement updated successfully');
        return redirect()->back();
    }

    public function convictedPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['decision_data'] = LegalReviewUpdate::where('id',$id)->first();
        $data['data'] = LegalConvicted::where('legal_review_id',$id)->get();
        return view('legal_judgement.convicted',$data);
    }


    public function insertConvicted(Request $request)
    {
        $new = new LegalConvicted;
        $new->legal_review_id = $request->legal_review_id;
        $new->sentense = $request->sentense;
        $new->restitution = $request->restitution;
        $new->recovery = $request->recovery;
        $new->fines = $request->fines;
        $new->other = $request->other;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();

    }


    public function updateConvicted(Request $request)
    {
        LegalConvicted::where('id',$request->id_convicted)->update([
            'sentense'=>$request->sentense,
            'restitution'=>$request->restitution,
            'recovery'=>$request->recovery,
            'fines'=>$request->fines,
            'other'=>$request->other,
        ]);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function deleteConvicted($id)
    {
        LegalConvicted::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function appraisalPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = LegalReviewUpdate::where('id',$id)->first();
        if(@$data['data']->judgement_assign_id==auth()->user()->id)
        {
            $data['decision_data'] = LegalAppraisal::where('legal_review_id',$id)->first();
            return view('legal_judgement.appraisal_dashboard',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }


    public function appraisalInsert(Request $request)
    {
        $check = LegalAppraisal::where('legal_review_id',$request->id)->first();
        if(@$check=="")
        {
            $new = new LegalAppraisal;
            $new->legal_review_id = $request->id;
            $new->recommendation = $request->recommendation;
            $new->decision = $request->decision;
            if(@$request->decision=="Appeal"){
                $new->court = $request->court;
                $new->registration_date = $request->registration_date;
                $new->registration_no = $request->registration_no;
                if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/legal_appraise/',$filename);
                    $new->attachment = $filename;
                }
            }
            $new->save();



        }else{

            $upd = [];
            $upd['recommendation'] = $request->recommendation;
            $upd['decision'] = $request->decision;
            if(@$request->decision=="Appeal"){
                $upd['court'] = $request->court;
                $upd['registration_date'] = $request->registration_date;
                $upd['registration_no'] = $request->registration_no;
                if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/legal_appraise/',$filename);
                    $upd['attachment'] = $filename;
                }
            }
            LegalAppraisal::where('legal_review_id',$request->id)->update($upd);


        }

        Alert::success('Decision updated successfully');
        return redirect()->back();
    }


    public function appealPage($id)
    {

        $data = [];
        $data['decision_data'] = LegalAppraisal::where('legal_review_id',$id)->first();
        $data['id'] = $id;
        $data['off'] = Offence::get();
        $data['data'] = LegalReviewUpdate::where('decision','Own Prosecution')->where('id',$id)->first();
        $data['offences'] = OffenceLegal::where('legal_review_id',$id)->where('type','A')->get();
        $data['offence_count'] = LegalOffenceCount::where('legal_review_id',$id)->where('type','A')->get();
        $data['sections'] = LegalSections::where('legal_review_id',$id)->where('type','A')->get();
        $data['restitution'] = LegalRestitution::where('legal_review_id',$id)->where('type','A')->get();
        $data['recovery'] = LegalRecovery::where('legal_review_id',$id)->where('type','!=','other')->where('type_type','A')->get();
        $data['other'] = LegalRecovery::where('legal_review_id',$id)->where('type','other')->where('type_type','A')->get();
        return view('legal_judgement.appeal_page',$data);
    }

}
