<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Redirect;
use Alert;
use Route;

class IdiaryController extends Controller
{
    public function addidiary(Request $request)
    {
        $casenoid               = $request->input('idiarycasenoidadd');
        $idiary_date            = $request->input('idiary_date');
        $idiarytasktobedone     = $request->input('idiarytaskdetails');
        $idiarycategory         = $request->input('idiarytasktype');
        $idiarystatus           = $request->input('idiarystatus');
        $idiarystarttime        = $request->input('idiary_starttime');
        $idiaryendtime          = $request->input('idiary_endtime');
        $updatedby              = Auth::user()->email;
        
        DB::table('tbl_case_idiary')->insert([
            'case_no_id' => $casenoid,
            'date'=>$idiary_date,
            'task_to_be_done' => $idiarytasktobedone,
            'activity_category' => $idiarycategory,
            'start_time' => $idiarystarttime,
            'end_time' => $idiaryendtime,
            'updated_by' => $updatedby
            ]);

            Alert::success('Idiary added successfully');
                             return Redirect::back();
    }

    public function showeditidiary($id)
    {
        
        $idiarydetails= DB::table('tbl_case_idiary')
            ->where('id',$id)
            ->get();

        $tasktypes =  DB::table('tbl_task_types_lookup')->get();
        
             return view('idiaries.edit',compact('idiarydetails','tasktypes'));
    }

    public function updateidiary(Request $request)
    {
        
        $id                 = $request->input('idiaryid');
        $date               = $request->input('idiary_date');
        $tasktype           = $request->input('idiarytasktype');
        $taskdetails        = $request->input('idiarytaskdetailsedit');
        $status             = $request->input('idiarystatus');
        $starttime          = $request->input('idiary_starttime');
        $endtime            = $request->input('idiary_endtime');

        DB::table('tbl_case_idiary')->where('id', $id)
                    ->update(array(                                     
                        'date' => $date,
                        'activity_category' => $tasktype,
                        'task_to_be_done' => $taskdetails,
                        'status' => $status,
                        'start_time' =>$starttime,
                        'end_time' => $endtime
                        
                    ));
        
        Alert::success('You\'ve Successfully updated idiary');
                    return Redirect::back();

        }

    public function deleteidiary($id)
        {
            $id = Route::current()->parameter('idiary_id');

            DB::delete('delete from tbl_case_idiary where id = ?',[$id]);
        
            Alert::success('You\'ve Successfully deleted idiary');
                return Redirect::back();

        }
}
