<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mail;
use DB;
use Redirect;
use Alert;
use Carbon\Carbon;

class ArrestandDetentionController extends Controller
{
    public function addArrestdetails(Request $request)
        {
          $casenoid          = $request->input('arrestcasenoidadd');
          $emailreceiver     = DB::table('tbl_user_role_mapping')->where('role', 'Commission')->where('case_no_id', $casenoid)->value('assigned_to');
          $emailreceivername = DB::table('users')->where('email',$emailreceiver)->value('name');
          $caseno            = DB::table('tbl_registered_cases')->where('id', $casenoid)->value('case_no');
          $casetitle         = DB::table('tbl_registered_cases')->where('id', $casenoid)->value('case_title');
          $assigned_email    = Auth::user()->email;
          $sender_name       = DB::table('users')->where('email',$assigned_email)->value('name');
          $suspectid         = $request->input('suspect');
          $suspectname       = DB::table('tbl_case_entities')->where('id',$suspectid)->value('name');
          $suspectcid        = DB::table('tbl_case_entities')->where('id',$suspectid)->value('identification_no');
          
          $data=array(
                'case_no_id' => $request->input('arrestcasenoidadd'),
                'arrest_requested_by' =>Auth::user()->email,
                'typeofArrest' => $request->input('typeofArrest'),
                'suspect' => $request->input('suspect'),
                'applicationdate' => $request->input('applicationdate'),
                );
            
              DB::table('tbl_case_mainarrests')->insert($data);

              $id    = DB::table('tbl_case_mainarrests')->latest('arrest_id')->first();
              $arrest_id = $id->arrest_id;
                
              $probable_causes = $request->input('pcause');

              foreach($probable_causes as $pcauses)
                {
                        DB::table('tbl_case_arrest_probable_causes')->insert([
                            'arrest_id'   => $arrest_id,
                            'name' => $pcauses
                        ]);
                }

                $data["titlecoi"]  = "Arrest Approval Request";
                $data["firstcoi"]  = "Dear Mr/Mrs/Ms " . $emailreceivername . ",";
                $data["secondcoi"] = "This is to notify that you have been requested by ". $sender_name ." to review and approve the request to proceed with arrest and detention of Mr/Mrs." . $suspectname . " bearing identification no " . $suspectcid ." relating to the case: ";
                $data["thirdcoi"]  = "Case No:" . $caseno;
                $data["fourthcoi"] = "Case Title:" . $casetitle;
                $data["fifthcoi"]  = "";
                $data["emailreceiver"] = DB::table('tbl_user_role_mapping')->where('role', 'Commission')->where('case_no_id', $casenoid)->value('assigned_to');
 
                $data["cardValuecoi"] = "Arrest Approval Request";    

                // Mail::send('emails.arrestemail', $data, function($message)use($data) {
                //     $message->to($data["emailreceiver"], $data["emailreceiver"])
                //             ->subject($data["titlecoi"]);
                // });

          Alert::success('You\'ve Successfully submit for Arrest Approval');
              return Redirect::back();

        
        }

    public function commissionUpdateAnD($arrest_id)
        {
          
          $Recommendationstatus = DB::table('tbl_recommendationstatuses_lookup')->get();
          $Mainarrest = DB::table('tbl_case_mainarrests')->where('arrest_id',$arrest_id)->get();
          $pcauses = DB::table('tbl_case_arrest_probable_causes')->where('arrest_id',$arrest_id)->get();

          return view('arrestanddetentions.commissionreview',compact('Mainarrest','Recommendationstatus','arrest_id','pcauses'))
          ->with('i', (request()->input('page', 1) - 1) * 5);
        }

