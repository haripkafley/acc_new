<?php

namespace App\Http\Controllers\InvestigationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inv_pltblinvestigation_branch;
use Redirect;
use Alert;
class BranchController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = inv_pltblinvestigation_branch::where('isDelete','0')->get();
        return view('investigation_master.branch',$data);
    }

    public function delete($id)
    {
        inv_pltblinvestigation_branch::where('invBranchID',$id)->update(['isDelete'=>'1']);
        Alert::success('You\'ve Successfully Deleted A Branch');
        return Redirect::back();
    }

    public function insert(Request $request)
    {
        // return $request;
        $new = new inv_pltblinvestigation_branch;
        $new->branchName = $request->branchName;
        $new->save();
        Alert::success('You\'ve Successfully Added A Branch');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        inv_pltblinvestigation_branch::where('invBranchID',$request->id)->update([
            'branchName'=>$request->branchName,
            
            
        ]);
        Alert::success('You\'ve Successfully Updated A Branch');
        return Redirect::back();
    }

    
}
