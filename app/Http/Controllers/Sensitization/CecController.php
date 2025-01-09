<?php

namespace App\Http\Controllers\Sensitization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EvaluationMeetingPerson;
use App\Models\Complaint\complaintRegistrationModel;
use App\Models\User;
use Alert;
use DB;
use App\Models\AdditionalInformationEvaluation;
use App\Models\CecTempNumber;
use App\Models\TempMemeber;
use App\Models\Complaint\complaintReceivedByModel;
use App\Models\Complaint\link_Repeated_Complaint;
use App\Models\Complaint\Attachment;
use App\Models\FinanceImplicationDetails;
use App\Models\Complaint\NaturalResource;
use App\Models\Complaint\PolicyComplaint;
use App\Models\Complaint\Political;
use App\Models\Complaint\Personnel;
use App\Models\Complaint\ProcurementGoodService;
use App\Models\Complaint\ProcurementGoods;
use App\Models\Complaint\LandDetails;
use App\Models\Complaint\Scoring;
use App\Models\Complaint\agencyModel;
use App\Models\SensitizationActionList;
use App\Models\ActionAgency;
use App\Models\SensitizationReminderAgency;
use App\Models\SensitizationReminder;
use Redirect;
use App\Models\SensitizationAtrDetails;
use App\Models\SensitizationAtrPerson;
use App\Models\ActionList;
use App\Models\Country;
use App\Models\ActionTakenStatus;
use App\Models\SensitizationMeetingPerson;
use App\Models\Complaint\CecComCrud;
use App\Models\UserToRole;
use App\Models\RolePermission;
use App\Models\Complaint\CompalintEveOffence;
class CecController extends Controller
{
    public function index($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = SensitizationAtrDetails::where('id',$id)->first();
        $data['user'] = User::get();
        $data['action_id'] = $data['data']->action_id;
        $data['action_details'] = SensitizationActionList::where('id',$data['data']->action_id)->first();


        $data['offence_details'] = CompalintEveOffence::where('id',$data['action_details']->eve_offence_id)->first();



        $cec_users = CecComCrud::where('user_type','CEC')->where('status','A')->pluck('user_id')->toArray();
        $com_users = CecComCrud::where('user_type','COM')->where('status','A')->pluck('user_id')->toArray();
        $data['cec_user_dropdown'] = User::whereIn('id',$cec_users)->get();
        $data['com_user_dropdown'] = User::whereIn('id',$com_users)->get();

        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['members'] = SensitizationMeetingPerson::where('atr_id',$id)->where('type','cec')->get();
        $data['persons'] = SensitizationAtrPerson::where('atr_id',$id)->where('status','!=','D')->get();
        $data['commision_members'] = SensitizationMeetingPerson::where('atr_id',$id)->where('type','com')->get();

        $data['members_cec_approve'] = SensitizationMeetingPerson::where('atr_id',$id)->where('type','cec')->where('coi_status','N')->count();
        $data['members_com_approve'] = SensitizationMeetingPerson::where('atr_id',$id)->where('type','com')->where('coi_status','N')->count();


        return view('sensitization_atr.cec',$data);
    }


    public function updateCecDate(Request $request)
    {
        SensitizationAtrDetails::where('id',$request->id)->update([
            'cec_date'=>$request->cec_date,
            'cec_time'=>$request->cec_time,
            'cec_venue'=>$request->cec_venue,
        ]);

        Alert::success('You\'ve Successfully Updated CEC MEETING INFORMATION ');
        return Redirect::back();
    }


    public function personAddMeeting(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        $new = new SensitizationMeetingPerson;
        $new->eid = $user->eid;
        $new->role = $request->role;
        $new->atr_id = $request->atr_id;
        $new->member_id = $user->id;
        $new->assign_member_id = auth()->user()->id;
        $new->remarks = $request->remarks;
        $new->type = $request->type;
        $new->save();
        Alert::success('Person added successfully');
        return redirect()->back();
    }


    public function personUpdateMeeting(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        SensitizationMeetingPerson::where('id',$request->member_id)->update([
            'eid'=>$user->eid,
            'role'=>$request->role,
            'atr_id'=>$request->atr_id,
            'member_id'=>$user->id,
            'assign_member_id'=>auth()->user()->id,
            'remarks'=>$request->remarks_edit,
            'availability'=>'AA',
            'coi_status'=>'AA',
         ]);
        Alert::success('Person updated successfully');
        return redirect()->back();
    }


    public function personDeleteMeeting($id)
    {
        SensitizationMeetingPerson::where('id',$id)->delete();
        Alert::success('Person deleted successfully');
        return redirect()->back();
    }


    public function updatecomissionDate(Request $request)
    {
         SensitizationAtrDetails::where('id',$request->id)->update([
            'com_date'=>$request->com_date,
            'com_time'=>$request->com_time,
            'com_venue'=>$request->com_venue,
        ]);

        Alert::success('You\'ve Successfully Updated Comission Meeting Information ');
        return Redirect::back();
    }

