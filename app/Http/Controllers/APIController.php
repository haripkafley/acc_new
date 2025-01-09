<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
     public function gettoken()
    {
        global $token_url, $client_id, $client_secret; 
        $token = '';
        
        $token_url = "https://stg-sso.dit.gov.bt/oauth2/token";
        $test_api_url = "https://apim.staging.api.gov.bt/dcrc_citizen_details_api/1.0.0";
        $client_id = "jm56a6bOyzrhzQghp2reqJs06xMa";
        $client_secret = "T59VIweocAO6llg_LhK1iTfU5Wsa";
    
        $content = "grant_type=client_credentials";
        $authorization = base64_encode("$client_id:$client_secret");
        $header = array("Authorization: Basic {$authorization}","Content-Type: application/x-www-form-urlencoded");
    
        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => $token_url,
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $content
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $token = json_decode($response)->access_token;
        echo json_encode($token);
    }
}
