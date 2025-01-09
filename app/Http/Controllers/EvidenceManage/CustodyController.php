<?php

namespace App\Http\Controllers\EvidenceManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustodyStorageProperty;
use App\Models\Evidence\EvidenceCaseAssign;
use App\Models\Custody\CashStorage;
use App\Models\Custody\MaintenanceLog;
use App\Models\Custody\Valuation;
use App\Models\Custody\Chain;
use App\Models\Custody\LeaseHiring;
use Alert;
use DB;
class CustodyController extends Controller
{
    public function index($id)
    {
        $data = [];
        $data['data'] = EvidenceCaseAssign::where('id',$id)->first();
        if(@$data['data']->user_id != auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }
        $data['case_id'] = $data['data']->case_id;
        $data['id'] = $id;
        $data['data'] = CustodyStorageProperty::where('case_id',$data['data']->case_id)->get();
        return view('custody.property',$data);
    }

    public function insert(Request $request)
    {
        $new = new CustodyStorageProperty;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;

        $new->item = $request->item;
        $new->item_code = $request->item_code;
        $new->item_description = $request->item_description;
        $new->room_no = $request->room_no;

        $new->rack_no = $request->rack_no;
        $new->column_no = $request->column_no;
        $new->box_no = $request->box_no;
        $new->file_no = $request->file_no;

        $new->other_location = $request->other_location;
        $new->status = $request->status;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();

    }

