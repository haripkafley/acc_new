<?php

namespace App\Http\Controllers\Action;

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
use App\Models\Complaint\personModel;
use App\Models\ActionAgency;
use App\Models\ActionList;
use App\Models\Reminder;
use App\Models\ReminderAgency;
use App\Models\AtrDetails;
use App\Models\AtrPerson;
use App\Models\Country;
use App\Models\ActionTakenStatus;
use App\Models\ActionAtrMeetingPerson;
use App\Models\UserToRole;
use App\Models\RolePermission;
use App\Models\ActionCecTempMember;
use App\Models\ActionCecTempNumber;
use App\Models\Complaint\CecComCrud;
use App\Models\Complaint\CompalintEveOffence;
use Redirect;
class CecController extends Controller
{
    public function index($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['user'] = User::get();
        $data['data'] = AtrDetails::where('id',$id)->first();
        $data['action_id'] = $data['data']->action_id;
        $data['action_details'] = ActionList::where('id',$data['data']->action_id)->first();
        $data['offence_details'] = CompalintEveOffence::where('id',$data['action_details']->eve_offence_id)->first();
        $cec_users = CecComCrud::where('user_type','CEC')->where('status','A')->pluck('user_id')->toArray();
        $com_users = CecComCrud::where('user_type','COM')->where('status','A')->pluck('user_id')->toArray();
        $data['cec_user_dropdown'] = User::whereIn('id',$cec_users)->get();
        $data['com_user_dropdown'] = User::whereIn('id',$com_users)->get();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['members'] = ActionAtrMeetingPerson::where('atr_id',$id)->where('type','cec')->get();
        $data['persons'] = AtrPerson::where('atr_id',$id)->where('status','!=','D')->get();
        $data['commision_members'] = ActionAtrMeetingPerson::where('atr_id',$id)->where('type','com')->get();


        $data['members_cec_approve'] = ActionAtrMeetingPerson::where('atr_id',$id)->where('type','cec')->where('coi_status','N')->count();
        $data['members_com_approve'] = ActionAtrMeetingPerson::where('atr_id',$id)->where('type','com')->where('coi_status','N')->count();

        
        return view('atr.cec',$data);
    }

