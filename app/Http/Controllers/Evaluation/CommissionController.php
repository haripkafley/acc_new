<?php

namespace App\Http\Controllers\Evaluation;

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
use App\Models\EvaluationReviewTeam;
use App\Models\UserToRole;
use App\Models\RolePermission;
use App\Models\Appraise;
use App\Models\Complaint\CompalintEveOffence;
class CommissionController extends Controller
{
    // public function __construct(){      
    //     $this->middleware(function ($request, $next) {      
            


            
    //         return $next($request);
    //     });
    // }


    public function listing()
    {
            $user_id = auth()->user()->id;
            $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
            $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',14)->where('view_option','Y')->where('is_delete',0)->first();
            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

            }


        $data = [];
        $data['data'] = EvaluationMeetingPerson::where('member_id',auth()->user()->id)->where('type','com')->where('coi_status','!=','Y')->get();
        return view('com_cases.index',$data);
    }

    public function coi($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = EvaluationMeetingPerson::where('id',$id)->first();
        $data['person'] =   DB::table('cr_linkcomplaint_person_category')->where('personCatID',1)
            ->LeftJoin('tblperson', 'cr_linkcomplaint_person_category.personID', '=', 'tblperson.personID')
            ->LeftJoin('cr_pltblpersoncategory', 'cr_pltblpersoncategory.personCategoryID', '=', 'cr_linkcomplaint_person_category.personCatID')
            ->LeftJoin('cr_tblcomplaintregistration', 'cr_linkcomplaint_person_category.complaintID', '=', 'cr_tblcomplaintregistration.complaintID')
            ->select('tblperson.personID', 'tblperson.fname', 'tblperson.mname', 'tblperson.lname', 'tblperson.cid', 'tblperson.otherIdentificationNo', 'cr_pltblpersoncategory.categoryName')
            ->where(['cr_linkcomplaint_person_category.complaintID' => $data['data']->complaint_id, 'tblperson.isDelete' => 0])
            ->get();
        return view('com_cases.coi',$data);
    }

    public function coiDesicion(Request $request)
    {
       
        EvaluationMeetingPerson::where('id',$request->id)->update([
            'coi_status'=>$request->evaluation,
            'describe_coi'=>$request->describe,
        ]);
        Alert::success('Details updated successfully');
        return redirect()->route('commision.cases.list');
    }


    public function caseDetails($id)
    {
        $data = [];
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['data'] = complaintRegistrationModel::where('complaintID',$details->complaint_id)->first();
        $data['id'] = $id;
        $data['received_users'] = complaintReceivedByModel::where('complaintID',$details->complaint_id)->get();
        $data['information'] = AdditionalInformationEvaluation::where('complaint_id',$details->complaint_id)->where('status','A')->get();
        $data['members'] = EvaluationMeetingPerson::where('complaint_id',$details->complaint_id)->where('type','cec')->get();
        $data['commision_members'] = EvaluationMeetingPerson::where('complaint_id',$details->complaint_id)->where('type','com')->get();
        $data['score'] = Scoring::where('complaint_id',$details->complaint_id)->where('type','system')->first();
        $data['given_score'] = EvaluationMeetingPerson::where('complaint_id',$details->complaint_id)->where('member_id',auth()->user()->id)->first();
        return view('com_cases.details',$data);
    }


    public function caseDetailsAttachment($id)
    {
        $data = [];
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['data'] = Attachment::where('complaintID',$details->complaint_id)->get();
        $data['id'] = $id;
        return view('com_cases.attachment',$data);
    }

    public function caseDetailsPerson($id)
    {
        $data = [];
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['person'] =   DB::table('cr_linkcomplaint_person_category')
            ->LeftJoin('tblperson', 'cr_linkcomplaint_person_category.personID', '=', 'tblperson.personID')
            ->LeftJoin('cr_pltblpersoncategory', 'cr_pltblpersoncategory.personCategoryID', '=', 'cr_linkcomplaint_person_category.personCatID')
            ->LeftJoin('cr_tblcomplaintregistration', 'cr_linkcomplaint_person_category.complaintID', '=', 'cr_tblcomplaintregistration.complaintID')
            ->select('tblperson.personID', 'tblperson.fname', 'tblperson.mname', 'tblperson.lname', 'tblperson.cid', 'tblperson.otherIdentificationNo', 'cr_pltblpersoncategory.categoryName')
            ->where(['cr_linkcomplaint_person_category.complaintID' =>$details->complaint_id, 'tblperson.isDelete' => 0])
            ->get();
            $data['id'] = $id;
        return view('com_cases.person_involved',$data);
    }


    public function caseDetailsLink($id)
    {
        $data = [];
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['person_involved'] = link_Repeated_Complaint::where('newComplaintID',$details->complaint_id)->where('isDelete','0')->with('repeatedComplaint_registrationRelation','repeatedComplaint_registrationRelation.complaintmoderelation','repeatedComplaint_registrationRelation.complaintTyperelation')->get();
        $data['id'] = $id;
        return view('com_cases.case_link',$data);
    }


    public function financialImplication($id)
    {
        $data = [];
        $data['id'] = $id;
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['data'] = complaintRegistrationModel::where('complaintID',$details->complaint_id)->first();
        $data['finance'] = FinanceImplicationDetails::where('complaint_id',$details->complaint_id)->first();
        $data['LandDetails'] = LandDetails::where('complaint_id',$details->complaint_id)->get();
        $data['NaturalResource'] = NaturalResource::where('complaint_id',$details->complaint_id)->get();
        $data['PolicyComplaint'] = PolicyComplaint::where('complaint_id',$details->complaint_id)->get();
        $data['Political'] = Political::where('complaint_id',$details->complaint_id)->get();
        $data['Personnel'] = Personnel::where('complaint_id',$details->complaint_id)->get();
        $data['ProcurementGoodService'] = ProcurementGoodService::where('complaint_id',$details->complaint_id)->get();
        $data['ProcurementGoods'] = ProcurementGoods::where('complaint_id',$details->complaint_id)->get();
        return view('com_cases.financial_implication',$data);

    }


    public function socialImplication($id)
    {
        $data = [];
        $data['id'] = $id;
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['data'] = complaintRegistrationModel::where('complaintID',$details->complaint_id)->first();
        return view('com_cases.social_implication',$data);
    }


    public function assignTeam($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['offence_details'] = CompalintEveOffence::where('id',$id)->first();
        $data['data'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['members'] = EvaluationReviewTeam::where('eve_offence_id',$id)->get();
        $data['appaise'] = Appraise::where('eve_offence_id',$id)->first();
        return view('evaluation.review',$data);
    }

    public function insertTeam(Request $request)
    {
        $user = User::where('eid',$request->eid)->first();
        $new  = new EvaluationReviewTeam;
        $new->user_id = $user->id;
        $new->eve_offence_id = $request->complaint_id;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('Person added successfully');
        return redirect()->back();
    }

    public function deleteTeam($id)
    {
        EvaluationReviewTeam::where('id',$id)->delete();
        Alert::success('Person deleted successfully');
        return redirect()->back();
    }
}
