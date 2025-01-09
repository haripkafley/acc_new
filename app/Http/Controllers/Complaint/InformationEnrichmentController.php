<?php

namespace App\Http\Controllers\Complaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\CompalintEveOffence;
use App\Models\Complaint\complaintRegistrationModel;
use App\Models\Complaint\InformationEnrichmentTeam;
use App\Models\AdditionalInformationEvaluation;
use App\Models\User;
use App\Models\Complaint\IrPlan;
use App\Models\Complaint\IrFieldVisit;
use App\Models\Complaint\IePersonContact;
use App\Models\Complaint\IeFieldPersonDocument;
use App\Models\Complaint\IEceccommember;
use App\Models\Complaint\CecComCrud;
use Redirect;
use Session;
use Alert;
class InformationEnrichmentController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = CompalintEveOffence::where('com_sub_decision','IE')->where('com_decision','DD')->get();
        return view('information_enrichment.index',$data);
    }

    public function view($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['offence_details'] = CompalintEveOffence::where('id',$id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['information'] = AdditionalInformationEvaluation::where('complaint_id',$data['offence_details']->complaint_id)->where('status','A')->get();
        $data['data'] = IrPlan::where('ir_id',$id)->get();
        $data['data_two'] = IrFieldVisit::where('ir_id',$id)->get();

        $cec_users = CecComCrud::where('user_type','CEC')->where('status','A')->pluck('user_id')->toArray();
        $com_users = CecComCrud::where('user_type','COM')->where('status','A')->pluck('user_id')->toArray();
        $data['cec_user_dropdown'] = User::whereIn('id',$cec_users)->get();
        $data['com_user_dropdown'] = User::whereIn('id',$com_users)->get();
        $data['cec_members'] = IEceccommember::where('ie_id',$id)->where('type','cec')->get();
        $data['com_members'] = IEceccommember::where('ie_id',$id)->where('type','com')->get();

        $data['members_cec_approve'] = IEceccommember::where('ie_id',$id)->where('type','cec')->where('coi_status','N')->count();
        $data['members_com_approve'] = IEceccommember::where('ie_id',$id)->where('type','com')->where('coi_status','N')->count();
        return view('information_enrichment.view',$data);
    }

    public function ieDetailsChief($id)
    {
        $data = [];
        $data['data'] = IrPlan::where('id',$id)->first();
        $data['person'] = IePersonContact::where('ie_plan_id',$id)->where('type','P')->get();
       $data['document'] = IePersonContact::where('ie_plan_id',$id)->where('type','D')->get();
        return view('information_enrichment.ie_plan_update_chief',$data);
    }

    public function feildDetailsChief($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = IrFieldVisit::where('id',$id)->first();
        $data['person'] = IeFieldPersonDocument::where('ie_field_id',$id)->where('type','P')->get();
        $data['document'] = IeFieldPersonDocument::where('ie_field_id',$id)->where('type','D')->get();
        return view('information_enrichment.ie_field_update_chief',$data);
    }

    public function insertCecMember(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        $new = new IEceccommember;
        $new->eid = $user->eid;
        $new->role = $request->role;
        $new->ie_id = $request->ie_id;
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
        IEceccommember::where('id',$request->member_id)->update([
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

    public function updateCecStatus(Request $request)
    {
        // return $request;
        $upd = [];
        $upd['ie_cec_date'] = $request->ie_cec_date;
        $upd['ie_cec_time'] = $request->ie_cec_time;
        $upd['ie_cec_venue'] = $request->ie_cec_venue;
        $upd['ie_cec_status'] = $request->ie_cec_status;
        $upd['ie_cec_remarks'] = $request->ie_cec_remarks;
        CompalintEveOffence::where('id',$request->ie_id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function updateComStatus(Request $request)
    {
        $details = CompalintEveOffence::where('id',$request->id)->first();
        $upd = [];
        $upd['ie_com_date'] = $request->ie_com_date;
        $upd['ie_com_time'] = $request->ie_com_time;
        $upd['ie_com_venue'] = $request->ie_com_venue;
        $upd['ie_com_status'] = $request->ie_com_status;
        $upd['ie_com_remarks'] = $request->ie_com_remarks;
        if (@$request->ie_com_status=="ECD") {
            $upd['ie_com_decision'] = $details->ie_cec_status;
        }else{
            $upd['ie_com_decision'] = $request->ie_com_decision;
        }
        CompalintEveOffence::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();

    }

    public function deleteCecMember($id)
    {
        IEceccommember::where('id',$id)->delete();
        Alert::success('Person deleted successfully');
        return redirect()->back();
    }

    public function cecUserList()
    {
        $data = [];
        $data['data'] = IEceccommember::where('type','cec')->where('member_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->get();
        return view('information_enrichment.cec_list',$data);
    }

    public function comUserList()
    {
        $data = [];
        $data['data'] = IEceccommember::where('type','com')->where('member_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->get();
        return view('information_enrichment.com_list',$data);
    }

    public function cecUserListCoi($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = IEceccommember::where('id',$id)->where('member_id',auth()->user()->id)->first();
        if (@$data['details']=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data['offence_details'] = CompalintEveOffence::where('id',$data['details']->ie_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        return view('information_enrichment.cec_com_coi',$data);
    }

    public function cecUserListCoiUpdate(Request $request)
    {
        $check = IEceccommember::where('id',$request->id)->first();
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['describe_coi'] = $request->coi_description;
        IEceccommember::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        if ($check->type=="cec") {
            return redirect()->route('information.enrichment.get.user.list');
        }else{
            return redirect()->route('information.enrichment.get.user.list.commission.list');
        }
        
    }

    public function updateReportDecision(Request $request)
    {
        $upd = [];
        $upd['ie_report_status'] = $request->ie_report_status;
        $upd['ie_chief_remarks'] = $request->ie_chief_remarks;
        CompalintEveOffence::where('id',$request->ie_id)->update($upd);
        Alert::success('You\'ve Successfully Updated A Report');
        return Redirect::back();
    }


    public function assginMember($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['offence_details'] = CompalintEveOffence::where('id',$id)->first();

        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['data'] = InformationEnrichmentTeam::where('ir_id',$id)->get();
        $data['users'] = User::get();
        return view('information_enrichment.assign',$data);
    }

    public function assginMemberInsert(Request $request)
    {
        $new = new InformationEnrichmentTeam;
        $new->user_id = $request->user_id;
        $new->role = $request->role;
        $new->ir_id = $request->ir_id;
        $new->save();
        Alert::success('You\'ve Successfully Added A Member');
        return Redirect::back();
    }

    public function assginMemberDelete($id)
    {
        InformationEnrichmentTeam::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Member');
        return Redirect::back();

    }

    public function getList()
    {
        $data =[];
        $data['data'] = InformationEnrichmentTeam::where('user_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->get();
        return view('information_enrichment.index_dashboard',$data);
    }

    public function coiStatus($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = InformationEnrichmentTeam::where('id',$id)->first();
        $data['offence_details'] = CompalintEveOffence::where('id',$data['details']->ir_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        return view('information_enrichment.coi',$data);
    }

    public function coiStatusUpdate(Request $request)
    {
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['coi_description'] = $request->coi_description;
        InformationEnrichmentTeam::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->route('information.enrichment.get.list.assigned');
    }

    public function iePlan($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = InformationEnrichmentTeam::where('id',$id)->first();
        $data['ir_id'] = $data['details']->ir_id;
        $data['offence_details'] = CompalintEveOffence::where('id',$data['details']->ir_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['data'] = IrPlan::where('user_id',auth()->user()->id)->where('ir_id',$data['ir_id'])->get();
        $data['data_two'] = IrFieldVisit::where('user_id',auth()->user()->id)->where('ir_id',$data['ir_id'])->get();
        return view('information_enrichment.ie_plan',$data);
    }

    public function updateFinalReport(Request $request)
    {
        $upd = [];
        $upd['ie_report_remakrs'] = $request->ie_report_remakrs;
        if (@$request->ie_report_attachment) {
            $file = @$request->ie_report_attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/information_enrichment/',$filename);
            $upd['ie_report_attachment'] = $filename;
        }
        CompalintEveOffence::where('id',$request->ie_id)->update($upd);
        Alert::success('Report submitted successfully');
        return redirect()->back();
    }

    public function iePlanInsert(Request $request)
    {
        $new = new IrPlan;
        $new->activity = $request->activity;
        $new->person_contact = $request->person_contact;
        $new->document_review = $request->document_review;
        $new->start_date = $request->start_date;
        $new->status = $request->status;
        if (@$request->status=="COM") {
            $new->end_date = date('Y-m-d');
        }
        $new->ir_id = $request->ir_id;
        $new->user_id = auth()->user()->id;
        $new->save();
        Alert::success('You\'ve Successfully Added A IE Plan');
        return Redirect::back();
    }

    public function iePlanupdate(Request $request)
    {
        $check = IrPlan::where('id',$request->id)->first();
        IrPlan::where('id',$request->id)->update([
            'activity'=>$request->activity,
            'person_contact'=>$request->person_contact,
            'document_review'=>$request->document_review,
            'start_date'=>$request->start_date,
            'status'=>$request->status,
         ]);

        if ($check->status!="COM" && @$request->status=="COM") {
            IrPlan::where('id',$request->id)->update(['end_date'=>date('Y-m-d')]);
        }
        Alert::success('You\'ve Successfully Updated A IE Plan');
        return Redirect::back();
    }

    public function feildPlanInsert(Request $request)
    {
        $new = new IrFieldVisit;
        $new->activity = $request->activity;
        $new->start_date = $request->start_date;
        $new->location = $request->location;
        $new->status = $request->status;
        if (@$request->status=="COM") {
            $new->end_date = date('Y-m-d');
        }
        $new->ir_id = $request->ir_id;
        $new->user_id = auth()->user()->id;
        $new->save();
        Alert::success('You\'ve Successfully Added Data');
        return Redirect::back();
    }

    public function feildPlanupdate(Request $request)
    {
        $check = IrFieldVisit::where('id',$request->id)->first();
        IrFieldVisit::where('id',$request->id)->update([
            'activity'=>$request->activity,
            'location'=>$request->location,
            'start_date'=>$request->start_date,
            'status'=>$request->status,
         ]);

        if ($check->status!="COM" && @$request->status=="COM") {
            IrFieldVisit::where('id',$request->id)->update(['end_date'=>date('Y-m-d')]);
        }
        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }

    public function iePlandelete($id)
    {
        IrPlan::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted Data');
        return Redirect::back();
    }

    public function feildPlandelete($id)
    {
        IrFieldVisit::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted Data');
        return Redirect::back();
    }


    public function iePlanUpdatePage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = IrPlan::where('id',$id)->first();
        $data['person'] = IePersonContact::where('ie_plan_id',$id)->where('type','P')->where('user_id',auth()->user()->id)->get();
        $data['document'] = IePersonContact::where('ie_plan_id',$id)->where('type','D')->where('user_id',auth()->user()->id)->get();
        return view('information_enrichment.ie_plan_update',$data);
    }

    public function iePlaninsertPersonContact(Request $request)
    {
        $new = new IePersonContact;
        $new->ie_plan_id = $request->id;
        $new->user_id = auth()->user()->id;
        $new->name = $request->name;
        $new->designation = $request->designation;
        $new->contact = $request->contact;
        $new->save();
        Alert::success('You\'ve Successfully Inserted Data');
        return Redirect::back();
    }

    public function iePlanupdatePersonContact(Request $request)
    {
        IePersonContact::where('id',$request->id)->update([
            'name'=>$request->name,
            'designation'=>$request->designation,
            'contact'=>$request->contact,
        ]);
        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }


    public function iePlandeletePersonContact($id)
    {
        IePersonContact::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted Data');
        return Redirect::back();
    }


    public function iePlaninsertdocumentContact(Request $request)
    {
        $new = new IePersonContact;
        $new->ie_plan_id = $request->id;
        $new->user_id = auth()->user()->id;
        $new->document_name = $request->document_name;
        $new->document_description = $request->document_description;
        $new->type = 'D';
        if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/ie_attachment/',$filename);
            $new->attachment = $filename;
        }
        $new->save();
        Alert::success('You\'ve Successfully Inserted Data');
        return Redirect::back();
    }



    public function iePlanupdatedocumentContact(Request $request)
    {
        IePersonContact::where('id',$request->id)->update([
            'document_name'=>$request->document_name,
            'document_description'=>$request->document_description,
        ]);

        if (@$request->hasFile('attachment')) {
            $upd = [];
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/ie_attachment/',$filename);
            $upd['attachment'] = $filename;
            IePersonContact::where('id',$request->id)->update($upd);
        }

        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }

    public function fieldPlanUpdatePage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = IrFieldVisit::where('id',$id)->first();
        $data['person'] = IeFieldPersonDocument::where('ie_field_id',$id)->where('type','P')->where('user_id',auth()->user()->id)->get();
        $data['document'] = IeFieldPersonDocument::where('ie_field_id',$id)->where('type','D')->where('user_id',auth()->user()->id)->get();
        return view('information_enrichment.ie_field_update',$data);
    }

    public function fieldPlaninsertPersonContact(Request $request)
    {
        $new = new IeFieldPersonDocument;
        $new->ie_field_id = $request->id;
        $new->user_id = auth()->user()->id;
        $new->name = $request->name;
        $new->designation = $request->designation;
        $new->contact = $request->contact;
        $new->save();
        Alert::success('You\'ve Successfully Inserted Data');
        return Redirect::back();
    }

    public function fieldPlanupdatePersonContact(Request $request)
    {
        IeFieldPersonDocument::where('id',$request->id)->update([
            'name'=>$request->name,
            'designation'=>$request->designation,
            'contact'=>$request->contact,
        ]);
        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }


    public function fieldPlandeletePersonContact($id)
    {
        IeFieldPersonDocument::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted Data');
        return Redirect::back();
    }



    public function fieldPlaninsertdocumentContact(Request $request)
    {
        $new = new IeFieldPersonDocument;
        $new->ie_field_id = $request->id;
        $new->user_id = auth()->user()->id;
        $new->document_name = $request->document_name;
        $new->document_description = $request->document_description;
        $new->type = 'D';
        if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/ie_attachment/',$filename);
            $new->attachment = $filename;
        }
        $new->save();
        Alert::success('You\'ve Successfully Inserted Data');
        return Redirect::back();
    }



    public function fieldPlanupdatedocumentContact(Request $request)
    {
        IePersonContact::where('id',$request->id)->update([
            'document_name'=>$request->document_name,
            'document_description'=>$request->document_description,
        ]);

        if (@$request->hasFile('attachment')) {
            $upd = [];
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/ie_attachment/',$filename);
            $upd['attachment'] = $filename;
            IePersonContact::where('id',$request->id)->update($upd);
        }

        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }

    public function iePlanfullUpdate(Request $request)
    {
        $upd = [];
        $upd['start_date'] = $request->start_date;
        $upd['status'] = $request->status;
        $upd['end_date'] = $request->end_date;
        $upd['remarks'] = $request->remarks;
        $upd['end_date'] = $request->end_date;
        IrPlan::where('id',$request->id)->update($upd);
        // $check = IrPlan::where('id',$request->id)->first();
        // if ($check->status!="COM" && @$request->status=="COM") {
        //     IrPlan::where('id',$request->id)->update(['end_date'=>date('Y-m-d')]);
        // }
        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }

    public function feildPlanfullUpdate(Request $request)
    {
        $upd = [];
        $upd['start_date'] = $request->start_date;
        $upd['status'] = $request->status;
        $upd['end_date'] = $request->end_date;
        $upd['remarks'] = $request->remarks;
        $upd['end_date'] = $request->end_date;
        IrFieldVisit::where('id',$request->id)->update($upd);
        // $check = IrFieldVisit::where('id',$request->id)->first();
        // if ($check->status!="COM" && @$request->status=="COM") {
        //     IrFieldVisit::where('id',$request->id)->update(['end_date'=>date('Y-m-d')]);
        // }
        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }

    public function ceccomUserListView($type,$id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = IEceccommember::where('id',$id)->first();
        $data['offence_details'] = CompalintEveOffence::where('id',$data['details']->ie_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['information'] = AdditionalInformationEvaluation::where('complaint_id',$data['offence_details']->complaint_id)->where('status','A')->get();
        $data['data'] = IrPlan::where('ir_id',$data['details']->ie_id)->get();
        $data['data_two'] = IrFieldVisit::where('ir_id',$data['details']->ie_id)->get();
        return view('information_enrichment.cec_com_view',$data);
    }
}
