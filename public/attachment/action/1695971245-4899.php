<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\IndustryProfile;
class ContactController extends Controller
{

    // public function __construct(){      
    // $this->middleware(function ($request, $next) {      
    //     if(auth()->user()->role!="SA"){
    //         return redirect()->route('focal_dashboard')->with('error','You are not authorized to access that page.');
    //     }
    //     return $next($request);
    // });
    // }

    
    public function index()
    {
        $data = [];
        $data['data'] = Contact::get();
        return view('contact.index',$data);
    }

    public function delete($id)
    {
        Contact::where('id',$id)->delete();
        return redirect()->back()->with('success','Data Deleted Successfully');
    }

    public function view($id)
    {
        $data = [];
        $data['data'] = Contact::where('id',$id)->first();
        return view('contact.view',$data);
    }


        public function checkApi(Request $request)
    {

        // header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
        // header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X- 
        // Request-With');


        $response = [];
        $check = IndustryProfile::where('license_no',$request->id)->where('status','!=','D')->first();
        if (@$check!="") {
            $response['code'] = '300';
            return $response;
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://datahub-apim.dit.gov.bt/token',
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=access_token',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic RjFqVmtfaUh1QVNtYkhRRU1aeURQUDFzcXNvYTpnTUl4YkFFQ3JmMVU2TFZlVldzOU5MbzkxcFVh',
    'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $token = json_decode($response)->access_token;
// 'crc345'
        $license_no = $request->id;
        $curl = curl_init();
        curl_setopt_array($curl, array(
       // CURLOPT_URL => 'https://datahub-apim.dit.gov.bt/moea_licenseinformationapi/1.0.0/DetailsAgainstLicense/'.$license_no.'',
          CURLOPT_URL => 'https://datahub-apim.dit.gov.bt/moea_licensedetailsapi/1.0.0/licensedetail/'.$license_no.'',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}
