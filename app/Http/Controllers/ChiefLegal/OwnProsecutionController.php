<?php

namespace App\Http\Controllers\ChiefLegal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Legal\LegalReviewUpdate;
use App\Models\Legal\OffenceLegal;
use App\Models\Legal\LegalOffenceCount;
use App\Models\Legal\LegalSections;
use App\Models\Legal\LegalRestitution;
use App\Models\Legal\LegalRecovery;
use App\Models\User;
use App\Models\Offence;
use DB;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class OwnProsecutionController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',43)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = LegalReviewUpdate::where('decision','Own Prosecution')->get();
        return view('own_prosecution.index',$data);
    }   

    public function officialView($id)
    {
        $data = [];
        $data['users'] = User::where('is_delete',0)->get();
        $data['data'] = LegalReviewUpdate::where('id',$id)->first();
        return view('own_prosecution.assign',$data);
    }

    public function insertOfficial(Request $request)
    {
        LegalReviewUpdate::where('id',$request->id)->update([
            'assign_id_own'=>$request->user_id,
            'instruction'=>$request->instruction
        ]);
        
        if (@$request->power_of_attorney) {
             $file = $request->power_of_attorney;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal/',$filename);
            $upd['power_of_attorney'] = $filename;
            LegalReviewUpdate::where('id',$request->id)->update($upd);
        }
        Alert::success('Official assgined successfully');
        return redirect()->route('manage.own.prosecution.chief.list');
    }

    public function chabmber($id)
    {
        $data = [];
        $data['data'] = LegalReviewUpdate::where('decision','Own Prosecution')->where('id',$id)->first();
        return view('own_prosecution.chamber',$data);
    }

    public function admitted($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['off'] = Offence::get();
        $data['data'] = LegalReviewUpdate::where('decision','Own Prosecution')->where('id',$id)->first();
        $data['offences'] = OffenceLegal::where('legal_review_id',$id)->where('type','P')->get();
        $data['offence_count'] = LegalOffenceCount::where('legal_review_id',$id)->where('type','P')->get();
        $data['sections'] = LegalSections::where('legal_review_id',$id)->where('type','P')->get();
        $data['restitution'] = LegalRestitution::where('legal_review_id',$id)->where('type','P')->get();
        $data['recovery'] = LegalRecovery::where('legal_review_id',$id)->where('type','!=','other')->where('type_type','P')->get();
        $data['other'] = LegalRecovery::where('legal_review_id',$id)->where('type','other')->where('type_type','P')->get();
        return view('own_prosecution.admit',$data);
    }

    public function prosStatus($id)
    {
        $data = [];
        $data['data'] = LegalReviewUpdate::where('decision','Own Prosecution')->where('id',$id)->first();
        return view('own_prosecution.status_chief',$data);
    }

    public function getCase()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',48)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = LegalReviewUpdate::where('decision','Own Prosecution')->where('assign_id_own',auth()->user()->id)->get();
        return view('own_prosecution.index_dashboard',$data);
    }

    public function statusUpdateView($id)
    {
        $data = [];
        $data['data'] = LegalReviewUpdate::where('decision','Own Prosecution')->where('assign_id_own',auth()->user()->id)->where('id',$id)->first();
        if(@$data['data']->assign_id_own!=auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }else{
            return view('own_prosecution.status_update',$data);
        }
    }

    public function statusUpdate(Request $request)
    {
        LegalReviewUpdate::where('id',$request->id_status)->update([
            'own_status'=>$request->own_status,
            'status_date'=>$request->status_date,
            'status_remark'=>$request->status_remark,
            'court_name'=>$request->court_name,
        ]);

        $upd = [];
        if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_prosecution/',$filename);
            $upd['status_attachment'] = $filename;
            LegalReviewUpdate::where('id',$request->id_status)->update($upd);
        }
        
        Alert::success('Status updated successfully');
        return redirect()->back();
    }


    public function admittedDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['off'] = Offence::get();
        $data['data'] = LegalReviewUpdate::where('decision','Own Prosecution')->where('assign_id_own',auth()->user()->id)->where('id',$id)->first();
        $data['offences'] = OffenceLegal::where('legal_review_id',$id)->where('type','P')->get();
        $data['offence_count'] = LegalOffenceCount::where('legal_review_id',$id)->where('type','P')->get();
        $data['sections'] = LegalSections::where('legal_review_id',$id)->where('type','P')->get();
        $data['restitution'] = LegalRestitution::where('legal_review_id',$id)->where('type','P')->get();
        $data['recovery'] = LegalRecovery::where('legal_review_id',$id)->where('type','!=','other')->where('type_type','P')->get();
        $data['other'] = LegalRecovery::where('legal_review_id',$id)->where('type','other')->where('type_type','P')->get();
        if(@$data['data']->assign_id_own!=auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }

        if(@$data['data']->own_status!="Admitted")
        {
            return redirect()->route('own.prosecution.get.assign.official.case.status.update-view-page',@$id);
        }
        return view('own_prosecution.more_details',$data); 
    }


    public function offenceInsert(Request $request)
    {
        $new = new OffenceLegal;
        $new->legal_review_id = $request->legal_review_id;
        $new->offence = $request->offence;
        $new->remarks = $request->remarks;
        $new->type = $request->type;
        $new->save();
        Alert::success('Offence added successfully');
        return redirect()->back();
    }

    public function offenceupdate(Request $request)
    {
        OffenceLegal::where('id',$request->id_offence)->update([
            'offence'=>$request->offence,
            'remarks'=>$request->remarks,
        ]);
        Alert::success('Offence updated successfully');
        return redirect()->back();
    }

    public function offencedelete($id)
    {
        OffenceLegal::where('id',$id)->delete();
        Alert::success('Offence deleted successfully');
        return redirect()->back();
    }


    public function offenceCountInsert(Request $request)
    {
        $new = new LegalOffenceCount;
        $new->legal_review_id = $request->legal_review_id;
        $new->offence = $request->offence_name_count;
        $new->remarks = $request->offence_remark;
        $new->counts = $request->offence_count;
        $new->type = $request->type;
        $new->save();
        Alert::success('Offence Count added successfully');
        return redirect()->back();
    }

    public function offenceCountupdate(Request $request)
    {
        LegalOffenceCount::where('id',$request->id_offence_edit_id)->update([
            'offence'=>$request->offence,
            'remarks'=>$request->remarks,
            'counts'=>$request->offence_count,
        ]);
        Alert::success('Offence Count updated successfully');
        return redirect()->back();
    }

    public function offenceCountdelete($id)
    {
        LegalOffenceCount::where('id',$id)->delete();
        Alert::success('Offence Count deleted successfully');
        return redirect()->back();
    }

    public function sectionInsert(Request $request)
    {
        $new = new LegalSections;
        $new->legal_review_id = $request->legal_review_id;
        $new->offence = $request->offence;
        $new->remarks = $request->remarks;
        $new->section = $request->section;
        $new->type = $request->type;
        $new->save();
        Alert::success('Section added successfully');
        return redirect()->back();
    }

    public function sectionupdate(Request $request)
    {
         LegalSections::where('id',$request->id_section)->update([
            'offence'=>$request->offence,
            'remarks'=>$request->remarks,
            'section'=>$request->section,
        ]);
        Alert::success('Section updated successfully');
        return redirect()->back();
    }

    public function sectiondelete($id)
    {
        LegalSections::where('id',$id)->delete();
        Alert::success('Section deleted successfully');
        return redirect()->back();
    }

    public function restitutionInsert(Request $request)
    {
        $new = new LegalRestitution;
        $new->legal_review_id = $request->legal_review_id;
        $new->offence = $request->offence;
        $new->remarks = $request->remarks;
        $new->restitution_prayed = $request->restitution_prayed;
        $new->type = $request->type;
        $new->save();
        Alert::success('Restitution prayed added successfully');
        return redirect()->back();
    }

    public function restitutionupdate(Request $request)
    {
        LegalRestitution::where('id',$request->id_resti)->update([
            'offence'=>$request->offence,
            'remarks'=>$request->remarks,
            'restitution_prayed'=>$request->restitution_prayed,
        ]);
        Alert::success('Restitution prayed updated successfully');
        return redirect()->back();
    }

    public function restitutiondelete($id)
    {
        LegalRestitution::where('id',$id)->delete();
        Alert::success('Restitution prayed deleted successfully');
        return redirect()->back();
    }

    public function recoveryInsert(Request $request)
    {
        $new = new LegalRecovery;
        $new->legal_review_id = $request->legal_review_id;
        $new->offence = $request->offence;
        $new->remarks = $request->remarks;
        $new->prayer = $request->prayer;
        $new->type = $request->type;
        $new->type_type = $request->type_type;
        $new->save();
        Alert::success('Prayed added successfully');
        return redirect()->back();
    }


    public function recoveryupdate(Request $request)
    {
        LegalRecovery::where('id',$request->id_recovery)->update([
            'offence'=>$request->offence,
            'remarks'=>$request->remarks,
            'prayer'=>$request->prayer,
            'type'=>$request->type,
        ]);
        Alert::success(' Prayed updated successfully');
        return redirect()->back();
    }

    public function recoverydelete($id)
    {
        LegalRecovery::where('id',$id)->delete();
        Alert::success('Prayed deleted successfully');
        return redirect()->back();
    }


    public function prosecutionView($id)
    {
        $data = [];
        $data['data'] = LegalReviewUpdate::where('decision','Own Prosecution')->where('assign_id_own',auth()->user()->id)->where('id',$id)->first();
        if(@$data['data']->assign_id_own!=auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }
        return view('own_prosecution.status_page',$data);
    }

    public function prosecutionStatusUpdate(Request $request)
    {
        $upd = [];
        $upd['judge_court'] = $request->judge_court;
        $upd['judge_decision'] = $request->judge_decision;
        if(@$request->judge_decision=="Yes")
        {
            $upd['judge_date'] = $request->judge_date;
            $upd['judge_no'] = $request->judge_no;
            $upd['judge_agency'] = $request->judge_agency;
            $upd['judge_remarks'] = $request->judge_remarks;
            
            if (@$request->hasFile('judge_attachment')) {
            $file = $request->judge_attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/legal_prosecution/',$filename);
            $upd['judge_attachment'] = $filename;
            }
        }
        LegalReviewUpdate::where('id',$request->id)->update($upd);

        Alert::success('Prosecution status updted successfully');
        return redirect()->back();

    }



}
