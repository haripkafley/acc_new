<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Mail;
use DB;
use Auth;
use Alert;
use Storage;
use Redirect;
use Carbon\Carbon;
use Session;
use App\Models\RegisteredCase;
use App\Models\Complaint;
use App\Models\Source;
use App\Models\Priority;
use App\Models\InvestigationType;
use App\Models\Branch;
use App\Models\User;
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

class CaseController extends Controller
{
     public function directornonassigned(Request $request)
    {
        $complaints_list    = Complaint::where('complaint_status','=','0')->get();
        $sources            = Source::get();
        $priority           = Priority::get();
        $investigationtype  = InvestigationType::get();
        $branches           = Branch::get();
        $usersspecial       = User::where('status',1)->where('role','chief')->orWhere('role','Investigator')->get();
        $allcases           = RegisteredCase::orderBy('updated_at', 'desc')->get();

        return view('director.nonassignedcases', compact('complaints_list','sources','priority','investigationtype','branches','usersspecial','allcases'));
    }

    public function directorassigned(Request $request)
    {
        $sources            = Source::get();
        $sector             = SectorType::get();
        $subsector          = SectorSubtype::get();
        $institutiontype    = InstitutionType::get();
        $area               = Area::get();
        $priority           = Priority::get();
        $investigationtype  = InvestigationType::get();
        $branches           = Branch::get();
        $offencetypes       = Offence::get();
        $usersspecial       = User::where('status',1)->where('role','chief')->orWhere('role','Investigator')->get();
        $allcases           = RegisteredCase::orderBy('updated_at', 'desc')->get();

        return view('director.assignedcases',compact('sources','sector','subsector','institutiontype','area','priority','investigationtype','branches','offencetypes','usersspecial','allcases'));
    }

    public function generateCaseno(Request $request)
{
    $generatedCaseNo = null;
    $month = Carbon::now()->format('m');
    $year = Carbon::now()->format('Y');

    $sourcetype = Route::current()->parameter('sourceName');
    $tableIsEmpty = RegisteredCase::where("source_type", $sourcetype)->count() === 0;

    if ($tableIsEmpty) {
        $serialno = 1;
    } else {
        $lastcaseno =  RegisteredCase::where('source_type', $sourcetype)->orderBy('id', 'desc')->first();
        if ($lastcaseno) {
            $pieces = explode("-", $lastcaseno->case_no);
            if (count($pieces) === 3) {
                $serialno = $pieces[2];
                $serialno++;
            } else {
                // Handle invalid case_no format
                $serialno = 1;
            }
        } else {
            // Handle case when there are no records
            $serialno = 1;
        }
    }

    $serialno = sprintf('%03d', $serialno);

    if ($sourcetype == "Reactive (Complaint)") {
        $generatedCaseNo = "RCO" . '-' . $month . $year . '-' . $serialno;
    } elseif ($sourcetype == "Reactive (Agency Referral)") {
        $generatedCaseNo = "RAG" . '-' . $month . $year . '-' . $serialno;
    } elseif ($sourcetype == "Proactive (Offshoot)") {
        $generatedCaseNo = "POF" . '-' . $month . $year . '-' . $serialno;
    } elseif ($sourcetype == "Proactive (Intel)") {
        $generatedCaseNo = "PIN" . '-' . $month . $year . '-' . $serialno;
    }

    return response()->json($generatedCaseNo);
}


    public function showdivisionheads(Request $request)
    {
        $branch = $request->branch;
        $headdtls = User::where("branch", "=", $branch)->first();
        return response()->json($headdtls);
    }

    public function addcasefromcomplaint(Request $request, Showcase $showcase)
    {
        
        Alert::success('You\'ve Successfully created a case');
            return Redirect::back(); 
    }


    public function searchentity(Request $request)
        {
       
            $cid = Route::current()->parameter('cid');
            $data = Entity::where('identification_no', '=', $cid)->get();

            return response()->json(['data' => $data]);
        }

