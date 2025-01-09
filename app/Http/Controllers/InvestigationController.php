<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\CaseEvidenceMatrixOne;



use Alert;

use Carbon\Carbon;
use Date;
use Redirect;
use DateTime;
use Auth;
use DB;
use App\Models\RegisteredCase;
use App\Models\Complaint;
use App\Models\Source;
use App\Models\Priority;
use App\Models\InvestigationType;
use App\Models\Branch;
use App\Models\SectorType;
use App\Models\SectorSubtype;
use App\Models\InstitutionType;
use App\Models\Area;
use App\Models\Offence;
use App\Models\UserRoleMapping;
use App\Models\CaseOffence;
use App\Models\CaseAllegationDocument;
use App\Models\CaseEntity;
use App\Models\Entity;
use App\Models\CaseConflict;
use App\Models\CaseOffenceTypesInvPlan;
use App\Models\CaseInvestigationPlan;
use App\Models\CaseHypothesis;
use App\Models\CaseActionPlan;
use App\Models\CaseEvidence;
use App\Models\CollectionMethod;
use App\Models\EvidenceCategory;
use App\Models\ReportCategoryLookUp;
use App\Models\CaseReport;

class InvestigationController extends Controller
{
    
    public function casesummary(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $caseid = RegisteredCase::where('id', $casenoid)->value('case_id');
        
        $casesdtls = RegisteredCase:: where('id',$casenoid)->get();
        
        $teamleader = UserRoleMapping:: where('role','=','Team Leader')->where('case_no_id','=',$casenoid)->value('assigned_to');

        $teammember = UserRoleMapping:: where('role','=','Team Member')->where('case_no_id','=',$casenoid) ->get();

        $legalrep = UserRoleMapping:: where('role','=','Legal Representative') ->where('case_no_id','=',$casenoid) ->value('assigned_to');

        $caseno = RegisteredCase:: where('id', $casenoid)->value('case_no');

        $casealleationdtls = RegisteredCase::where('id',$casenoid)->value('allegation_details');


        return view('investigator/casesummary', compact('casesdtls','caseno','caseid','casenoid','casealleationdtls','teamleader','teammember','legalrep'));
    }

    public function viewinvestigationplan(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $caseid = RegisteredCase::where('id', $casenoid)->value('case_id');
        
        $casesdtls = RegisteredCase:: where('id',$casenoid)->get();
        
       $teamleader = UserRoleMapping:: where('role','=','Team Leader')->where('case_no_id','=',$casenoid)->value('assigned_to');

       $teammember = UserRoleMapping:: where('role','=','Team Member')->where('case_no_id','=',$casenoid) ->get();

       $legalrep = UserRoleMapping:: where('role','=','Legal Representative') ->where('case_no_id','=',$casenoid) ->value('assigned_to');

       $caseno = RegisteredCase:: where('id', $casenoid)->value('case_no');

       $casealleationdtls = RegisteredCase::where('id',$casenoid)->value('allegation_details');


       $investigationplans= CaseInvestigationPlan::where('case_no_id',$casenoid)->get();

       $caseregistrationdate = RegisteredCase::where('id', $casenoid)->pluck('creation_date')->first();

       $caseenddate = RegisteredCase::where('id', $casenoid)->pluck('expected_end_date')->first();

       $offencetypes    = DB::table('tbl_offences_lookup')->get();

       $invcount        = CaseInvestigationPlan::where('case_no_id', $casenoid)->count();
       $hypothesiscount = CaseHypothesis::where('case_no_id', $casenoid)->count();
       $actionplancount = CaseActionPlan::where('case_no_id', $casenoid)->count();

       $investigationplanoffences= CaseOffenceTypesInvPlan::where('case_no_id',$casenoid)
        ->get();

       $hypothesis = CaseHypothesis::where('case_no_id',$casenoid)->get();
    
       $hypoevidence = DB::table('tbl_case_hypo_evidences')
       ->where('case_no_id',$casenoid)
       ->get();
       

       $uniqueValues = $hypothesis->groupBy('hypotheses')->map(function($item) {
            return $item->unique(['evaluated_on', 'evaluated_status']);
        });

       $priority  =  DB::table('tbl_priorities_lookup')->where("active_status", "=", 1)->get();

       $invplanstartdate = CaseInvestigationPlan::where('case_no_id', $casenoid)->pluck('startdate_actionplan')->first();
       $invplanenddate   = CaseInvestigationPlan::where('case_no_id', $casenoid)->pluck('case_end_date')->first();

       $tasktypes  =  DB::table('tbl_task_types_lookup')->get();

       $useresults = UserRoleMapping::where("case_no_id", "=", $casenoid)->where('role','Team Leader')->orWhere('role','Team Member')->orWhere('role','Legal Representative')->get();

       $actionplans = CaseActionPlan::where("case_no_id", "=", $casenoid)->get();

       $id = CaseActionPlan::where("case_no_id", "=", $casenoid)->value('id');

       $taskactivities = DB::table('tbl_case_actionplan_activities')->where("actionplanid", "=", $id)->get();

       $invstatus = CaseInvestigationPlan::where('case_no_id', $casenoid)->pluck('evaluation_status')->first();

       return view('investigator/investigationplan', compact('casesdtls','invcount','investigationplanoffences','caseno','caseid','casenoid','investigationplans','caseregistrationdate','caseenddate','offencetypes','hypothesis','uniqueValues','priority','invplanstartdate','invplanenddate','tasktypes','useresults','actionplans','taskactivities','hypothesiscount','actionplancount','teamleader','teammember','legalrep','invstatus','hypoevidence'));
       }

