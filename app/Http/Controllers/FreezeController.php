<?php

namespace App\Http\Controllers;
use Alert;
use Redirect;
use DB;


use Illuminate\Http\Request;

class FreezeController extends Controller
{
    public function displayassetdetailsforfreeze($assetid)
    {
        $assetdtls= DB::table('tbl_case_assets')
            ->where('id',$assetid)
            ->get();

        $freezedtls = DB::table('tbl_case_freezes')
        ->where('asset_id',$assetid)
            ->get();
        
        return view('asset.viewassetdtls',compact('assetdtls','freezedtls'));
    }

    public function addfreeze(Request $request)
    {
        $assetid        = $request->input('assetid');
        $freezedate     = $request->input('freezedate');
        $freezedetails  = $request->input('freezedetails');

        DB::table('tbl_case_freezes')->insert([
                            'asset_id'        => $assetid,
                            'freeze_date'     => $freezedate,
                            'freeze_details'  =>$freezedetails   
                            
                        ]);

        DB::table('tbl_case_assets')->where('id', $assetid)
                ->update(array( 
                'status'=>"Frozen",
                'freeze_date' => $freezedate));

            Alert::success('Item Freezed Successfully');
                        return Redirect::back();
    
    }

    public function addunfreeze(Request $request)
    {
        $assetid        = $request->input('assetidun');
        $unfreezedate     = $request->input('revokedate');
        $unfreezedetails  = $request->input('unfreezedetails');

        DB::table('tbl_case_freezes')->where('asset_id', $assetid)
                        ->update(array(
                            'unfreeze_date'     => $unfreezedate,
                            'unfreeze_details'  => $unfreezedetails   
                            
                        ));

        DB::table('tbl_case_assets')->where('id', $assetid)
                ->update(array( 
                'status'=>"Revoked",
                'unfreeze_date' => $unfreezedate));

            Alert::success('Revoke Successful');
                        return Redirect::back();
    
    }
}
