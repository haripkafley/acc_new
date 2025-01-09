<?php

namespace App\Http\Controllers\Complaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\CompalintEveOffence;
use App\Models\User;
use App\Models\Complaint\complaintRegistrationModel;
use App\Models\Complaint\LegalOpinionOfficial;
use App\Models\Complaint\LegalOpinionModel;
use App\Models\Complaint\LegalOpinioActivity;
use App\Models\Complaint\LegalOpinionCecCom;
use App\Models\AdditionalInformationEvaluation;
use App\Models\Complaint\CecComCrud;
use Redirect;
use Session;
use Alert;
class LegalOpinionController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = LegalOpinionModel::get();
        return view('legal_opinion.index',$data);
    }

    public function view($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = LegalOpinionModel::where('id',$id)->first();
        $data['activities'] = LegalOpinioActivity::where('legal_id',$id)->get();
        $cec_users = CecComCrud::where('user_type','CEC')->where('status','A')->pluck('user_id')->toArray();
        $com_users = CecComCrud::where('user_type','COM')->where('status','A')->pluck('user_id')->toArray();
        $data['cec_user_dropdown'] = User::whereIn('id',$cec_users)->get();
        $data['com_user_dropdown'] = User::whereIn('id',$com_users)->get();
        $data['cec_members'] = LegalOpinionCecCom::where('legal_id',$id)->where('type','cec')->get();
        $data['com_members'] = LegalOpinionCecCom::where('legal_id',$id)->where('type','com')->get();
        $data['all_users'] = User::where('status','A')->get();
        return view('legal_opinion.view',$data);
    }

    public function insertCecMember(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        $new = new LegalOpinionCecCom;
        $new->eid = $user->eid;
        $new->role = $request->role;
        $new->legal_id = $request->legal_id;
        $new->member_id = $user->id;
        $new->assign_member_id = auth()->user()->id;
        $new->remarks = $request->remarks;
        $new->type = $request->type;
        $new->save();
        Alert::success('Person added successfully');
        return redirect()->back();
    }

    public function updateCecMember(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        LegalOpinionCecCom::where('id',$request->member_id)->update([
            'eid'=>$user->eid,
            'role'=>$request->role,
            'member_id'=>$user->id,
            'assign_member_id'=>auth()->user()->id,
            'remarks'=>$request->remarks_edit,
            'coi_status'=>'AA',
         ]);
        Alert::success('Person updated successfully');
        return redirect()->back();
    }

    public function deleteCecMember($id)
    {
        LegalOpinionCecCom::where('id',$id)->delete();
        Alert::success('Person deleted successfully');
        return redirect()->back();
    }

    public function updateCecDecision(Request $request)
    {
        $upd = [];
        $upd['cec_date'] = $request->cec_date;
        $upd['cec_time'] = $request->cec_time;
        $upd['cec_venue'] = $request->cec_venue;
        $upd['cec_decision'] = $request->cec_decision;
        $upd['cec_remarks'] = $request->cec_remarks;
        LegalOpinionModel::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function updatecommissionDecision(Request $request)
    {
        $details = LegalOpinionModel::where('id',$request->id)->first();
        $upd = [];
        $upd['com_date'] = $request->com_date;
        $upd['com_time'] = $request->com_time;
        $upd['com_venue'] = $request->com_venue;
        $upd['com_status'] = $request->com_status;
        $upd['com_remarks'] = $request->com_remarks;
        if (@$request->com_status=="ECD") {
            $upd['com_decision'] = $details->cec_decision;
        }else{
            $upd['com_decision'] = $request->com_decision;
        }
        LegalOpinionModel::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function assignOfficialPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = LegalOpinionModel::where('id',$id)->first();
        $data['members'] = LegalOpinionOfficial::where('legal_id',$id)->get();
        $data['users'] = User::get();
        return view('legal_opinion.assign',$data);
    }

    public function insertOfficial(Request $request)
    {
        $new = new LegalOpinionOfficial;
        $new->user_id = $request->user_id;
        $new->role = $request->role;
        $new->legal_id = $request->legal_id;
        $new->save();
        Alert::success('You\'ve Successfully Added A Member');
        return Redirect::back();
    }

    public function deleteOfficial($id)
    {
        LegalOpinionOfficial::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Member');
        return Redirect::back();
    }

    public function updateStatusReport(Request $request)
    {
        $upd = [];
        $upd['chief_report_status'] = $request->chief_report_status;
        $upd['chief_report_remakrs'] = $request->chief_report_remakrs;
        LegalOpinionModel::where('id',$request->legal_id)->update($upd);
        Alert::success('Decision updated successfully');
        return Redirect::back();
    }

    public function getOfficialList()
    {
        $data = [];
        $data['data'] = LegalOpinionOfficial::whereIn('coi_status',['AA','N'])->where('user_id',auth()->user()->id)->get();
        return view('legal_opinion.official_list',$data);
    }

    public function coiPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = LegalOpinionOfficial::where('id',$id)->first();
        return view('legal_opinion.official_list_coi',$data);
    }

    public function coiPageUpdate(Request $request)
    {
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['coi_description'] = $request->coi_description;
        LegalOpinionOfficial::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->route('legal.opinion.get.official.list');
    }

    public function getOfficialView($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = LegalOpinionOfficial::where('id',$id)->first();
        $data['activities'] = LegalOpinioActivity::where('legal_id',$data['data']->legal_id)->where('user_id',auth()->user()->id)->get();
        $data['legal_id'] = $data['data']->legal_id;
        $data['legal'] = LegalOpinionModel::where('id',$data['legal_id'])->first();
        return view('legal_opinion.view_official',$data);
    }

    public function getOfficialInsertActivity(Request $request)
    {
        $new = new LegalOpinioActivity;
        $new->legal_id = $request->legal_id;
        $new->activity_date = $request->activity_date;
        $new->activity_name = $request->activity_name;
        $new->activity_description = $request->activity_description;
        $new->user_id = auth()->user()->id;
        $new->save();
        Alert::success('Activity added successfully');
        return Redirect::back();
    }

    public function getOfficialupdateActivity(Request $request)
    {
        LegalOpinioActivity::where('id',$request->id)->update([
            'activity_date'=>$request->activity_date,
            'activity_name'=>$request->activity_name,
            'activity_description'=>$request->activity_description,
         ]);
        Alert::success('Activity updated successfully');
        return Redirect::back();
    }

    public function getOfficialdeleteActivity($id)
    {
        LegalOpinioActivity::where('id',$id)->delete();
        Alert::success('Activity deleted successfully');
        return Redirect::back();
    }

    public function updateLegalReport(Request $request)
    {
        $upd = [];
        $upd['legal_report_remarks'] = $request->legal_report_remarks;
        if (@$request->legal_report_attachment) {
            $file = @$request->legal_report_attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/information_enrichment/',$filename);
            $upd['legal_report_attachment'] = $filename;
        }
        LegalOpinionModel::where('id',$request->legal_id)->update($upd);
        Alert::success('Report submitted successfully');
        return redirect()->back();
    }


    public function cecCases()
    {
        $data = [];
        $data['data'] = LegalOpinionCecCom::where('member_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->where('type','cec')->get();
        return view('legal_opinion.cec_cases',$data);
    }

    public function coiStatusCec($id,$type)
    {
        $data = [];
        $data['data'] = LegalOpinionCecCom::where('id',$id)->where('member_id',auth()->user()->id)->first();
        if (@$data['data']=="") {
            Alert::error('Unauthorized Access');
            return redirect('dashboard');
        }

        $data['type'] = $type;
        $data['id'] = $id;
        return view('legal_opinion.cec_com_view',$data);
    }

    public function coiStatusCecMakeDecision(Request $request)
    {
        $check = LegalOpinionCecCom::where('id',$request->id)->first();
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['describe_coi'] = $request->coi_description;
        LegalOpinionCecCom::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        if ($check->type=="cec") {
            return redirect()->route('legal.opinion.cec.assign.cases');
        }else{
            return redirect()->route('com.get.information.gathering.cases');
        }
    }

    public function viewCecDetails($id,$type)
    {
        $data = [];
        $data['data'] = LegalOpinionCecCom::where('id',$id)->where('member_id',auth()->user()->id)->first();
        if (@$data['data']=="") {
            Alert::error('Unauthorized Access');
            return redirect('dashboard');
        }

        $data['type'] = $type;
        $data['id'] = $id;
        return view('legal_opinion.cec_com_view_details',$data);
    }


    public function comCases()
    {
        $data = [];
        $data['data'] = LegalOpinionCecCom::where('member_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->where('type','com')->get();
        return view('legal_opinion.com_cases',$data);
    }

}
