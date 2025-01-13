<?php

namespace App\Http\Controllers\Recovery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\CompalintEveOffence;
use App\Models\User;
use App\Models\Complaint\RecoveryDetails;
use App\Models\Complaint\RecoveryModel;
use App\Models\Complaint\RecoveryModelOfficial;
use App\Models\Complaint\RecoveryCecCom;
use App\Models\Complaint\CecComCrud;
use Redirect;
use Session;
use Alert;
class RecoveryController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = RecoveryModel::get();
        return view('recovery.index',$data);
    }

    public function addOfficial($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = RecoveryModel::where('id',$id)->first();
        $data['members'] = RecoveryModelOfficial::where('recovery_id',$id)->get();
        $data['users'] = User::get();
        return view('recovery.assign',$data);
    }

    public function insertMember(Request $request)
    {
        $new = new RecoveryModelOfficial;
        $new->user_id = $request->user_id;
        $new->role = $request->role;
        $new->recovery_id = $request->monetary_id;
        $new->save();
        Alert::success('You\'ve Successfully Added A Member');
        return Redirect::back();
    }

    public function deleteMember($id)
    {
        RecoveryModelOfficial::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Member');
        return Redirect::back();
    }

    public function getOfficial()
    {
        $data = [];
        $data['data'] = RecoveryModelOfficial::whereIn('coi_status',['AA','N'])->where('user_id',auth()->user()->id)->get();
        return view('recovery.official_list',$data);
    }

    public function getOfficialCoiPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = RecoveryModelOfficial::where('id',$id)->first();
        return view('recovery.official_list_coi',$data);
    }

    public function getOfficialCoiPageDecision(Request $request)
    {
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['coi_description'] = $request->coi_description;
        RecoveryModelOfficial::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->route('recovery-model.get.official');
    }

    public function viewPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = RecoveryModelOfficial::where('id',$id)->first();
        $data['monetary_id'] = $data['data']->recovery_id;
        $data['monetary_details'] = RecoveryModel::where('id',$data['monetary_id'])->first();
        $data['details'] = RecoveryDetails::where('user_id',auth()->user()->id)->where('recovery_id',$data['monetary_id'])->get();
        return view('recovery.view_official',$data);
    }

    public function insertFine(Request $request)
    {
        $new = new RecoveryDetails;
        $new->recovery_id = $request->monetary_id;
        $new->user_id = auth()->user()->id;
        $new->category_id = $request->category_id;
        if(@$request->category_id=="IND")
        {
            $new->cid_permit = $request->cid_permit;
        }
        $new->name = $request->name;
        $new->amount = $request->amount;
        $new->remarks = $request->remarks;
        $new->save();
        Alert::success('Data added successfully');
        return Redirect::back();
    }

    public function updateFine(Request $request)
    {
        $upd = [];
        $upd['name'] = $request->name;
        $upd['amount'] = $request->amount;
        $upd['remarks'] = $request->remarks;
        $upd['category_id'] = $request->category_id;
        if(@$request->category_id=="IND")
        {
            $upd['cid_permit'] = $request->cid_permit;
        }

        RecoveryDetails::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return Redirect::back();

    }

    public function deleteFine($id)
    {
        RecoveryDetails::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return Redirect::back();
    }

    public function updateFinePayment(Request $request)
    {
        $upd = [];
        $upd['receipt_date'] = $request->receipt_date;
        $upd['receipt_no'] = $request->receipt_no;
        RecoveryDetails::where('id',$request->id)->update($upd);
        Alert::success('Payment details updated successfully');
        return Redirect::back();
    }


    // cec-and commission flow
    public function viewDetails($id)
    {
        $data = [];
        $data['monetary_id'] = $id;
        $data['id'] = $id;
        $data['data'] = RecoveryModel::where('id',$id)->first();
        $data['monetary_details'] = RecoveryModel::where('id',$id)->first();
        $data['details'] = RecoveryDetails::where('recovery_id',$data['monetary_id'])->get();
        $cec_users = CecComCrud::where('user_type','CEC')->where('status','A')->pluck('user_id')->toArray();
        $com_users = CecComCrud::where('user_type','COM')->where('status','A')->pluck('user_id')->toArray();
        $data['cec_user_dropdown'] = User::whereIn('id',$cec_users)->get();
        $data['com_user_dropdown'] = User::whereIn('id',$com_users)->get();
        $data['cec_members'] = RecoveryCecCom::where('recovery_id',$id)->where('type','cec')->get();
        $data['com_members'] = RecoveryCecCom::where('recovery_id',$id)->where('type','com')->get();
        $data['all_users'] = User::where('status','A')->get();
        return view('recovery.view_chief',$data);
    }

    public function insertCecMember(Request $request)
    {
        // return $request;
        $user = User::where('id',$request->user_id)->first();
        $new = new RecoveryCecCom;
        $new->eid = $user->eid;
        $new->role = $request->role;
        $new->recovery_id = $request->monetory_id;
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
        RecoveryCecCom::where('id',$request->member_id)->update([
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

    public function deleteCecMember($id)
    {
        RecoveryCecCom::where('id',$id)->delete();
        Alert::success('Person deleted successfully');
        return redirect()->back();
    }

    public function updateCecMemberDecision(Request $request)
    {
        $upd = [];
        $upd['cec_date'] = $request->cec_date;
        $upd['cec_time'] = $request->cec_time;
        $upd['cec_venue'] = $request->cec_venue;
        $upd['cec_decision'] = $request->cec_decision;
        $upd['cec_remarks'] = $request->cec_remarks;
        RecoveryModel::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function updatecommissionMemberDecision(Request $request)
    {
        $details = RecoveryModel::where('id',$request->id)->first();
        $upd = [];
        $upd['com_date'] = $request->com_date;
        $upd['com_time'] = $request->com_time;
        $upd['com_venue'] = $request->com_venue;
        $upd['com_status'] = $request->com_status;
        $upd['com_remarks'] = $request->com_remarks;
        if (@$request->com_status=="ECD") {
            $upd['com_decision'] = $details->cec_decision;
        }else{
            $upd['com_decision'] = $request->com_decision;
        }
        RecoveryModel::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    

    public function cecCasesList()
    {
        $data = [];
        $data['data'] = RecoveryCecCom::where('member_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->where('type','cec')->get();
        return view('recovery.cec_cases',$data);
    }

    public function cecCasesListCoi($id,$type)
    {
        $data = [];
        $data['data'] = RecoveryCecCom::where('id',$id)->where('member_id',auth()->user()->id)->where('coi_status','AA')->first();
        if (@$data['data']=="") {
            Alert::error('Unauthorized Access');
            return redirect('dashboard');
        }

        $data['type'] = $type;
        $data['id'] = $id;
        return view('recovery.cec_com_view',$data);
    }

    public function cecCasesListUpdateDecision(Request $request)
    {
        $check = RecoveryCecCom::where('id',$request->id)->first();
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['describe_coi'] = $request->coi_description;
        RecoveryCecCom::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        if ($check->type=="cec") {
            return redirect()->route('recovery-model.cec.cases.list');
        }else{
            return redirect()->route('recovery-model.commission.cases.list');
        }
    }

    public function cecCasesListView($id,$type)
    {
        $data = [];
        $data['data'] = RecoveryCecCom::where('id',$id)->where('member_id',auth()->user()->id)->where('coi_status','N')->first();
        if (@$data['data']=="") {
            Alert::error('Unauthorized Access');
            return redirect('dashboard');
        }
        $data['monetary_details'] = RecoveryModel::where('id',$data['data']->monetory_id)->first();
        $data['details'] = RecoveryDetails::where('recovery_id', $data['data']->monetory_id)->get();
        return view('recovery.cec_full_view',$data);
    }

    public function commissionCasesList()
    {
        $data = [];
        $data['data'] = RecoveryCecCom::where('member_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->where('type','com')->get();
        return view('recovery.com_cases',$data);
    }
}
