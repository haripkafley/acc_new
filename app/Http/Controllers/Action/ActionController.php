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
use App\Models\ActionAgency;
use App\Models\ActionList;
use App\Models\Reminder;
use App\Models\ReminderAgency;
use App\Models\UserToRole;
use App\Models\RolePermission;
use App\Models\Complaint\CompalintEveOffence;
use Session;
class ActionController extends Controller
{
     public function index(Request $request)
     {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',27)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        
        $data['data'] = CompalintEveOffence::whereHas('appraise_details',function($query){
            $query->where('comission_status','For Action');
        });
        // if (@$request->registration_no) {
        //     $data['data'] = $data['data']->where('complaintRegNo',$request->registration_no);
        // }
        $data['data'] = $data['data']->get();
        return view('action.index',$data);
     }

     public function actionList($id)
     {
        $data = [];
        $data['id'] = $id;
        $data['data'] = ActionList::where('eve_offence_id',$id)->where('status','!=','D')->get();
        $data['offence_details'] = CompalintEveOffence::where('id',$id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        Session::put('session_action_id',$id);
        return view('action.action',$data);
     }

     public function actionAdd($id)
     {
        $data = [];
        $data['id'] = $id;
        $data['agency'] = agencyModel::get();
        return view('action.add',$data);
     }

     public function insertAction(Request $request)
     {

        $new = new ActionList;
        $new->eve_offence_id = $request->eve_offence_id;
        $new->letter_no = $request->letter_no;
        $new->letter_date = $request->letter_date;
        $new->description_action = $request->description_action;
        $new->deadline = $request->deadline;
        $new->user_id = auth()->user()->id;
        if (@$request->hasFile('attachment')) {

            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/action/',$filename);
            $new->attachment = $filename;
        }

        $new->save();

        if (isset($request['agencyUser'])) {
                foreach ($request['agencyUser'] as $value) {
                    $receiver = new ActionAgency;
                    $receiver->action_id  = $new->id;
                    $receiver->agency_id = $value;
                    $receiver->save();
                }
        }
        Alert::success('Action Added Successfully');  
        // return $request->id;
        return redirect()->route('action.taken.list.action-list',['id'=>$request->eve_offence_id]);
     }


     public function editView($id)
     {
        $data = [];
        $data['data'] = ActionList::where('id',$id)->first();
        $data['agency'] = agencyModel::get();
        $data['selected'] = ActionAgency::where('action_id',$id)->pluck('agency_id')->toArray();
        return view('action.edit',$data);
     }

     public function updateAction(Request $request)
     {
        $upd = [];
        $upd['letter_no'] = $request->letter_no;
        $upd['letter_date'] = $request->letter_date;
        $upd['description_action'] = $request->description_action;
        $upd['deadline'] = $request->deadline;
        if (@$request->hasFile('attachment')) {

            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/action/',$filename);
            $upd['attachment'] = $filename;
        }

        ActionList::where('id',$request->id)->update($upd);
        $ids = explode(',',$request->id);
        
        ActionAgency::whereIn('action_id',$ids)->delete();
        if (isset($request['agencyUser'])) {
                foreach ($request['agencyUser'] as $value) {
                    $receiver = new ActionAgency;
                    $receiver->action_id  = $request->id;
                    $receiver->agency_id = $value;
                    $receiver->save();
                }
        }
        Alert::success('Action Updated Successfully');  
        return redirect()->route('action.taken.list.action-list',['id'=>$request->complaintID]);

     }


     public function deleteView($id)
     {
        $data = [];
        $data['id'] = $id;
        return view('action.delete',$data);
     }

     public function deleteAction(Request $request)
     {
        $data = ActionList::where('id',$request->id)->first();
        ActionList::where('id',$request->id)->update([
            'status'=>'D',
            'reason'=>$request->reason,
        ]);
        Alert::success('Action Deleted Successfully');  
        return redirect()->route('action.taken.list.action-list',['id'=>$data->eve_offence_id]);
     } 

     public function extensionView($id)
     {
        $data= [];
        $data['data'] = ActionList::where('id',$id)->first();
        $data['id'] = $id;
        return view('action.extend',$data);
     }

     public function extensionAction(Request $request)
     {
        $upd = [];
        $upd['extended_to'] = $request->extended_to;
        $upd['extension_letter_no'] = $request->extension_letter_no;
        $upd['reason_extension'] = $request->reason_extension;
        $upd['extended_status'] = 'Y';

        if (@$request->hasFile('request_letter_attachment')) {

            $file = $request->request_letter_attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/action/',$filename);
            $upd['request_letter_attachment'] = $filename;
        }

        if (@$request->hasFile('extension_letter_attachment')) {

            $file = $request->extension_letter_attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/action/',$filename);
            $upd['extension_letter_attachment'] = $filename;
        }

        ActionList::where('id',$request->id)->update($upd);
        Alert::success('Action Date Extended Successfully');  
        return redirect()->back();
     }


     public function reminderList($id)
     {
        $data = [];
        $data['id'] = $id;
        $action_details = ActionList::where('id',$id)->first();
        $data['offence_details'] = CompalintEveOffence::where('id',$action_details->eve_offence_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['data'] = Reminder::where('action_id',$id)->get();
        $data['action_id'] = Session::get('session_action_id');
        return view('reminder.index',$data);
     }

     public function reminderAddView($id)
     {
        $data = [];
        $data['id'] = $id;
        $data['agency'] = agencyModel::get();
        return view('reminder.add',$data);
     }

     public function reminderInsert(Request $request)
     {
        $new = new Reminder;
        $new->action_id = $request->action_id;
        $new->letter_no = $request->letter_no;
        $new->letter_date = $request->letter_date;
        $new->remarks = $request->remarks;
        $new->user_id = auth()->user()->id;
        if (@$request->hasFile('letter_attachment')) {

            $file = $request->letter_attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/action/',$filename);
            $new->letter_attachment = $filename;
        }
        $new->save();

        if (isset($request['agencyUser'])) {
                foreach ($request['agencyUser'] as $value) {
                    $receiver = new ReminderAgency;
                    $receiver->reminder_id  = $new->id;
                    $receiver->agency_id = $value;
                    $receiver->save();
                }
        }

        Alert::success('Reminder Added Successfully');  
        return redirect()->route('action.taken.reminder.list',['id'=>$request->action_id]);

     }


     public function reminderDelete($id)
     {
        
        Reminder::where('id',$id)->delete();
        $explode = explode(',',$id);
        ReminderAgency::whereIn('reminder_id',$explode)->delete();
        Alert::success('Reminder Deleted Successfully');
        return redirect()->bacK();
     }
}
