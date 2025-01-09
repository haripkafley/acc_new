<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Alert;
use Redirect;

class CaseSummaryController extends Controller
{
    public function addcasesummary(Request $request)
    {
        $casenoid           = $request->input('casesummarycasenoidadd');
        $casesummarydtls    = $request->input('casesummarydtls');

        DB::table('tbl_registered_cases')->where('id', $casenoid)
                ->update(array( 
                'case_summary'=>$casesummarydtls));

            Alert::success('Case Summary Added Successfully');
                        return Redirect::back();
    }

    public function updatecasesummary(Request $request)
    {
        $casenoid           = $request->input('casesummarycasenoidedit');
        $casesummarydtls    = $request->input('casesummaryeditdtls');

        DB::table('tbl_registered_cases')->where('id', $casenoid)
                ->update(array( 
                'case_summary'=>$casesummarydtls));

            Alert::success('Case Summary Updated Successfully');
                        return Redirect::back();
    }
}