    public function updateCecDate(Request $request)
    {
        AtrDetails::where('id',$request->id)->update([
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
        $new = new ActionAtrMeetingPerson;
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
        ActionAtrMeetingPerson::where('id',$request->member_id)->update([
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
        ActionAtrMeetingPerson::where('id',$id)->delete();
        Alert::success('Person deleted successfully');
        return redirect()->back();
    }


    public function actionAssignList()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',29)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = ActionAtrMeetingPerson::where('member_id',auth()->user()->id)->where('type','cec')->whereIn('coi_status',['AA','N'])->get();
        return view('atr.meeting_list',$data);
    }

    public function updateAvailability(Request $request)
    {
        ActionAtrMeetingPerson::where('id',@$request->id_value)->update(['availability'=>@$request->optradio_value]);
                  Alert::success('Details updated successfully');
                  return redirect()->back();
    }

    public function coiDetails($id,$type)
    {
        $data = [];
        $data['type'] = $type;
        $data['id'] = $id;
        $data['details'] = ActionAtrMeetingPerson::where('id',$id)->first();
        $data['data'] = AtrDetails::where('id',$data['details']->atr_id)->first();
        $data['action_id'] = $data['data']->action_id;
        $data['action_details'] = ActionList::where('id',$data['data']->action_id)->first();
        $data['offence_details'] = CompalintEveOffence::where('id',$data['action_details']->eve_offence_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        return view('atr.coi',$data);
    }

    public function coiDesicion(Request $request)
    {
       
        ActionAtrMeetingPerson::where('id',$request->id)->update([
            'coi_status'=>$request->evaluation,
            'describe_coi'=>$request->describe,
        ]);
        Alert::success('Details updated successfully');
        if($request->type=="cec"){
            return redirect()->route('action.review.assign.committee.list');
        }else{
            return redirect()->route('action.review.assign.comission-committee.list');
        }
        
    }


    public function caseDetails($id,$type)
    {
        $data = [];
        $data['type'] = $type;
        $data['id'] = $id;
        $data['details'] = ActionAtrMeetingPerson::where('id',$id)->first();
        $data['data'] = AtrDetails::where('id',$data['details']->atr_id)->first();
        $data['action_id'] = $data['data']->action_id;
        $data['action_details'] = ActionList::where('id',$data['data']->action_id)->first();
        $data['offence_details'] = CompalintEveOffence::where('id',$data['action_details']->eve_offence_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['persons'] = AtrPerson::where('atr_id',$data['details']->atr_id)->where('status','!=','D')->get();
        $data['members'] = ActionAtrMeetingPerson::where('atr_id',$data['details']->atr_id)->where('type','cec')->get();
        if(@$type=="com")
        {
            $data['comission'] = ActionAtrMeetingPerson::where('atr_id',$data['details']->atr_id)->where('type','com')->get();
        }
        return view('atr.case_details',$data);
    }

    public function caseDetailsUpdateDecision(Request $request)
    {
       ActionAtrMeetingPerson::where('id',$request->id)->update([
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
        ActionAtrMeetingPerson::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }


    public function updatecomissionDate(Request $request)
    {
         AtrDetails::where('id',$request->id)->update([
            'com_date'=>$request->com_date,
            'com_time'=>$request->com_time,
            'com_venue'=>$request->com_venue,
        ]);

        Alert::success('You\'ve Successfully Updated Comission Meeting Information ');
        return Redirect::back();
    }


    public function actionAssignListComission()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',30)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = ActionAtrMeetingPerson::where('member_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->where('type','com')->get();
        // return $data['data'];
        return view('atr.meeting_list_comission',$data);
    }

    public function viewMore($id)
    {
        $data = [];
        $data['data'] = ActionAtrMeetingPerson::where('id',$id)->first();
        return view('atr.member_details',$data);
    }


    public function createNumber(Request $request)
    {
        if (@$request->addmore) {
            $arrays = [];
            foreach(@$request->addmore as $value){
                array_push($arrays, $value['checkbox']);
            }
            $comma_separated = implode(',',$arrays);
            $new = new ActionCecTempNumber;
            $new->user_id = auth()->user()->id;
            $new->atr_id  = $comma_separated;
            $new->save();
            $rand =  'CEC'.mt_rand(10000,99999).$new->id;
            ActionCecTempNumber::where('id',$new->id)->update([
                'temp_number'=>$rand,
            ]);
            return redirect()->route('action-atr-ces.number.generate.memebers.committee.room',$rand);
        }else{
            Alert::error('Please select atleast one case.');
            return redirect()->back(); 
        }    
    }



    public function createMemberRoom(Request $request,$id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = ActionCecTempNumber::where('temp_number',$id)->first();
        if (@$request->date_search) {
            if(@$request->meeting_type=="cec"){
                $find_cases = AtrDetails::where('cec_date',@$request->date_search)->pluck('id')->toArray();
            }else{
                $find_cases = AtrDetails::where('com_date',@$request->date_search)->pluck('id')->toArray();
            }
            
            $find_members = ActionAtrMeetingPerson::whereIn('atr_id',$find_cases)->get();
            if (count($find_members)>0) {
                
                ActionCecTempMember::where('temp_id',$id)->delete();

                foreach($find_members as $member)
                {
                    $new = new ActionCecTempMember;
                    $new->temp_id = $id;
                    $new->member_id = $member->member_id;
                    $new->remarks = $member->remarks;
                    $new->temp_id = $id;
                    $new->role = $member->role;
                    $new->save();

                }
             }
        }
        $data['data'] = ActionCecTempMember::where('temp_id',$id)->get();
        return view('atr.bulk',$data);
    }


    public function deleteTempMember($id)
    {
        ActionCecTempMember::where('id',$id)->delete();
        return redirect()->back()->with('success','Member deleted successfully');
    }


    public function updateTempMember(Request $request)
    {
        $user = User::where('eid',$request->eid)->first();
        ActionCecTempMember::where('id',$request->member_id)->update([
            'eid'=>$request->eid,
            'role'=>$request->role,
            'member_id'=>$user->id,
            'remarks'=>$request->remarks_edit,
         ]);
        Alert::success('Person updated successfully');
        return redirect()->back();
    }


    public function addTempMember(Request $request)
    {
        $user = User::where('eid',$request->eid)->first();
        $new = new ActionCecTempMember;
        $new->temp_id = $request->temp_id;
        $new->eid = $request->eid;
        $new->remarks = $request->remarks;
        $new->role = $request->role;
        $new->member_id = $user->id;
        $new->remarks = $request->remarks;
        $new->save();
        Alert::success('Person added successfully');
        return redirect()->back();
    }


    public function finalTempMember(Request $request)
    {
        $checkMember = ActionCecTempMember::where('temp_id',$request->temp_id)->first();
        if (@$checkMember=="") {
           Alert::error('Please assign atleast one person'); 
           return redirect()->back(); 
        }

        $getComplaint = ActionCecTempNumber::where('temp_number',$request->temp_id)->first();
        $explodeIds = explode(',', $getComplaint->atr_id);
        $action_details = AtrDetails::where('id',$explodeIds[0])->first();

        $members = ActionCecTempMember::where('temp_id',$request->temp_id)->get();
        foreach($explodeIds as $value)
        {
            
            // update location and time

            if(@$request->meeting_decide=="cec"){
                AtrDetails::where('id',$value)->update([
                'cec_date'=>$request->cec_date,
                'cec_time'=>$request->cec_time,
                'cec_venue'=>$request->cec_venue,
                ]);

                ActionAtrMeetingPerson::where('atr_id',$value)->where('type','cec')->delete();
            }else{
                AtrDetails::where('id',$value)->update([
                'com_date'=>$request->cec_date,
                'com_time'=>$request->cec_time,
                'com_venue'=>$request->cec_venue,
                ]);
                ActionAtrMeetingPerson::where('atr_id',$value)->where('type','com')->delete();
            }

            if(@$request->meeting_decide=="cec"){
                $type="cec";
            }else{
                $type="com";
            }
            

            foreach($members as $member)
            {

                $new = new ActionAtrMeetingPerson;
                $new->eid = $member->eid;
                $new->role = $member->role;
                $new->type = $type;
                $new->atr_id = $value;
                $new->member_id = $member->member_id;
                $new->assign_member_id = auth()->user()->id;
                $new->remarks = $member->remarks;
                $new->save();
            }
        }
        ActionCecTempMember::where('temp_id',$request->temp_id)->delete();
        ActionCecTempNumber::where('temp_number',$request->temp_id)->delete();
        Alert::success('Person assigned successfully'); 
        return redirect()->route('action.taken.report',@$action_details->action_id); 

    }


    
}
