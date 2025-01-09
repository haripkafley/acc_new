<?php

namespace App\Http\Controllers\Evaluation;

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
use App\Models\Complaint\CecComCrud;
use App\Models\Complaint\OffenceEvaluation;
use App\Models\Complaint\CompalintEveOffence;
use App\Models\Complaint\CecComplaintRecommendation;
use App\Models\Ti\TackticalInteligence;
class EvaluationController extends Controller
{

    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',6)->where('view_option','Y')->where('is_delete',0)->first();
        if ($this->view_option=="") {
            Alert::error('You are not allowed to access this page');
           return redirect()->route('home');

        }


        
        return $next($request);
    });
  }


    public function index()
    {
        $data = [];
        $headquater = complaintRegistrationModel::where('headquater_user_id',auth()->user()->id)->where('assign_to','H')->pluck('complaintID')->toArray();
        $regional = complaintRegistrationModel::where('regional_user_id',auth()->user()->id)->where('assign_to','R')->pluck('complaintID')->toArray();
        $merge = array_merge($headquater,$regional);
        $data['data'] = complaintRegistrationModel::whereIn('complaintID',$merge)->where('evalution_coi','!=','Y')->get();
        return view('evaluation.list',$data);
    }

    public function coi($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = complaintRegistrationModel::where('complaintID',$id)->first();
        $data['person'] =   DB::table('cr_linkcomplaint_person_category')->where('personCatID',1)
            ->LeftJoin('tblperson', 'cr_linkcomplaint_person_category.personID', '=', 'tblperson.personID')
            ->LeftJoin('cr_pltblpersoncategory', 'cr_pltblpersoncategory.personCategoryID', '=', 'cr_linkcomplaint_person_category.personCatID')
            ->LeftJoin('cr_tblcomplaintregistration', 'cr_linkcomplaint_person_category.complaintID', '=', 'cr_tblcomplaintregistration.complaintID')
            ->select('tblperson.personID', 'tblperson.fname', 'tblperson.mname', 'tblperson.lname', 'tblperson.cid', 'tblperson.otherIdentificationNo', 'cr_pltblpersoncategory.categoryName')
            ->where(['cr_linkcomplaint_person_category.complaintID' => $id, 'tblperson.isDelete' => 0])
            ->get();
        return view('evaluation.conflict_view',$data);
    }

    public function postDecision(Request $request)
    {   
        $check = complaintRegistrationModel::where('complaintID',$request->complaintID)->first();
        if(@$request->evaluation=="Y"){
         if ($check->assign_to=="H") {
               complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
                'assign_status'=>'N',
                // 'headquater_user_id'=>'',
                'reason_change'=>'',
                'evalution_coi'=>'Y',
              ]); 
         }else{
            complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
                'regional_assign_status'=>'N',
                // 'regional_user_id'=>'',
                'regional_reason_change'=>'',
                'evalution_coi'=>'Y',
              ]); 
         }   
            
            $reject = new ConflictRejection;
            $reject->user_id = auth()->user()->id;
            $reject->complaint_id = $request->complaintID;
            $reject->description = $request->describe;
            $reject->save();
            Alert::success('Complaint Updated Successfully');
            return redirect()->route('complaint.evaluate.list');
        }else{

            complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
                'evaluation_status'=>'N',
                'evalution_coi'=>'N',
            ]);  
            Alert::success('Complaint Updated Successfully');
            return redirect()->route('complaint.evaluate.list');
        }
        
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
        $cec_users = CecComCrud::where('user_type','CEC')->where('status','A')->pluck('user_id')->toArray();
        $com_users = CecComCrud::where('user_type','COM')->where('status','A')->pluck('user_id')->toArray();
        $data['cec_user_dropdown'] = User::whereIn('id',$cec_users)->get();
        $data['com_user_dropdown'] = User::whereIn('id',$com_users)->get();

        $data['members_cec_approve'] = EvaluationMeetingPerson::where('complaint_id',$id)->where('type','cec')->where('coi_status','N')->count();
        $data['members_com_approve'] = EvaluationMeetingPerson::where('complaint_id',$id)->where('type','com')->where('coi_status','N')->count();

        $data['offence_list'] = OffenceEvaluation::get();
        $data['evalution_offence_list'] = CompalintEveOffence::where('type','OFF')->where('complaint_id',$id)->orderBy('id','desc')->get();
        $data['evalution_allegation_list'] = CompalintEveOffence::where('type','alle')->where('complaint_id',$id)->orderBy('id','desc')->get();

        return view('evaluation.view',$data);
    }

    public function pursuableUpdate(Request $request)
    {
        complaintRegistrationModel::where('complaintID',$request->complaint_id)->update([
            'pursuable_decision'=>$request->pursuable,
            'pursuable_remarks'=>$request->pursuable_remark,
        ]);
        Alert::success('Data Updated Successfully');
        return redirect()->back();
    }

    public function cecRecommendationUpdate(Request $request)
    {
        
        complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
            'cec_date'=>$request->cec_date,
            'cec_time'=>$request->cec_time,
            'cec_venue'=>$request->cec_venue,
         ]);

        foreach ($request->addmore as $key => $value) {
            $check = CompalintEveOffence::where('complaint_id',$request->complaintID)->where('id',$value['id'])->first();
            if (@$check=="") {
                $new = new CompalintEveOffence;
                $new->complaint_id = $request->complaintID;
                $new->decision = $value['decision'];
                $new->sub_decision   = $value['sub_decision'];
                $new->remarks   = $value['remarks'];
                $new->created_by   = auth()->user()->id;
                $new->save();
            }else{
                CompalintEveOffence::where('complaint_id',$request->complaintID)->where('id',$value['id'])->update([
                    'decision'=>$value['decision'],
                    'sub_decision'=>$value['sub_decision'],
                    'remarks'=>$value['remarks'],
                ]);
            }
        }

        Alert::success('Decision Updated Successfully');
        return redirect()->back();



    }

    public function addOffencePost(Request $request)
    {
        $check = CompalintEveOffence::where('complaint_id',$request->complaint_id)->where('offence_id',$request->offence)->first();
        if (@$check!="") {
            Alert::error('Offence already added');
            return redirect()->back();
        }
        $new = new CompalintEveOffence;
        $new->offence_id = $request->offence;
        $new->complaint_id = $request->complaint_id;
        $new->save();
        Alert::success('Offence added successfully');
        return redirect()->back();
    }

    public function deleteOffencePost($id)
    {
        CompalintEveOffence::where('id',$id)->delete();
        Alert::success('Offence deleted successfully');
        return redirect()->back();
    }

    public function finalDecision(Request $request)
    {
        if (@$request->outcome_status=="Share With Agencies") {
            $agency_outcome = @$request->agency_outcome;
        }else{
            $agency_outcome = '';
        }
        complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
            'outcome_status'=>$request->outcome_status,
            'agency_outcome'=>$agency_outcome,
            'final_remark'=>$request->final_remark,
            'cec_date'=>$request->cec_date,
            'cec_time'=>$request->cec_time,
            'cec_venue'=>$request->cec_venue,
         ]);

        $upd = [];
        if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/cec/',$filename);
            $upd['attachment'] = $filename;
        }
        complaintRegistrationModel::where('complaintID',$request->complaintID)->update($upd);
        Alert::success('Final Decision updated successfully');
        return redirect()->back();
    }


    public function viewDetailsAttachment($id)
    {
        $data = [];
        $data['data'] = Attachment::where('complaintID',$id)->get();
        $data['id'] = $id;
        return view('evaluation.attachment',$data);
    }

    public function viewDetailsPersonInvolved($id)
    {
        $data = [];
        $data['person'] =   DB::table('cr_linkcomplaint_person_category')
            ->LeftJoin('tblperson', 'cr_linkcomplaint_person_category.personID', '=', 'tblperson.personID')
            ->LeftJoin('cr_pltblpersoncategory', 'cr_pltblpersoncategory.personCategoryID', '=', 'cr_linkcomplaint_person_category.personCatID')
            ->LeftJoin('cr_tblcomplaintregistration', 'cr_linkcomplaint_person_category.complaintID', '=', 'cr_tblcomplaintregistration.complaintID')
            ->select('tblperson.personID', 'tblperson.fname', 'tblperson.mname','tblperson.designation', 'tblperson.lname', 'tblperson.cid', 'tblperson.otherIdentificationNo', 'cr_pltblpersoncategory.categoryName')
            ->where(['cr_linkcomplaint_person_category.complaintID' => $id, 'tblperson.isDelete' => 0])
            ->get();
            $data['id'] = $id;
        return view('evaluation.person_involved',$data);
    }

    public function viewDetailsCaseLink($id)
    {
        $data = [];
        $data['person_involved'] = link_Repeated_Complaint::where('newComplaintID',$id)->where('isDelete','0')->with('repeatedComplaint_registrationRelation','repeatedComplaint_registrationRelation.complaintmoderelation','repeatedComplaint_registrationRelation.complaintTyperelation')->get();
        $data['id'] = $id;
        return view('evaluation.case_link',$data);
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
        return view('evaluation.financial_implication',$data);

    }


    public function socialImplication($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = complaintRegistrationModel::where('complaintID',$id)->first();
        return view('evaluation.social_implication',$data);
    }

    public function finalDecisionCommission(Request $request)
    {

        $details = complaintRegistrationModel::where('complaintID',$request->complaintID)->first();
        complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
            'com_date'=>$request->com_date,
            'com_time'=>$request->com_time,
            'com_venue'=>$request->com_venue,
         ]);

        foreach ($request->addmore as $key => $value) {
            
                CompalintEveOffence::where('complaint_id',$request->complaintID)->where('id',$value['id'])->update([
                    'com_decision'=>$value['com_decision'],
                    'com_sub_decision'=>$value['com_sub_decision'],
                    'com_remarks'=>$value['com_remarks'],
                ]);

                if ($value['com_sub_decision']=="IG" || $value['com_sub_decision']=="IGI") {
                    $new = new TackticalInteligence;
                    $new->created_by = auth()->user()->id;
                    $new->type_ti = 'IG';
                    $new->relation_to = $details->complaintRegNo;
                    $new->requesting_officer = auth()->user()->id;
                    $new->request_date = $request->com_date;
                    $new->start_date = $request->com_date;
                    $new->status = 'COM';
                    $new->com_decision = 'AP';
                    $new->complaint_id = $request->complaintID;
                    $new->offence_allegation = $value['id'];
                    $new->tacktical_from = 'COM';
                    $new->save();
                    $upd = [];
                    $upd['si_ig_no'] = 'IG-00'.$new->id.'/'.date('Y');
                    TackticalInteligence::where('id',$new->id)->update($upd);
                }


            
        }

        // if (@$request->com_final_decision=="ECD") {
        //     complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
        //         'com_outcome_status'=>$details->outcome_status,
        //         'com_agency_outcome'=>$details->agency_outcome,
        //     ]);
        // }else{
        //    if (@$request->com_outcome_status=="Share With Agencies") {
        //         $agency_outcome = @$request->com_agency_outcome;
        //     }else{
        //         $agency_outcome = '';
        //     }

        //     $upd = [];
        //     $upd['com_outcome_status'] = $request->com_outcome_status;
        //     $upd['com_agency_outcome'] = $agency_outcome;
        //     $upd['com_agency_final_remark'] = $request->com_agency_final_remark;
        //     if (@$request->hasFile('com_final_attachement')) {
        //     $file = $request->com_final_attachement;
        //     $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        //     $file->move(public_path().'/attachment/cec/',$filename);
        //     $upd['com_final_attachement'] = $filename;
        //     }
        //     complaintRegistrationModel::where('complaintID',$request->complaintID)->update($upd);
            
        // }
        Alert::success('Commission Final Decision updated successfully');
        return redirect()->back();

    }





}
