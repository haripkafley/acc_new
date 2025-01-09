<?php

namespace App\Http\Controllers\Complaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\CompalintEveOffence;
use App\Models\Complaint\OffenceEvaluation;
use Auth;
use DB;
use Redirect;
use Alert;
class AllegationController extends Controller
{
    public function allegationIndex($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['allegation'] = CompalintEveOffence::where('type','alle')->where('complaint_id',$id)->get();
        $data['evalution_offence_list'] = CompalintEveOffence::where('type','OFF')->where('complaint_id',$id)->get();
        $data['offence_list'] = OffenceEvaluation::get();
        return view('complaint.allegation',$data);
    }

    public function allegationInsert(Request $request)
    {
        $new = new CompalintEveOffence;
        $new->allegation_name = $request->allegation_name;
        $new->allegation_description = $request->allegation_description;
        $new->complaint_id = $request->complaint_id;
        $new->type = 'alle';
        $new->save();
        Alert::success('Allegation added successfully');
        return redirect()->back();
    }

    public function allegationupdate(Request $request)
    {
        CompalintEveOffence::where('id',$request->id)->update([
            'allegation_name'=>$request->allegation_name,
            'allegation_description'=>$request->allegation_description,
        ]);
        Alert::success('Allegation updated successfully');
        return redirect()->back();
    }

    public function allegationdelete($id)
    {
        CompalintEveOffence::where('id',$id)->delete();
        Alert::success('Allegation deleted successfully');
        return redirect()->back();
    }

}
