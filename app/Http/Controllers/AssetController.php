<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Alert;
use Redirect;
use DB;

class AssetController extends Controller
{
     public function savecaseasset(Request $request)
        {
            $data = $request->all();
            $type = $data['assettype'];
            $casenoid = $data['assetcasenoid'];
                        
            if($type == "Land")
            {
                
                DB::table('tbl_case_assets')->insert([
                        'cidno' => $data['landcid'],
                        'plotno' => $data['assetplotno'],
                        'thramno' => $data['assetthramno'],
                        'area' => $data['assetarea'],
                        'owner' => $data['landowner'],
                        'location_dzongkhag' => $data['landdzongkhag'],
                        'location_gewog' => $data['landthromde'],
                        'location_village' => $data['landvillage'],
                        'location_address' => $data['landaddress'],
                        'asset_type'  => $type,
                        'case_no_id' => $casenoid,
                    ]);


                    
                }
            
            if($type == "Vehicle")
            {
            
                DB::table('tbl_case_assets')->insert([
                        'cidno' => $data['assetvehiclecid'],
                        'vehicletype' => $data['vehicletype'],
                        'vehicle_registrationno' => $data['vehicleregistrationno'],
                        'vehicle_registrationdate' => $data['vehicleregistrationdate'],
                        'owner' => $data['vehicleowner'],
                        'asset_type'  => $type,
                        'case_no_id' => $casenoid,
                        
                    ]);
                }

            if($type == "Building")
                {
            
                DB::table('tbl_case_assets')->insert([
                        'cidno' => $data['assetbuildingcid'],
                        'plotno' => $data['buildingplotno'],
                        'thramno' => $data['buildingthramno'],
                        'area' => $data['landareaplr'],
                        'building_no' => $data['buildingno'],
                        'noofunits' => $data['landnoofunits'],
                        'owner' => $data['buildingowner'],
                        'location_dzongkhag' => $data['buildingdzongkhag'],
                        'location_gewog' => $data['buildingthromde'],
                        'location_village' => $data['buildingvillage'],
                        'location_address' => $data['buildingaddress'],
                        'asset_type'  => $type,
                        'case_no_id' => $casenoid,
                        
                    ]);
                }

                if($type == "Bank")
                {
            
                DB::table('tbl_case_assets')->insert([
                        'bank_name' => $data['bankname'],
                        'bank_accounttype' => $data['bankaccounttype'],
                        'owner' => $data['bankaccountowner'],
                        'bank_accountno' => $data['bankaccountno'],
                        'asset_type'  => $type,
                        'case_no_id' => $casenoid,
                        
                    ]);
                }

                Alert::success('Successful');
                    return Redirect::back(); 
            
        }
        public function showassetdetails(Request $request)
        {        
            $id = Route::current()->parameter('id');
            $assetdtls =  DB::table('tbl_case_assets')->where('id', $id)->get();
            
            return view('asset.showassetdetails',compact('assetdtls'));
        }

         public function deleteasset(Request $request)
        {
            $id = Route::current()->parameter('id');

            DB::table('tbl_case_assets')->where('id', $id)->delete();

            Alert::success('Delete Successful');
                        return Redirect::back(); 
                
        }
}
