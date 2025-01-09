<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdditionalInformationEvaluation;
use Redirect;
use Alert;
class AdditionalController extends Controller
{
    public function index($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = AdditionalInformationEvaluation::where('complaint_id',$id)->where('status','A')->get();
        return view('evaluation.information',$data);
    }

    public function insert(Request $request)
    {
        $ins = new AdditionalInformationEvaluation;
        $ins->description = $request->description;
        $ins->date = $request->date;
        $ins->user_id = auth()->user()->id;
        $ins->complaint_id = $request->id;
        if(@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/information/',$filename);
            $ins->attachment = $filename;
        }

        $ins->save();
        Alert::success('You\'ve Successfully Added A Information ');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        $upd = [];
        $upd['description'] = $request->description;
        $upd['date'] = $request->date;
        $upd['user_id'] = auth()->user()->id;
        if(@$request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/information/',$filename);
            $upd['attachment'] = $filename;
        }
        AdditionalInformationEvaluation::where('id',$request->info_id)->update($upd);
        Alert::success('You\'ve Successfully Updated A Information ');
        return Redirect::back();

    }

    public function delete($id)
    {
        AdditionalInformationEvaluation::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Information ');
        return Redirect::back();
    }
}
