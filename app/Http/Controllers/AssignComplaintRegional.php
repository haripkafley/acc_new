<?php

namespace App\Http\Controllers;


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
use App\Models\RegionAssignUser;
use App\Models\Complaint\ConflictRejection;
use App\Models\UserToRole;
use App\Models\RolePermission;
use App\Models\FinanceImplicationDetails;
use App\Models\Complaint\NaturalResource;
use App\Models\Complaint\PolicyComplaint;
use App\Models\Complaint\Political;
use App\Models\Complaint\Personnel;
use App\Models\Complaint\ProcurementGoodService;
use App\Models\Complaint\ProcurementGoods;
use App\Models\Complaint\LandDetails;
class AssignComplaintRegional extends Controller
{

    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',5)->where('view_option','Y')->where('is_delete',0)->first();
        if ($this->view_option=="") {
            Alert::error('You are not allowed to access this page');
           return redirect()->route('home');

        }


        
        return $next($request);
    });
  }


    public function list()
    {
        $data = [];
        $data['data'] = complaintRegistrationModel::orderBy('complaintID','desc')->where('assign_to','R')->where('regional_office',auth()->user()->regional_id)->where('regional_coi','!=','Y')->get();
        return view('regional_assign.list',$data);
    }

    public function viewDetails($id)
    {
        $data = [];
        $data['data'] = complaintRegistrationModel::where('complaintID',$id)->first();
        $data['id'] = $id;
        $data['received_users'] = complaintReceivedByModel::where('complaintID',$id)->get();
        $data['user'] = User::where('is_delete',0)->where('office','R')->where('regional_id',$data['data']->regional_office)->get();
        $data['regional_office'] = RegionalOffice::get();
        $data['assignUsers'] = RegionAssignUser::where('complaint_id',$id)->pluck('user_id')->toArray();
        return view('regional_assign.view',$data);
    }


    public function postAssign(Request $request)
    {   

        if (@$request->instruction=="") {
           Alert::error('Please Enter Instruction');  
           return redirect()->back();
        }
        
        
        complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
            'regional_assign_status'=>'Y',
            'regional_instruction'=>$request->instruction,
            'regional_user_id'=>$request->regional_user_id,
            'evalution_coi'=>'AA',
        ]);

            // if (isset($request['assignUsers'])) {
            //     foreach ($request['assignUsers'] as $receivedByUserID) {
            //         $receiver = new RegionAssignUser;
            //         $receiver->complaint_id  = $request->complaintID;
            //         $receiver->user_id = $receivedByUserID;
            //         $receiver->save();
            //     }
            // }
        

        Alert::success('Regional Complaint Assigned Successfully');  
        return redirect()->route('assign.complaint.regional');


    }


    public function postAssignUpdate(Request $request)
    {

        if (@$request->reason_change=="") {
           Alert::error('Please Enter Reason Of Re-Assign');  
           return redirect()->back();
        }

        if (@$request->instruction=="") {
           Alert::error('Please Enter Instruction');  
           return redirect()->back();
        }



       
        complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
            'regional_assign_status'=>'Y',
            'regional_instruction'=>$request->instruction,
            'regional_reason_change'=>$request->reason_change,
            'regional_user_id'=>$request->regional_user_id,
            'evaluation_status'=>null,
            'evalution_coi'=>'AA',
        ]);

        
            // if (isset($request['assignUsers'])) {

            //     RegionAssignUser::where(['complaint_id' => $request->complaintID])->delete();
            //     foreach ($request['assignUsers'] as $receivedByUserID) {
            //         $receiver = new RegionAssignUser;
            //         $receiver->complaint_id = $request->complaintID;
            //         $receiver->user_id = $receivedByUserID;
            //         $receiver->save();
            //     }
            // }
        

        Alert::success('Regional Complaint Re-Assigned Successfully');  
        return redirect()->route('assign.complaint.regional');
    }


    public function viewDetailsAttachment($id)
    {
        $data = [];
        $data['data'] = Attachment::where('complaintID',$id)->get();
        $data['id'] = $id;
        return view('regional_assign.attachment',$data);
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
        return view('regional_assign.person_involved',$data);
    }

    public function viewDetailsCaseLink($id)
    {
        $data = [];
        $data['person_involved'] = link_Repeated_Complaint::where('newComplaintID',$id)->where('isDelete','0')->with('repeatedComplaint_registrationRelation','repeatedComplaint_registrationRelation.complaintmoderelation','repeatedComplaint_registrationRelation.complaintTyperelation')->get();
        $data['id'] = $id;
        return view('regional_assign.case_link',$data);
    }

    public function coi($id)
    {
        // return $id;
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
        return view('regional_assign.conflict_view',$data);
    }

    public function decisionSubmit(Request $request)
    {
        // return $request;
        if (@$request->cheif_coi=="Y") {
             // return $request;
            complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
                'assign_status'=>'N',
                // 'assign_to'=>'',
                'reason_change'=>'',
                // 'regional_office'=>'',
                'regional_coi'=>'Y',
            ]);

            $reject = new ConflictRejection;
            $reject->user_id = auth()->user()->id;
            $reject->complaint_id = $request->complaintID;
            $reject->description = $request->describe;
            $reject->type = 'R';
            $reject->save();



            Alert::success('Data COI updated successfully.');
            return redirect()->route('assign.complaint.regional');
        



        }else{
            complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
                'regional_coi'=>'N',
            ]);
            Alert::success('Data COI updated successfully.');  
            return redirect()->route('assign.complaint.regional');
        }


    }


    public function coi_person($id)
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
        return view('regional_assign.coi_person',$data);
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
        return view('regional_assign.financial_implication',$data);

    }

    public function socialImplication($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = complaintRegistrationModel::where('complaintID',$id)->first();
        return view('regional_assign.social_implication',$data);
    }
}
