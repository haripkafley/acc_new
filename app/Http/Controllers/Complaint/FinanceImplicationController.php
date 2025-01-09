<?php

namespace App\Http\Controllers\Complaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\complaintRegistrationModel;
use App\Models\User;
use App\Models\Dzongkhag;
use App\Models\Complaint\NaturalResource;
use App\Models\Complaint\PolicyComplaint;
use App\Models\Complaint\Political;
use App\Models\Complaint\Personnel;
use App\Models\Complaint\ProcurementGoodService;
use App\Models\Complaint\ProcurementGoods;
use App\Models\Complaint\LandDetails;
use App\Models\Complaint\Scoring;
use App\Models\FinanceImplicationDetails;
use Alert;
use DB;
class FinanceImplicationController extends Controller
{
    public function index($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['dzongkhag'] = Dzongkhag::get();
        $data['data'] = complaintRegistrationModel::where('complaintID',$id)->first();
        $data['natural_resources'] = NaturalResource::where('complaint_id',$id)->get();
        $data['policy'] = PolicyComplaint::where('complaint_id',$id)->get();
        $data['political'] = Political::where('complaint_id',$id)->get();
        $data['personnel'] = Personnel::where('complaint_id',$id)->get();
        $data['goods_services'] = ProcurementGoodService::where('complaint_id',$id)->get();
        $data['goods'] = ProcurementGoods::where('complaint_id',$id)->get();
        $data['land'] = LandDetails::where('complaint_id',$id)->get();
        $data['finance_details'] = FinanceImplicationDetails::where('complaint_id',$id)->first();
        // return $data['finance_details'];
        return view('complaint.finance',$data);
    }


    public function saveDetails(Request $request)
    {
        if ($request->financial_implication_amount <= 50000) {
            $finance = '3';
        }
        if ($request->financial_implication_amount > 50000 && $request->financial_implication_amount <=100000) {
            $finance = '7';
        }

        if ($request->financial_implication_amount > 100000 && $request->financial_implication_amount <= 500000) {
            $finance = '10';
        }

        if ($request->financial_implication_amount > 500000) {
            $finance = '15';
        }

        Scoring::where('complaint_id',$request->complaintID)->where('type','system')->update([
            'finance'=>$finance,
        ]);
        complaintRegistrationModel::where('complaintID',$request->complaintID)->update([
            'financial_implication_amount'=>$request->financial_implication_amount,
        ]);
        Alert::success('Data Updated Successfully');
        return redirect()->back();
    }


    public function naturalAdd(Request $request)
    {

        $new = new NaturalResource;
        $new->complaint_id = $request->complaintID;
        $new->sector = $request->sector;
        $new->resource = $request->resource;
        $new->description = $request->description;
        $new->amount = $request->amount;
        $new->save();
        Alert::success('Data added successfully');
        return redirect()->back();
    }


    public function newPolicyAdd(Request $request)
    {
        $new = new PolicyComplaint;
        $new->complaint_id = $request->complaintID;
        $new->description = $request->description;
        $new->amount = $request->amount;
        $new->save();
        Alert::success('Data added successfully');
        return redirect()->back();
    }


    public function newPoliticalAdd(Request $request)
    {
        $new = new Political;
        $new->reason = $request->reason;
        $new->complaint_id = $request->complaintID;
        $new->description = $request->description;
        $new->amount = $request->amount;
        $new->save();
        Alert::success('Data added successfully');
        return redirect()->back();
    }


    public function newpersonnelAdd(Request $request)
    {
        $new = new Personnel;
        $new->agency = $request->agency;
        $new->activity = $request->activity;
        $new->complaint_id = $request->complaintID;
        $new->description = $request->description;
        $new->amount = $request->amount;
        $new->save();
        Alert::success('Data added successfully');
        return redirect()->back();
    }


    public function goodsServicesAdd(Request $request)
    {
        $new = new ProcurementGoodService;
        $new->dzongkhag_id = $request->dzongkhag_id;
        $new->gewog_id = $request->gewog_id;
        $new->complaint_id = $request->complaintID;
        $new->supplier = $request->supplier;
        $new->description = $request->description;
        $new->amount = $request->amount;
        $new->save();
        Alert::success('Data added successfully');
        return redirect()->back();
    }

