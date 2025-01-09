<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Mail;
use Redirect;
use Alert;

class InterviewPlanController extends Controller
{
    public function add_interview_plan(Request $request)
    {

        $accused          = $request->input('interviewaccused');
        $date             = $request->input('interviewdate');
        $intpersons       = $request->input('interviewers');
        $location         = $request->input('interviewlocation');
        $defences         = $request->input('interviewdefences');
        $facts            = $request->input('facts_altready_established_add');
        $casenoid         = $request->input('interviewplancasenoidadd');
        $interviewPoints  = $request->input('interview_points');
        $interviewFacts   = $request->input('interviewplan_facts');
        $caseno         = DB::table('tbl_registered_cases')->where('id', $casenoid)->value('case_no');
        $casetitle      = DB::table('tbl_registered_cases')->where('id', $casenoid)->value('case_title');
        $chief_email    = DB::table('tbl_user_role_mapping')->where('case_no_id', $casenoid)->where('role', "=", 'Chief')->value('assigned_to');
        $sender_email   = Auth::user()->name;
        
        DB::table('tbl_case_interviewplans')->insert([
                'case_no_id' => $casenoid,
                'accused' => $accused,
                'interview_date'=>$date,
                'location' => $location,
                'defences' => $defences,
                'facts_established' => $facts,
                'status' => 1                
                ]);

            $interviewid    = DB::table('tbl_case_interviewplans')->latest('id')->first();
            $id = $interviewid->id;  

                foreach($intpersons as $inter)
                {
                    DB::table('tbl_case_interviewers')->insert([
                        'case_no_id' => $casenoid,
                        'interviewers' => $inter,
                        'interviewplan_id' => $id
                    ]);
                }

                DB::table('tbl_case_pointstoprove')->insert([
                        'case_no_id' => $casenoid,
                        'pointstoprove' => $interviewPoints,
                        'interviewplanid' => $id
                    ]);

                 $pointsid    = DB::table('tbl_case_pointstoprove')->latest('id')->first();
                 $pid = $pointsid->id;  

                
                $number = COUNT($interviewFacts);//count how many arrays available
                    if($number > 0)  
                    {  
                      for($i=0; $i<$number; $i++)//loop thru each arrays
                        {
                            DB::table('tbl_case_factstodetermine')->insert([
                                'case_no_id'       => $casenoid,
                                'interviewplanid'  => $id,
                                'point_id'         => $pid,
                                'interview_fact'   => $interviewFacts[$i],
                            
                        ]);
                    }
                }

                $data["chiefemail"] = $chief_email;

                $chief_name =  DB::table('users')->where('email',$chief_email)->value('name');

                $data["title"]  = "Review Interview Plan";
                $data["first"]  = "Dear Mr/Mrs/Ms " . $chief_name . ",";
                $data["second"] = "This is to notify that you have been requested by ". $sender_email . " to review the interview plan relating to case:";
                $data["third"]  = "Case No:" . $caseno;
                $data["fourth"] = "Case Title:" . $casetitle;

                $data["cardValue"] = "Review Interview Plan";    

                // Mail::send('emails.reviewinvplanemail', $data, function($message)use($data) {
                //     $message->to($data["chiefemail"], $data["chiefemail"])
                //             ->subject($data["title"]);
                // });


        Alert::success('Your application has been created successfully and submitted for evaluation to your immediate supervisor for review and comment. You must wait for the response to be able to proceed further');
           return Redirect::back();
    
    }

     public function displayinterviewplandetails($id)
    {
        $interviewplans= DB::table('tbl_case_interviewplans')
            ->where('id',$id)
            ->get();
        
        $interviewers = DB::table('tbl_case_interviewers')
            ->where('interviewplan_id',$id)
            ->get();

        $points = DB::table('tbl_case_pointstoprove')
            ->join('tbl_case_factstodetermine', 'tbl_case_factstodetermine.point_id', '=', 'tbl_case_pointstoprove.id')
            ->where('tbl_case_pointstoprove.interviewplanid', $id)
            ->select('tbl_case_pointstoprove.pointstoprove', 'tbl_case_factstodetermine.interview_fact')
            ->get()
            ->groupBy('pointstoprove');

        return view('interviewplans.editinterviewplan',compact('interviewplans','interviewers','points'));
    }

    public function updateinterviewplan(Request $request)
    {
        $id        = $request->input('interviewplanid');
        $status    = $request->input('status');
        $remarks    = $request->input('remarks');

      
         DB::table('tbl_case_interviewplans')->where('id', $id)
                    ->update(array(                                     
                        'status' => 2,
                        'remarks' => $remarks
                    ));
    

        
                    Alert::success('Reviewed Successfully');
                   return Redirect::back();
    }

    public function displaysummonorder($id)
    {
        $interviewers = DB::table('users')
       ->where('role', "Investigator")
        ->get();

        return view('interviewplans.showsummonorder',compact('id','interviewers'));
    }

