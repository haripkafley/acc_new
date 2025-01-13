<?php

namespace App\Http\Controllers\MonitoryFine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\CompalintEveOffence;
use App\Models\User;
use App\Models\Complaint\MonitoryFine;
use App\Models\Complaint\MonitoryFineOfficial;
use App\Models\Complaint\MonitoryFineDetails;
use App\Models\Complaint\CecComCrud;
use App\Models\Complaint\MonetoryCecCom;
use Redirect;
use Session;
use Alert;
class MonitorController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = MonitoryFine::get();
        return view('monetary_fine.index',$data);
    }

    public function addOfficial($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = MonitoryFine::where('id',$id)->first();
        $data['members'] = MonitoryFineOfficial::where('monetary_id',$id)->get();
        $data['users'] = User::get();
        return view('monetary_fine.assign',$data);
    }

    public function insertMember(Request $request)
    {
        $new = new MonitoryFineOfficial;
        $new->user_id = $request->user_id;
        $new->role = $request->role;
        $new->monetary_id = $request->monetary_id;
        $new->save();
        Alert::success('You\'ve Successfully Added A Member');
        return Redirect::back();
    }

    public function deleteMember($id)
    {
        MonitoryFineOfficial::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Member');
        return Redirect::back();
    }


    // cec-and commission flow
    public function viewDetails($id)
    {
        $data = [];
        $data['monetary_id'] = $id;
        $data['id'] = $id;
        $data['data'] = MonitoryFine::where('id',$id)->first();
        $data['monetary_details'] = MonitoryFine::where('id',$id)->first();
        $data['details'] = MonitoryFineDetails::where('monetary_id',$data['monetary_id'])->get();
        $cec_users = CecComCrud::where('user_type','CEC')->where('status','A')->pluck('user_id')->toArray();
        $com_users = CecComCrud::where('user_type','COM')->where('status','A')->pluck('user_id')->toArray();
        $data['cec_user_dropdown'] = User::whereIn('id',$cec_users)->get();
        $data['com_user_dropdown'] = User::whereIn('id',$com_users)->get();
        $data['cec_members'] = MonetoryCecCom::where('monetory_id',$id)->where('type','cec')->get();
        $data['com_members'] = MonetoryCecCom::where('monetory_id',$id)->where('type','com')->get();
        $data['all_users'] = User::where('status','A')->get();
        return view('monetary_fine.view_chief',$data);
    }

    public function insertCecMember(Request $request)
    {
        // return $request;
        $user = User::where('id',$request->user_id)->first();
        $new = new MonetoryCecCom;
        $new->eid = $user->eid;
        $new->role = $request->role;
        $new->monetory_id = $request->monetory_id;
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
        MonetoryCecCom::where('id',$request->member_id)->update([
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
        MonetoryCecCom::where('id',$id)->delete();
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
        MonitoryFine::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function updatecommissionMemberDecision(Request $request)
    {
        $details = MonitoryFine::where('id',$request->id)->first();
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
        MonitoryFine::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function getOfficial()
    {
        $data = [];
        $data['data'] = MonitoryFineOfficial::whereIn('coi_status',['AA','N'])->where('user_id',auth()->user()->id)->get();
        return view('monetary_fine.official_list',$data);
    }

    public function getOfficialCoiPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = MonitoryFineOfficial::where('id',$id)->first();
        return view('monetary_fine.official_list_coi',$data);
    }

    public function getOfficialCoiPageDecision(Request $request)
    {
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['coi_description'] = $request->coi_description;
        MonitoryFineOfficial::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->route('monetary.fine.get.official');
    }

    public function viewPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = MonitoryFineOfficial::where('id',$id)->first();
        $data['monetary_id'] = $data['data']->monetary_id;
        $data['monetary_details'] = MonitoryFine::where('id',$data['monetary_id'])->first();
        $data['details'] = MonitoryFineDetails::where('user_id',auth()->user()->id)->where('monetary_id',$data['monetary_id'])->get();
        return view('monetary_fine.view_official',$data);
    }

    public function insertFine(Request $request)
    {
        $new = new MonitoryFineDetails;
        $new->monetary_id = $request->monetary_id;
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

        MonitoryFineDetails::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return Redirect::back();

    }

    public function deleteFine($id)
    {
        MonitoryFineDetails::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return Redirect::back();
    }

    public function updateFinePayment(Request $request)
    {
        $upd = [];
        $upd['receipt_date'] = $request->receipt_date;
        $upd['receipt_no'] = $request->receipt_no;
        MonitoryFineDetails::where('id',$request->id)->update($upd);
        Alert::success('Payment details updated successfully');
        return Redirect::back();
    }

    public function cecCasesList()
    {
        $data = [];
        $data['data'] = MonetoryCecCom::where('member_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->where('type','cec')->get();
        return view('monetary_fine.cec_cases',$data);
    }

    public function cecCasesListCoi($id,$type)
    {
        $data = [];
        $data['data'] = MonetoryCecCom::where('id',$id)->where('member_id',auth()->user()->id)->where('coi_status','AA')->first();
        if (@$data['data']=="") {
            Alert::error('Unauthorized Access');
            return redirect('dashboard');
        }

        $data['type'] = $type;
        $data['id'] = $id;
        return view('monetary_fine.cec_com_view',$data);
    }

    public function cecCasesListUpdateDecision(Request $request)
    {
        $check = MonetoryCecCom::where('id',$request->id)->first();
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['describe_coi'] = $request->coi_description;
        MonetoryCecCom::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        if ($check->type=="cec") {
            return redirect()->route('monetary.fine.cec.cases.list');
        }else{
            return redirect()->route('com.get.information.gathering.cases');
        }
    }

    public function cecCasesListView($id,$type)
    {
        $data = [];
        $data['data'] = MonetoryCecCom::where('id',$id)->where('member_id',auth()->user()->id)->where('coi_status','N')->first();
        if (@$data['data']=="") {
            Alert::error('Unauthorized Access');
            return redirect('dashboard');
        }
        $data['monetary_details'] = MonitoryFine::where('id',$data['data']->monetory_id)->first();
        $data['details'] = MonitoryFineDetails::where('monetary_id', $data['data']->monetory_id)->get();
        return view('monetary_fine.cec_full_view',$data);
    }

    public function commissionCasesList()
    {
        $data = [];
        $data['data'] = MonetoryCecCom::where('member_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->where('type','com')->get();
        return view('monetary_fine.com_cases',$data);
    }
}
