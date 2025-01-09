<?php

namespace App\Http\Controllers\EvidenceManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evidence\EvidenceCaseAssign;
use App\Models\Disposal\EscrowAccused;
use App\Models\Disposal\EscrowAgency;
use App\Models\Disposal\Auction;
use App\Models\Disposal\ReturnItem;
use App\Models\CustodyStorageProperty;
use Alert;
use DB;;
class DisposalController extends Controller
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
        $data['data'] = EscrowAccused::where('case_id',$data['data']->case_id)->get();
        return view('disposal.escrow_accused',$data);
    }


    public function insert(Request $request)
    {
        $new = new EscrowAccused;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;

        $new->cid = $request->cid;
        $new->name = $request->name;
        $new->date = $request->date;
        $new->time = $request->time;

        $new->amount = $request->amount;
        $new->handed_over_to = $request->handed_over_to;
        $new->purpose = $request->purpose;
        $new->remarks = $request->remarks;

        if (@$request->hasFile('reference')) {
            $file = $request->reference;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/disposal/reference/',$filename);
            $new->reference = $filename;
        }


        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function update(Request $request)
    {
        EscrowAccused::where('id',$request->id)->where('case_id',$request->case_id)->update([
            'cid' => $request->cid,
            'name' => $request->name,
            'date' => $request->date,
            'time' => $request->time,
            'amount' => $request->amount,
            'handed_over_to' => $request->handed_over_to,
            'purpose' => $request->purpose,
            'remarks' => $request->remarks,
         ]);

        if (@$request->hasFile('reference')) {
            $upd = [];
            $file = $request->reference;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/disposal/reference/',$filename);
            $upd['reference'] = $filename;
            EscrowAccused::where('id',$request->id)->where('case_id',$request->case_id)->update($upd);
        }

        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function delete($id)
    {
        EscrowAccused::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function escrowIndex($id)
    {
        $data = [];
        $data['data'] = EvidenceCaseAssign::where('id',$id)->first();
        if(@$data['data']->user_id != auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }
        $data['case_id'] = $data['data']->case_id;
        $data['id'] = $id;
        $data['data'] = EscrowAgency::where('case_id',$data['data']->case_id)->get();
        $data['agency'] = DB::table('pl_tblagency')->get();
        return view('disposal.escrow_agency',$data);
    }


    public function escrowInsert(Request $request)
    {
        $new = new EscrowAgency;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;

        $new->agency = $request->agency;
        $new->date = $request->date;
        $new->time = $request->time;

        $new->amount = $request->amount;
        $new->handed_over_to = $request->handed_over_to;
        $new->purpose = $request->purpose;
        $new->remarks = $request->remarks;

        if (@$request->hasFile('reference')) {
            $file = $request->reference;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/disposal/reference/',$filename);
            $new->reference = $filename;
        }


        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function escrowupdate(Request $request)
    {
        EscrowAgency::where('id',$request->id)->where('case_id',$request->case_id)->update([
            'agency' => $request->agency,
            'date' => $request->date,
            'time' => $request->time,
            'amount' => $request->amount,
            'handed_over_to' => $request->handed_over_to,
            'purpose' => $request->purpose,
            'remarks' => $request->remarks,
         ]);

        if (@$request->hasFile('reference')) {
            $upd = [];
            $file = $request->reference;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/disposal/reference/',$filename);
            $upd['reference'] = $filename;
            EscrowAgency::where('id',$request->id)->where('case_id',$request->case_id)->update($upd);
        }

        Alert::success('Data updated successfully');
        return redirect()->back();
    }


    public function escrowdelete($id)
    {
        EscrowAgency::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function auctionIndex($id)
    {
        $data = [];
        $data['data'] = EvidenceCaseAssign::where('id',$id)->first();
        if(@$data['data']->user_id != auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }
        $data['case_id'] = $data['data']->case_id;
        $data['id'] = $id;
        $data['data'] = Auction::where('case_id',$data['data']->case_id)->get();
        $data['itemsData'] = CustodyStorageProperty::where('case_id',$data['case_id'])->get();
        return view('disposal.auction',$data);
    }


    public function auctionInsert(Request $request)
    {
        $new = new Auction;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;
        $new->item_id = $request->item_id;

        // $new->item = $request->item;
        // $new->item_code = $request->item_code;
        // $new->item_description = $request->item_description;

        $new->purpose = $request->purpose;
        $new->date = $request->date;
        $new->time = $request->time;
        $new->venue = $request->venue;

        $new->auction_com = $request->auction_com;
        $new->reserved_price = $request->reserved_price;
        $new->amount = $request->amount;
        $new->win_bidder = $request->win_bidder;

        $new->cid_bidder = $request->cid_bidder;
        $new->contact_bidder = $request->contact_bidder;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function auctionupdate(Request $request)
    {
        Auction::where('id',$request->id)->where('case_id',$request->case_id)->update([
            // 'item' => $request->item,
            // 'item_code' => $request->item_code,
            // 'item_description' => $request->item_description,
            'purpose' => $request->purpose,
            'date' => $request->date,
            'time' => $request->time,
            'venue' => $request->venue,

            'auction_com' => $request->auction_com,
            'reserved_price' => $request->reserved_price,
            'amount' => $request->amount,
            'win_bidder' => $request->win_bidder,

            'cid_bidder' => $request->cid_bidder,
            'contact_bidder' => $request->contact_bidder,
         ]);

        Alert::success('Data updated successfully');
        return redirect()->back();
    }


    public function auctiondelete($id)
    {
        Auction::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function returnIndex($id)
    {
        $data = [];
        $data['data'] = EvidenceCaseAssign::where('id',$id)->first();
        if(@$data['data']->user_id != auth()->user()->id)
        {
            return redirect()->route('dashboard');
        }
        $data['case_id'] = $data['data']->case_id;
        $data['id'] = $id;
        $data['data'] = ReturnItem::where('case_id',$data['data']->case_id)->get();
        $data['itemsData'] = CustodyStorageProperty::where('case_id',$data['case_id'])->get();
        return view('disposal.return',$data);
    }

    public function returnInsert(Request $request)
    {
        $new = new ReturnItem;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;
        $new->item_id = $request->item_id;

        // $new->item = $request->item;
        // $new->item_code = $request->item_code;
        // $new->item_description = $request->item_description;

        $new->handed_over_by = $request->handed_over_by;
        $new->date = $request->date;
        $new->time = $request->time;
        $new->handed_over_to = $request->handed_over_to;

        $new->maintain = $request->maintain;
        $new->purpose = $request->purpose;
        $new->remarks = $request->remarks;
        
        if (@$request->hasFile('handling_file')) {
            $file = $request->handling_file;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/disposal/handling_file/',$filename);
            $new->handling_file = $filename;
        }

        if (@$request->hasFile('evidence')) {
            $file = $request->evidence;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/disposal/evidence/',$filename);
            $new->evidence = $filename;
        }

        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function returnupdate(Request $request)
    {
        ReturnItem::where('id',$request->id)->where('case_id',$request->case_id)->update([
            // 'item' => $request->item,
            // 'item_code' => $request->item_code,
            // 'item_description' => $request->item_description,
            'purpose' => $request->purpose,
            'date' => $request->date,
            'time' => $request->time,
            'handed_over_to' => $request->handed_over_to,
            'handed_over_by' => $request->handed_over_by,
            'maintain' => $request->maintain,
            'remarks' => $request->remarks,
         ]);

        $upd = [];
        if (@$request->hasFile('handling_file')) {
            $file = $request->handling_file;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/disposal/handling_file/',$filename);
            $upd['handling_file'] = $filename;
        }

        if (@$request->hasFile('evidence')) {
            $file = $request->evidence;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/disposal/evidence/',$filename);
            $upd['evidence'] = $filename;
        }

        ReturnItem::where('id',$request->id)->where('case_id',$request->case_id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();

    }

    public function returndelete($id)
    {
        ReturnItem::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

}
