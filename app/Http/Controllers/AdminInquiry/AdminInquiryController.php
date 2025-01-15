<?php

namespace App\Http\Controllers\AdminInquiry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appraise;
use App\Models\User;
use App\Models\Complaint\AdministrativeOfficialTeam;
use App\Models\Complaint\AdministrativeDeskReview;
use App\Models\Complaint\AdministrativeFeildVisit;
use App\Models\Complaint\DeskReviewContact;
use App\Models\Complaint\AdministrativeFeildPersonContact;
use App\Models\Complaint\AdminInquiryRoom;
use App\Models\Complaint\AdminInquiryCommittee;
use App\Models\Complaint\CompalintEveOffence;
use App\Models\Complaint\CecComCrud;
use App\Models\Complaint\MonitoryFine;
use App\Models\Complaint\RecoveryModel;
use Redirect;
use Session;
use Alert;
class AdminInquiryController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = Appraise::get();
        return view('administrative_inquiry.chief_list',$data);
    }

    public function addOfficials($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['complaint'] = Appraise::where('id',$id)->first();
        $data['users'] = User::get();
        $data['team'] = AdministrativeOfficialTeam::where('appraise_id',$id)->get();
        return view('administrative_inquiry.team_official',$data);
    }

    public function addOfficialsInsert(Request $request)
    {
        $new = new AdministrativeOfficialTeam;
        $new->user_id = $request->user_id;
        $new->role = $request->role;
        $new->appraise_id = $request->appraise_id;
        $new->save();
        Alert::success('You\'ve Successfully Added A Member');
        return Redirect::back();
    }

    public function addOfficialsdelete($id)
    {
        AdministrativeOfficialTeam::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Member');
        return Redirect::back();
    }

    public function viewDetailsChief($id)
    {
        $data = [];
        $data['appraise_id'] = $id;
        $data['appraisal_details'] = Appraise::where('id',$id)->first();
        $data['data_one'] = AdministrativeDeskReview::where('user_id',auth()->user()->id)->where('appraise_id',$data['appraise_id'])->get();
        $data['data_two'] = AdministrativeFeildVisit::where('user_id',auth()->user()->id)->where('appraise_id',$data['appraise_id'])->get();
        $user_ids = AdminInquiryCommittee::where('status','A')->pluck('user_id')->toArray();
        $com_users = CecComCrud::where('user_type','COM')->where('status','A')->pluck('user_id')->toArray();
        $data['com_user_dropdown'] = User::whereIn('id',$com_users)->get();
        $data['committee_dropdown'] = User::whereIn('id',$user_ids)->get();
        $data['user_dropdown'] = User::where('status','A')->get();
        $data['com_members'] = AdminInquiryRoom::where('appraise_id',$id)->where('type','com')->get();
        $data['members'] = AdminInquiryRoom::where('appraise_id',$id)->where('type','admin')->get();
        $data['member_no_coi'] = AdminInquiryRoom::where('appraise_id',$id)->where('coi_status','N')->where('type','admin')->count();
        $data['members_com_approve'] = AdminInquiryRoom::where('appraise_id',$id)->where('type','com')->where('coi_status','N')->count();
        return view('administrative_inquiry.view_chief',$data);
    }

    public function updateInquiryMeetinDecision(Request $request)
    {
        $upd = [];
        $upd['inquiry_meeting_date'] = $request->inquiry_meeting_date;
        $upd['inquiry_meeting_time'] = $request->inquiry_meeting_time;
        $upd['inquiry_meeting_venue'] = $request->inquiry_meeting_venue;
        $upd['inquiry_decision'] = $request->inquiry_decision;
        $upd['inquiry_remakrs'] = $request->inquiry_remakrs;
        Appraise::where('id',$request->appraise_id)->update($upd);
        Alert::success('You\'ve Successfully Updated A Report');
        return Redirect::back();
    }

    public function updateCommissionMeetinDecision(Request $request)
    {
        $details = Appraise::where('id',$request->appraise_id)->first();
        $allegation_details = CompalintEveOffence::where('id',$details->eve_offence_id)->first();
        $upd = [];
        $upd['inquiry_com_date'] = $request->inquiry_com_date;
        $upd['inquiry_com_time'] = $request->inquiry_com_time;
        $upd['inquiry_com_venue'] = $request->inquiry_com_venue;
        $upd['inquiry_com_status'] = $request->inquiry_com_status;
        $upd['inquiry_com_decision'] = $request->inquiry_com_decision;
        $upd['inquiry_com_remarks'] = $request->inquiry_com_remarks;
        if (@$request->inquiry_com_status=="ECD") {
            if ($details->inquiry_decision=="MF") {
                $mf_fine = new MonitoryFine;
                $mf_fine->complaint_id = $allegation_details->complaint_id;
                $mf_fine->offence_allegation = $details->eve_offence_id;
                $mf_fine->save();
            }
            if ($details->inquiry_decision=="REC") {
                $recovery = new RecoveryModel;
                $recovery->complaint_id = $allegation_details->complaint_id;
                $recovery->offence_allegation = $details->eve_offence_id;
                $recovery->save();
            }
            $upd['inquiry_com_decision'] = $details->inquiry_decision;
        }else{
            if ($request->inquiry_com_decision=="MF") {
                $mf_fine = new MonitoryFine;
                $mf_fine->complaint_id = $allegation_details->complaint_id;
                $mf_fine->offence_allegation = $details->eve_offence_id;
                $mf_fine->save();
            }
            if ($request->inquiry_com_decision=="REC") {
                $recovery = new RecoveryModel;
                $recovery->complaint_id = $allegation_details->complaint_id;
                $recovery->offence_allegation = $details->eve_offence_id;
                $recovery->save();
            }
            $upd['inquiry_com_decision'] = $request->inquiry_com_decision;
        }
        Appraise::where('id',$request->appraise_id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function insertInquiryMember(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        $new = new AdminInquiryRoom;
        $new->eid = $user->eid;
        $new->role = $request->role;
        $new->appraise_id = $request->appraise_id;
        $new->member_id = $user->id;
        $new->assign_member_id = auth()->user()->id;
        $new->remarks = $request->remarks;
        $new->type = $request->type;
        $new->save();
        Alert::success('Person added successfully');
        return redirect()->back();
    }

    public function updateInquiryMember(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        AdminInquiryRoom::where('id',$request->member_id)->update([
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

    public function deleteInquiryMember($id)
    {
        AdminInquiryRoom::where('id',$id)->delete();
        Alert::success('Person deleted successfully');
        return redirect()->back();
    }

    public function updateReportChief(Request $request)
    {
        $upd = [];
        $upd['admin_approval_status_chief'] = $request->admin_approval_status_chief;
        $upd['admin_approval_remarks_chief'] = $request->admin_approval_remarks_chief;
        Appraise::where('id',$request->appraise_id)->update($upd);
        Alert::success('You\'ve Successfully Updated A Report');
        return Redirect::back();
    }

    public function deskReviewViewChief($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = AdministrativeDeskReview::where('id',$id)->first();
        $data['person'] = DeskReviewContact::where('desk_review_id',$id)->where('type','P')->get();
        $data['document'] = DeskReviewContact::where('desk_review_id',$id)->where('type','D')->get();
        return view('administrative_inquiry.desk_review_chief',$data);
    }

    public function feildVisitViewChief($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = AdministrativeFeildVisit::where('id',$id)->first();
        $data['person'] = AdministrativeFeildPersonContact::where('feild_id',$id)->where('type','P')->get();
        $data['document'] = AdministrativeFeildPersonContact::where('feild_id',$id)->where('type','D')->get();
        return view('administrative_inquiry.feild_review_chief',$data);
    }

    public function getList()
    {
        $data = [];
        $data['data'] = AdministrativeOfficialTeam::whereIn('coi_status',['AA','N'])->where('user_id',auth()->user()->id)->get();
        return view('administrative_inquiry.official_list',$data);
    }

    public function getListCoiPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = AdministrativeOfficialTeam::where('id',$id)->first();
        return view('administrative_inquiry.official_list_coi',$data);
    }

    public function getListCoiPageUpdateDecision(Request $request)
    {
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['coi_description'] = $request->coi_description;
        AdministrativeOfficialTeam::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->route('administrative.inquiry.plan.official.get.list');
    }

    public function officialView($id)
    {

        $data = [];
        $data['id'] = $id;
        $data['data'] = AdministrativeOfficialTeam::where('id',$id)->first();
        $data['appraise_id'] = $data['data']->appraise_id;
        $data['appraisal_details'] = Appraise::where('id',$data['data']->appraise_id)->first();
        $data['data_one'] = AdministrativeDeskReview::where('user_id',auth()->user()->id)->where('appraise_id',$data['appraise_id'])->get();
        $data['data_two'] = AdministrativeFeildVisit::where('user_id',auth()->user()->id)->where('appraise_id',$data['appraise_id'])->get();
        return view('administrative_inquiry.view_official',$data);
    }

    public function updateReportSubmission(Request $request)
    {
        $upd = [];
        $upd['admin_report_remarks'] = $request->admin_report_remarks;
        if (@$request->admin_report_attachment) {
            $file = @$request->admin_report_attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/information_enrichment/',$filename);
            $upd['admin_report_attachment'] = $filename;
        }
        Appraise::where('id',$request->appraise_id)->update($upd);
        Alert::success('Report submitted successfully');
        return redirect()->back();
    }

    public function insertDeskReview(Request $request)
    {
        $new = new AdministrativeDeskReview;
        $new->activity = $request->activity;
        $new->person_contact = $request->person_contact;
        $new->document_review = $request->document_review;
        $new->start_date = $request->start_date;
        $new->status = $request->status;
        if (@$request->status=="COM") {
            $new->end_date = date('Y-m-d');
        }
        $new->appraise_id = $request->appraise_id;
        $new->user_id = auth()->user()->id;
        $new->save();
        Alert::success('You\'ve Successfully Added A Desk Review');
        return Redirect::back();
    }

    public function updateDeskReview(Request $request)
    {
        $check = AdministrativeDeskReview::where('id',$request->id)->first();
        AdministrativeDeskReview::where('id',$request->id)->update([
            'activity'=>$request->activity,
            'person_contact'=>$request->person_contact,
            'document_review'=>$request->document_review,
            'start_date'=>$request->start_date,
            'status'=>$request->status,
         ]);

        if ($check->status!="COM" && @$request->status=="COM") {
            AdministrativeDeskReview::where('id',$request->id)->update(['end_date'=>date('Y-m-d')]);
        }
        Alert::success('You\'ve Successfully Updated A Desk Review');
        return Redirect::back();
    }

    public function deleteDeskReview($id)
    {
        AdministrativeDeskReview::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted Data');
        return Redirect::back();
    }

    public function insertFeildVisit(Request $request)
    {
        $new = new AdministrativeFeildVisit;
        $new->activity = $request->activity;
        $new->start_date = $request->start_date;
        $new->location = $request->location;
        $new->status = $request->status;
        if (@$request->status=="COM") {
            $new->end_date = date('Y-m-d');
        }
        $new->appraise_id = $request->appraise_id;
        $new->user_id = auth()->user()->id;
        $new->save();
        Alert::success('You\'ve Successfully Added Data');
        return Redirect::back();
    }

    public function updateFeildVisit(Request $request)
    {
        $check = AdministrativeFeildVisit::where('id',$request->id)->first();
        AdministrativeFeildVisit::where('id',$request->id)->update([
            'activity'=>$request->activity,
            'location'=>$request->location,
            'start_date'=>$request->start_date,
            'status'=>$request->status,
         ]);

        if ($check->status!="COM" && @$request->status=="COM") {
            AdministrativeFeildVisit::where('id',$request->id)->update(['end_date'=>date('Y-m-d')]);
        }
        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }

    public function deleteFeildVisit($id)
    {
        AdministrativeFeildVisit::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted Data');
        return Redirect::back();
    }

    public function viewDeskReviewUpdate($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = AdministrativeDeskReview::where('id',$id)->first();
        $data['person'] = DeskReviewContact::where('desk_review_id',$id)->where('type','P')->where('user_id',auth()->user()->id)->get();
        $data['document'] = DeskReviewContact::where('desk_review_id',$id)->where('type','D')->where('user_id',auth()->user()->id)->get();
        return view('administrative_inquiry.desk_review_update',$data);
    }

    public function viewDeskReviewInsertPerContact(Request $request)
    {
        $new = new DeskReviewContact;
        $new->desk_review_id = $request->id;
        $new->user_id = auth()->user()->id;
        $new->name = $request->name;
        $new->designation = $request->designation;
        $new->contact = $request->contact;
        $new->save();
        Alert::success('You\'ve Successfully Inserted Data');
        return Redirect::back();
    }

    public function viewDeskReviewupdatePerContact(Request $request)
    {

        DeskReviewContact::where('id',$request->id)->update([
            'name'=>$request->name,
            'designation'=>$request->designation,
            'contact'=>$request->contact,
        ]);
        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }

    public function viewDeskReviewdeletePerContact($id)
    {
        DeskReviewContact::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted Data');
        return Redirect::back();
    }

    public function viewDeskReviewInsertDocument(Request $request)
    {
        $new = new DeskReviewContact;
        $new->desk_review_id = $request->id;
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

    public function viewDeskReviewdeleteDocument(Request $request)
    {
        DeskReviewContact::where('id',$request->id)->update([
            'document_name'=>$request->document_name,
            'document_description'=>$request->document_description,
        ]);

        if (@$request->hasFile('attachment')) {
            $upd = [];
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/ie_attachment/',$filename);
            $upd['attachment'] = $filename;
            DeskReviewContact::where('id',$request->id)->update($upd);
        }

        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }

    public function viewDeskReviewFullUpdate(Request $request)
    {
        $upd = [];
        $upd['start_date'] = $request->start_date;
        $upd['status'] = $request->status;
        $upd['end_date'] = $request->end_date;
        $upd['remarks'] = $request->remarks;
        $upd['end_date'] = $request->end_date;
        AdministrativeDeskReview::where('id',$request->id)->update($upd);
        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }

    public function viewFeildPageUpdate($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = AdministrativeFeildVisit::where('id',$id)->first();
        $data['person'] = AdministrativeFeildPersonContact::where('feild_id',$id)->where('type','P')->where('user_id',auth()->user()->id)->get();
        $data['document'] = AdministrativeFeildPersonContact::where('feild_id',$id)->where('type','D')->where('user_id',auth()->user()->id)->get();
        return view('administrative_inquiry.admin_field_update',$data);
    }

    public function viewFeildPageUpdateInsertPerson(Request $request)
    {
        $new = new AdministrativeFeildPersonContact;
        $new->feild_id = $request->id;
        $new->user_id = auth()->user()->id;
        $new->name = $request->name;
        $new->designation = $request->designation;
        $new->contact = $request->contact;
        $new->save();
        Alert::success('You\'ve Successfully Inserted Data');
        return Redirect::back();
    }

    public function viewFeildPageUpdateupdatePerson(Request $request)
    {
        AdministrativeFeildPersonContact::where('id',$request->id)->update([
            'name'=>$request->name,
            'designation'=>$request->designation,
            'contact'=>$request->contact,
        ]);
        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }

    public function viewFeildPagedeletedeletePerson($id)
    {
        AdministrativeFeildPersonContact::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted Data');
        return Redirect::back();
    }

    public function viewFeildPageUpdateInsertDocument(Request $request)
    {
        $new = new AdministrativeFeildPersonContact;
        $new->feild_id = $request->id;
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
    public function viewFeildPageUpdateupdateDocument(Request $request)
    {
        AdministrativeFeildPersonContact::where('id',$request->id)->update([
            'document_name'=>$request->document_name,
            'document_description'=>$request->document_description,
        ]);

        if (@$request->hasFile('attachment')) {
            $upd = [];
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/ie_attachment/',$filename);
            $upd['attachment'] = $filename;
            AdministrativeFeildPersonContact::where('id',$request->id)->update($upd);
        }

        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }

    public function viewFeildPgaeFullUpdate(Request $request)
    {
        $upd = [];
        $upd['start_date'] = $request->start_date;
        $upd['status'] = $request->status;
        $upd['end_date'] = $request->end_date;
        $upd['remarks'] = $request->remarks;
        $upd['end_date'] = $request->end_date;
        AdministrativeFeildVisit::where('id',$request->id)->update($upd);
        // $check = IrFieldVisit::where('id',$request->id)->first();
        // if ($check->status!="COM" && @$request->status=="COM") {
        //     IrFieldVisit::where('id',$request->id)->update(['end_date'=>date('Y-m-d')]);
        // }
        Alert::success('You\'ve Successfully Updated Data');
        return Redirect::back();
    }


    public function getCommitteList()
    {
        $data = [];
        $data['data'] = AdminInquiryRoom::whereIn('coi_status',['AA','N'])->where('type','admin')->where('member_id',auth()->user()->id)->get();
        return view('administrative_inquiry.administrative_inquiry_list',$data);
    }

    public function getCommitteListCoiPage($type,$id)
    {
        $data = [];
        $data['id'] = $id;
        $data['type'] = $type;
        $data['details'] = AdminInquiryRoom::where('id',$id)->where('member_id',auth()->user()->id)->first();
        if (@$data['details']=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data['data'] = Appraise::where('id',$data['details']->appraise_id)->first();
        return view('administrative_inquiry.administrative_inquiry_coi',$data);
    }

    public function getCommitteListCoiUpdate(Request $request)
    {
        $check = AdminInquiryRoom::where('id',$request->id)->first();
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['describe_coi'] = $request->coi_description;
        AdminInquiryRoom::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        if(@$request->type=="admin"){
            return redirect()->route('administrative.inquiry.committe.get.list.page');
        }else{
            return redirect()->route('administrative.commission.list.committe.get.list.page');
        }
        
    }

    public function viewDetailsPanel($type,$id)
    {
        $data = [];
        $data['data'] = AdminInquiryRoom::where('id',$id)->first();
        $data['appraisal_details'] = Appraise::where('id',$data['data']->appraise_id)->first();
        $data['data_one'] = AdministrativeDeskReview::where('appraise_id',$data['appraisal_details']->id)->get();
        $data['data_two'] = AdministrativeFeildVisit::where('appraise_id',$data['appraisal_details']->id)->get();
        return view('administrative_inquiry.administrative_inquiry_view',$data);
    }

    public function getCommissionList()
    {
        $data = [];
        $data['data'] = AdminInquiryRoom::whereIn('coi_status',['AA','N'])->where('type','com')->where('member_id',auth()->user()->id)->get();
        return view('administrative_inquiry.administrative_inquiry_commission',$data);
    }
}
