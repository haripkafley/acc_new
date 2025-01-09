<?php

namespace App\Http\Controllers\InvestigationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inv_pltblinv_investigationtype;
use Redirect;
use Alert;
class InvestigationType extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = inv_pltblinv_investigationtype::where('isDelete','0')->get();
        return view('investigation_master.type',$data);
    }

    public function delete($id)
    {
        inv_pltblinv_investigationtype::where('investigationTypeID',$id)->update(['isDelete'=>'1']);
        Alert::success('You\'ve Successfully Deleted A Investigation Type');
        return Redirect::back();
    }

    public function insert(Request $request)
    {
        // return $request;
        $new = new inv_pltblinv_investigationtype;
        $new->investigationTypeName = $request->investigationTypeName;
        $new->save();
        Alert::success('You\'ve Successfully Added A Investigation Type');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        inv_pltblinv_investigationtype::where('investigationTypeID',$request->id)->update([
            'investigationTypeName'=>$request->investigationTypeName,
            
            
        ]);
        Alert::success('You\'ve Successfully Updated A Investigation Type');
        return Redirect::back();
    }
}