    public function viewinterviewplan(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $caseid = RegisteredCase::where('id', $casenoid)->value('case_id');
        
        $casesdtls = RegisteredCase:: where('id',$casenoid)->get();
        
        $teamleader = UserRoleMapping:: where('role','=','Team Leader')->where('case_no_id','=',$casenoid)->value('assigned_to');

        $teammember = UserRoleMapping:: where('role','=','Team Member')->where('case_no_id','=',$casenoid) ->get();

        $legalrep = UserRoleMapping:: where('role','=','Legal Representative') ->where('case_no_id','=',$casenoid) ->value('assigned_to');

        $caseno = RegisteredCase:: where('id', $casenoid)->value('case_no');

        $casealleationdtls = RegisteredCase::where('id',$casenoid)->value('allegation_details');

       $interviewplans =  DB::table('tbl_case_interviewplans')->where('case_no_id',$casenoid)->get();

       $accused = DB::table('tbl_case_interviewees')->where('case_no_id', $casenoid)->get();
    
        $interviewers = User::where('role', "Investigator")->get();

        $interviewtypes = DB::table('tbl_interviewtypes_lookup')->get();

       return view('investigator/interviewplan', compact('casesdtls','caseid','caseno','casenoid','interviewplans','casenoid','accused','interviewers','interviewtypes','teamleader','teammember','legalrep'));
    }

    public function viewsummonorder(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $caseid = RegisteredCase::where('id', $casenoid)->value('case_id');
        
        $casesdtls = RegisteredCase:: where('id',$casenoid)->get();
        
        $teamleader = UserRoleMapping:: where('role','=','Team Leader')->where('case_no_id','=',$casenoid)->value('assigned_to');

        $teammember = UserRoleMapping:: where('role','=','Team Member')->where('case_no_id','=',$casenoid) ->get();

        $legalrep = UserRoleMapping:: where('role','=','Legal Representative') ->where('case_no_id','=',$casenoid) ->value('assigned_to');

        $caseno = RegisteredCase:: where('id', $casenoid)->value('case_no');

        $casealleationdtls = RegisteredCase::where('id',$casenoid)->value('allegation_details');

        $summonorder = DB::table('tbl_case_summonorders')->where('case_no_id', $casenoid)->get();
        
        $interviewers = User::where('role', "Investigator")->get();

       return view('investigator/summonorder', compact('casesdtls','caseno','caseid','casenoid','summonorder','interviewers','teamleader','teammember','legalrep'));

    }
     public function viewinterviewreport(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $caseid = RegisteredCase::where('id', $casenoid)->value('case_id');
        
        $casesdtls = RegisteredCase:: where('id',$casenoid)->get();
        
        $teamleader = UserRoleMapping:: where('role','=','Team Leader')->where('case_no_id','=',$casenoid)->value('assigned_to');

        $teammember = UserRoleMapping:: where('role','=','Team Member')->where('case_no_id','=',$casenoid) ->get();

        $legalrep = UserRoleMapping:: where('role','=','Legal Representative') ->where('case_no_id','=',$casenoid) ->value('assigned_to');

        $caseno = RegisteredCase:: where('id', $casenoid)->value('case_no');

        $casealleationdtls = RegisteredCase::where('id',$casenoid)->value('allegation_details');


       return view('investigator/interviewreport', compact('casesdtls','caseno','caseid','casenoid','teamleader','teammember','legalrep'));

    }

