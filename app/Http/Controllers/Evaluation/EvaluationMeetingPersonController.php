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
use App\Models\UserToRole;
use App\Models\RolePermission;
class EvaluationMeetingPersonController extends Controller
{

    //     public function __construct(){      
    //     $this->middleware(function ($request, $next) {      
            


            
    //         return $next($request);
    //     });
    // }


    public function detailsPerson(Request $request)
    {
    	$response = [];
    	$user = User::where('eid',$request->eid)->first();
    	if (@$user=="") {
    		$response['success'] = false;
    	}else{
    		$response['success'] = true;
    		$response['name'] = $user->name;
    		$response['cid'] = $user->cid;
    		$response['department'] = @$user->department_name->name;
    	}
    	return $response;
    }

    public function addMember(Request $request)
    {
    	// return $request;
    	$user = User::where('id',$request->user_id)->first();
    	$new = new EvaluationMeetingPerson;
    	$new->eid = $user->eid;
    	$new->role = $request->role;
    	$new->complaint_id = $request->complaint_id;
    	$new->member_id = $user->id;
    	$new->assign_member_id = auth()->user()->id;
    	$new->remarks = $request->remarks;
        $new->type = $request->type;
    	$new->save();
    	Alert::success('Person added successfully');
    	return redirect()->back();
    }

    public function updateMember(Request $request)
    {
    	$user = User::where('id',$request->user_id)->first();
    	EvaluationMeetingPerson::where('id',$request->member_id)->update([
    		'eid'=>$request->eid,
    		'role'=>$request->role,
    		'complaint_id'=>$request->complaint_id,
    		'member_id'=>$user->id,
    		'assign_member_id'=>auth()->user()->id,
    		'remarks'=>$request->remarks_edit,
    		'availability'=>'AA',
    		'coi_status'=>'AA',
         ]);
    	Alert::success('Person updated successfully');
    	return redirect()->back();
    }

    public function deletePerson($id)
    {
    	EvaluationMeetingPerson::where('id',$id)->delete();
    	Alert::success('User deleted successfully');
    	return redirect()->back();
    }

