<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use DB;
use Illuminate\Http\Response;
use Auth;
use Storage;
use Carbon\Carbon;
use Alert;
use Redirect;

class SuspensionController extends Controller
{
    public function addsuspension(Request $request)

    {
        $casenoid                       = $request->input('suspensioncasenoidadd');
        $type                           = $request->input('suspensiontype');
        $identification_no              = $request->input('bhutanesecid');
        $name                           = $request->input('civilservantname');
        $employeeno                     = $request->input('civilservantemployeeno');
        $dateofappointment              = $request->input('civilservantappointmentdate');
        $positiontitle                  = $request->input('civilservantpositiontitle');
        $parentagency                   = $request->input('civilservantparentagency');
        $workingagency                  = $request->input('civilservantworkingagency');
        $suspensiondatepublic           = $request->input('suspensiondatepublic');
        $suspensionreasonpublic         = $request->input('suspensionreasonpublic');
        $suspensiondatebusiness         = $request->input('suspensiondatebusiness');
        $suspensionreasonbusiness       = $request->input('suspensionreasonbusiness');
        $businesslicenseno              = $request->input('businesslicenseno');
        $businesslocation               = $request->input('businesslocation');
        $businessowner                  = $request->input('businessowners');
        $businesslicenseissuedate       = $request->input('businesslicenseissuedate');
        $businesslicenseexpirydate      = $request->input('businesslicenseexpirydate');
        $businessactivity               = $request->input('businessactivity');
        $businessname                   = $request->input('businessname');

        $date = Carbon::createFromFormat('d/m/Y', $dateofappointment);
        $formattedDate = $date->format('Y-m-d');
        
        if($type == "Public")
        {

         DB::table('tbl_case_suspensions')->insert([
            "case_no_id"          => $casenoid,
            "suspension_type"     => $type,
            "identification_no"   => $identification_no,
            "name"                => $name,
            "employeeno"          => $employeeno,
            "dateofappointment"   => $formattedDate,
            "positiontitle"       => $positiontitle,
            "parentagency"        => $parentagency,
            "workingagency"       => $workingagency,
            "suspended_on"        => $suspensiondatepublic,
            "suspension_reason"   => $suspensionreasonpublic,
            "suspension_status"   => "Suspended"

            ]);

            $suspensiontable = DB::table('tbl_case_suspensions')->latest('id')->first();
            $id = $suspensiontable->id;

            $suspensions = DB::table('tbl_case_suspensions')->where('id',$id )->get();

            return view('suspensions.suspensionorderpublicservant',compact('suspensions'));
        }
        if($type == "Business")
        {
        
            DB::table('tbl_case_suspensions')->insert([
            "case_no_id"                    => $casenoid,
            "suspension_type"               => $type,
            "name"                          => $businessname,
            "identification_no"             => $businesslicenseno,
            "business_location"             => $businesslocation,
            "business_owner"                => $businessowner,
            "business_license_issue_date"   => $businesslicenseissuedate,
            "business_license_expiry_date"  => $businesslicenseexpirydate,
            "business_activity"             => $businessactivity,
            "suspended_on"                  => $suspensiondatebusiness,
            "suspension_reason"             => $suspensionreasonbusiness,
            "suspension_status"             => "Suspended"

            ]);

            $suspensiontable = DB::table('tbl_case_suspensions')->latest('id')->first();
            $id = $suspensiontable->id;

            $suspensions = DB::table('tbl_case_suspensions')->where('id',$id )->get();

            return view('suspensions.suspensionorderbusiness',compact('suspensions'));
        }
        
                    
    }

    public function generatesuspensionorder(Suspension $suspensions)
    {
        $suspensionid = Route::current()->parameter('id');
        $casenoid = Route::current()->parameter('casenoid');

        $suspensions = DB::table('suspensions')
        ->where('id',$suspensionid)
        ->get();

        $caseno = DB::table('showcases')
        ->where('id', $casenoid)
        ->value('case_no');

        Suspension::where('id', $suspensionid)
        ->update(array( 
        'suspension_status'=>"In Force"));



        return view('suspensions.showsuspensionorder',compact('suspensions','caseno'));

    }

    public function revokesuspensionorder(Request $request)
    {
        $suspensionid = $request->input('suspensionidrevoke');
        $revokedate = $request->input('suspensionrevokedate');
        $revokereason = $request->input('revokedetails');

        DB::table('tbl_case_suspensions')->where('id', $suspensionid)
                ->update(array( 
                'suspension_status'=>"Revoked",
                'revoke_date' => $revokedate,
                'revoke_reason' => $revokereason));

        $suspensions = DB::table('tbl_case_suspensions')->where('id', $suspensionid)->get();

        return view('suspensions.revokeorder',compact('suspensions'));

    }

    public function displayassetdetailsforsuspension($id)
    {
        $suspensiondtls= DB::table('tbl_case_suspensions')
            ->where('id',$id)
            ->get();
        
        return view('suspensions.suspensiondtlsview',compact('suspensiondtls'));

    }

}