    public function viewentity(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $caseid = RegisteredCase::where('id', $casenoid)->value('case_id');
        
        $casesdtls = RegisteredCase:: where('id',$casenoid)->get();
        
        $teamleader = UserRoleMapping:: where('role','=','Team Leader')->where('case_no_id','=',$casenoid)->value('assigned_to');

        $teammember = UserRoleMapping:: where('role','=','Team Member')->where('case_no_id','=',$casenoid) ->get();

        $legalrep = UserRoleMapping:: where('role','=','Legal Representative') ->where('case_no_id','=',$casenoid) ->value('assigned_to');

        $caseno = RegisteredCase:: where('id', $casenoid)->value('case_no');

        $offences = Offence::where("case_no_id", "=", $casenoid)->get();

        return view('investigator/entity', compact('caseno','caseid','casesummary','casenoid','offences','teamleader','teammember','legalrep'));
    }
    
    public function viewidiary(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

        $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

       $idiarydetails = DB::table('tbl_case_idiary')
       ->where ('case_no_id',$casenoid)
      ->get();

      $tasktypes  =  DB::table('tbl_task_types_lookup')->get();


        return view('investigator/idiary', compact('casesdtls','caseno','caseid','casenoid','idiarydetails','tasktypes','teamleader','teammember','legalrep'));
    }
    public function viewcaseevent(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

        $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $events = DB::table('tbl_case_events')
        ->where('case_no_id',$casenoid)
        ->get();

        $eventtimeline = DB::table('tbl_case_events')
        ->where('case_no_id', $casenoid)
        ->orderBy('date', 'asc') // Order by 'date' column in ascending (chronological) order
        ->get();

              
        $tasktypes  =  DB::table('tbl_task_types_lookup')->get();

        return view('investigator/caseevent', compact('casesdtls','casenoid','caseid','events','tasktypes','caseno','teamleader','teammember','legalrep','eventtimeline'));
    }
    
    public function viewevidence(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $caseid = RegisteredCase::where('id', $casenoid)->value('case_id');
        
        $casesdtls = RegisteredCase:: where('id',$casenoid)->get();
        
        $teamleader = UserRoleMapping:: where('role','=','Team Leader')->where('case_no_id','=',$casenoid)->value('assigned_to');

        $teammember = UserRoleMapping:: where('role','=','Team Member')->where('case_no_id','=',$casenoid) ->get();

        $legalrep = UserRoleMapping:: where('role','=','Legal Representative') ->where('case_no_id','=',$casenoid) ->value('assigned_to');

        $caseno = RegisteredCase:: where('id', $casenoid)->value('case_no');

        $casealleationdtls = RegisteredCase::where('id',$casenoid)->value('allegation_details');

        $evidences = CaseEvidence::where('case_no_id',$casenoid)->get();

        $collectionmethods = CollectionMethod::get();

        $accused = CaseEntity::where('case_no_id', $casenoid)->where('entitytype', "Accused") ->get();
    
        $officers = User::where('role', "Investigator")->get();

        $teamleader = UserRoleMapping:: where('role','=','Team Leader')->where('case_no_id','=',$casenoid)->value('assigned_to');

        $teammember = UserRoleMapping::where('role','=','Team Member')->where('case_no_id','=',$casenoid)->get();

        $legalrep = UserRoleMapping::where('role','=','Legal Representative') ->where('case_no_id','=',$casenoid)->value('assigned_to');

        $evidencecategory = EvidenceCategory::get();

        return view('investigator/evidence', compact('casesdtls','caseno','caseid','casenoid','evidences','collectionmethods','accused','officers','teamleader','teammember','legalrep','evidencecategory'));
    }

