<?php

namespace App\Http\Controllers;

use DB;
use Alert;
use Redirect;
use Illuminate\Http\Request;

class ForensicController extends Controller
{
   public function forensiccases(Request $request)
    {
    
        $seizeditems =  DB::table('tbl_case_seized_items')->where('forensic_status','Forensics')->get();

        return view('forensics.index',compact('seizeditems'));
        
    }

    public function showeditforensic($id)
    {
        
        $forensicdetails= DB::table('tbl_case_seized_items')
            ->join('tbl_registered_cases', 'tbl_registered_cases.id', '=', 'tbl_case_seized_items.case_no_id')
            ->where('tbl_case_seized_items.id',$id)
            ->select('tbl_registered_cases.case_no','tbl_registered_cases.case_title','tbl_case_seized_items.*')
            ->get();
        
        $status = DB::table('tbl_forensic_status_lookup')->get();

        return view('forensics.editstatus',compact('forensicdetails','status'));
    }

    public function updatestatusforensic(Request $request)
    {
        $id     = $request->input('itemid');
        $status   = $request->input('forensicstatus');

        DB::table('tbl_case_seized_items')->where('id', $id)
                    ->update(array(                                     
                        'id' => $id,
                        'status' => $status,
                    ));
        
        Alert::success('You\'ve Successfully updated status');
                    return Redirect::back();

        
    }
}