     public function printsummonorder(Request $request)
    {
       
       $id           = $request->input('interviewplanidforsummonorder');
       $reportto     = $request->input('add_report_to');
       $reportdate   = $request->input('summondate');
       $reporttime   = $request->input('summontime');
       $description  = $request->input('description');
       $quantity     = $request->input('quantity');
       $remarks      = $request->input('remarks');
       $reportvenue  = $request->input('summonvenue');
       
        DB::table('tbl_case_interviewplans')->where('id', $id)
                    ->update(array(  
                        'status' => 3,                                   
                        'report_to'     => $reportto,
                        'report_date'   => $reportdate,
                        'report_time'   => $reporttime,
                        'report_venue'  => $reportvenue
                    ));
        
        $number = COUNT($description);//count how many arrays available
            if($number > 0)  
            {  
                for($j=0; $j<$number; $j++)//loop thru each arrays
                {
                    DB::table('tbl_case_interview_documents')->insert([
                        'interviewplan_id'  => $id,
                        'documents'         => $description[$j],
                        'quantity'          => $quantity[$j],
                        'remarks'           => $remarks[$j]
                    
                ]);
            }
        }

        $interviewdtls  = DB::table('tbl_case_interviewplans')->where('id', $id)->get();
        $documents      = DB::table('tbl_case_interview_documents')->where('interviewplan_id', $id)->get();
        
        return view('interviewplans.printsummonorder',compact('interviewdtls','documents'));
    }

    public function addsummonorder(Request $request)
    {

        $name        = $request->input('intervieweename');
        $reportto    = $request->input('add_report_to');
        $date        = $request->input('summondate');
        $time        = $request->input('summontime');
        $venue       = $request->input('summonvenue');
        $casenoid    = $request->input('summonordercasenoid');

            DB::table('tbl_case_summonorders')->insert([
                'case_no_id'  => $casenoid,
                'interviewee' => $name,
                'report_to'   =>$reportto,
                'summondate'  => $date,
                'summontime'  => $time,
                'summonvenue' => $venue,
                
                ]);

        Alert::success('Summon Order Created Successfully');
           return Redirect::back();
    
    }

    public function displayinterviewreport(Request $request)
    {
        
        $id                            = $request->input('interviewplanidforinterviewreport');
        $interviewtype                 = $request->input('interviewtype');
        $interviewdate                 = $request->input('interviewdate');
        $starttime                     = $request->input('interviewstarttime');
        $endtime                       = $request->input('interviewendtime');
        $actuallocation                = $request->input('actuallocation');
        $interviewsummary              = $request->input('interviewsummary');
        $interviewobservationsummary   = $request->input('interviewobservationsummary');
        $interviewrecord               = $request->input('interviewrecord');
        $urladd                        = $request->input('recordurl');
        $writtenstatement              = $request->input('writtenstatement');
        $writtenby                     = $request->input('writtenby');
        $readby                        = $request->input('readby');
        //$attachment                    = $request->input('statement_read_by_add');

        
        DB::table('tbl_case_interview_report')->insert([
                'interviewplan_id'        => $id,
                'interview_type'          => $interviewtype,
                'interview_date'          => $interviewdate,
                'start_time'              => $starttime,
                'end_time'                => $endtime,
                'actual_location'         => $actuallocation,
                'interview_summary'       => $interviewsummary,
                'observation_summary'     => $interviewobservationsummary,
                'interview_recorded'      => $interviewrecord,
                'interview_recording_url' => $urladd,
                'written_statement'       => $writtenstatement,
                'statement_writtenby'     => $writtenby,
                'statement_readby'        => $readby,
                ]);

                
        DB::table('tbl_case_interviewplans')->where('id', $id)
                    ->update(array(                                     
                        'status' => 4,
                    ));
        
        $interviewreportdtls  = DB::table('tbl_case_interview_report')->where('interviewplan_id', $id)->get();
        $interviewee = DB::table('tbl_case_interviewplans')->where('id', $id)->value('accused');
        $caseno =    DB::table('tbl_case_interviewplans')->where('id', $id)->value('case_no_id');
        $interviewers = DB::table('tbl_case_interviewers')->where('interviewplan_id',$id)->get();

        return view('interviewplans.showinterviewreport',compact('interviewreportdtls','interviewee','caseno','interviewers'));
    }

    public function showinterviewdetails($id)
    {
        
        $interviewdetails= DB::table('tbl_case_interviewplans')
            ->where('id',$id)
            ->get();
        
        $interviewers = DB::table('tbl_case_interviewers')
            ->where('interviewplan_id',$id)
            ->get();

        $points = DB::table('tbl_case_pointstoprove')
            ->join('tbl_case_factstodetermine', 'tbl_case_factstodetermine.point_id', '=', 'tbl_case_pointstoprove.id')
            ->where('tbl_case_pointstoprove.interviewplanid', $id)
            ->select('tbl_case_pointstoprove.pointstoprove', 'tbl_case_factstodetermine.interview_fact')
            ->get()
            ->groupBy('pointstoprove');

        return view('interviewplans.viewinterviewplan',compact('interviewdetails','interviewers','points'));
    }

    public function deleteintplan($id)
        {

            DB::delete('delete from tbl_case_interviewplans where id = ?',[$id]);
            DB::delete('delete from tbl_case_interviewers where interviewplan_id = ?',[$id]);
            DB::delete('delete from tbl_case_pointstoprove where interviewplanid = ?',[$id]);
            DB::delete('delete from tbl_case_factstodetermine where interviewplanid = ?',[$id]);
        
            Alert::success('You\'ve Successfully deleted Interview Plan');
                return Redirect::back();

        }
}