    public function viewevidencematrix(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

       $evidences = CaseEvidence::where('case_no_id',$casenoid)
       ->get();

       $collectionmethods = CollectionMethod::get();

       $subjects = CaseEntity::where('case_no_id', $casenoid)
       ->where('entitytype', "Accused")
        ->get();

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

        $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        
        $elements = DB::table('tbl_elements_lookup')
        ->where('offence_id', '4')
        ->get();

        
        
        $evidencematrix = CaseEvidenceMatrixOne::where('case_no_id', $casenoid)
        ->where('saved', 'Yes')
        ->orderBy('accused_id')
        ->get()
        ->groupBy('accused_id');

        $evidencesmat = CaseEvidenceMatrixOne::where('case_no_id', $casenoid)
        ->where('saved', 'Yes')
        ->leftJoin('tbl_case_evidence_matrix_two', 'tbl_case_evidence_matrix_one.id', '=', 'tbl_case_evidence_matrix_two.table_one_id')
        ->leftJoin('tbl_case_evidence_matrix_three', 'tbl_case_evidence_matrix_three.table_two_id', '=', 'tbl_case_evidence_matrix_two.id')
        ->get();



       $offencetypes    = DB::table('tbl_offences_lookup')->get();

        return view('investigator/evidencematrix', compact('casesdtls','caseno','caseid','casenoid','subjects','evidences','offencetypes','teamleader','teammember','legalrep','elements','evidencematrix','evidencesmat'));
    }

    public function viewevidencesummary(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

       $evidences = CaseEvidence::where('case_no_id',$casenoid)
       ->get();

       $collectionmethods = CollectionMethod::get();

       $subjects = CaseEntity::where('case_no_id', $casenoid)
       ->where('entitytype', "Accused")
        ->get();

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

        $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        
        $evidencesummary =  DB::table('tbl_case_evidence_matrix_one')
        ->where('case_no_id','=',$casenoid)
        ->select('offence_id', DB::raw('COUNT(DISTINCT accused_id) AS accused_count'), DB::raw('MAX(count) AS last_count'))
        ->where('saved', 'Yes')
        ->groupBy('offence_id')
        ->get();


        return view('investigator/evidencesummary', compact('casesdtls','caseno','caseid','casenoid','subjects','evidences','teamleader','teammember','legalrep','evidencesummary'));
    }

    public function viewfiles(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

         $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        return view('investigator/files', compact('casesdtls','caseno','casenoid','caseid','teamleader','teammember','legalrep'));
    }
    public function viewreports(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

         $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $reportcategory = ReportCategoryLookUp::get();

        $reports = CaseReport::where('case_no_id','=',$casenoid)->get();

        $accused = CaseEntity::where('case_no_id', $casenoid)->where('entitytype', "Accused") ->get();

        $witness = CaseEntity::where('case_no_id', $casenoid)->where('entitytype', "Witness") ->get();

        return view('investigator/reports', compact('casesdtls','caseno','caseid','casenoid','teamleader','teammember','legalrep','reportcategory','reports','accused','witness'));
    }
    
