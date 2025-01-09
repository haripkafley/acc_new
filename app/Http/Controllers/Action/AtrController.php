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
use App\Models\Complaint\CompalintEveOffence;
class AtrController extends Controller
{                                               
    public function index($id)
    {

        $data = [];
        $data['id'] = $id;
        $data['data'] = AtrDetails::where('action_id',$id)->get();
        $data['action_details'] = ActionList::where('id',$id)->first();
        $data['offence_details'] = CompalintEveOffence::where('id',$data['action_details']->eve_offence_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        return view('atr.index',$data);
    }

    public function cecDecisionUpdate(Request $request)
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
        AtrDetails::where('id',$request->id)->update($upd);
        Alert::success('Decision Made Successfully');  
        return redirect()->back();
    }

    public function comDecisionUpdate(Request $request)
    {
        $details = AtrDetails::where('id',$request->id)->first();
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

        AtrDetails::where('id',$request->id)->update($upd);
        Alert::success('Decision Made Successfully');  
        return redirect()->back();

    }

    public function addView($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('atr.add',$data);
    }

    public function actionInsertForNo(Request $request)
    {
        $new = new AtrDetails;
        $new->action_taken = 'N';
        $new->letter_date = $request->letter_date;
        $new->letter_no = $request->letter_no;
        $new->action_id = $request->action_id;
        $new->reason = $request->reason;
        if (@$request->hasFile('attach_letter')) {

            $file = $request->attach_letter;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/action/',$filename);
            $new->attach_letter = $filename;
        }
        $new->save();
        Alert::success('Action Added Successfully');  
        return redirect()->route('action.taken.report',['id'=>$request->action_id]);

    }

    public function actionInsertForYesRedirect(Request $request)
    {

        if (@$request->redirect=="N") {

           AtrDetails::where('id',$request->id)->update(['action_taken'=>'N']);
           return redirect()->route('action.taken.report.edit.view',$request->id);
        

        }elseif(@$request->redirect=="Y"){
            AtrDetails::where('id',$request->id)->update(['action_taken'=>'Y']);
            return redirect()->route('action.taken.report.edit.view.yes.action',$request->id);
        }else{
        $new = new AtrDetails;
        $new->action_taken = 'Y';
        $new->action_id = $request->action_id;
        $new->save();
        return redirect()->route('action.taken.report.edit.view.yes.action',['id'=>$new->id]);
        }
    }

    public function editViewYes($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = AtrDetails::where('id',$id)->first();
        $data['persons'] = AtrPerson::where('atr_id',$id)->where('status','!=','D')->get();
        return view('atr.yes_action',$data);
    }

    public function yesUpdateDecision(Request $request)
    {
        $upd = [];
        $upd['letter_no'] = $request->letter_no;
        $upd['letter_date'] = $request->letter_date;

        if (@$request->hasFile('attach_letter')) {

            $file = $request->attach_letter;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/action/',$filename);
            $upd['attach_letter'] = $filename;
        }

        AtrDetails::where('id',$request->action_id)->update($upd);
        Alert::success('Action Added Successfully');
        return redirect()->back();

    }


    public function crudAddview($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['country'] = Country::get();
        $data['actions'] = ActionTakenStatus::get();
        return view('atr.add_person',$data);
    }

    public function personDetails(Request $request)
    {
        $response = [];
        $user = personModel::where('cid',$request->cid)->first();
        if (@$user=="") {
            $response['success'] = false;
        }else{
            $response['success'] = true;
            $response['name'] = $user->fname.' '. $user->mname. ' '. $user->lname;
            $response['dzongkhag'] = $user->dzongkhagrelation->dzoName;
            $response['gewog'] = @$user->gewogrelation->gewogName;
            $response['village'] = @$user->villagerelation->villageName;
        }
        return $response;
    }


