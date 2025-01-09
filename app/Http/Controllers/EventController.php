<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Redirect;
use Alert;
use Route;
use Carbon\Carbon;

class EventController extends Controller
{
    public function addevent(Request $request)
    {
       
        $casenoid            = $request->input('eventcasenoidadd');
        $eventname           = $request->input('eventname');
        $eventdate           = $request->input('eventdate');        
        $eventdescription    = $request->input('event_desc'); 
        $eventtime            = $request->input('event_time');
        


        $data=array('case_no_id'=>$casenoid,'name'=>$eventname,'date'=>$eventdate,
        'description'=>$eventdescription,'time'=>$eventtime,'conducted_by'=>Auth::user()->name,
         'created_at' => Carbon::now());
        DB::table('tbl_case_events')->insert($data);

        Alert::success('You\'ve Successfully added an Event');
        return Redirect::back();
    }
    

    public function editevent($id)
    {
        $events= DB::table('tbl_case_events')
            ->where('id',$id)
            ->get();

        return view('events.editevents',compact('events'));
    }

    public function updateevent(Request $request)
    {
        
        $id                = $request->input('editeventid');
        $eventname         = $request->input('eventname');
        $eventdate         = $request->input('eventdate'); 
        $eventtime         = $request->input('eventtime');       
        $eventdescription  = $request->input('event_desc');

        DB::table('tbl_case_events')->where('id', $id)
                    ->update(array( 
                        'name'=>$eventname,
                        'date'=>$eventdate,
                        'time' => $eventtime,
                        'description'=>$eventdescription,
                        'updated_at' => Carbon::now()
                             ));
                             Alert::success('You\'ve Successfully edited an Event');
                             return Redirect::back();

    }

    public function deleteevent($id)
        {
            $id = Route::current()->parameter('id');

            DB::delete('delete from tbl_case_events where id = ?',[$id]);
        
            Alert::success('You\'ve Successfully deleted event');
                return Redirect::back();

        }
}