    public function viewlinkanalysis(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

         $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        return view('investigator/linkanalysis', compact('casesdtls','caseno','caseid','casenoid','teamleader','teammember','legalrep'));
    }

    
    public function viewhypo(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

       
       $hypothesis = CaseHypothesis::where('case_no_id',$casenoid)->get();

       $hypoevidence = DB::table('tbl_case_hypo_evidences')
       ->where('case_no_id',$casenoid)
       ->get();

       $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');
       

        $uniqueValues = $hypothesis->groupBy('hypotheses')->map(function($item) {
            return $item->unique(['evaluated_on', 'evaluated_status']);
        });

       $invcount        = CaseInvestigationPlan::where('case_no_id', $casenoid)->count();
       $hypothesiscount = CaseHypothesis::where('case_no_id', $casenoid)->count();
       $actionplancount = CaseActionPlan::where('case_no_id', $casenoid)->count();

        $hypocount = CaseHypothesis::where('case_no_id', $casenoid)->count();
        
        $invstatus = CaseInvestigationPlan::where('case_no_id', $casenoid)->pluck('evaluation_status')->first();

        return view('investigator/hypothesisandevidence', compact('casesdtls','caseid','uniqueValues','caseno','casenoid','hypothesis','hypocount','invcount','hypothesiscount','actionplancount','teamleader','teammember','legalrep','invstatus','hypoevidence'));
    }