    public function crudInsert(Request $request)
    {

        $new = new AtrPerson;
        $new->type = $request->action_taken;
        $new->action_taken = $request->action_taken_status;
        $new->action_details = $request->action_details;
        $new->atr_id = $request->atr_id;

        if (@$request->action_taken=="Individual") {
            
            if (@$request->nationality=="Bhutan") {
                
                $new->nationality = $request->nationality;
                $new->cid_no = $request->cid_no;
                $new->name = $request->bhutan_name;
            }else{
                $new->nationality = $request->nationality;
                $new->document_no = $request->document_no;
                $new->name = $request->othernation_name;
                $new->parmanent_address  = $request->parmanent_address;
                $new->bhutan_address  = $request->bhutan_address;
            }
        }else{

            // return $request;

            if (@$request->organization_type=="Contractor") {
                // return $erquest;
               $new->organization_type = $request->organization_type;
               $new->name = $request->contractor_name;
               $new->reg_no = $request->reg_no;
               $new->office_address = $request->office_address;
            }

            if (@$request->organization_type=="Other Businessess") {
                // return $request;

                $new->organization_type = $request->organization_type;
                $new->name = $request->otherbusiness_name;
                $new->reg_no = $request->reg_no_other_business;
                $new->business_location = $request->business_location;
            }

            if (@$request->organization_type=="Others") {
                $new->organization_type = $request->organization_type;
                $new->name = $request->other_name;
                $new->office_address = $request->other_office_address;
                    
            }


        }

        $new->save();
        Alert::success('Data Added Successfully');
        return redirect()->route('action.taken.report.edit.view.yes.action',$request->atr_id);

    }


    public function crudeditview($id)
    {
        // return $id;
        $data = [];
        $data['data'] = AtrPerson::where('id',$id)->first();
        $data['country'] = Country::get();
        $data['actions'] = ActionTakenStatus::get();
        $data['atr_id'] = $data['data']->atr_id;
        // return $data['atr_id'];
        return view('atr.edit',$data);
    }

    public function crudUpdate(Request $request)
    {
        $upd = [];
        $upd['type'] = $request->action_taken;
        $upd['action_taken'] = $request->action_taken_status;
        $upd['action_details'] = $request->action_details;
        

        if (@$request->action_taken=="Individual") {
            
            if (@$request->nationality=="Bhutan") {
                
                $upd['nationality'] = $request->nationality;
                $upd['cid_no'] = $request->cid_no;
                $upd['name'] = $request->bhutan_name;
            }else{
                $upd['nationality'] = $request->nationality;
                $upd['document_no'] = $request->document_no;
                $upd['name'] = $request->othernation_name;
                $upd['parmanent_address']  = $request->parmanent_address;
                $upd['bhutan_address']  = $request->bhutan_address;
            }
        }else{

            // return $request;

            if (@$request->organization_type=="Contractor") {
                // return $erquest;
               $upd['organization_type'] = $request->organization_type;
               $upd['name'] = $request->contractor_name;
               $upd['reg_no'] = $request->reg_no;
               $upd['office_address'] = $request->office_address;
            }

            if (@$request->organization_type=="Other Businessess") {
                // return $request;

                $upd['organization_type'] = $request->organization_type;
                $upd['name'] = $request->otherbusiness_name;
                $upd['reg_no'] = $request->reg_no_other_business;
                $upd['business_location'] = $request->business_location;
            }

            if (@$request->organization_type=="Others") {
                $upd['organization_type'] = $request->organization_type;
                $upd['name'] = $request->other_name;
                $upd['office_address'] = $request->other_office_address;
                    
            }


        }
    
        AtrPerson::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully');
        return redirect()->route('action.taken.report.crud.edit.view',$request->id);

    }


    public function cruddeleteview($id)
    {
        $data = [];
        $data['id'] = $id;
        $details = AtrPerson::where('id',$id)->first();
        $data['atr_id'] = $details->atr_id;
        return view('atr.delete',$data);
    }


    public function cruddelete(Request $request)
    {
        AtrPerson::where('id',$request->id)->update([
            'status'=>'D',
            'reason'=>$request->reason,
        ]);
        Alert::success('Data Deleted Successfully');
        return redirect()->route('action.taken.report.edit.view.yes.action',$request->atr_id);
    }

    public function editView($id)
    {
        $data = [];
        $data['data'] = AtrDetails::where('id',$id)->first();
        $data['id'] = $id;
        return view('atr.no_edit',$data);
    }

    public function updateView(Request $request)
    {
        // return $request;
        $upd = [];
        $upd['action_taken'] = 'N';
        $upd['letter_date'] = $request->letter_date;
        $upd['letter_no'] = $request->letter_no;
        $upd['reason'] = $request->reason;
        if (@$request->hasFile('attach_letter')) {

            $file = $request->attach_letter;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/action/',$filename);
            $upd['attach_letter'] = $filename;
        }
        AtrDetails::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully');
        return redirect()->back();
    }


    public function atrEdit($id)
    {
        $check = AtrDetails::where('id',$id)->first();
        if (@$check->action_taken=="Y") {
            
            return redirect()->route('action.taken.report.edit.view.yes.action',@$id);
        }else{
            return redirect()->route('action.taken.report.edit.view',@$id);
        }
    }








}
