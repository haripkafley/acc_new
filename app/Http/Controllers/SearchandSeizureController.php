<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mail;
use DB;
use Redirect;
use Alert;
use App\Models\Mainseizure;
use App\Models\Mainforensic;
use App\Models\Mainsearch;
use App\Models\Seizures;
use App\Models\Seziurewitness;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class SearchandSeizureController extends Controller
{
    public function addsearch(Request $request){
      
        DB::table('tbl_case_mainsearches')->insert([
            'case_no_id' => $request->input('searchcasenoidadd'),
            'typeofsearch' => $request->input('typeofsearch'),
            'suspect' => $request->input('searchsuspect'),
            'pcause' => $request->input('searchpcause'),
            'applicationdate' => $request->input('searchapplicationdate'),
            'ownership_type' => $request->input('ownershiptype'),
            'searchtarget' => $request->input('searchtarget')
                ]);
        
          $casenoid        = $request->input('searchcasenoidadd');
          $emailreceiver     = DB::table('tbl_user_role_mapping')->where('role', 'Commission')->where('case_no_id', $casenoid)->value('assigned_to');
          $emailreceivername = DB::table('users')->where('email',$emailreceiver)->value('name');
          $caseno          = DB::table('tbl_registered_cases')->where('id', $casenoid)->value('case_no');
          $casetitle       = DB::table('tbl_registered_cases')->where('id', $casenoid)->value('case_title');
          $assigned_email  = Auth::user()->email;
          $sender_name     = DB::table('users')->where('email',$assigned_email)->value('name');

        $data["titlecoi"]  = "Search Approval Request";
        $data["firstcoi"]  = "Dear Mr/Mrs/Ms " . $emailreceivername . ",";
        $data["secondcoi"] = "This is to notify that you have been requested by ". $sender_name ." to review and approve the request to proceed with search and seizure operation relating to the case: ";
        $data["thirdcoi"]  = "Case No:" . $caseno;
        $data["fourthcoi"] = "Case Title:" . $casetitle;
        $data["fifthcoi"]  = "";
        $data["emailreceiver"] = DB::table('tbl_user_role_mapping')->where('role', 'Commission')->where('case_no_id', $casenoid)->value('assigned_to');

        $data["cardValuecoi"] = "Search Approval Request";    

        // Mail::send('emails.arrestemail', $data, function($message)use($data) {
        //     $message->to($data["emailreceiver"], $data["emailreceiver"])
        //             ->subject($data["titlecoi"]);
        // });

       Alert::success('You\'ve Successfully added search application');
       return Redirect::back();
    
    }

    public function viewsearchdetails($search_id)
    {
      $searchdetails = DB::table('tbl_case_mainsearches')
      ->where('search_id',$search_id)
      ->get();

      $pcause = DB::table('tbl_case_search_probable_causes')
      ->where('search_id',$search_id)
      ->get();
    
    return view('searchandseizures.search_details_view',compact('searchdetails','search_id','pcause'))
      ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function viewseizuredetails($seizure_id)
    {
      
      $seizuredtls = DB::table('tbl_case_mainseizures')
      ->where('seizure_id',$seizure_id)
      ->get();

      $officers = DB::table('tbl_officer_seizure')
      ->where('seizure_id',$seizure_id)
      ->get();

       $witnesses = DB::table('tbl_case_seizure_witnesses')
      ->where('seizure_id',$seizure_id)
      ->get();

      $seizeditems = DB::table('tbl_case_seized_items')
      ->where('seizure_id',$seizure_id)
      ->get();

    return view('searchandseizures.seizure_details_view',compact('seizuredtls','seizure_id','officers','witnesses','seizeditems'))
      ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function viewseizuredetailsupdate($seizure_id)
    {
      $seizuredtls = DB::table('tbl_case_mainseizures')
      ->where('seizure_id',$seizure_id)
      ->get();

      $officers = DB::table('tbl_officer_seizure')
      ->where('seizure_id',$seizure_id)
      ->get();

       $witnesses = DB::table('tbl_case_seizure_witnesses')
      ->where('seizure_id',$seizure_id)
      ->get();

      $seizeditemsdigital = DB::table('tbl_case_seized_items')
      ->where('seizure_id',$seizure_id)
      ->where('item_type', "Digital")
      ->get();

      $seizeditemsemail = DB::table('tbl_case_seized_items')
      ->where('seizure_id',$seizure_id)
      ->where('item_type', "Email")
      ->get();

      $seizeditemssocial = DB::table('tbl_case_seized_items')
      ->where('seizure_id',$seizure_id)
      ->where('item_type', "Social Media")
      ->get();

      $seizeditemspassport = DB::table('tbl_case_seized_items')
      ->where('seizure_id',$seizure_id)
      ->where('item_type', "Passport")
      ->get();

      $seizeditemscurrency = DB::table('tbl_case_seized_items')
      ->where('seizure_id',$seizure_id)
      ->where('item_type', "Currency")
      ->get();

    
    return view('searchandseizures.seizureDetailsUpdate',compact('seizuredtls','seizure_id','officers','witnesses','seizeditemsdigital','seizeditemsemail','seizeditemspassport','seizeditemssocial','seizeditemscurrency'))
      ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function updateseizurestatus($seizure_id)
    {
        

        DB::table('tbl_case_seized_items')->where('id', $seizure_id)
                   ->update(array(
                   'status'=>"Sent to Forensics",
                   'forensic_status'=>"Forensics",
                   ));
                   
        
        Alert::success('You\'ve Successfully sent to Forensics');
                return Redirect::back();
    
    }

    public function commissionUpdateSearch($search_id)
    {

      $Recommendationstatus = DB::table('tbl_recommendationstatuses_lookup')->get();
      $searchdetails = DB::table('tbl_case_mainsearches')->where('search_id',$search_id)->get();
      $pcause = DB::table('tbl_case_search_probable_causes')->where('search_id',$search_id)->get();

      return view('searchandseizures.commissionReviewUpdate',compact('searchdetails','Recommendationstatus','search_id','pcause'))
      ->with('i', (request()->input('page', 1) - 1) * 5);
    }

     public function updateCommissionSearch(Request $request)
    {
      // $newData = Mainseizure::find($seizure_id);
      $commissionStatus = $request->input('commissionStatusSearch');
      $commissionReview = $request->input('commissionReviewSearch');
      $search_id = $request->input('searchidupdate');


      DB::table('tbl_case_mainsearches')->where('search_id', $search_id)
                   ->update(array(
                   'commissionStatus'=>$commissionStatus,
                   'commissionReview'=>$commissionReview,
                   ));
                 
                   Alert::success('You\'ve Successfully updated Search application status');
                   return Redirect::back();
    }

     public function seizureAdd(Request $request)
    {
        $seizuretype = $request->input('seizuretype');

        if($seizuretype == "Without Search")
        {
     
      DB::table('tbl_case_mainseizures')->insert([
            'case_no_id' => $request->input('casenoidseizureadd'),
            'seizure_date' => $request->input('seziureDate'),
            'seizure_time' => $request->input('seziureTime'),
            'seized_from_cid' => $request->input('seizedCid'),
            'seized_from_name' => $request->input('seizedName'),
            'seizure_type' => $seizuretype,
            'authorization_type' => $request->input('authorizationtype')
            ]);
        }
        if($seizuretype == "With Search")
        {
            DB::table('tbl_case_mainseizures')->insert([
            'case_no_id' => $request->input('casenoidseizureadd'),
            'seizure_date' => $request->input('seziureDate'),
            'seizure_time' => $request->input('seziureTime'),
            'search_id' => $request->input('searchid'),
            'seizure_type' => $seizuretype,
            'authorization_type' => $request->input('authorizationtype')
            ]);
        }


      $id  = DB::table('tbl_case_mainseizures')->latest('seizure_id')->first();
                $seizure_id = $id->seizure_id;
                
                $officers = $request->input('officers');

            foreach($officers as $officers)
            {
                    DB::table('tbl_officer_seizure')->insert([
                        'seizure_id'   => $seizure_id,
                        'officer_email' => $officers
                    ]);
            }

            $witnessname         = $request->input('witnessname');
            $witnesscid          = $request->input('witnesscid');

        $countwitness = COUNT($witnessname);
       
            if (!empty($countwitness)) 
                {
                    for($j=0; $j<$countwitness; $j++)
                        {
                            DB::table('tbl_case_seizure_witnesses')->insert([
                                'seizure_id'   => $seizure_id,
                                'witness_name' => $witnessname[$j],
                                'witness_cid' => $witnesscid[$j],
                                
                                
                            ]);
                        }
                }
        
            $digitalcategory = $request->input('digitalcategory');
            $digitalname = $request->input('digitalname');
            $manufacturer = $request->input('manufacturer');
            $model = $request->input('model');
            $serialno = $request->input('serialno');
            $condition = $request->input('condition');

            if (is_array($digitalcategory) && count($digitalcategory) > 0) {
                for ($j = 0; $j < count($digitalcategory); $j++) {
                    DB::table('tbl_case_seized_items')->insert([
                        'seizure_id' => $seizure_id,
                        'case_no_id' => $request->input('casenoidseizureadd'),
                        'item_type' => "Digital",
                        'item_name' => $digitalname[$j],
                        'manufacturer' => $manufacturer[$j],
                        'model' => $model[$j],
                        'serial_no' => $serialno[$j],
                        'condition' => $condition[$j],
                    ]);
                }
            }

            $emailcategory = $request->input('emailcategory');
            $emailid = $request->input('emailid');
            $password = $request->input('password');
            $oldpassword = $request->input('oldpwd');
            $inbox = $request->input('inbox');
            $sent = $request->input('sent');
            $draft = $request->input('draft');
            $spam = $request->input('spam');

            if (is_array($emailcategory) && count($emailcategory) > 0) {
                for ($j = 0; $j < count($emailcategory); $j++) {
                    DB::table('tbl_case_seized_items')->insert([
                        'seizure_id' => $seizure_id,
                        'item_type' => "Email",
                        'case_no_id' => $request->input('casenoidseizureadd'),
                        'email_address' => $emailid[$j],
                        'password' => $password[$j],
                        'oldpassword' => $oldpassword[$j],
                        'inbox' => $inbox[$j],
                        'spam' => $spam[$j],
                        'draft' => $draft[$j],
                        'sent' => $sent[$j],
                    ]);
                }
            }
        
            $socialmediacategory  = $request->input('socialmediacategory');
            $platform             = $request->input('platform');
            $socialpassword       = $request->input('socialpassword');
            $socialoldpassword    = $request->input('socialoldpassword');
        
            if (is_array($socialmediacategory) && count($socialmediacategory) > 0) {
                    for($j=0; $j< count($socialmediacategory); $j++)
                        {
                            DB::table('tbl_case_seized_items')->insert([
                                'seizure_id'   => $seizure_id,
                                'item_type' => "Social Media",
                                'case_no_id'   => $request->input('casenoidseizureadd'),
                                'platform' =>  $platform[$j],
                                'password'   => $socialpassword[$j],
                                'oldpassword' => $socialoldpassword[$j],
                            ]);
                        }
                }
      
            $passportcategory     = $request->input('passportcategory');
            $passportno           = $request->input('passportno');
            $passportname         = $request->input('passportname');
            $passportissuedate    = $request->input('passportissuedate');
            $passportexpirydate   = $request->input('passportexpirydate');
        
       
             if (is_array($passportcategory) && count($passportcategory) > 0) {
                    for($j=0; $j< count($passportcategory); $j++)
                        {
                            DB::table('tbl_case_seized_items')->insert([
                                'seizure_id'   => $seizure_id,
                                'case_no_id'   => $request->input('casenoidseizureadd'),
                                'item_type' => "Passport",
                                'passportno' => $passportno[$j],
                                'passportname'   => $passportname[$j],
                                'passportissuedate' => $passportissuedate[$j],
                                'passportexpirydate' => $passportexpirydate[$j],
                            ]);
                        }
                }

            $currencycategory     = $request->input('currencycategory');
            $currencyamt          = $request->input('currencyamt');

            if (is_array($currencycategory) && count($currencycategory) > 0) { 
                    for($j=0; $j< count($currencycategory); $j++)
                        {
                            DB::table('tbl_case_seized_items')->insert([
                                'seizure_id'   => $seizure_id,
                                'case_no_id'   => $request->input('casenoidseizureadd'),
                                'item_type' => "Currency",
                                'currencyamt' => $currencyamt[$j],
                            ]);
                        }
                }

      Alert::success('You\'ve Successfully added seizure details');
                   return Redirect::back();
    }

    public function updateSeizureDetailsView($seizure_id)
    {
      $seizure = DB::table('tbl_case_mainseizures')
      ->where('seizure_id',$seizure_id)
      ->get();

      $officers = DB::table('tbl_officer_seizure')
      ->where('seizure_id',$seizure_id)
      ->get();

      $witnesses = DB::table('tbl_case_seizure_witnesses')
      ->where('seizure_id',$seizure_id)
      ->get();

      $seizeditems = DB::table('tbl_case_seized_items')
       ->where('seizure_id',$seizure_id)
        ->get();
    
      $typeseizures = DB::table('tbl_seizuretypes_lookup')->get();

    return view('searchandseizures.seizureDetailsView',compact('seizure','officers','witnesses','seizeditems','typeseizures'))
      ->with('i', (request()->input('page', 1) - 1) * 5);
    }

  public function updateSelectedRows(Request $request)
    {
        $selectedIds = $request->input('selected');
        $newStatus = 'Sent to Forensics'; // set the new status here
        
        DB::table('mainseizures')
            ->whereIn('seizure_id', $selectedIds)
            ->update(['status' => $newStatus]);
        
        $seizeddigitalitems = DB::table('mainseizures')->select('*')
            ->where('seizure_type', '=', 'Digital Items')
            ->get(); 
        
            foreach ($seizeddigitalitems as $seizeddigitalitem) {
              Mainforensic::create([
                  'item' => $seizeddigitalitem->item,
                  'manufacturer' => $seizeddigitalitem->manufacturer,
                  'model' => $seizeddigitalitem->model,
                  'serialNo' => $seizeddigitalitem->serialNo,
                  'condition' => $seizeddigitalitem->condition,
              ]);
          }

            Alert::success('You\'ve Successfully sent items to Forensics');
            return Redirect::back();
    }

    public function addDigitalItems(Request $request)
    {
            $data = $request->all();
            $seizure_id =$request->input('seizureidupdatedetails');

            DB::table('tbl_case_seized_items')->insert([
                'item_name' => $data['digitalitem'],
                'manufacturer' =>$data['manufacturer'],
                'model'=>$data['model'],
                'serial_no'=>$data['serialno'],
                'condition'=>$data['condition'],
                'item_type' =>"Digital",
                'created_at' => Carbon::now(),
                'seizure_id' => $seizure_id
                
                    ]);

           return response()->json(['success'=>'Data is successfully added']);
    }

    public function addEmail(Request $request)
    {
            $data = $request->all();
            $seizure_id =$request->input('seizureidupdatedetails');
         
            DB::table('tbl_case_seized_items')->insert([
                'email_address' => $data['emailid'],
                'password' =>$data['password'],
                'oldpassword'=>$data['oldpassword'],
                'inbox'=>$data['inbox'],
                'spam'=>$data['spam'],
                'sent'=>$data['sent'],
                'draft'=>$data['draft'],
                'item_type' =>"Email",
                'created_at' => Carbon::now(),
                'seizure_id' => $seizure_id
                
                    ]);

           return response()->json(['success'=>'Data is successfully added']);
    }

    public function addSocialMedia(Request $request)
    {
            $data = $request->all();
            $seizure_id =$request->input('seizureidupdatedetails');
         
            DB::table('tbl_case_seized_items')->insert([
                'platform' => $data['platform'],
                'password' =>$data['socialpassword'],
                'oldpassword'=>$data['socialoldpassword'],
                'item_type' =>"Social Media",
                'created_at' => Carbon::now(),
                'seizure_id' => $seizure_id
                
                    ]);

           return response()->json(['success'=>'Data is successfully added']);
    }

    public function addPassport(Request $request)
    {
            $data = $request->all();
            $seizure_id =$request->input('seizureidupdatedetails');
         
            DB::table('tbl_case_seized_items')->insert([
                'passportno' => $data['passportno'],
                'passportname' =>$data['passportname'],
                'passportissuedate'=>$data['passportissuedate'],
                'passportexpirydate'=>$data['passportexpirydate'],
                'item_type' =>"Passport",
                'created_at' => Carbon::now(),
                'seizure_id' => $seizure_id
                
                    ]);

           return response()->json(['success'=>'Data is successfully added']);
    }

    public function addCurrency(Request $request)
    {
            $data = $request->all();
            $seizure_id =$request->input('seizureidupdatedetails');
         
            DB::table('tbl_case_seized_items')->insert([
                'currencyamt' => $data['currencyamt'],
                'item_type' =>"Currency",
                'created_at' => Carbon::now(),
                'seizure_id' => $seizure_id
            ]);

           return response()->json(['success'=>'Data is successfully added']);
    }

    public function updateAjaxTable(Request $request)
    {        
        $seizeddigitalitem = DB::table('tbl_case_seized_items')->latest()->first();
        
        return response()->json($seizeddigitalitem);
       
        
    }

    public function getsearchdtls(Request $request)
        {
       
            $id   = Route::current()->parameter('selectedValue');
            $data = DB::table('tbl_case_mainsearches')
                ->join('tbl_case_entities', 'tbl_case_mainsearches.suspect', '=', 'tbl_case_entities.id')
                ->join('tbl_search_probable_causes_lookup', 'tbl_case_mainsearches.pcause', '=', 'tbl_search_probable_causes_lookup.id')
                ->where('tbl_case_mainsearches.search_id', $id)
                ->select('tbl_case_entities.name','tbl_case_mainsearches.*','tbl_search_probable_causes_lookup.cause_name')
                ->get();

            return response()->json(['data' => $data]);

        }
}
