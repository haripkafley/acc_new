<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Mail;
use Alert;
use Redirect;
use Route;
use Carbon\Carbon;
use App\Models\CaseInvestigationPlan;
use App\Models\CaseOffenceTypesInvPlan;
use App\Models\RegisteredCase;
use App\Models\CaseHypoEvidence;
use App\Models\CaseActionPlanActivity;
use App\Models\CaseActionPlan;
use App\Models\CaseIdiary;
use App\Models\CaseHypothesis;

class InvestigationPlanController extends Controller
{
    public function add_investigation_plan(Request $request)
    {
         DB::beginTransaction();

        try 
            {
                $case_start_date   = $request->input('case_start_date');
                $case_end_date     = $request->input('case_end_date');
                $allegations       = $request->input('case_allegations');
                $objectives        = $request->input('case_objectives');
                $scope             = $request->input('case_scope');
                $offtype           = $request->input('offence_type_invplan');
                $casenoid          = $request->input('invplancasenoidadd');
            
            CaseInvestigationPlan::insert([
                'case_no_id' => $casenoid,
                'case_start_date' => $case_start_date,
                'case_end_date'=>$case_end_date,
                'allegations' => $allegations,
                'objectives' => $objectives,
                'scope' => $scope,
                
                ]);

                foreach($offtype as $offtype)
                {
                    CaseOffenceTypesInvPlan::insert([
                        'case_no_id' => $casenoid,
                        'offence_type' => $offtype
                    ]);
                }
                DB::commit();
                
                Alert::success('Investigation Plan Created Successfully');
                return Redirect::back();
                
               
            } 
        catch (Exception $e) 
            {
                DB::rollBack();

            }
    
    }

    /////////////////////////////////////////////////////////////////////////////////
    public function updateinvplan(Request $request)
    {
        
        $id                 = $request->input('invplaneditid');
        $end_date           = $request->input('case_end_date_inv');
        $case_allegations   = $request->input('case_allegations_inv');
        $case_objectives    = $request->input('case_objectives_inv');
        $case_scope         = $request->input('case_scope_inv');

        CaseInvestigationPlan::where('id', $id)
                    ->update(array(                                     
                        'case_end_date' => $end_date,
                        'allegations' => $case_allegations,
                        'objectives' => $case_objectives,
                        'scope' => $case_scope,
                    ));
        
                    Alert::success('You\'ve Successfully updated investigation plan');
                   return Redirect::back();
    }
    
    ///////////////////////////////////////////////////////////

    public function updateinvplanstatus(Request $request)
    {
        
        $casenoid       = $request->input('casenoidinvstatusupdate');
        $caseno         = RegisteredCase::where('id', $casenoid)->value('case_no');
        $casetitle      = RegisteredCase::where('id', $casenoid)->value('case_title');
        $chief_email    = DB::table('tbl_user_role_mapping')->where('case_no_id', $casenoid)->where('role', "=", 'Chief')->value('assigned_to');
        $sender_email   = Auth::user()->name;

        CaseInvestigationPlan::where('case_no_id', $casenoid)
            ->update(array('evaluation_status' => "1",));
        
                $data["chiefemail"] = $chief_email;

                $chief_name =  DB::table('users')->where('email',$chief_email)->value('name');

                $data["title"]  = "Review Investigation Plan";
                $data["first"]  = "Dear Mr/Mrs/Ms " . $chief_name . ",";
                $data["second"] = "This is to notify that you have been requested by ". $sender_email . " to review the investigation plan relating to case:";
                $data["third"]  = "Case No:" . $caseno;
                $data["fourth"] = "Case Title:" . $casetitle;

                $data["cardValue"] = "Review Investigation Plan";    

                // Mail::send('emails.reviewinvplanemail', $data, function($message)use($data) {
                //     $message->to($data["chiefemail"], $data["chiefemail"])
                //             ->subject($data["title"]);
                // });
        
        Alert::success('Your application has been successfully submitted for evaluation to your immediate supervisor for review and comment. You must wait for the response to be able to proceed further');
                   return Redirect::back();
    }
    ///////////////////////////////////////////////////////////

    public function editinvplan($id)
    {
        $investigationplans= DB::table('tbl_case_investigation_plans')
            ->where('id',$id)
            ->get();

        return view('investigationplans.editinvplan',compact('investigationplans'));
    }

    ///////////////////////////////////////////////////////////////

    public function showhypoevidencedetails($id)
    {
        $hypdetails= DB::table('tbl_case_hypothesis')
            ->where('id',$id)
            ->get();
        
        $assessmenttypes = DB::table('tbl_assessment_types_lookup')
        ->get();

        return view('hypothesisandevidence.showhypoevidencedetails',compact('hypdetails','assessmenttypes'));
    }

    ////////////////////////////////////////////////////////////////

    public function add_hypothesis(Request $request)
    {
         DB::beginTransaction();

        try 
            {
                $casenoid       = $request->input('casenoidaddhypo');
                $hypothesis     = $request->input('case_hypo');
                $evidence       = $request->input('case_evidence');
                
                $countevidence = COUNT($evidence); 
                
                CaseHypothesis::insert([
                        'case_no_id' => $casenoid,
                        'hypotheses'=>$hypothesis,

                        ]);

                $hypothesisid    = CaseHypothesis::latest('id')->first();
                $id = $hypothesisid->id;           

                for($j=0; $j<$countevidence; $j++)//loop thru each arrays
                {
                
                    CaseHypoEvidence::insert([
                        'case_no_id' => $casenoid,
                        'evidences' => $evidence[$j],
                        'hypothesis_id' => $id
                    ]);
                }
                DB::commit();

        Alert::success('You\'ve Successfully added hypothesis');
       return Redirect::back();
    
                
            } 
        catch (Exception $e) 
            {
                DB::rollBack();

            }

             
    }
    ///////////////////////////////////////////////////////////////

