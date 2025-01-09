<?php

namespace App\Http\Controllers\EvidenceManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evidence\EvidenceCaseAssign;
use App\Models\Evidence\BailandBound;
use App\Models\Evidence\EscrowModel;
use App\Models\User;
use App\Models\Dzongkhag;
use App\Models\Gewog;
use App\Models\UserToRole;
use App\Models\RolePermission;

use App\Models\Custody\CashStorage;
use App\Models\Custody\MaintenanceLog;
use App\Models\Custody\Valuation;
use App\Models\Custody\Chain;
use App\Models\CustodyStorageProperty;
use App\Models\Custody\LeaseHiring;

use App\Models\Disposal\EscrowAccused;
use App\Models\Disposal\EscrowAgency;
use App\Models\Disposal\Auction;
use App\Models\Disposal\ReturnItem;


use Alert;
use DB;
class EvidenceSeized extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',52)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }


        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->get();
        return view('evidence_seized_property.index',$data);
    }


    public function receiptPropertyChiefView($id)
    {
        $data = [];
        $data['bailbound'] = BailandBound::where('case_id',$id)->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['dzongkhag'] = Dzongkhag::where('isDelete',0)->get();
        $data['gewog'] = Gewog::where('isDelete',0)->get();
        $data['case_id'] = $id;
        return view('evidence_seized_property.seized_details_chief',$data);
    }

    public function escrowAccountChiefView($id)
    {
            $data = [];
            $data['bailbound'] = EscrowModel::where('case_id',$id)->where('user_id',auth()->user()->id)->get();
            $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
            $data['case_id'] = $id;
            return view('evidence_seized_property.escrow_account_chief',$data);
    }

    public function assignOfficial($id)
    {
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->first();
        $data['assignOfficial'] = EvidenceCaseAssign::where('case_id',$id)->first();
        $data['users'] = User::where('is_delete',0)->get();
        $data['id'] = $id;
        return view('evidence_seized_property.assign',$data);
    }

    public function fetchUser(Request $request)
    {
        return $request;
        $data = User::where('id',$request->id)->first();
        $response=array();
        $response['users']=$data;
        return response()->json($response);
    }

    public function insertUser(Request $request)
    {
        $check = EvidenceCaseAssign::where('case_id',$request->id)->first();
        if (@$check=="") {
            $new = new EvidenceCaseAssign;
            $new->user_id = $request->user_id;
            $new->case_id = $request->id;
            $new->instruction = $request->instruction;
            $new->save();

        }else{
            EvidenceCaseAssign::where('case_id',$request->id)->update([
                'user_id'=>$request->user_id,
                'instruction'=>$request->instruction,
            ]);
        }
        Alert::success('Official assgined successfully');
        return redirect()->back();
    }


    public function getCase()
    {
        // $user_id = auth()->user()->id;
        // $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        // $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',54)->where('view_option','Y')->where('is_delete',0)->first();

        //     if ($this->view_option=="") {
        //         Alert::error('You are not allowed to access this page');
        //        return redirect()->route('home');

        // }


        $data = [];
        $data['data'] = EvidenceCaseAssign::where('user_id',auth()->user()->id)->get();
        return view('evidence_seized_property.index_dashboard',$data);
    }

    public function receiptDetails($id)
    {
        $data = [];
        $data['data'] = EvidenceCaseAssign::where('id',$id)->first();
        if(@$data['data']->user_id != auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }else{
            $data['bailbound'] = BailandBound::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['data']->case_id)->first();
            $data['dzongkhag'] = Dzongkhag::where('isDelete',0)->get();
            $data['gewog'] = Gewog::where('isDelete',0)->get();

            $data['case_id'] = $data['data']->case_id;
            return view('evidence_seized_property.seized_receipt',$data);
        }
    }

    public function gewoglistAsperDzongkhag($id){
        $data = Gewog::where('isDelete',0)->where('dzoID',$id)->get();
        return $data;
    }


    public function insertBail(Request $request)
    {
        $new = new BailandBound;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;
        $new->value_property = $request->value_property;
        $new->remarks = $request->remarks;
        $new->name = $request->name;
        $new->cid = $request->cid;
        $new->security_type = $request->security_type;
        if(@$request->security_type=="Land" || @$request->security_type=="Building" || @$request->security_type=="Flat")
        {
            $new->tham_no = $request->tham_no;
            $new->plot_no = $request->plot_no;
            $new->dzongkhag = $request->dzongkhag;
            $new->gewog = $request->gewog;

        }

        if(@$request->security_type=="Building" || @$request->security_type=="Flat"){
            $new->building_no = $request->building_no;
        }

        if(@$request->security_type=="Flat"){
            $new->flat_no = $request->flat_no;
        }

        if(@$request->security_type=="Vehicle"){
            $new->vehicle_type = $request->vehicle_type;
            $new->vehicle_registration_no = $request->vehicle_registration_no;
            $new->registered_owner = $request->registered_owner;
        }

        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();



    }


    public function getEditDetails(Request $request)
    {
        $response = [];
        $response['data'] =  BailandBound::where('id',$request->id)->first();
        return $response;
    }

    public function updateBail(Request $request)
    {

        $upd = [];

        $upd['user_id'] = auth()->user()->id;
        $upd['value_property'] = $request->value_property;
        $upd['remarks'] = $request->remarks;
        $upd['name'] = $request->name;
        $upd['cid'] = $request->cid;
        $upd['security_type'] = $request->security_type;
        if(@$request->security_type=="Land" || @$request->security_type=="Building" || @$request->security_type=="Flat")
        {
            $upd['tham_no'] = $request->tham_no;
            $upd['plot_no'] = $request->plot_no;
            $upd['dzongkhag'] = $request->dzongkhag;
            $upd['gewog'] = $request->gewog;

        }

        if(@$request->security_type=="Building" || @$request->security_type=="Flat"){
            $upd['building_no'] = $request->building_no;
        }

        if(@$request->security_type=="Flat"){
            $upd['flat_no'] = $request->flat_no;
        }

        if(@$request->security_type=="Vehicle"){
            $upd['vehicle_type'] = $request->vehicle_type;
            $upd['vehicle_registration_no'] = $request->vehicle_registration_no;
            $upd['registered_owner'] = $request->registered_owner;
        }
        BailandBound::where('id',$request->id)->update($upd);

        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function deleteBail($id)
    {
        BailandBound::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function escrowAccount($id)
    {
        $data = [];
        $data['data'] = EvidenceCaseAssign::where('id',$id)->first();
        if(@$data['data']->user_id != auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }else{
            $data['bailbound'] = EscrowModel::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['data']->case_id)->first();
            $data['case_id'] = $data['data']->case_id;
            return view('evidence_seized_property.escrow_account',$data);
        }
    }


    public function escrowAccountInsert(Request $request)
    {
        $new = new EscrowModel;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;

        $new->cid = $request->cid;
        $new->name = $request->name;
        $new->source = $request->source;

        $new->total_amount = $request->total_amount;
        $new->receipt_date = $request->receipt_date;
        $new->remarks = $request->remarks;

        if(@$request->source=="Auction")
        {
            $new->type_of_property = $request->type_of_property;
            if(@$request->type_of_property=="Land"){
                $new->tham_no = $request->tham_no;
                $new->plot_no = $request->plot_no;
            }
            if(@$request->type_of_property=="Vehicle")
            {
                $new->registration_no = $request->vehicle_registration_no;
            }
            
        }

        if(@$request->source=="Seized Cash")
        {
            $new->ng = $request->ng;
            $new->ir = $request->ir;
            $new->oc = $request->oc;
        }

        if(@$request->source=="Fines and Penalties")
        {
            $new->type_of_fines = $request->type_of_fines;
        }

        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }

    public function escrowAccountDetails(Request $request)
    {
        // return 'sayan';
        $response = [];
        $response['data'] =  EscrowModel::where('id',$request->id)->first();
        return $response;
    }

    public function escrowAccountupdate(Request $request)
    {
        $new = [];
        
        $new['user_id'] = auth()->user()->id;

        $new['cid'] = $request->cid;
        $new['name'] = $request->name;
        $new['source'] = $request->source;

        $new['total_amount'] = $request->total_amount;
        $new['receipt_date'] = $request->receipt_date;
        $new['remarks'] = $request->remarks;

        if(@$request->source=="Auction")
        {
            $new['type_of_property'] = $request->type_of_property;
            if(@$request->type_of_property=="Land"){
                $new['tham_no'] = $request->tham_no;
                $new['plot_no'] = $request->plot_no;
            }
            if(@$request->type_of_property=="Vehicle")
            {
                $new['registration_no'] = $request->vehicle_registration_no;
            }
            
        }

        if(@$request->source=="Seized Cash")
        {
            $new['ng'] = $request->ng;
            $new['ir'] = $request->ir;
            $new['oc'] = $request->oc;
        }

        if(@$request->source=="Fines and Penalties")
        {
            $new['type_of_fines'] = $request->type_of_fines;
        }

        EscrowModel::where('id',$request->id)->update($new);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function escrowAccountdelete($id)
    {
        EscrowModel::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function getcustodyDetails($id)
    {
        $data = [];
        $data['cash'] = CashStorage::where('case_id',$id)->get();
        $data['storage'] = CustodyStorageProperty::where('case_id',$id)->get();
        $data['maintain'] = MaintenanceLog::where('case_id',$id)->get();
        $data['chain'] = Chain::where('case_id',$id)->get();
        $data['valuation'] = Valuation::where('case_id',$id)->get();
        $data['lease'] = LeaseHiring::where('case_id',$id)->get();
        return view('evidence_seized_property.custody',$data);
    }

    public function getdisposalDetails($id)
    {
        $data = [];
        $data['accused'] = EscrowAccused::where('case_id',$id)->get();
        $data['agency'] = EscrowAgency::where('case_id',$id)->get();
        $data['auction'] = Auction::where('case_id',$id)->get();
        $data['return'] = ReturnItem::where('case_id',$id)->get();
        return view('evidence_seized_property.disposal',$data);
    }
}

