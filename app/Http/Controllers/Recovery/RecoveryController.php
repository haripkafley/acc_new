<?php

namespace App\Http\Controllers\Recovery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\CompalintEveOffence;
use App\Models\User;
use App\Models\Complaint\RecoveryDetails;
use App\Models\Complaint\RecoveryModel;
use App\Models\Complaint\RecoveryModelOfficial;
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
        $data['members'] = RecoveryModelOfficial::where('monetary_id',$id)->get();
        $data['users'] = User::get();
        return view('recovery.assign',$data);
    }

    public function insertMember(Request $request)
    {
        $new = new RecoveryModelOfficial;
        $new->user_id = $request->user_id;
        $new->role = $request->role;
        $new->monetary_id = $request->monetary_id;
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
        return redirect()->route('monetary.fine.get.official');
    }

    public function viewPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = RecoveryModelOfficial::where('id',$id)->first();
        $data['monetary_id'] = $data['data']->monetary_id;
        $data['monetary_details'] = RecoveryModel::where('id',$data['monetary_id'])->first();
        $data['details'] = RecoveryDetails::where('user_id',auth()->user()->id)->where('monetary_id',$data['monetary_id'])->get();
        return view('recovery.view_official',$data);
    }

    public function insertFine(Request $request)
    {
        $new = new RecoveryDetails;
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
}