    public function registercase(Request $request)
        {
            DB::beginTransaction();

             $request->validate(['case_no_add' => 'required|unique:tbl_registered_cases,case_no']);

            $entityname         = $request->input('entityname');
            $entitycid          = $request->input('entitycid');
            $entitytype         = $request->input('partytype');
            $entitygender       = $request->input('entitygender');
            $entitydob          = $request->input('entitydob');
            $entitynationality  = $request->input('entitynationality');
            $assigned_email     = Auth::user()->email;
            $yesno              = $request->input('yesno');
            $invtype            = $request->input('investigation_type_add');
            $natureofconflict   = $request->input('coidirector');
            $branch             = $request->input('branch');
            $caseno             = $request->input('case_no_add');
            $casetitle          = $request->input('case_title_add');
            
            $data = $request->all();

            $chief_email = User::where('branch','=', $branch)
                    ->where('role', "=", 'Chief')
                    ->value('email');
                
            $commission_email = User::where('role', "=", 'Commission')
                    ->value('email');


        try {

            if($invtype == "Normal")
                {
                    RegisteredCase::insert([
                        'source_type'               => $data['source_add'],
                        'agency_name'               => $data['agency_name_add'],
                        'sector'                    => $data['sector_type_add'],
                        'case_no'                   => $data['case_no_add'],
                        'case_id'                   => $data['case_id_add'],
                        'sector_type'               => $data['sector_subtype_add'],
                        'case_title'                => $data['case_title_add'],
                        'area'                      => $data['area_add'],
                        'creation_date'             => $data['case_reg_no_add'],
                        'institution_type'          => $data['institution_type_add'],
                        'priority'                  => $data['priority_add'],
                        'instructions'              => $data['remarks_add'],
                        'branch'                    => $data['branch'],
                        'investigation_type'        => $data['investigation_type_add'],
                        'allegation_details'        => $data['allegation_details_add'],
                        'assigned_status'           => "1",
                        'status'                    => "Assigned to Chief",
                        ]);

                        $caseid    = RegisteredCase::latest('id')->first();
                        $caseno_id = $caseid->id;

                            UserRoleMapping::insert([
                                    'case_no_id'      => $caseno_id,
                                    'assigned_by'     => $assigned_email,
                                    'assigned_to'     => $chief_email,
                                    'role'            => "Chief",
                                    'assigned_on'     => Carbon::now(),
                                    
                            ]);

                            UserRoleMapping::insert([
                                    'case_no_id'      => $caseno_id,
                                    'assigned_by'     => $assigned_email,
                                    'assigned_to'     => $commission_email,
                                    'role'            => "Commission",
                                    'assigned_on'     => Carbon::now(),
                                    
                            ]);

                            
                }

                if($invtype == "Special")
                {
                    $teammember       = $request->input('teammemberassign');
                    $teamrole         = $request->input('teamrolesassign');
                    $countmember      = COUNT($teammember); 
          
                    RegisteredCase::insert([
                            'source_type'               => $data['source_add'],
                            'agency_name'               => $data['agency_name_add'],
                            'sector'                    => $data['sector_type_add'],
                            'case_no'                   => $data['case_no_add'],
                            'case_id'                   => $data['case_id_add'],
                            'sector_type'               => $data['sector_subtype_add'],
                            'case_title'                => $data['case_title_add'],
                            'area'                      => $data['area_add'],
                            'creation_date'             => $data['case_reg_no_add'],
                            'institution_type'          => $data['institution_type_add'],
                            'priority'                  => $data['priority_add'],
                            'instructions'              => $data['remarks_add'],
                            'branch'                    => $data['branch'],
                            'investigation_type'        => $data['investigation_type_add'],
                            'assigned_status'           => "10",
                            'status'                    => "Assigned to Chief",
                            'allegation_details'        => $data['allegation_details_add'],
                            'updated_at'                => Carbon::now()
                        ]);

                        $caseid    = RegisteredCase::latest('id')->first();
                        $caseno_id = $caseid->id;

                        UserRoleMapping::insert([
                                'case_no_id'      => $caseno_id,
                                'assigned_by'     => $assigned_email,
                                'assigned_to'     => $commission_email,
                                'role'            => "Commission",
                                'assigned_on'     => Carbon::now(),
                                
                        ]);
                    
                    for($j=0; $j<$countmember; $j++)//loop thru each arrays
                    {
                                           
                    UserRoleMapping::insert([
                            'case_no_id'      => $caseno_id,
                            'assigned_by'     => $assigned_email,
                            'assigned_to'     => $teammember[$j],
                            'role'            => $teamrole[$j],
                            'assigned_on'     => Carbon::now(),
                            
                    ]);
                    }
                }
                    $allegation_doc_name = $request->input('allegation_doc_name');
                    $countdocuments = count($allegation_doc_name);

                    if ($request->hasfile('allegation_doc')) {
                        foreach ($request->file('allegation_doc') as $a => $file) {
                            if ($file->isValid()) {
                                $file_extension = $file->getClientOriginalExtension();
                                $file_name = $file->getClientOriginalName();

                                CaseAllegationDocument::insert([
                                    'case_no_id' => $caseno_id,
                                    'file_name' => $file_name,
                                    'doc_name' => $allegation_doc_name[$a],
                                ]);

                                $file_path = $file->move(public_path("Case Folder/{$caseno_id}"), $file_name);
                            }
                        }
                    }


                $offence_type = $request->input('offence_type_add');

                foreach($offence_type as $offtype)
                {
                        CaseOffence::insert([
                            'case_no_id'   => $caseno_id,
                            'offence_type' => $offtype
                        ]);
                }

            $countcid = COUNT($entityname);
            
            if (!empty($countcid)) 
                {
                    for($j=0; $j<$countcid; $j++)
                        {
                    $entitycidValue = $entitycid[$j];
                    $dzongkhag = Entity::where('identification_no', $entitycidValue)->value('dzongkhag');
                    $gewog = Entity::where('identification_no', $entitycidValue)->value('gewog');
                    $village = Entity::where('identification_no', $entitycidValue)->value('village');
                    $dateofbirth = Entity::where('identification_no', $entitycidValue)->value('dateofbirth');

                            CaseEntity::insert([
                                'case_no_id' => $caseno_id,
                                'name' => $entityname[$j],
                                'identification_no' => $entitycid[$j],
                                'dzongkhag' => $dzongkhag,
                                'gewog' => $gewog,
                                'village' => $village,
                                'entitytype' => $entitytype[$j],
                                'gender' => $entitygender[$j],
                                'dateofbirth' => $dateofbirth,
                                'type' => $entitynationality[$j],
                            ]);
                        }
                }

            $name = User::where('email',$assigned_email)->value('name');

                if($yesno == "Yes")
                    {
                        CaseConflict::insert([
                            'case_no_id'         => $caseno_id,
                            'declared_by'        => "Director",
                            'email'              => $assigned_email,
                            'name'               => $name,
                            'nature_of_conflict' => $natureofconflict,
                            'conflict_status'    => 1
                        ]);

                        $conflictstatus = 1;
                    }
                else
                    {
                        CaseConflict::insert([
                            'case_no_id'            => $caseno_id,
                            'declared_by'           => "Director",
                            'email'                 => $assigned_email,
                            'name'                  => $name,
                            'nature_of_conflict'    => "No Conflict",
                            'conflict_status' => 1
                        ]);

                        $conflictstatus = 2;
                    }

                

                $admin_email  = User::where('role', "=", 'Admin')
                ->value('email');
                

                $data["chiefemail"] = $chief_email;

                $chief_name =  User::where('email',$chief_email)->value('name');

                $data["title"]  = "Case Assignment Notification";
                $data["first"]  = "Dear Mr/Mrs/Ms " . $chief_name . ",";
                $data["second"] = "This is to notify that you have been assigned as a member of the investigating team for the";
                $data["third"]  = "Case No:" . $caseno;
                $data["fourth"] = "Case Title:" . $casetitle;
                $data["fifth"] = "You are expected to review the allegation or the matter as well as identity of the alleged person and declare conflict of interest before proceeding any further";

 
                $data["cardValue"] = "Case Assignment Notification";    

                // Mail::send('emails.caseassignmentemail', $data, function($message)use($data) {
                //     $message->to($data["chiefemail"], $data["chiefemail"])
                //             ->subject($data["title"]);
                // });

            DB::commit();

            Alert::success('Case Created Successfully');
                    return Redirect::back(); 

        } 
        catch (\Exception $e) {
        
            DB::rollback();

        return response()->json(['error' => 'Transaction failed: ' . $e->getMessage()], 500);
        
        } 

        }