    public function goodsAdd(Request $request)
    {
        $new = new ProcurementGoods;
        $new->dzongkhag_id = $request->dzongkhag_id;
        $new->gewog_id = $request->gewog_id;
        $new->complaint_id = $request->complaintID;
        $new->contractor = $request->contractor;
        $new->description = $request->description;
        $new->amount = $request->amount;
        $new->save();
        Alert::success('Data added successfully');
        return redirect()->back();
    }

    public function landAdd(Request $request)
    {
        $new = new LandDetails;
        $new->dzongkhag_id = $request->dzongkhag_id;
        $new->gewog_id = $request->gewog_id;
        $new->complaint_id = $request->complaintID;
        $new->area = $request->area;
        $new->tham_no = $request->tham_no;
        $new->plot_no = $request->plot_no;
        $new->amount = $request->amount;
        $new->save();
        Alert::success('Data added successfully');
        return redirect()->back();
    }


    public function naturalStatusUpdate(Request $request)
    {
        
        $check = FinanceImplicationDetails::where('complaint_id',$request->complaintId)->first();
        
        if (@$check=="") {
            $new = new FinanceImplicationDetails;
            $new->complaint_id = $request->complaintId;
            $new->natural_resource = $request->getvalue;
            $new->save();
        }else{
            FinanceImplicationDetails::where('complaint_id',$request->complaintId)->update([
                'natural_resource'=>$request->getvalue,
            ]);

        }
    }

    public function newPolicyStatusUpdate(Request $request)
    {
        $check = FinanceImplicationDetails::where('complaint_id',$request->complaintId)->first();
        
        if (@$check=="") {
            $new = new FinanceImplicationDetails;
            $new->complaint_id = $request->complaintId;
            $new->policy = $request->getvalue;
            $new->save();
        }else{
            FinanceImplicationDetails::where('complaint_id',$request->complaintId)->update([
                'policy'=>$request->getvalue,
            ]);

        }
    }


    public function politicalStatusUpdate(Request $request)
    {
        $check = FinanceImplicationDetails::where('complaint_id',$request->complaintId)->first();
        
        if (@$check=="") {
            $new = new FinanceImplicationDetails;
            $new->complaint_id = $request->complaintId;
            $new->political = $request->getvalue;
            $new->save();
        }else{
            FinanceImplicationDetails::where('complaint_id',$request->complaintId)->update([
                'political'=>$request->getvalue,
            ]);

        }
    }


    public function personnelStatusUpdate(Request $request)
    {
        $check = FinanceImplicationDetails::where('complaint_id',$request->complaintId)->first();
        
        if (@$check=="") {
            $new = new FinanceImplicationDetails;
            $new->complaint_id = $request->complaintId;
            $new->personnel = $request->getvalue;
            $new->save();
        }else{
            FinanceImplicationDetails::where('complaint_id',$request->complaintId)->update([
                'personnel'=>$request->getvalue,
            ]);

        }
    }


    public function procurementgoodStatusUpdate(Request $request)
    {
        $check = FinanceImplicationDetails::where('complaint_id',$request->complaintId)->first();
        
        if (@$check=="") {
            $new = new FinanceImplicationDetails;
            $new->complaint_id = $request->complaintId;
            $new->procurement_good = $request->getvalue;
            $new->save();
        }else{
            FinanceImplicationDetails::where('complaint_id',$request->complaintId)->update([
                'procurement_good'=>$request->getvalue,
            ]);

        }
    }

    public function serviceStatusUpdate(Request $request)
    {
        $check = FinanceImplicationDetails::where('complaint_id',$request->complaintId)->first();
        
        if (@$check=="") {
            $new = new FinanceImplicationDetails;
            $new->complaint_id = $request->complaintId;
            $new->procurement_work = $request->getvalue;
            $new->save();
        }else{
            FinanceImplicationDetails::where('complaint_id',$request->complaintId)->update([
                'procurement_work'=>$request->getvalue,
            ]);

        }
    }


    public function landStatusUpdate(Request $request)
    {
        $check = FinanceImplicationDetails::where('complaint_id',$request->complaintId)->first();
        
        if (@$check=="") {
            $new = new FinanceImplicationDetails;
            $new->complaint_id = $request->complaintId;
            $new->land = $request->getvalue;
            $new->save();
        }else{
            FinanceImplicationDetails::where('complaint_id',$request->complaintId)->update([
                'land'=>$request->getvalue,
            ]);

        }
    }


}
