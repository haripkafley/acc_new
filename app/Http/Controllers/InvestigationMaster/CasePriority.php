<?php

namespace App\Http\Controllers\InvestigationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inv_pltblcase_priority;
use Redirect;
use Alert;
class CasePriority extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = inv_pltblcase_priority::where('isDelete','0')->get();
        return view('investigation_master.case',$data);
    }

    public function delete($id)
    {
        inv_pltblcase_priority::where('invCasePriorityID',$id)->update(['isDelete'=>'1']);
        Alert::success('You\'ve Successfully Deleted A Case Priority');
        return Redirect::back();
    }

    public function insert(Request $request)
    {
        // return $request;
        $new = new inv_pltblcase_priority;
        $new->priorityName = $request->priorityName;
        $new->save();
        Alert::success('You\'ve Successfully Added A Case Priority');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        inv_pltblcase_priority::where('invCasePriorityID',$request->id)->update([
            'priorityName'=>$request->priorityName,
            
            
        ]);
        Alert::success('You\'ve Successfully Updated A Case Priority');
        return Redirect::back();
    }
}