    public function updateLocation(Request $request)
    {
        if (@$request->cec_create=="Y") {
            complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
            'cec_date'=>$request->cec_date,
            'cec_time'=>$request->cec_time,
            'cec_venue'=>$request->cec_venue,
            'cec_create'=>@$request->cec_create,
            'reason_not_create'=>'',
        ]);
        Alert::success('Details updated successfully');
        return redirect()->back();
        }else{
            complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
            'cec_date'=>'',
            'cec_time'=>'',
            'cec_venue'=>'',
            'cec_create'=>@$request->cec_create,
            'reason_not_create'=>@$request->reason_not_create,
        ]);
        Alert::success('Details updated successfully');
        return redirect()->back();
        }
        
    }


    public function updateLocationCommisionMeeting(Request $request)
    {
        complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
            'com_date'=>$request->com_date,
            'com_time'=>$request->com_time,
            'com_venue'=>$request->com_venue,
        ]);
        Alert::success('Details updated successfully');
        return redirect()->back();
    }

    public function listing()
    {
            $user_id = auth()->user()->id;
            $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
            $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',13)->where('view_option','Y')->where('is_delete',0)->first();
            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

            }

        $data = [];
        $data['data'] = EvaluationMeetingPerson::where('member_id',auth()->user()->id)->where('type','cec')->where('coi_status','!=','Y')->get();
        return view('cec_cases.listing',$data);
    }

    public function availabilityUpdate(Request $request)
    {
        // return $request;
        EvaluationMeetingPerson::where('id',@$request->id_value)->update(['availability'=>@$request->optradio_value]);
                  Alert::success('Details updated successfully');
                  return redirect()->back();


        // if (@$request->addmore) {
        //     foreach(@$request->addmore as $key=> $value)
        //     {
               
        //        if (@$value['id']) {
                  
               
        //        }else{
        //         Alert::success('Details updated successfully');
        //         return redirect()->back();
        //        }
        //     }
        // }else{
        //     Alert::success('Details updated successfully');
        //     return redirect()->back();
        // }

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
        return view('cec_cases.coi',$data);
    }

    public function coiDesicion(Request $request)
    {
       
        EvaluationMeetingPerson::where('id',$request->id)->update([
            'coi_status'=>$request->evaluation,
            'describe_coi'=>$request->describe,
        ]);
        Alert::success('Details updated successfully');
        return redirect()->route('ces.cases.listing');
    }

    public function caseDetails($id)
    {
        $data = [];
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['data'] = complaintRegistrationModel::where('complaintID',$details->complaint_id)->first();
        $data['id'] = $id;
        $data['received_users'] = complaintReceivedByModel::where('complaintID',$details->complaint_id)->get();
        $data['information'] = AdditionalInformationEvaluation::where('complaint_id',$details->complaint_id)->where('status','A')->get();
        $data['members'] = EvaluationMeetingPerson::where('complaint_id',$details->complaint_id)->get();
        $data['score'] = Scoring::where('complaint_id',$details->complaint_id)->where('type','system')->first();
        // return $data['score'];
        $data['given_score'] = EvaluationMeetingPerson::where('complaint_id',$details->complaint_id)->where('member_id',auth()->user()->id)->first();
        return view('cec_cases.details',$data);
    }

    public function updateMemberScore(Request $request)
    {
        if(@$request->score_create=="Y"){

        $ids = EvaluationMeetingPerson::where('complaint_id',$request->complaintID)->pluck('id')->toArray();

        EvaluationMeetingPerson::where('complaint_id',$request->complaintID)->whereIn('id',$ids)->update([
            'score_create'=>@$request->score_create,
        ]);
        

        $score = $request->complaint_score+$request->finance_score+$request->social_score;
        EvaluationMeetingPerson::where('complaint_id',$request->complaintID)->where('member_id',auth()->user()->id)->update([
            'scoring'=>$score,
            'complaint_score'=>$request->complaint_score,
            'finance_score'=>$request->finance_score,
            'social_score'=>$request->social_score,
        ]);
        Alert::success('Score updated successfully');
        return redirect()->back();
      }else{
        $ids = EvaluationMeetingPerson::where('complaint_id',$request->complaintID)->pluck('id')->toArray();

        EvaluationMeetingPerson::where('complaint_id',$request->complaintID)->whereIn('id',$ids)->update([
            'scoring'=>0,
            'complaint_score'=>0,
            'finance_score'=>0,
            'social_score'=>0,
            'score_create'=>@$request->score_create,
        ]);

        EvaluationMeetingPerson::where('complaint_id',$request->complaintID)->where('member_id',auth()->user()->id)->update([
            'reason_not_create'=>$request->reason_not_create,
        ]);

        Alert::success('Score dropped successfully');
        return redirect()->back();



      }
    }

    public function caseDetailsAttachment($id)
    {
        $data = [];
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['data'] = Attachment::where('complaintID',$details->complaint_id)->get();
        $data['id'] = $id;
        return view('cec_cases.attachment',$data);
    }

    public function caseDetailsPerson($id)
    {
        $data = [];
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['data'] = complaintRegistrationModel::where('complaintID',$details->complaint_id)->first();
        $data['person'] =   DB::table('cr_linkcomplaint_person_category')
            ->LeftJoin('tblperson', 'cr_linkcomplaint_person_category.personID', '=', 'tblperson.personID')
            ->LeftJoin('cr_pltblpersoncategory', 'cr_pltblpersoncategory.personCategoryID', '=', 'cr_linkcomplaint_person_category.personCatID')
            ->LeftJoin('cr_tblcomplaintregistration', 'cr_linkcomplaint_person_category.complaintID', '=', 'cr_tblcomplaintregistration.complaintID')
            ->select('tblperson.personID', 'tblperson.fname', 'tblperson.mname', 'tblperson.lname', 'tblperson.cid', 'tblperson.otherIdentificationNo', 'cr_pltblpersoncategory.categoryName')
            ->where(['cr_linkcomplaint_person_category.complaintID' =>$details->complaint_id, 'tblperson.isDelete' => 0])
            ->get();
            $data['id'] = $id;
        return view('cec_cases.person_involved',$data);
    }

    public function caseDetailsLink($id)
    {
        $data = [];
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['data'] = complaintRegistrationModel::where('complaintID',$details->complaint_id)->first();
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['person_involved'] = link_Repeated_Complaint::where('newComplaintID',$details->complaint_id)->where('isDelete','0')->with('repeatedComplaint_registrationRelation','repeatedComplaint_registrationRelation.complaintmoderelation','repeatedComplaint_registrationRelation.complaintTyperelation')->get();
        $data['id'] = $id;
        return view('cec_cases.case_link',$data);
    }

    public function createNumber(Request $request)
    {
        if (@$request->addmore) {
            $arrays = [];
            foreach(@$request->addmore as $value){
                array_push($arrays, $value['checkbox']);
            }
            $comma_separated = implode(',',$arrays);
            $new = new CecTempNumber;
            $new->user_id = auth()->user()->id;
            $new->complaint_ids  = $comma_separated;
            $new->save();
            $rand =  'CEC'.mt_rand(10000,99999).$new->id;
            CecTempNumber::where('id',$new->id)->update([
                'temp_number'=>$rand,
            ]);
            return redirect()->route('ces.number.generate.memebers.committee.room',$rand);
        }else{
            Alert::error('Please select atleast one case.');
            return redirect()->back(); 
        }    
    }

    public function createMemberRoom(Request $request,$id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = CecTempNumber::where('temp_number',$id)->first();
        if (@$request->date_search) {
            $find_cases = complaintRegistrationModel::where('cec_date',@$request->date_search)->pluck('complaintID')->toArray();
            $find_members = EvaluationMeetingPerson::whereIn('complaint_id',$find_cases)->get();
            if (count($find_members)>0) {
                
                TempMemeber::where('temp_id',$id)->delete();

                foreach($find_members as $member)
                {
                    $new = new TempMemeber;
                    $new->temp_id = $id;
                    $new->member_id = $member->member_id;
                    $new->temp_id = $id;
                    $new->role = $member->role;
                    $new->save();

                }
             }
        }
        $data['data'] = TempMemeber::where('temp_id',$id)->get();
        return view('cec_cases.bulk',$data);
    }

    public function deleteTempMember($id)
    {
        TempMemeber::where('id',$id)->delete();
        return redirect()->back()->with('success','Member deleted successfully');
    }

    public function addTempMember(Request $request)
    {
        $user = User::where('eid',$request->eid)->first();
        $new = new TempMemeber;
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

    public function updateTempMember(Request $request)
    {
        $user = User::where('eid',$request->eid)->first();
        TempMemeber::where('id',$request->member_id)->update([
            'eid'=>$request->eid,
            'role'=>$request->role,
            'member_id'=>$user->id,
            'remarks'=>$request->remarks_edit,
         ]);
        Alert::success('Person updated successfully');
        return redirect()->back();
    }


    public function finalTempMember(Request $request)
    {
        $checkMember = TempMemeber::where('temp_id',$request->temp_id)->first();
        if (@$checkMember=="") {
           Alert::error('Please assign atleast one person'); 
           return redirect()->back(); 
        }

        $getComplaint = CecTempNumber::where('temp_number',$request->temp_id)->first();
        $explodeIds = explode(',', $getComplaint->complaint_ids);
        $members = TempMemeber::where('temp_id',$request->temp_id)->get();
        foreach($explodeIds as $value)
        {
            EvaluationMeetingPerson::where('complaint_id',$value)->delete();
            // update location and time
            complaintRegistrationModel::where('complaintID',$value)->update([
                'cec_date'=>$request->cec_date,
                'cec_time'=>$request->cec_time,
                'cec_venue'=>$request->cec_venue,
            ]);

            foreach($members as $member)
            {

                $new = new EvaluationMeetingPerson;
                $new->eid = $member->eid;
                $new->role = $member->role;
                $new->complaint_id = $value;
                $new->member_id = $member->member_id;
                $new->assign_member_id = auth()->user()->id;
                $new->remarks = $member->remarks;
                $new->save();
            }
        }
        TempMemeber::where('temp_id',$request->temp_id)->delete();
        CecTempNumber::where('temp_number',$request->temp_id)->delete();
        Alert::success('Person assigned successfully'); 
        return redirect()->route('complaint.evaluate.list'); 

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
        return view('cec_cases.financial_implication',$data);

    }


    public function socialImplication($id)
    {
        $data = [];
        $data['id'] = $id;
        $details = EvaluationMeetingPerson::where('id',$id)->first();
        $data['data'] = complaintRegistrationModel::where('complaintID',$details->complaint_id)->first();
        return view('cec_cases.social_implication',$data);
    }


    public function updateDesicionCec(Request $request)
    {
        if (@$request->outcome_status=="Share With Agencies") {
            $agency_outcome = @$request->agency_outcome;
        }else{
            $agency_outcome = '';
        }
        EvaluationMeetingPerson::where('complaint_id',$request->complaintID)->where('member_id',auth()->user()->id)->update([
            'outcome_status'=>$request->outcome_status,
            'agency_outcome'=>$agency_outcome,
            'final_remark'=>$request->final_remark,
         ]);

        $upd = [];
        if (@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/cec/',$filename);
            $upd['attachment'] = $filename;
        }
        EvaluationMeetingPerson::where('complaint_id',$request->complaintID)->where('member_id',auth()->user()->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();

    }


    public function memberDetails($id)
    {
        $data = [];
        $data['data'] = EvaluationMeetingPerson::where('id',$id)->first();
        return view('cec_cases.more',$data);
    }



}