    public function updateCommissionArrest(Request $request)
      {
        $arrest_id         = $request->input('arrestid');
        $commissionStatus  = $request->input('commissionStatus');
        $commissionReview  = $request->input('commissionReview');
        $emailreceiver     = DB::table('tbl_case_mainarrests')->where('arrest_id', $arrest_id)->value('arrest_requested_by');
        $emailreceivername = DB::table('users')->where('email',$emailreceiver)->value('name');
        $casenoid          = DB::table('tbl_case_mainarrests')->where('arrest_id', $arrest_id)->value('case_no_id');
        $caseno            = DB::table('tbl_registered_cases')->where('id', $casenoid)->value('case_no');
        $casetitle         = DB::table('tbl_registered_cases')->where('id', $casenoid)->value('case_title');
        $suspectid         = DB::table('tbl_case_mainarrests')->where('arrest_id', $arrest_id)->value('suspect');
        $suspectname       = DB::table('tbl_case_entities')->where('id',$suspectid)->value('name');
        $suspectcid        = DB::table('tbl_case_entities')->where('id',$suspectid)->value('identification_no');

        DB::table('tbl_case_mainarrests')->where('arrest_id', $arrest_id)
                  ->update(array(
                      'commissionStatus'=>$commissionStatus,
                      'commissionReview'=>$commissionReview,
                    ));
        
        
        $data["titlecoi"]  = "Arrest Approval";
        $data["firstcoi"]  = "Dear Mr/Mrs/Ms " . $emailreceivername . ",";
        $data["secondcoi"] = "This is to notify that your request to review and approve the  arrest and detention of Mr/Mrs." . $suspectname . " bearing identification no " . $suspectcid ." relating to the case: ";
        $data["thirdcoi"]  = "Case No:" . $caseno;
        $data["fourthcoi"] = "Case Title:" . $casetitle;
        $data["fifthcoi"]  = "has been completed";
        $data["emailreceiver"] = DB::table('tbl_user_role_mapping')->where('role', 'Commission')->where('case_no_id', $casenoid)->value('assigned_to');

        $data["cardValuecoi"] = "Arrest Approval";    

        Mail::send('emails.arrestemail', $data, function($message)use($data) {
            $message->to($data["emailreceiver"], $data["emailreceiver"])
                    ->subject($data["titlecoi"]);
        });
                  
          Alert::success('You\'ve Successfully updated arrest application status');
                    return Redirect::back();
      }


  public function updatearrestdetails(Request $request)
      {
        $arrest_id = $request->input('arrestidforupdate');
        $arrestedon = $request->input('arrest_date');
        $arrestedby = $request->input('arrestedby');
        $arrestedfrom = $request->input('arrestedfrom');
        $arrested_remarks = $request->input('arrestremarks');



        DB::table('tbl_case_mainarrests')->where('arrest_id', $arrest_id)
                    ->update(array(
                    'arrested_by'=>$arrestedby,
                    'arrested_on'=>$arrestedon,
                    'arrested_from'=>$arrestedfrom,
                    'arrested_remarks'=>$arrested_remarks,
                    'commissionStatus' => "Arrested"
                    ));
                  
          Alert::success('You\'ve Successfully updated arrest application details');
                    return Redirect::back();
      }
      public function arrestdetailsview($arrest_id)
        {
          $Mainarrest = DB::table('tbl_case_mainarrests')->where('arrest_id',$arrest_id)->get();
          $pcauses = DB::table('tbl_case_arrest_probable_causes')->where('arrest_id',$arrest_id)->get();
          
          return view('arrestanddetentions.arrest_details_view',compact('Mainarrest','arrest_id','pcauses'))
          ->with('i', (request()->input('page', 1) - 1) * 5);
        }

         public function arrestdetailsviewarr($arrest_id)
        {
          $Mainarrest = DB::table('tbl_case_mainarrests')->where('arrest_id',$arrest_id)->get();
          $pcauses = DB::table('tbl_case_arrest_probable_causes')->where('arrest_id',$arrest_id)->get();
          
          return view('arrestanddetentions.arrest_details_view_after_arrest',compact('Mainarrest','arrest_id','pcauses'))
          ->with('i', (request()->input('page', 1) - 1) * 5);
        }