    public function viewactionplan(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

       $priority  =  DB::table('tbl_priorities_lookup')->where("active_status", "=", 1)->get();

       $invplanstartdate = CaseInvestigationPlan::where('case_no_id', $casenoid)->pluck('startdate_actionplan')->first();
       $invplanenddate   = CaseInvestigationPlan::where('case_no_id', $casenoid)->pluck('case_end_date')->first();

       $tasktypes  =  DB::table('tbl_task_types_lookup')->get();


       $useresults = UserRoleMapping::where('case_no_id', $casenoid)
                            ->whereIn('role', ['Team Leader', 'Team Member', 'Legal Representative'])
                            ->get();

       $actionplans = CaseActionPlan::where("case_no_id", "=", $casenoid)->get();

       $id = CaseActionPlan::where("case_no_id", "=", $casenoid)->value('id');

       $taskactivities = DB::table('tbl_case_actionplan_activities')->where("actionplanid", "=", $id)->get();

       $invcount        = CaseInvestigationPlan::where('case_no_id', $casenoid)->count();
       $hypothesiscount = CaseHypothesis::where('case_no_id', $casenoid)->count();
       $actionplancount = CaseActionPlan::where('case_no_id', $casenoid)->count();
       $invstatus       = CaseInvestigationPlan::where('case_no_id', $casenoid)->pluck('evaluation_status')->first();

       return view('investigator/actionplan', compact('useresults','priority','caseid','casesdtls','caseno','casenoid','invplanstartdate','invplanenddate','tasktypes','actionplans','taskactivities','invcount','hypothesiscount','actionplancount','teamleader','teammember','legalrep','invstatus'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    

    public function viewperson(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $entityperson = CaseEntity::where ('case_no_id',$casenoid)
          ->where ('type','=','Bhutanese')
          ->orWhere ('type','=', 'Non Bhutanese')
          ->get();

          $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $partytypes = DB::table('tbl_partytypes_lookup')->get();
        
        return view('investigator/person', compact('casesdtls','entityperson','caseid','caseno','casenoid','partytypes','teamleader','teammember','legalrep'));
    }

    public function vieworganization(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $parentagency = DB::table('tbl_parentagencies_lookup')->get();

        $agencyname = DB::table('tbl_agencynames_lookup')->get();

        $entityorganization = DB::table('tbl_case_organizations')
          ->where('case_no_id', $casenoid)
          ->get();
        
        $partytypes = DB::table('tbl_partytypes_lookup')->get();


        return view('investigator/organization', compact('casesdtls','parentagency','caseid','entityorganization','agencyname','caseno','casenoid','partytypes','teamleader','teammember','legalrep'));
    }

    public function viewasset(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');
        
        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $partytypes = DB::table('tbl_partytypes_lookup')
          ->get();

        $entityasset = DB::table('tbl_case_assets')
        ->where('case_no_id',$casenoid)
        ->get();

        


        return view('investigator/asset', compact('casesdtls','caseid','partytypes','entityasset','caseno','casenoid','teamleader','teammember','legalrep'));
    }

    public function viewarrest(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

       $arrests = DB::table('tbl_case_mainarrests')
       ->where ('case_no_id', $casenoid)
       ->get();
       
        $subjects = CaseEntity::where('entitytype', 'Accused')
       ->get();

       $pcause = DB::table('tbl_probable_causes')
       ->get();

       $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');
    
       $users  = User::where('status',1)->where('role','Investigator')->get();

        return view('investigator/arrest',compact('casesdtls','caseid','casenoid','caseno','arrests','subjects','pcause','users','teamleader','teammember','legalrep'));
    }

    public function viewdetention(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');
        
        $detentions = DB::table('tbl_case_detentions')
        ->where('case_no_id',$casenoid)
        ->get();

        $subjects = CaseEntity::where('entitytype', 'Accused')
       ->get();

       $pcause = DB::table('tbl_probable_causes')
       ->get();
    
       $users  = User::where('status',1)->where('role','Investigator')->get();

        return view('investigator/detention',compact('casesdtls','caseid','casenoid','caseno','subjects','detentions','pcause','users','teamleader','teammember','legalrep'));
    }
    public function viewsearch(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

       $searchdetails  = DB::table('tbl_case_mainsearches')
       ->where('case_no_id', $casenoid)
       ->get();

       $subjects = CaseEntity::where('entitytype', 'Accused')
       ->get();

       $pcause = DB::table('tbl_search_probable_causes_lookup')
       ->get();

       $typeseizures = DB::table('tbl_seizuretypes_lookup')->get();

       $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        return view('investigator/search',compact('casesdtls','caseid','casenoid','caseno','searchdetails','typeseizures','subjects','pcause','teamleader','teammember','legalrep'));
    }

    public function viewseizure(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

       $seizuredtls  = DB::table('tbl_case_seized_items')
       ->join('tbl_case_mainseizures', 'tbl_case_mainseizures.seizure_id', '=', 'tbl_case_seized_items.seizure_id')
        ->where('tbl_case_seized_items.case_no_id', $casenoid)
        ->select('tbl_case_seized_items.*','tbl_case_mainseizures.seizure_time','tbl_case_mainseizures.seizure_date','tbl_case_mainseizures.seizure_type','tbl_case_mainseizures.authorization_type')
        ->orderBy('tbl_case_seized_items.item_type')
       ->get();

        $searchdtls  = DB::table('tbl_case_mainsearches')
       ->where('case_no_id', $casenoid)
       ->get();

       $accused = CaseEntity::where('case_no_id', $casenoid)
       ->where('type', "Accused")
        ->get();

       $typeseizures = DB::table('tbl_seizuretypes_lookup')->get();

       $officers = User::where('role', "Investigator")->get();

       


        return view('investigator/seizure',compact('casesdtls','caseid','casenoid','caseno','seizuredtls','typeseizures','accused','officers','teamleader','teammember','legalrep','searchdtls'));
    }
    public function viewfreeze(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

       $entityasset = DB::table('tbl_case_assets')
        ->where('case_no_id',$casenoid)
        ->get();

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');
    
        $officers = User::where('role', "Investigator")->get();

        return view('investigator/freeze',compact('casesdtls','caseid','casenoid','caseno','entityasset','officers','teamleader','teammember','legalrep'));
    }
    public function viewsuspension(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casesdtls = RegisteredCase::
        where('id',$casenoid)
        ->get();

        $caseno = RegisteredCase::
        where('id', $casenoid)
        ->value('case_no');

        $caseid = RegisteredCase::
        where('id', $casenoid)
        ->value('case_id');

       $suspensions = DB::table('tbl_case_suspensions')
       ->where('case_no_id',$casenoid)
       ->get();

       $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$casenoid)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$casenoid)
        ->value('assigned_to');

       
        return view('investigator/suspension',compact('casesdtls','casenoid','caseid','caseno','suspensions','teamleader','teammember','legalrep'));
    }
}
