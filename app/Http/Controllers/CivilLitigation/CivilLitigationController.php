<?php

namespace App\Http\Controllers\CivilLitigation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Legal\CivilLitigation;
use Alert;
use Auth;
use DB;
use Redirect;
class CivilLitigationController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = CivilLitigation::where('status','A')->get();
        return view('civil_litigation.index',$data);
    }

    public function insertData(Request $request)
    {
        $new = new CivilLitigation;
        $new->service_request = $request->service_request;
        $new->description = $request->description;
        $new->requested_by = $request->requested_by;
        $new->request_date = $request->date;
        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/legal/',$filename);
                    $new->attachment = $filename;
        }
        $new->save();
        Alert::success('You\'ve Successfully Added A Civil Litigation Request');
        return Redirect::back();

    }

    public function updateData(Request $request)
    {
        $upd = [];
        $upd['service_request'] = $request->service_request;
        $upd['description'] = $request->description;
        $upd['requested_by'] = $request->requested_by;
        $upd['request_date'] = $request->date;
        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/legal/',$filename);
                    $upd['attachment'] = $filename;
        }
        CivilLitigation::where('id',$request->id)->update($upd);
        Alert::success('You\'ve Successfully Updated A Civil Litigation Request');
        return Redirect::back();

    }

    public function deleteData($id)
    {
        CivilLitigation::where('id',$id)->update(['status'=>'D']);
        Alert::success('You\'ve Successfully Deleted A Civil Litigation Request');
        return Redirect::back();
    }
}