    public function sensitizationAssignList()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',31)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = SensitizationMeetingPerson::where('member_id',auth()->user()->id)->where('type','cec')->whereIn('coi_status',['AA','N'])->get();
        return view('sensitization_atr.meeting_list',$data);
    }

    public function updateAvailability(Request $request)
    {
        SensitizationMeetingPerson::where('id',@$request->id_value)->update(['availability'=>@$request->optradio_value]);
                  Alert::success('Details updated successfully');
                  return redirect()->back();
    }

    public function coiDetails($id,$type)
    {
        $data = [];
        $data['type'] = $type;
        $data['id'] = $id;
        $data['details'] = SensitizationMeetingPerson::where('id',$id)->first();
        $data['data'] = SensitizationAtrDetails::where('id',$data['details']->atr_id)->first();
        $data['action_id'] = $data['data']->action_id;
        $data['action_details'] = SensitizationActionList::where('id',$data['data']->action_id)->first();

        $data['offence_details'] = CompalintEveOffence::where('id',$data['action_details']->eve_offence_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();

        
        return view('sensitization_atr.coi',$data);
    }

    public function coiDesicion(Request $request)
    {
       
        SensitizationMeetingPerson::where('id',$request->id)->update([
            'coi_status'=>$request->evaluation,
            'describe_coi'=>$request->describe,
        ]);
        Alert::success('Details updated successfully');
        if($request->type=="cec"){
            return redirect()->route('sensitization.review.assign.committee.list');
        }else{
            return redirect()->route('sensitization.review.assign.comission-committee.list');
        }
        
    }


    public function caseDetails($id,$type)
    {
        $data = [];
        $data['type'] = $type;
        $data['id'] = $id;
        $data['details'] = SensitizationMeetingPerson::where('id',$id)->first();
        $data['data'] = SensitizationAtrDetails::where('id',$data['details']->atr_id)->first();
        $data['action_id'] = $data['data']->action_id;
        $data['action_details'] = SensitizationActionList::where('id',$data['data']->action_id)->first();
        $data['offence_details'] = CompalintEveOffence::where('id',$data['action_details']->eve_offence_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['persons'] = SensitizationAtrPerson::where('atr_id',$data['details']->atr_id)->where('status','!=','D')->get();
        $data['members'] = SensitizationMeetingPerson::where('atr_id',$data['details']->atr_id)->where('type','cec')->get();
        if(@$type=="com")
        {
            $data['comission'] = SensitizationMeetingPerson::where('atr_id',$data['details']->atr_id)->where('type','com')->get();
        }
        return view('sensitization_atr.case_details',$data);
    }

    public function caseDetailsUpdateDecision(Request $request)
    {
       SensitizationMeetingPerson::where('id',$request->id)->update([
            'outcome_status'=>$request->outcome_status,
            'final_remark'=>$request->final_remark,
         ]);

        $upd = [];
        if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/cec/',$filename);
            $upd['attachment'] = $filename;
        }
        SensitizationMeetingPerson::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }


    public function sensitizationAssignListComission()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',32)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = SensitizationMeetingPerson::where('member_id',auth()->user()->id)->where('type','com')->whereIn('coi_status',['AA','N'])->get();
        return view('sensitization_atr.meeting_list_comission',$data);
    }

    public function viewMore($id)
    {
        $data = [];
        $data['data'] = SensitizationMeetingPerson::where('id',$id)->first();
        return view('sensitization_atr.member_details',$data);
    }

    public function updateCecDecision(Request $request)
    {
        $upd = [];
        if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/cec/',$filename);
            $upd['cec_attachment'] = $filename;
        }
        $upd['cec_decision'] = $request->outcome_status;
        $upd['cec_remarks'] = $request->cec_remarks;
        $upd['cec_date'] = $request->cec_date;
        $upd['cec_time'] = $request->cec_time;
        $upd['cec_venue'] = $request->cec_venue;
        SensitizationAtrDetails::where('id',$request->id)->update($upd);
        Alert::success('Decision Made Successfully');  
        return redirect()->back();
    }

    public function updatecomDecision(Request $request)
    {
        $details = SensitizationAtrDetails::where('id',$request->id)->first();
        $upd = [];
        $upd['com_date'] = $request->com_date;
        $upd['com_time'] = $request->com_time;
        $upd['com_venue'] = $request->com_venue;
        $upd['com_status'] = $request->com_status;
        if (@$request->com_status=="ECD") {
            $upd['com_decision'] = $details->cec_decision;
            $upd['com_decision'] = '';
            $upd['com_remarks'] = '';
        }else{
            $upd['com_decision'] = $request->com_decision;
            $upd['com_remarks'] = $request->com_remarks;
            if (@$request->hasFile('com_attachment')) {
            $file = $request->com_attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/cec/',$filename);
            $upd['com_attachment'] = $filename;
            }
        }

        SensitizationAtrDetails::where('id',$request->id)->update($upd);
        Alert::success('Decision Made Successfully');  
        return redirect()->back();
    }


}