    public function add_action_plan(Request $request)
    {
         DB::beginTransaction();

        try 
            {
                $casenoid            = $request->input('casenoidaddactionplan');
                $activitycategory    = $request->input('actionplantaskactivityadd');
                $startdate           = $request->input('startdateactionplan');
                $cycle               = $request->input('actionplantaskcycle');

                $taskname            = $request->input('actionplantask');
                $taskdesc            = $request->input('actionplandesc');
                $taskpriority        = $request->input('actionplanpriority');
                $taskassignedto      = $request->input('actionplanassignedto');
                $duedate             = $request->input('duedate');
        
        $lastno =  CaseActionPlan::where('case_no_id' , $casenoid )->orderBy('weekname', 'desc')->value('weekname');
            
        if(isset($lastno))
        {
            $serialno = $lastno + 1;
        }

        else
        {
            $serialno = 1;
        }

        if($cycle == "Weekly")
        {
            $enddate = Carbon::parse($startdate) ->addDays(7);
        }
        if($cycle == "Fortnightly")
        {
            $enddate = Carbon::parse($startdate) ->addDays(14);
        }
        if($cycle == "Monthly")
        {
            $enddate = Carbon::parse($startdate) ->addDays(30);
        }

            CaseActionPlan::insert([
                'case_no_id' => $casenoid,
                'activity_category' => $activitycategory,
                'cycle'=>$cycle,
                'actionplanstartdate' => $startdate,
                'actionplanenddate' => $enddate,
                'weekname' => $serialno,
                'status' => 'Open'
                
                ]);

            CaseInvestigationPlan::where('case_no_id', $casenoid)
                    ->update(array(                                     
                        'startdate_actionplan' => $enddate,
                       
                    ));

            $actionplanid    = CaseActionPlan::latest('id')->first();
            $id = $actionplanid->id;
            
            $countactivities = COUNT($taskname);
       
            if (!empty($countactivities)) 
                {
                    for($j=0; $j<$countactivities; $j++)
                        {
                            CaseActionPlanActivity::insert([
                                'actionplanid' => $id,
                                'case_no_id' => $casenoid,
                                'task' => $taskname[$j],
                                'description' => $taskdesc[$j],
                                'priority' => $taskpriority[$j],
                                'assigned_to' => $taskassignedto[$j],
                                'due_date' => $duedate[$j],
                                'assigned_on' => Carbon::now()
                                
                            ]);
                        }
                }
                DB::commit();
           
                Alert::success('Action Plan Added Successfully');
           return Redirect::back();
    
                
            } 
        catch (Exception $e) 
            {
                DB::rollBack();

            }
        
    }

    public function saveactionplanaddmore(Request $request)
    {
        $taskname        = $request->input('tasknameaddmore');
        $taskdesc        = $request->input('descriptionaddmore');
        $taskpriority    = $request->input('priorityaddmore');
        $taskassignedto  = $request->input('assignedtoaddmore');
        $id              = $request->input('actionplanidaddmore');
        $casenoid        = $request->input('casenoidaddmore');
        $duedate         = $request->input('duedateaddmore');

        CaseActionPlanActivity::insert([
                                'actionplanid' => $id,
                                'case_no_id' => $casenoid,
                                'task' => $taskname,
                                'description' => $taskdesc,
                                'priority' => $taskpriority,
                                'assigned_to' => $taskassignedto,
                                'due_date' => $duedate,
                                'assigned_on' => Carbon::now()
                                
                            ]);
        
        Alert::success('Action Plan Added Successfully');
           return Redirect::back();
    }

    public function updatehypothesisstatus(Request $request)
    {
        $id      = $request->input('hypothesisid');
        $status  = $request->input('assessmentstatus');

        CaseHypothesis::where('id', $id)
                    ->update(array(                                     
                        'evaluation_status' => $status,
                        'evaluated_on' => Carbon::now()
                    ));

        
        Alert::success('You\'ve Successfully evaluated hypothesis');
                   return Redirect::back();
    }

    public function updateactionplanstatus(Request $request)
    {
            
        $id      = $request->input('actionplanstatuseditid');
        $status  = $request->input('actionplanstatus');

        CaseActionPlanActivity::where('id', $id)
                    ->update(array(                                     
                        'status' => $status,
                        'date_of_completion' => Carbon::now()
                    ));

        $details = CaseActionPlanActivity::where('id', $id)->first();
        
        $actionplandetails = CaseActionPlan::where('id', $details->actionplanid)->first();
         
         
        if($status == "Complete")
            {
                CaseIdiary::insert([
                'case_no_id' => $details->case_no_id,
                'task_to_be_done' => $details->task,
                'assigned_to' => $details->assigned_to,
                'status' => $status,
                'activity_category' => $actionplandetails->activity_category,
                'date' => Carbon::now()

                ]);
        
            }
        
        
        
        Alert::success('You\'ve Successfully updated status');
                   return Redirect::back();
    }

    public function deletehypothesis($hypoid)
    {
        $id = Route::current()->parameter('hypoid');

        DB::delete('delete from tbl_case_hypothesis where id = ?',[$id]);
        DB::delete('delete from tbl_case_hypo_evidences where hypothesis_id = ?',[$id]);

        Alert::success('You\'ve Successfully deleted hypothesis');
        return Redirect::back();
    }
}
