<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\complaintRegistrationModel;
use App\Models\Complaint\complaintReceivedByModel;
use App\Models\Complaint\ComplaintAssignUser;
use App\Models\Complaint\RegionalOffice;
use App\Models\User;
use Alert;
use App\Models\Complaint\Attachment;
use DB;
use App\Models\Complaint\linkComplaintPersonModel;
use App\Models\Complaint\personModel;
use App\Models\Complaint\GenderModel;
use App\Models\Complaint\personCategoryModel;
use App\Models\Complaint\link_Repeated_Complaint;
use App\Models\Complaint\ConflictRejection;
use App\Models\Complaint\Scoring;
use App\Models\UserToRole;
use App\Models\RolePermission;
use App\Models\AdditionalInformationEvaluation;
use App\Models\EvaluationMeetingPerson;
use App\Models\FinanceImplicationDetails;
use App\Models\Complaint\NaturalResource;
use App\Models\Complaint\PolicyComplaint;
use App\Models\Complaint\Political;
use App\Models\Complaint\Personnel;
use App\Models\Complaint\ProcurementGoodService;
use App\Models\Complaint\ProcurementGoods;
use App\Models\Complaint\LandDetails;
use App\Models\DirectorDecision;
class DecisionController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = complaintRegistrationModel::where('outcome_status','!=',null)->get();
        return view('director_case.index',$data);
    }

    public function viewDetails($id)
    {
        $data = [];
        $data['data'] = complaintRegistrationModel::where('complaintID',$id)->first();
        $data['id'] = $id;
        $data['received_users'] = complaintReceivedByModel::where('complaintID',$id)->get();
        $data['user'] = User::get();
        $data['regional_office'] = RegionalOffice::get();
        $data['assignUsers'] = ComplaintAssignUser::where('complaint_id',$id)->pluck('user_id')->toArray();
        $data['information'] = AdditionalInformationEvaluation::where('complaint_id',$id)->where('status','A')->get();
        $data['members'] = EvaluationMeetingPerson::where('complaint_id',$id)->where('type','cec')->get();
        $data['commision_members'] = EvaluationMeetingPerson::where('complaint_id',$id)->where('type','com')->get();
        $data['score'] = Scoring::where('complaint_id',$id)->where('type','system')->first();
        $data['sum'] = EvaluationMeetingPerson::where('complaint_id',$id)->where('type','cec')->sum('scoring');
        $data['count_member'] = EvaluationMeetingPerson::where('complaint_id',$id)->where('type','cec')->count();
        $data['director_decision'] = DirectorDecision::where('user_id',auth()->user()->id)->where('complaint_id',$id)->first();
        return view('director_case.view',$data);
    }

    public function decision(Request $request)
    {
        $check = DirectorDecision::where('user_id',auth()->user()->id)->where('complaint_id',$request->compalint_id)->first();
        if (@$check=="") {
            $new  = new DirectorDecision;
            $new->user_id = auth()->user()->id;
            $new->complaint_id = $request->compalint_id;
            $new->decision = $request->director_decision;
            $new->save();
            Alert::success('Decision made successfully');
            return redirect()->back();
        }else{
            DirectorDecision::where('user_id',auth()->user()->id)->where('complaint_id',$request->compalint_id)->update([
                'decision'=>$request->director_decision,
            ]);
            Alert::success('Decision updated successfully');
            return redirect()->back();
        }
    }


    public function caseDetailsAttachment($id)
    {
        $data = [];
        $data['data'] = Attachment::where('complaintID',$id)->get();
        $data['id'] = $id;
        
        return view('director_case.attachment',$data);
    }


    public function caseDetailsPerson($id)
    {
       $data = [];
        $data['person'] =   DB::table('cr_linkcomplaint_person_category')
            ->LeftJoin('tblperson', 'cr_linkcomplaint_person_category.personID', '=', 'tblperson.personID')
            ->LeftJoin('cr_pltblpersoncategory', 'cr_pltblpersoncategory.personCategoryID', '=', 'cr_linkcomplaint_person_category.personCatID')
            ->LeftJoin('cr_tblcomplaintregistration', 'cr_linkcomplaint_person_category.complaintID', '=', 'cr_tblcomplaintregistration.complaintID')
            ->select('tblperson.personID', 'tblperson.fname', 'tblperson.mname', 'tblperson.lname', 'tblperson.cid', 'tblperson.otherIdentificationNo', 'cr_pltblpersoncategory.categoryName')
            ->where(['cr_linkcomplaint_person_category.complaintID' => $id, 'tblperson.isDelete' => 0])
            ->get();
            $data['id'] = $id;
        return view('director_case.person_involved',$data);
    }

    public function caseDetailsLink($id)
    {
        $data = [];
        $data['person_involved'] = link_Repeated_Complaint::where('newComplaintID',$id)->where('isDelete','0')->with('repeatedComplaint_registrationRelation','repeatedComplaint_registrationRelation.complaintmoderelation','repeatedComplaint_registrationRelation.complaintTyperelation')->get();
        $data['id'] = $id;
        return view('director_case.case_link',$data);
    }


    public function financialImplication($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = complaintRegistrationModel::where('complaintID',$id)->first();
        $data['finance'] = FinanceImplicationDetails::where('complaint_id',$id)->first();
        $data['LandDetails'] = LandDetails::where('complaint_id',$id)->get();
        $data['NaturalResource'] = NaturalResource::where('complaint_id',$id)->get();
        $data['PolicyComplaint'] = PolicyComplaint::where('complaint_id',$id)->get();
        $data['Political'] = Political::where('complaint_id',$id)->get();
        $data['Personnel'] = Personnel::where('complaint_id',$id)->get();
        $data['ProcurementGoodService'] = ProcurementGoodService::where('complaint_id',$id)->get();
        $data['ProcurementGoods'] = ProcurementGoods::where('complaint_id',$id)->get();
        return view('director_case.financial_implication',$data);

    }

    public function socialImplication($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = complaintRegistrationModel::where('complaintID',$id)->first();
        return view('director_case.social_implication',$data);
    }
}
