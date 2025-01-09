<?php

namespace App\Http\Controllers\Igcomplaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\InformationGatheringComplaint;
use App\Models\Ti\TackticalInteligence;
use App\Models\Complaint\CecComCrud;
use App\Models\Complaint\IgComplaintCecCom;
use App\Models\User;
use Redirect;
use Session;
use Alert;
class IgComplaintController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = InformationGatheringComplaint::orderBy('id','desc')->get();
        return view('information_gathering_complaint.index',$data);
    }

    public function viewDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = InformationGatheringComplaint::where('id',$id)->first();
        $cec_users = CecComCrud::where('user_type','CEC')->where('status','A')->pluck('user_id')->toArray();
        $com_users = CecComCrud::where('user_type','COM')->where('status','A')->pluck('user_id')->toArray();
        $data['cec_user_dropdown'] = User::whereIn('id',$cec_users)->get();
        $data['com_user_dropdown'] = User::whereIn('id',$com_users)->get();
        $data['cec_members'] = IgComplaintCecCom::where('ig_complaint_id',$id)->where('type','cec')->get();
        $data['com_members'] = IgComplaintCecCom::where('ig_complaint_id',$id)->where('type','com')->get();
        $data['all_users'] = User::where('status','A')->get();
        return view('information_gathering_complaint.view_details',$data);
    }

    public function insertMembers(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        $new = new IgComplaintCecCom;
        $new->eid = $user->eid;
        $new->role = $request->role;
        $new->ig_complaint_id = $request->ig_complaint_id;
        $new->member_id = $user->id;
        $new->assign_member_id = auth()->user()->id;
        $new->remarks = $request->remarks;
        $new->type = $request->type;
        $new->save();
        Alert::success('Person added successfully');
        return redirect()->back();
    }

    public function updateMembers(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        IgComplaintCecCom::where('id',$request->member_id)->update([
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

    public function deleteMembers($id)
    {
        IgComplaintCecCom::where('id',$id)->delete();
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
        InformationGatheringComplaint::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function updatecommissionDecision(Request $request)
    {
        $details = InformationGatheringComplaint::where('id',$request->id)->first();
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
        InformationGatheringComplaint::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function cecCases()
    {
        $data = [];
        $data['data'] = IgComplaintCecCom::where('member_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->where('type','cec')->get();
        return view('information_gathering_complaint.cec_cases',$data);
    }

    public function coiPage($id,$type)
    {
        $data = [];
        $data['data'] = IgComplaintCecCom::where('id',$id)->where('member_id',auth()->user()->id)->first();
        if (@$data['data']=="") {
            Alert::error('Unauthorized Access');
            return redirect('dashboard');
        }

        $data['type'] = $type;
        $data['id'] = $id;
        return view('information_gathering_complaint.cec_com_view',$data);
    }

    public function makeDecision(Request $request)
    {
        $check = IgComplaintCecCom::where('id',$request->id)->first();
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['describe_coi'] = $request->coi_description;
        IgComplaintCecCom::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        if ($check->type=="cec") {
            return redirect()->route('cec.get.information.gathering.cases');
        }else{
            return redirect()->route('com.get.information.gathering.cases');
        }
    }

    public function viewPageCecCom($id,$type)
    {
        $data = [];
        $data['data'] = IgComplaintCecCom::where('id',$id)->where('member_id',auth()->user()->id)->first();
        if (@$data['data']=="") {
            Alert::error('Unauthorized Access');
            return redirect('dashboard');
        }

        $data['type'] = $type;
        $data['id'] = $id;
        return view('information_gathering_complaint.cec_com_view_details',$data);
    }

    public function comCases()
    {
        $data = [];
        $data['data'] = IgComplaintCecCom::where('member_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->where('type','com')->get();
        return view('information_gathering_complaint.com_cases',$data);
    }



}
