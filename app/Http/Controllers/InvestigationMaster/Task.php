<?php

namespace App\Http\Controllers\InvestigationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inv_pltbltask;
use Redirect;
use Alert;
class Task extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = inv_pltbltask::where('isDelete','0')->get();
        return view('investigation_master.task',$data);
    }

    public function delete($id)
    {
        inv_pltbltask::where('invtaskID',$id)->update(['isDelete'=>'1']);
        Alert::success('You\'ve Successfully Deleted A Task');
        return Redirect::back();
    }

    public function insert(Request $request)
    {
        // return $request;
        $new = new inv_pltbltask;
        $new->invTaskName = $request->invTaskName;
        $new->save();
        Alert::success('You\'ve Successfully Added A Task');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        inv_pltbltask::where('invtaskID',$request->id)->update([
            'invTaskName'=>$request->invTaskName,
            
            
        ]);
        Alert::success('You\'ve Successfully Updated A Task');
        return Redirect::back();
    }
}