    public function mycases(Request $request)
    {
        $user_email = Auth::user()->email;
        $user_role = Auth::user()->role;

        $showassignedcases = UserRoleMapping::
            join('tbl_registered_cases', 'tbl_registered_cases.id', '=', 'tbl_user_role_mapping.case_no_id')
        ->where('tbl_user_role_mapping.assigned_to',$user_email)
        ->select('tbl_registered_cases.*','tbl_user_role_mapping.*')
        ->orderBy('tbl_registered_cases.updated_at', 'desc')
        ->get();


        $users  = User::where('status',1)->where('role','Investigator')->get();

        return view('casefolder.index',compact('showassignedcases','users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        
    }

    public function showcasedetailsforcoi(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $casedetails = RegisteredCase::where('id', $casenoid)->get();
        $accuseddetails = CaseEntity::where('case_no_id', $casenoid)->where('entitytype','=','Accused')->get();
        $offencedetails = CaseOffence::where('case_no_id', $casenoid)->get();
        $allegationdocuments = CaseAllegationDocument::where('case_no_id', $casenoid)->get();

        return view('casefolder.showdetailsforcoi', compact('casedetails','accuseddetails','offencedetails','allegationdocuments'));

    }

    public function showteamdetailsforreassign(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');

        $teamdetails = UserRoleMapping::where('case_no_id', $casenoid)->whereIn('role', ['Team Leader', 'Team Member', 'Legal Representative'])->get();
        
        $userdtls  = User::where('status',1)->where('role','Investigator')->get();

        return view('casefolder.showteamdetailsforreassign', compact('teamdetails','userdtls'));

    }

    public function searchentitydetails(Request $request)
    {        
        $id = Route::current()->parameter('id');
        $entitydetailsshow =  CaseEntity::where('id', $id)->get();
        $entityid = CaseEntity::where('id', $id)->value('identification_no');
        $casenoid = CaseEntity::where('id', $id)->value('case_no_id');
        $othercasesdtls = CaseEntity::where('identification_no', $entityid)->where('case_no_id','!=', $casenoid)->get();
        
        return view('casefolder.showentitiesdetails',compact('entitydetailsshow', 'othercasesdtls'));
    }

    public function viewentitydetailsforedit(Request $request)
    {
        $id = Route::current()->parameter('id');
        $entitydetailsshow =  CaseEntity::where('id', $id)->get();
        
        return view('casefolder.showentitiesdetailsedit',compact('entitydetailsshow'));
    }

     public function showentitydetails(Request $request)
    {        
        $id = Route::current()->parameter('id');
        $entitydetailsshow =  Entity::where('id', $id)->get();
        
        return view('casefolder.showentitiesdtls',compact('entitydetailsshow'));
    }

    function declarecoichief(Request $request)
    {
        $case_no_id_coi    = $request->input('case_no_id_coi');
        $natureofconflict  = $request->input('coichief');
        $yesno             = $request->input('yesno');
        $assigned_email    = Auth::user()->email;
        $name              = User::where('email',$assigned_email)->value('name');
        $emailreceiver     = UserRoleMapping::where('assigned_to', $assigned_email)->where('case_no_id', $case_no_id_coi)->value('assigned_by');
        $emailreceivername = User::where('email',$emailreceiver)->value('name');
        $caseno            = RegisteredCase::where('id', $case_no_id_coi)->value('case_no');
        $casetitle         = RegisteredCase::where('id', $case_no_id_coi)->value('case_title');

        if($yesno == "Yes")
            {
                CaseConflict::insert([
                    'case_no_id' => $case_no_id_coi,
                    'declared_by' => "Chief",
                    'name' => $name,
                    'email' => $assigned_email,
                    'nature_of_conflict' => $natureofconflict,
                    'conflict_status' => 1
                 ]);
            }
        else
            {
                CaseConflict::insert([
                    'case_no_id' => $case_no_id_coi,
                    'declared_by' => "Chief",
                    'name' => $name,
                    'email' => $assigned_email,
                    'nature_of_conflict' => "No Conflict",
                    'conflict_status' => 1
                 ]);
            }

             RegisteredCase::where('id', $case_no_id_coi)
                ->update(array( 
                'assigned_status'=>"2",
            ));

                $chief_name =  User::where('email',$assigned_email)->value('name');

                $data["titlecoi"]  = "COI Declaration Notification";
                $data["firstcoi"]  = "Dear Mr/Mrs/Ms " . $emailreceivername . ",";
                $data["secondcoi"] = "This is to notify that you ". $chief_name ." has successfully declared his/her COI against the case:";
                $data["thirdcoi"]  = "Case No:" . $caseno;
                $data["fourthcoi"] = "Case Title:" . $casetitle;
                $data["fifthcoi"] = "You are expected to review it before proceeding any further";
                $data["emailreceiver"] = UserRoleMapping::where('assigned_to', $assigned_email)->where('case_no_id', $case_no_id_coi)->value('assigned_by');
 
                $data["cardValuecoi"] = "COI Declaration Notification";    

                // Mail::send('emails.coideclareemail', $data, function($message)use($data) {
                //     $message->to($data["emailreceiver"], $data["emailreceiver"])
                //             ->subject($data["titlecoi"]);
                // });


            Alert::success('Your COI has been successfully submitted to your immediate supervisor for review and comment. You must wait for the response to be able to proceed further');
                        return Redirect::back();
    }

     function declarecoichief_special(Request $request)
    {
        $case_no_id_coi    = $request->input('case_no_id_coi_special');
        $natureofconflict  = $request->input('coichief_special');
        $yesno             = $request->input('yesno_special');
        $assigned_email    = Auth::user()->email;
        $name              = User::where('email',$assigned_email)->value('name');
        $emailreceiver     = UserRoleMapping::where('assigned_to', $assigned_email)->where('case_no_id', $case_no_id_coi)->value('assigned_by');
        $emailreceivername = User::where('email',$emailreceiver)->value('name');
        $caseno            = RegisteredCase::where('id', $case_no_id_coi)->value('case_no');
        $casetitle         = RegisteredCase::where('id', $case_no_id_coi)->value('case_title');
        
        if($yesno == "Yes")
            {
                CaseConflict::insert([
                    'case_no_id' => $case_no_id_coi,
                    'declared_by' => "Chief",
                    'name' => $name,
                    'email' => $assigned_email,
                    'nature_of_conflict' => $natureofconflict,
                    'conflict_status' => 1
                 ]);
            }
        else
            {
                CaseConflict::insert([
                    'case_no_id' => $case_no_id_coi,
                    'declared_by' => "Chief",
                    'name' => $name,
                    'email' => $assigned_email,
                    'nature_of_conflict' => "No Conflict",
                    'conflict_status' => 1
                 ]);
            }

             RegisteredCase::where('id', $case_no_id_coi)
                
                ->update(array( 
            ));

            UserRoleMapping::where('assigned_to', $assigned_email)
                        ->update(array( 
                            'conflictstatus'=> 1));

           $chief_name =  User::where('email',$assigned_email)->value('name');

                $data["titlecoi"]  = "COI Declaration Notification";
                $data["firstcoi"]  = "Dear Mr/Mrs/Ms " . $emailreceivername . ",";
                $data["secondcoi"] = "This is to notify that you ". $chief_name ." has successfully declared his/her COI against the case:";
                $data["thirdcoi"]  = "Case No:" . $caseno;
                $data["fourthcoi"] = "Case Title:" . $casetitle;
                $data["fifthcoi"] = "You are expected to review it before proceeding any further";
                $data["emailreceiver"] = UserRoleMapping::where('assigned_to', $assigned_email)->where('case_no_id', $case_no_id_coi)->value('assigned_by');
 
                $data["cardValuecoi"] = "COI Declaration Notification";    

                // Mail::send('emails.coideclareemail', $data, function($message)use($data) {
                //     $message->to($data["emailreceiver"], $data["emailreceiver"])
                //             ->subject($data["titlecoi"]);
                // });

            Alert::success('Your COI has been successfully submitted to your immediate supervisor for review and comment. You must wait for the response to be able to proceed further');
                        return Redirect::back();
    }

    public function viewcoi_chief(Request $request)
    {
        $casenoid = Route::current()->parameter('casenoid');
        $coifiles = CaseConflict::where(['case_no_id' => $casenoid,  'declared_by' => "Chief"])->get();
        
            return view('casefolder.viewcoi_chief',compact('coifiles'));

    }

    public function proceed_chief(Request $request)
    {
        $case_no_id_coi    = $request->input('case_no_id_coi_chief'); 
        $caseno            = RegisteredCase::where('id', $case_no_id_coi)->value('case_no');
        $casetitle         = RegisteredCase::where('id', $case_no_id_coi)->value('case_title'); 
        
        RegisteredCase::where('id', $case_no_id_coi)
                ->update(array( 
                'assigned_status'=>"3",
        ));

        UserRoleMapping::where('case_no_id', $case_no_id_coi)
                ->where('role','Chief')
                ->update(array( 
                'conflictstatus'=>"1"));
            
            
            $chief = UserRoleMapping::where('case_no_id', $case_no_id_coi)->where('role','Chief')->value("assigned_to");
            $chief_name =  User::where('email',$chief)->value('name');

            $data["titlecoi"]  = "Notification";
            $data["firstcoi"]  = "Dear Mr/Mrs/Ms " . $chief_name . ",";
            $data["secondcoi"] = "This is to notify that your COI for the following case has been reviewed by your supervisor.";
            $data["thirdcoi"]  = "Case No:" . $caseno;
            $data["fourthcoi"] = "Case Title:" . $casetitle;
            $data["fifthcoi"]  = "You can now proceed further.";
            $data["chief"]     = UserRoleMapping::where('case_no_id', $case_no_id_coi)->where('role','Chief')->value("assigned_to");

            $data["cardValuecoi"] = "Notification";    

                // Mail::send('emails.proceedemail', $data, function($message)use($data) {
                //     $message->to($data["chief"], $data["chief"])
                //             ->subject($data["titlecoi"]);
                // });

            Alert::success('status updated successfully');
                        return Redirect::back();
    }

    public function assigncasechief(Request $request)
    {
        //dd(request()->all());
        
        $case_id        = $request->input('case_no_id_chief_assign');
        $teammember     = $request->input('teammembers');
        $teamrole       = $request->input('teamroles');
        $teamname       = $request->input('teamname');
        $user_email     = Auth::user()->email;

        
                $number = COUNT($teammember);//count how many arrays available
                    if($number > 0)  
                    {  
                      for($i=0; $i<$number; $i++)//loop thru each arrays
                        {
                            UserRoleMapping::insert([
                                'case_no_id'      => $case_id,
                                'assigned_by'     => $user_email,
                                'assigned_to'     => $teammember[$i],
                                'role'            => $teamrole[$i],
                                'assigned_on'     => Carbon::now(),
                                'conflictstatus'  => 0
                            
                        ]);
                    }

                    }

                    RegisteredCase::where('id', $case_id)
                        ->update(array( 
                            'assigned_status'=>"4",
                            'status' => "Assigned to Team",
                    ));

                    
                    
                       
                    Alert::success('Assigned case successfully');
                        return Redirect::back();
        }

         public function reassigncasechief(Request $request)
    {
        //dd(request()->all());
        
        $case_id        = $request->input('case_no_id_chief_reassign');
        $teammember     = $request->input('teammemberreassign');
        $teamrole       = $request->input('teamrolesreassign');
        //$teamname       = $request->input('teamname');
        $user_email     = Auth::user()->email;

        UserRoleMapping::where('case_no_id', $case_id)->whereIn('role', ['Team Leader', 'Team Member', 'Legal Representative'])->delete();

                $number = COUNT($teammember);//count how many arrays available
                    if($number > 0)  
                    {  
                      for($i=0; $i<$number; $i++)//loop thru each arrays
                        {
                            UserRoleMapping::insert([
                                'case_no_id'      => $case_id,
                                'assigned_by'     => $user_email,
                                'assigned_to'     => $teammember[$i],
                                'role'            => $teamrole[$i],
                                'assigned_on'     => Carbon::now(),
                                'conflictstatus'  => 0
                            
                        ]);
                    }

                    }

                    RegisteredCase::where('id', $case_id)
                        ->update(array( 
                            'assigned_status'=>"4",
                            'status' => "Assigned to Team",
                        ));

                    
                    
                       
                    Alert::success('Assigned case successfully');
                        return Redirect::back();
        }

        public function viewcoi(Request $request)
        {
            $casenoid = Route::current()->parameter('casenoid');
            $coifiles = CaseConflict::where(['case_no_id' => $casenoid,  'declared_by' => "Director"])->get();
            return view('casefolder.viewcoi',compact('coifiles'));
        } 

        public function viewcoiinv(Request $request)
        {
            $casenoid = Route::current()->parameter('casenoid');
            $coifiles = CaseConflict::where('case_no_id', $casenoid)->where('declared_by', '!=', 'Investigator')->get();
            return view('casefolder.viewcoiinv',compact('coifiles'));
        } 

        public function viewcoitogether(Request $request)
        {
            $casenoid = Route::current()->parameter('casenoid');
            $coifiles = CaseConflict::where('case_no_id', $casenoid)->where('declared_by', '!=', 'Chief')->get();

            return view('casefolder.viewcoitogether',compact('coifiles'));
        }
        
        public function viewcoitogether_special(Request $request)
        {
            $casenoid = Route::current()->parameter('casenoid');
            $users  = User::where('status',1)->where('role','Investigator')->get();
            $coifiles = CaseConflict::where('case_no_id', $casenoid)->where('declared_by', '!=', 'Director')->get();

            return view('casefolder.viewcoitogetherspecial',compact('coifiles','users'));
        }

        public function declarecoi_investigator(Request $request)
    {
            $case_no_id_coi         = $request->input('case_no_id_coi_inv');
            $natureofconflict       = $request->input('coiinv');
            $yesno                  = $request->input('yesnoinv');
            $assigned_email         = Auth::user()->email;
            $name                   = User::where('email',$assigned_email)->value('name');
            $user_role              = Auth::user()->role;
                        
            if($yesno == "Yes")
                {
                    CaseConflict::insert([
                    'case_no_id' => $case_no_id_coi,
                    'declared_by' => "Investigator",
                    'name' => $name,
                    'email' => $assigned_email,
                    'nature_of_conflict' => $natureofconflict,
                    'conflict_status' => 1
                 ]);
                }
            else
                {
                    CaseConflict::insert([
                    'case_no_id' => $case_no_id_coi,
                    'declared_by' => "Investigator",
                    'name' => $name,
                    'email' => $assigned_email,
                    'nature_of_conflict' => "No Conflict",
                    'conflict_status' => 1
                 ]);
                }
                
                UserRoleMapping::where('assigned_to', $assigned_email)
                        ->update(array( 
                            'conflictstatus'=> 1));

                Alert::success('Your COI has been successfully submitted to your immediate supervisor for review and comment. You must wait for the response to be able to proceed further');
                    return Redirect::back();
           

    }

    public function replaceinvestigator(Request $request)
    {
        return response()->json([
        'status' => 'success',
        'message' => 'Data updated successfully.',
        'data' => $data
    ]);
    }

    public function printassignmentorder(Request $request)
    {
        $case_no_id  = $request->input('case_no_id_coi_together');
        RegisteredCase::where('id', $case_no_id)
                        ->update(array( 
                            'assigned_status'=>"Assignment Order Printed",
                            'assignment_order_date' => Carbon::now(),
                            'status' => 'Open',
                            'sub_status' =>'Active'));
        $casesdtls = RegisteredCase::
        where('id',$case_no_id)
        ->get();

        $caseno = RegisteredCase::
        where('id', $case_no_id)
        ->value('case_no');

        $chief = UserRoleMapping::
        where('role','=','Chief')
        ->where('case_no_id','=',$case_no_id)
        ->value('assigned_to');

        $teamleader = UserRoleMapping::
        where('role','=','Team Leader')
        ->where('case_no_id','=',$case_no_id)
        ->value('assigned_to');

        $teammember = UserRoleMapping::
        where('role','=','Team Member')
        ->where('case_no_id','=',$case_no_id)
        ->get();

         $legalrep = UserRoleMapping::
        where('role','=','Legal Representative')
        ->where('case_no_id','=',$case_no_id)
        ->value('assigned_to');
        
        
         return view('casefolder.assignmentorder',compact('casesdtls','caseno','teamleader','teammember','legalrep','chief'));
    }

     public function showcasedetailsforreassigncasedirector(Request $request)
    {
        $casenoid  = Route::current()->parameter('casenoid');

        $casedetails = RegisteredCase::where('id', $casenoid)->get();
        $branches  = Branch::get();

        return view('casefolder.showcasedetailsforreassigncasedirector', compact('casedetails','branches'));
    }
       
    public function reassigncase(Request $request)
    {
        $casenoid   = $request->input('casenoid_reassign');
        $branch     = $request->input('new_branch');
        $reason     = $request->input('reason_reassign');
        $caseno     = RegisteredCase::where('id', $casenoid)->value('case_no');
        $casetitle  = RegisteredCase::where('id', $casenoid)->value('case_title'); 
        
            $assigned_email  = User::where('branch','=', $branch)
                                ->where('role', "=", 'Chief')
                                ->value('email');

            UserRoleMapping::
                        where('case_no_id', '=', $casenoid)
                        ->where('role', '=', 'Chief')
                        ->update(['assigned_to' => $assigned_email]);

            RegisteredCase::where('id', $casenoid)
                        ->update(array(
                        'branch'=>$branch,
                        'reassignment_reason'=>$reason,
                        'assigned_status' => "1",
                        'status'  => "Assigned to Chief",
                        'reassignmentstatus'=>1,
                        ));

            

                $chief_name =  User::where('email',$assigned_email)->value('name');

                $data["chiefemail"] = $assigned_email;
                
                $data["title"]  = "Case ReAssignment Notification";
                $data["first"]  = "Dear Mr/Mrs/Ms " . $chief_name . ",";
                $data["second"] = "This is to notify that you have been assigned as a member of the investigating team for the";
                $data["third"]  = "Case No:" . $caseno;
                $data["fourth"] = "Case Title:" . $casetitle;
                $data["fifth"] = "You are expected to review the allegation or the matter as well as identity of the alleged person and declare conflict of interest before proceeding any further";

 
                $data["cardValue"] = "Case ReAssignment Notification";    

                // Mail::send('emails.caseassignmentemail', $data, function($message)use($data) {
                //     $message->to($data["chiefemail"], $data["chiefemail"])
                //             ->subject($data["title"]);
                // });
                    
            Alert::success('You\'ve Successfully Reassigned the case');
                    return Redirect::back();
    }
    
    public function showexistingteam(Request $request)

        {
            $casenoid  = Route::current()->parameter('casenoid');
                $existingteammembers =  UserRoleMapping::
                        where('case_no_id', '=', $casenoid)
                        ->where('role', '=', 'Team Member')
                        ->orWhere('role', '=', 'Team Leader')
                        ->orWhere('role', '=', 'Legal Representative')
                        ->get();

            return view('casefolder.existingteammembers', compact('existingteammembers'));
        }

    // public function updatestatusinv(Request $request, $id)
    //     {
    //         return response()->json(['message' => 'Status updated successfully.']);
    //     }

        public function showallegationandaccused(Request $request)
    {
        $caseid = Route::current()->parameter('case_id');
        $offences = CaseOffence::where('case_no_id', $casenoid)->get();
        $entitieshow = CaseEntity::where('case_no_id', '=', $caseid)->get();
               
        return view('casefolder.showallegationandaccused',compact('offences','entitieshow'));
    }

     public function searchcid(Showcase $showcase)
    {        
        $cid = Route::current()->parameter('cid');
        $entitieshow = Entity::
        where("entities.identification_no", "=", $cid)
        ->join('entitytypes', 'entitytypes.entity_type_id', '=', 'entities.entity_type_id')
        ->select('entities.*','entitytypes.entity_type')      
        ->first();
        
        return response()->json($entitieshow);
        // return view('showcases.showcid',compact('entitieshow'));
       
        
    }

    public function updateinvstatus(Request $request,$caseid)
    {

        $newData = $request->input('newData');

        $record = RegisteredCase::where('id', $caseid)->first();
        if ($record) {
                RegisteredCase::where('id', $caseid)
                    ->update(array( 
                    'sub_status'=> $newData,
                    ));
                    Session::flash('success', 'Status updated successfully');
            return response()->json(['message' => 'Status updated successfully']);
        }

    return response()->json(['message' => 'Record not found'], 404);

    }

    

    public function updatechiefstatus(Request $request,$caseid)
    {
        $newData = $request->input('newData');

        $record = RegisteredCase::where('id', $caseid)->first();
        if ($record) {
            RegisteredCase::where('id', $caseid)
                ->update(array( 
                'status'=> $newData,
                ));
                 Session::flash('success', 'Status updated successfully');
        return response()->json(['message' => 'Status updated successfully']);
    }

    return response()->json(['message' => 'Record not found'], 404);

    
    }

public function handleHiddenRoute($hiddenRoute)
{
    switch ($hiddenRoute) {
        case 'director/assignedcases':
            return $this->directorassigned();
        case 'director/nonassignedcases':
            return $this->directornonassigned();
        // Add cases for other routes
        default:
            abort(404); // Handle unknown routes
    }
}

    public function editcasedetails($casenoid)
    {
        
        $casedetails   = RegisteredCase::where("id", $casenoid)->get();
        $sectors       = SectorType::get();
        $sectortypes   = SectorSubtype::get();
        $institutions  = InstitutionType::get();
        $areas         = Area::get();

        return view('casefolder.editcasedetails',compact('casedetails','sectors','sectortypes','institutions','areas'));
    }

    public function updatecasedetails(Request $request)
    {
        
        $id                = $request->input('casenoidedit');
        $caseid            = $request->input('case_id_edit');
        $casetitle         = $request->input('case_title_edit');        
        $casedate          = $request->input('case_date_edit'); 
        $sector            = $request->input('case_sector_edit'); 
        $subsector         = $request->input('case_sectortype_edit');
        $area              = $request->input('case_area_edit');
        $institution       = $request->input('case_institution_edit');

        RegisteredCase::where('id', $id)
                    ->update(array(                                     
                        'case_id'=>$caseid,
                        'case_title'=>$casetitle,
                        'assignment_order_date'=> $casedate,
                        'sector'=> $sector,
                        'sector_type'=>$subsector,
                        'area'=> $area,
                        'institution_type'=>$institution,
                             ));

        Alert::success('You\'ve Successfully Updated Case Details');
        return Redirect::back();

                           
    }
}