      public function detentionAdd($arrest_id)
    {
      $Recommendationstatus = DB::table('tbl_recommendationstatuses_lookup')->get();
      $Mainarrest = DB::table('tbl_case_mainarrests')->where('arrest_id',$arrest_id)->get();
      $casenoid = DB::table('tbl_case_mainarrests')->where('arrest_id',$arrest_id)->value('case_no_id');
      
      return view('arrestanddetentions.AddDetention',compact('Mainarrest','Recommendationstatus','arrest_id','casenoid'))
      ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function detentiondetailsadd(Request $request)
    {
      $casenoid = $request->input('detentioncasenoidadd');
      $subjectid = $request->input('suspect');
      $gender = DB::table('tbl_case_entities')->where("id", "=", $subjectid)->value('gender');
     
     DB::table('tbl_case_detentions')->insert([
      'case_no_id' => $request->input('detentioncasenoidadd'),
      'suspect' => $request->input('suspect'),
      'gender' => $gender,
      'detained_from' => $request->input('detained_from'),
      'detained_on' => $request->input('detained_on'),
      'detention_faciliity' => $request->input('detained_location'),
      'detained_by' => $request->input('detainedby'),
      'status' => "Detained"
    ]);


              $id    = DB::table('tbl_case_detentions')->latest('detention_id')->first();
              $detention_id = $id->detention_id;
                
              $probable_causes = $request->input('pcause');

            foreach($probable_causes as $pcauses)
            {
                    DB::table('tbl_case_detention_probable_causes')->insert([
                        'detention_id'   => $detention_id,
                        'name' => $pcauses
                    ]);
            }
      Alert::success('You\'ve Successfully added detention details');
                   return Redirect::back();
       
    }

    public function detentiondetailsdisplay($detention_id)
    {
      $detentions = DB::table('tbl_case_detentions')
        ->where('detention_id',$detention_id)
        ->get();
      
        $pcauses = DB::table('tbl_case_detention_probable_causes')->where('detention_id',$detention_id)->get();
      

      return view('arrestanddetentions.detention_details_view',compact('detentions','pcauses'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

     public function remanddetailsdisplay($detention_id)
    {
      $remands = DB::table('tbl_case_remands')
        ->where('detention_id',$detention_id)
        ->get();
      
      return view('arrestanddetentions.remand_details_view',compact('remands'));
      
    }

    public function detentiondetailsdisplayforremand($arrest_id)
    {
      $detentions = DB::table('tbl_case_detentions')
        ->where('arrest_id',$arrest_id)
        ->get();
      
      $courts = DB::table('tbl_courts_lookup')->get();
      
      $Mainarrest = DB::table('tbl_case_mainarrests')->where('arrest_id',$arrest_id)->get();

      return view('arrestanddetentions.RemandDetails',compact('detentions','Mainarrest','courts'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function addremanddetails(Request $request)
        {

          $remand_status = $request->input('remandtype');
          $remanddocument = $request->file('remanddocument');
          $type_of_release = $request->input('typeofrelease');  

          if($remand_status == "Under Custody")
          {
            $data=array(
                'detention_id' => $request->input('detentionidforremand'),
                'case_no_id' => $request->input('casenoidforemand'),
                'remand_status' =>$remand_status,
                'remanded_until' => $request->input('remandeduntil'),
                'court' => $request->input('court'),
                'remand_file_name' => $request->remanddocument->getClientOriginalName()
                
                );

                DB::table('tbl_case_remands')->insert($data);

                $remands = DB::table('tbl_case_remands')->latest('id')->first();
                $remandid = $remands->id;

                $request->remanddocument->move(public_path('Remand')."/".$remandid,$request->remanddocument->getClientOriginalName());
              
              
              }
                
          if($remand_status == "Released" && $type_of_release == "Bail")
            {
             $data=array(
                'detention_id' => $request->input('detentionidforremand'),
                'case_no_id' => $request->input('casenoidforemand'),
                'remand_status' =>$remand_status,
                'released_on' => $request->input('releasedon'),
                'type_of_release' => $type_of_release,
                'bail_amount' => $request->input('bailamt'),
                'bail_document_name' => $request->baildocument->getClientOriginalName(),
                'bail_bond_undertaking_name' => $request->bailbondundertaking->getClientOriginalName(),
                'bond_receipt_name' => $request->bondreceipt->getClientOriginalName()
                
                );
                DB::table('tbl_case_remands')->insert($data);

                $remands = DB::table('tbl_case_remands')->latest('id')->first();
                $remandid = $remands->id;

                $request->baildocument->move(public_path('Remand')."/".$remandid,$request->baildocument->getClientOriginalName());
                $request->bailbondundertaking->move(public_path('Remand')."/".$remandid,$request->bailbondundertaking->getClientOriginalName());
                $request->bondreceipt->move(public_path('Remand')."/".$remandid,$request->bondreceipt->getClientOriginalName());
              
                DB::table('tbl_case_detentions')->where('detention_id',  $request->input('detentionidforremand'))
                    ->update(array(
                    'status'=>"Released"
                    ));
              
              }

            if($remand_status == "Released" && $type_of_release == "Surety")
            {
             $data=array(
                'detention_id' => $request->input('detentionidforremand'),
                'case_no_id' => $request->input('casenoidforemand'),
                'remand_status' =>$remand_status,
                'released_on' => $request->input('releasedon'),
                'type_of_release' => $type_of_release,
                'surety_name' => $request->input('suretyname'),
                'surety_cid' => $request->input('suretycid'),
                'relationship_surety' => $request->input('suretyrelation'),
                'surety_phone' => $request->input('suretycontactno'),
                'surety_undertaking_name' => $request->suretyundertaking->getClientOriginalName(),
                
                );
                 DB::table('tbl_case_remands')->insert($data);

                $remands = DB::table('tbl_case_remands')->latest('id')->first();
                $remandid = $remands->id;

                $request->suretyundertaking->move(public_path('Remand')."/".$remandid,$request->suretyundertaking->getClientOriginalName());
                
                DB::table('tbl_case_detentions')->where('detention_id',  $request->input('detentionidforremand'))
                    ->update(array(
                    'status'=>"Released"
                    ));
              
              }

              if($remand_status == "Released" && $type_of_release == "Both")
            {
             $data=array(
                'detention_id' => $request->input('detentionidforremand'),
                'case_no_id' => $request->input('casenoidforemand'),
                'remand_status' =>$remand_status,
                'released_on' => $request->input('releasedon'),
                'type_of_release' => $type_of_release,
                'bail_amount' => $request->input('bailamt'),
                'bail_document_name' => $request->baildocument->getClientOriginalName(),
                'bail_bond_undertaking_name' => $request->bailbondundertaking->getClientOriginalName(),
                'bond_receipt_name' => $request->bondreceipt->getClientOriginalName(),
                'surety_name' => $request->input('suretyname'),
                'surety_cid' => $request->input('suretycid'),
                'relationship_surety' => $request->input('suretyrelation'),
                'surety_phone' => $request->input('suretycontactno'),
                'surety_undertaking_name' => $request->suretyundertaking->getClientOriginalName(),
                
                );
              
              DB::table('tbl_case_remands')->insert($data);

              $remands = DB::table('tbl_case_remands')->latest('id')->first();
                $remandid = $remands->id;

                $request->suretyundertaking->move(public_path('Remand')."/".$remandid,$request->suretyundertaking->getClientOriginalName());
                $request->baildocument->move(public_path('Remand')."/".$remandid,$request->bail_documenbaildocumentt_name->getClientOriginalName());
                $request->bailbondundertaking->move(public_path('Remand')."/".$remandid,$request->bailbondundertaking->getClientOriginalName());
                $request->bondreceipt->move(public_path('Remand')."/".$remandid,$request->bondreceipt->getClientOriginalName());
                $request->remanddocument->move(public_path('Remand')."/".$remandid,$request->remanddocument->getClientOriginalName());

                DB::table('tbl_case_detentionss')->where('detention_id',  $request->input('detentionidforremand'))
                    ->update(array(
                    'status'=>"Released"
                    ));
              
              }

          Alert::success('You\'ve Successfully added remand details');
              return Redirect::back();

        
        }
}
