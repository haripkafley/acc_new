<?php

namespace App\Http\Controllers\MonitoryFine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\CompalintEveOffence;
use App\Models\User;
use App\Models\Complaint\MonitoryFine;
use App\Models\Complaint\MonitoryFineOfficial;
use App\Models\Complaint\MonitoryFineDetails;
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
}
