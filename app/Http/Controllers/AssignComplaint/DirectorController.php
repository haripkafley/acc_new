<?php

namespace App\Http\Controllers\AssignComplaint;

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
class DirectorController extends Controller
{

    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',4)->where('view_option','Y')->where('is_delete',0)->first();
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
        $data['data'] = complaintRegistrationModel::orderBy('complaintID','desc')->where('assign_chief_director','D')->get();
        return view('assign_complaint_director.list',$data);
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
        return view('assign_complaint_director.view',$data);
    }

    public function postAssign(Request $request)
    {
                if (@$request->instruction=="") {
           Alert::error('Please Enter Instruction');  
           return redirect()->back();
        }
        
        if (@$request->assign_to=="H") {
            $regional_office = '';
            $headquater_user_id = $request->headquater_user_id;
            $regional_user_id = '';
        }else{
            $regional_office =@$request->regional_office;
            $headquater_user_id = '';
            $regional_user_id = '';
        }
        complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
            'assign_to'=>$request->assign_to,
            'regional_office'=>$regional_office,
            'instruction'=>$request->instruction,
            'assign_status'=>'Y',
            'headquater_user_id'=>$headquater_user_id,
            'regional_user_id'=>$regional_user_id,
        ]);

        

        Alert::success('Complaint Assigned Successfully');  
        return redirect()->back();

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



        if (@$request->assign_to=="H") {
             $regional_office = '';
             $headquater_user_id = $request->headquater_user_id;
             $regional_user_id = '';
        }else{
            $regional_office =@$request->regional_office;
            $headquater_user_id = '';
            $regional_user_id = '';
        }
        complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
            'assign_to'=>$request->assign_to,
            'regional_office'=>$regional_office,
            'instruction'=>$request->instruction,
            'reason_change'=>$request->reason_change,
            'assign_status'=>'Y',
            'headquater_user_id'=>$headquater_user_id,
            'regional_user_id'=>$regional_user_id,
            'evaluation_status'=>null,
        ]);

        

        Alert::success('Complaint Re-Assigned Successfully');  
        return redirect()->back();
    }


    public function viewDetailsAttachment($id)
    {
        $data = [];
        $data['data'] = Attachment::where('complaintID',$id)->get();
        $data['id'] = $id;
        return view('assign_complaint_director.attachment',$data);
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
        return view('assign_complaint_director.person_involved',$data);
    }

    public function viewDetailsCaseLink($id)
    {
        $data = [];
        $data['person_involved'] = link_Repeated_Complaint::where('newComplaintID',$id)->where('isDelete','0')->with('repeatedComplaint_registrationRelation','repeatedComplaint_registrationRelation.complaintmoderelation','repeatedComplaint_registrationRelation.complaintTyperelation')->get();
        $data['id'] = $id;
        $data['case_already_register'] = link_Repeated_Complaint::where('newComplaintID',$id)->where('isDelete','0')->pluck('repeatedComplaintID')->toArray();
        $persons_involved = linkComplaintPersonModel::where('complaintID',$id)->pluck('personID')->toArray();
        $get_complaint_id = linkComplaintPersonModel::whereIn('personID',$persons_involved)->pluck('complaintID')->toArray();
        $data['person_previous_case'] = complaintRegistrationModel::whereIn('complaintID',$get_complaint_id)->where('complaintID','!=',$id)->get();
        return view('assign_complaint_director.case_link',$data);
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
        return view('assign_complaint_director.financial_implication',$data);

    }

    public function socialImplication($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = complaintRegistrationModel::where('complaintID',$id)->first();
        return view('assign_complaint_director.social_implication',$data);
    }


}