    public function update(Request $request)
    {
        CustodyStorageProperty::where('id',$request->id)->where('case_id',$request->case_id)->update([
            'item' => $request->item,
            'item_code' => $request->item_code,
            'item_description' => $request->item_description,
            'room_no' => $request->room_no,

            'rack_no' => $request->rack_no,
            'column_no' => $request->column_no,
            'box_no' => $request->box_no,
            'file_no' => $request->file_no,

            'other_location' => $request->other_location,
            'status' => $request->status,

        ]);

        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function delete($id)
    {
        CustodyStorageProperty::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function cashIndex($id)
    {
        $data = [];
        $data['data'] = EvidenceCaseAssign::where('id',$id)->first();
        if(@$data['data']->user_id != auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }
        $data['id'] = $id;
        $data['case_id'] = $data['data']->case_id;
        $data['data'] = CashStorage::where('case_id',$data['data']->case_id)->get();
        return view('custody.cash',$data);
    }


    public function cashInsert(Request $request)
    {
        $new = new CashStorage;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;

        $new->amount = $request->amount;
        $new->date_receipt = $request->date_receipt;
        $new->time_receipt = $request->time_receipt;

        $new->source = $request->source;
        $new->description = $request->description;
        $new->location_amount = $request->location_amount;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function cashupdate(Request $request)
    {
        CashStorage::where('id',$request->id)->where('case_id',$request->case_id)->update([
            'amount' => $request->amount,
            'date_receipt' => $request->date_receipt,
            'time_receipt' => $request->time_receipt,
            'source' => $request->source,
            'description' => $request->description,
            'location_amount' => $request->location_amount,
         ]);

        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function cashdelete($id)
    {
        CashStorage::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function maintenanceIndex($id)
    {
        $data = [];
        $data['data'] = EvidenceCaseAssign::where('id',$id)->first();
        if(@$data['data']->user_id != auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }
        $data['id'] = $id;
        $data['case_id'] = $data['data']->case_id;
        $data['data'] = MaintenanceLog::where('case_id',$data['data']->case_id)->get();
        $data['itemsData'] = CustodyStorageProperty::where('case_id',$data['case_id'])->get();
        return view('custody.maintain',$data);
    }

    public function maintenanceInsert(Request $request)
    {
        $new = new MaintenanceLog;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;
        $new->item_id = $request->item_id;
        // $new->item = $request->item;
        // $new->item_code = $request->item_code;
        // $new->item_description = $request->item_description;

        $new->date = $request->date;
        $new->maintenance_type = $request->maintenance_type;
        $new->location = $request->location;
        $new->carried_by = $request->carried_by;
        $new->amount = $request->amount;

        if (@$request->hasFile('evidence')) {
            $file = $request->evidence;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/custody/evidence/',$filename);
            $new->evidence = $filename;
        }
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function maintenanceupdate(Request $request)
    {
        MaintenanceLog::where('id',$request->id)->where('case_id',$request->case_id)->update([
            'date' => $request->date,
            'maintenance_type' => $request->maintenance_type,
            'location' => $request->location,

            'carried_by' => $request->carried_by,
            'amount' => $request->amount,
         ]);

        if (@$request->hasFile('evidence')) {
            $upd = [];
            $file = $request->evidence;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/custody/evidence/',$filename);
            $upd['evidence'] = $filename;
            MaintenanceLog::where('id',$request->id)->where('case_id',$request->case_id)->update($upd);
        }

        Alert::success('Data updated successfully');
        return redirect()->back();

    }


    public function maintenancedelete($id)
    {
        MaintenanceLog::where('id',$id)->delete();
        Alert::success('Data delted successfully');
        return redirect()->back();
    }


    public function valuationIndex($id)
    {
        $data = [];
        $data['data'] = EvidenceCaseAssign::where('id',$id)->first();
        if(@$data['data']->user_id != auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }
        $data['case_id'] = $data['data']->case_id;
        $data['id'] = $id;
        $data['data'] = Valuation::where('case_id',$data['data']->case_id)->get();
        $data['itemsData'] = CustodyStorageProperty::where('case_id',$data['case_id'])->get();
        return view('custody.valuation',$data);
    }

    public function valuationInsert(Request $request)
    {
        $new = new Valuation;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;
        $new->item_id = $request->item_id;

        // $new->item = $request->item;
        // $new->item_code = $request->item_code;
        // $new->item_description = $request->item_description;

        $new->date = $request->date;
        $new->worth = $request->worth;
        $new->competen = $request->competen;
        

        if (@$request->hasFile('report')) {
            $file = $request->report;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/custody/report/',$filename);
            $new->report = $filename;
        }
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function valuationupdate(Request $request)
    {
        Valuation::where('id',$request->id)->where('case_id',$request->case_id)->update([
            // 'item' => $request->item,
            // 'item_code' => $request->item_code,
            // 'item_description' => $request->item_description,
            'date' => $request->date,
            'worth' => $request->worth,
            'competen' => $request->competen,
        ]);

        if (@$request->hasFile('report')) {
            $upd = [];
            $file = $request->report;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/custody/report/',$filename);
            $upd['report'] = $filename;
            Valuation::where('id',$request->id)->where('case_id',$request->case_id)->update($upd);
        }

        Alert::success('Data updated successfully');
        return redirect()->back();
    }


    public function valuationdelete($id)
    {
        Valuation::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function leaseHiring($id)
    {
        $data = [];
        $data['data'] = EvidenceCaseAssign::where('id',$id)->first();
        if(@$data['data']->user_id != auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }
        $data['case_id'] = $data['data']->case_id;
        $data['id'] = $id;
        $data['data'] = LeaseHiring::where('case_id',$data['data']->case_id)->get();
        $data['itemsData'] = CustodyStorageProperty::where('case_id',$data['case_id'])->get();
        return view('custody.lease_hiring',$data);   
    }

    public function leaseHiringInsert(Request $request)
    {
        $new = new LeaseHiring;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;
        $new->item_id = $request->item_id;
        $new->action_type = $request->action_type;
        $new->leased_to = $request->leased_to;
        $new->name = $request->name;
        if (@$request->leased_to=="B") {
            $new->license = $request->license;
        }else{
            $new->cid = $request->cid;
        }
        $new->start_date = $request->start_date;
        $new->end_date = $request->end_date;
        $new->remarks = $request->remarks;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }

    public function leaseHiringupdate(Request $request)
    {
        $upd = [];
        $upd['action_type'] = $request->action_type;
        $upd['name'] = $request->name;
        $upd['start_date'] = $request->start_date;
        $upd['end_date'] = $request->end_date;
        $upd['remarks'] = $request->remarks;
        $upd['cid'] = $request->cid;
        $upd['license'] = $request->license;
        LeaseHiring::where('id',$request->id)->where('case_id',$request->case_id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();

    }


    public function leaseHiringdelete($id)
    {
        LeaseHiring::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();   
    }

    public function chainIndex($id)
    {
        $data = [];
        $data['data'] = EvidenceCaseAssign::where('id',$id)->first();
        if(@$data['data']->user_id != auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }
        $data['id'] = $id;
        $data['case_id'] = $data['data']->case_id;
        $data['data'] = Chain::where('case_id',$data['data']->case_id)->get();
        $data['itemsData'] = CustodyStorageProperty::where('case_id',$data['case_id'])->get();
        return view('custody.chain',$data);
    }


    public function chainInsert(Request $request)
    {
        $new = new Chain;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;
        $new->item_id = $request->item_id;
        // $new->item = $request->item;
        // $new->item_code = $request->item_code;
        // $new->item_description = $request->item_description;

        $new->issued_to = $request->issued_to;
        $new->issued_by = $request->issued_by;
        $new->issue_date = $request->issue_date;

        $new->issue_time = $request->issue_time;
        $new->purpose = $request->purpose;
        
        
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function chainupdate(Request $request)
    {
        Chain::where('id',$request->id)->where('case_id',$request->case_id)->update([
            'issued_to' => $request->issued_to,
            'issued_by' => $request->issued_by,
            'issue_date' => $request->issue_date,

            'issue_time' => $request->issue_time,
            'purpose' => $request->purpose,
         ]);

        Alert::success('Data updated successfully');
        return redirect()->back();

    }


    public function chaindelete($id)
    {
        Chain::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function chainreturn(Request $request)
    {
        Chain::where('id',$request->id)->where('case_id',$request->case_id)->update([
            'return_by' => $request->return_by,
            'return_date' => $request->return_date,
            'return_time' => $request->return_time,
            'received_by' => $request->received_by,
            'remarks' => $request->remarks,
        ]);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }

}
