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
use App\Models\UserToRole;
use App\Models\RolePermission;
use App\Models\Complaint\CompalintEveOffence;
class SensitizationController extends Controller
{
     public function index(Request $request)
     {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',28)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = CompalintEveOffence::where('com_decision','SEN')->get();
        // if (@$request->registration_no) {
        //     $data['data'] = $data['data']->where('complaintRegNo',$request->registration_no);
        // }
        // $data['data'] = $data['data']->get();
        return view('sensitization.index',$data);
     }


     public function actionList($id)
     {
        $data = [];
        $data['id'] = $id;
        $data['data'] = SensitizationActionList::where('eve_offence_id',$id)->where('status','!=','D')->get();
        $data['offence_details'] = CompalintEveOffence::where('id',$id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        return view('sensitization.action',$data);
     }


     public function actionAdd($id)
     {
        $data = [];
        $data['id'] = $id;
        $data['agency'] = agencyModel::get();
        return view('sensitization.add',$data);
     }

     public function insertAction(Request $request)
     {

        $new = new SensitizationActionList;
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
        Alert::success('Data Added Successfully');  
        // return $request->id;
        return redirect()->route('sensitization.list.action-list',['id'=>$request->eve_offence_id]);
     }


    public function editView($id)
     {
        $data = [];
        $data['data'] = SensitizationActionList::where('id',$id)->first();
        $data['agency'] = agencyModel::get();
        $data['selected'] = ActionAgency::where('action_id',$id)->pluck('agency_id')->toArray();
        return view('sensitization.edit',$data);
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

        SensitizationActionList::where('id',$request->id)->update($upd);
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
        Alert::success('Data Updated Successfully');  
        return redirect()->back();

     }


    public function deleteView($id)
     {
        $data = [];
        $data['id'] = $id;
        return view('sensitization.delete',$data);
     }

     public function deleteAction(Request $request)
     {
        $data = SensitizationActionList::where('id',$request->id)->first();
        SensitizationActionList::where('id',$request->id)->update([
            'status'=>'D',
            'reason'=>$request->reason,
        ]);
        Alert::success('Action Deleted Successfully');  
        return redirect()->route('sensitization.list.action-list',['id'=>$data->eve_offence_id]);
     } 


     public function extensionView($id)
     {
        $data= [];
        $data['data'] = SensitizationActionList::where('id',$id)->first();
        $data['id'] = $id;
        return view('sensitization.extend',$data);
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

        SensitizationActionList::where('id',$request->id)->update($upd);
        Alert::success('Action Date Extended Successfully');  
        return redirect()->route('sensitization.list.action-list',['id'=>$request->eve_offence_id]);
     }



     public function reminderList($id)
     {
        $data = [];
        $data['id'] = $id;
        $action_details = SensitizationActionList::where('id',$id)->first();
        $data['offence_details'] = CompalintEveOffence::where('id',$action_details->eve_offence_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['data'] = SensitizationReminder::where('action_id',$id)->get();
        return view('sensitization_reminder.index',$data);
     }

     public function reminderAddView($id)
     {
        $data = [];
        $data['id'] = $id;
        $data['agency'] = agencyModel::get();
        return view('sensitization_reminder.add',$data);
     }

     public function reminderInsert(Request $request)
     {
        $new = new SensitizationReminder;
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
                    $receiver = new SensitizationReminderAgency;
                    $receiver->reminder_id  = $new->id;
                    $receiver->agency_id = $value;
                    $receiver->save();
                }
        }

        Alert::success('Reminder Added Successfully');  
        return redirect()->route('sensitization.taken.reminder.list',['id'=>$request->action_id]);

     }

     public function reminderDelete($id)
     {
        SensitizationReminder::where('id',$id)->delete();
        $explode = explode(',',$id);
        SensitizationReminderAgency::whereIn('reminder_id',$ids)->delete();
        Alert::success('Reminder Deleted Successfully');
        return redirect()->bacK();
     }





}
