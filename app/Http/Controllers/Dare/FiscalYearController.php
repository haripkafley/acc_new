<?php

namespace App\Http\Controllers\Dare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dare\FiscalYear;
use Alert;
class FiscalYearController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = FiscalYear::where('status','A')->get();
        return view('dare.fiscal_year',$data);
    }

    public function insert(Request $request)
    {
        $check = FiscalYear::where('status','A')->where('year',$request->year)->first();
        if (@$check!="") {
            Alert::error('Fiscal Year Already Added.Try Another.');
            return redirect()->back();
        }
        $new = new FiscalYear;
        $new->year = $request->year;
        $new->start_date = $request->start_date;
        $new->end_date = $request->end_date;
        $new->save();
        Alert::success('You\'ve Successfully Added A Fiscal Year ');
        return redirect()->back();
    }


    public function update(Request $request)
    {
        $upd = [];
        $upd['start_date'] = $request->start_date;
        $upd['end_date'] = $request->end_date;
        FiscalYear::where('id',$request->id)->update($upd);
        Alert::success('You\'ve Successfully Updated Data ');
        return redirect()->back();
    }

    public function delete($id)
    {
        FiscalYear::where('id',$id)->update(['status'=>'D']);
        Alert::success('You\'ve Successfully Deleted Data ');
        return redirect()->back();
    }


}
