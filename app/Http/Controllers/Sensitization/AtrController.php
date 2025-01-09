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

use App\Models\SensitizationAtrDetails;
use App\Models\SensitizationAtrPerson;
use App\Models\ActionList;
use App\Models\Country;
use App\Models\ActionTakenStatus;
use App\Models\Complaint\CompalintEveOffence;
class AtrController extends Controller
{
    public function index($id)
    {

        $data = [];
        $data['id'] = $id;
        $data['data'] = SensitizationAtrDetails::where('action_id',$id)->get();
        $data['action_details'] = SensitizationActionList::where('id',$id)->first();
        $data['offence_details'] = CompalintEveOffence::where('id',$data['action_details']->eve_offence_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        return view('sensitization_atr.index',$data);
    }

    public function addView($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('sensitization_atr.add',$data);
    }

    public function actionInsertForNo(Request $request)
    {
        $new = new SensitizationAtrDetails;
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
        return redirect()->route('sensitization.action.taken.report',['id'=>$request->action_id]);

    }


    public function actionInsertForYesRedirect(Request $request)
    {

        if (@$request->redirect=="N") {

           SensitizationAtrDetails::where('id',$request->id)->update(['action_taken'=>'N']);
           return redirect()->route('sensitization.action.taken.report.edit.view',$request->id);
        

        }elseif(@$request->redirect=="Y"){
            SensitizationAtrDetails::where('id',$request->id)->update(['action_taken'=>'Y']);
            return redirect()->route('sensitization.action.taken.report.edit.view.yes.action',$request->id);
        }else{
        $new = new SensitizationAtrDetails;
        $new->action_taken = 'Y';
        $new->action_id = $request->action_id;
        $new->save();
        return redirect()->route('sensitization.action.taken.report.edit.view.yes.action',['id'=>$new->id]);
        }
    }

    public function editViewYes($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = SensitizationAtrDetails::where('id',$id)->first();
        $data['persons'] = SensitizationAtrPerson::where('atr_id',$id)->where('status','!=','D')->get();
        return view('sensitization_atr.yes_action',$data);
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

        SensitizationAtrDetails::where('id',$request->action_id)->update($upd);
        Alert::success('Action Added Successfully');
        return redirect()->back();

    }


    public function crudAddview($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['country'] = Country::get();
        $data['actions'] = ActionTakenStatus::get();
        return view('sensitization_atr.add_person',$data);
    }




    public function crudInsert(Request $request)
    {

        $new = new SensitizationAtrPerson;
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
        return redirect()->route('sensitization.action.taken.report.edit.view.yes.action',$request->atr_id);

    }


    public function crudeditview($id)
    {
        // return $id;
        $data = [];
        $data['data'] = SensitizationAtrPerson::where('id',$id)->first();
        $data['country'] = Country::get();
        $data['actions'] = ActionTakenStatus::get();
        $data['atr_id'] = $data['data']->atr_id;
        // return $data['atr_id'];
        return view('sensitization_atr.edit',$data);
    }

    public function crudUpdate(Request $request)
    {
        // return $request;
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
    
        SensitizationAtrPerson::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully');
        return redirect()->route('sensitization.action.taken.report.edit.view.yes.action',$request->atr);

    }


    public function cruddeleteview($id)
    {
        $data = [];
        $data['id'] = $id;
        $details = SensitizationAtrPerson::where('id',$id)->first();
        $data['atr_id'] = $details->atr_id;
        return view('sensitization_atr.delete',$data);
    }


    public function cruddelete(Request $request)
    {
        SensitizationAtrPerson::where('id',$request->id)->update([
            'status'=>'D',
            'reason'=>$request->reason,
        ]);
        Alert::success('Data Deleted Successfully');
        return redirect()->route('sensitization.action.taken.report.edit.view.yes.action',$request->atr_id);
    }


    public function editView($id)
    {
        $data = [];
        $data['data'] = SensitizationAtrDetails::where('id',$id)->first();
        $data['id'] = $id;
        return view('sensitization_atr.no_edit',$data);
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
        SensitizationAtrDetails::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully');
        return redirect()->back();
    }


     public function atrEdit($id)
    {
        $check = SensitizationAtrDetails::where('id',$id)->first();
        if (@$check->action_taken=="Y") {
            
            return redirect()->route('sensitization.action.taken.report.edit.view.yes.action',@$id);
        }else{
            return redirect()->route('sensitization.action.taken.report.edit.view',@$id);
        }
    }
}
