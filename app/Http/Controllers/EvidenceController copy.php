<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Auth;
use DB;
use Redirect;
use Alert;
use Carbon\Carbon;
use Storage;

class EvidenceController extends Controller
{
    public function addevidences(Request $request)
    {
       
        $casenoid            = $request->input('evicasenoidadd');
        $evidencecat         = $request->input('evidencecat');
        $evidescription      = $request->input('evidescription');        
        $evidenceno          = $request->input('evidenceno');        
        $evisource           = $request->input('evidfrom');
        $evidencecolldate    = $request->input('collected_on');
        $evidname            = $request->input('evidname');
        $collectedby         = $request->input('evidcollectedby');

        $file_extention = $request->eviexhibit->getClientOriginalExtension();
        $file_name = $request->eviexhibit->getClientOriginalName();

        $data=array('case_no_id'=>$casenoid,'evidence_category'=>$evidencecat,
        'collected_on'=>$evidencecolldate, 'evidence_file_name' => $file_name, 
        'collected_by'=>$collectedby,'evidence_description'=>$evidescription,
        'evidence_no'=>$evidenceno,'collected_from'=>$evisource,'evidence_name'=>$evidname,
        'evidence_file_extension' => $file_extention,
        'created_at' => Carbon::now());
         DB::table('tbl_case_evidences')->insert($data);

        $evidences    = DB::table('tbl_case_evidences')->latest('id')->first();
        $evidence_id = $evidences->id;

            

        //  if ($request->hasFile('eviexhibit')) {
        //     $collageImages = [];

        //     foreach ($request->file('eviexhibit') as $image) {
        //         $imageName = $image->getClientOriginalName();
        //         $imageExtension = $image->getClientOriginalExtension();
        //         $image->move(public_path('Evidences')."/".$evidence_id, $imageName);

        //         DB::table('tbl_case_evidence_files')->insert([
        //                     'evidence_id'     => $evidence_id,
        //                     'evidence_path'   => $imageExtension,
        //                     'evidence_name'   => $imageName,
        //                     'case_no_id'        => $casenoid,
        //                 ]);
        //     }
        // }
        
        $file_path = $request->eviexhibit->move(public_path('Evidences')."/".$evidence_id,$file_name);
        
        
        Alert::success('You\'ve Successfully added an Evidence');
        return Redirect::back();
       
    }

  
    public function editevid($caseno)
    {
        $evidences= DB::table('tbl_case_evidences')
            ->where('id',$caseno)
            ->get();
        
        $officers = DB::table('users')
            ->where('role', "Investigator")
            ->get();
        
        $collectionmethods = DB::table('tbl_collection_methods_lookup')
       ->get();

        return view('evidences.editevidences',compact('evidences','officers','collectionmethods'));
    }

    public function viewevid($caseno)
    {
        $evidences= DB::table('tbl_case_evidences')
            ->where('id',$caseno)
            ->get();
        

        return view('evidences.viewevidences',compact('evidences'));
    }

    public function updateevid(Request $request)
    {
        
        $id                = $request->input('evidenceid');
        $caseno            = $request->input('evicasenoupdate');
        $evidescription    = $request->input('evidescription');        
        $evidenceno        = $request->input('evidenceno');        
        $evisource         = $request->input('evidsource');

        DB::table('tbl_case_evidences')->where('id', $id)
                    ->update(array(                                     
                        'evidence_description'=>$evidescription,
                        'evidence_no'=>$evidenceno,
                        'collected_from'=>$evisource,
                        'updated_at' => Carbon::now()
                             ));

        Alert::success('You\'ve Successfully updated an Evidence');
        return Redirect::back();

                           
    }

    public function generateevidenceno(Request $request)
    {
        $generatedEvidenceNo = null;
        
        $zerostring = "0";
        
        

        $evidencecategory = $request->evidencecat;

        $lastevidenceno =  DB::table('tbl_case_evidences')->select(['evidence_no'])->where('evidence_category' , $evidencecategory )->latest()->first();
        

        if(isset($lastevidenceno))
        {
            $pieces = explode("-", $lastevidenceno->evidence_no);
            $serialno = $pieces[2] + 1;
              
        } 
        else
        {
            $serialno = 1;
        
        }

        

        
        if($evidencecategory == "Statement")
        {
            $generatedEvidenceNo ="RCO";
        }

        
        
        return response()->json($generatedEvidenceNo);
    }

    public function showelements($offenceid)
    {
        
        $elements = DB::table('tbl_elements_lookup')->where('offence_id', $offenceid)->get();

         return view('evidences.showelements', compact('elements'));

        //return response()->json($data);

    }

    public function showelementmatrix($id,$casenoid)
    {
         $offenceDetails = DB::table('tbl_case_evidence_matrix')->where('accused_name', $id)->where('case_no_id', $casenoid)->get();
          $uniqueOffences = $offenceDetails->groupBy('offence_name')->map->first();

         return view('evidences.showmatrix', compact('offenceDetails','uniqueOffences'));
    }

    public function updateevidencematrix($id, $value,$accusedname, $offencename, $casenoid, $evidenceid)
    {

         DB::table('tbl_case_evidence_matrix')->insert([
                            'element_id'        => $id,
                            'textdetails'       => $value,
                            'accused_name'      => $accusedname,
                            'offence_name'      => $offencename,
                            'case_no_id'        => $casenoid,
                            'evidence_id'       => $evidenceid
                        ]);
    }

    public function getLastExhibitNumber($categoryname,$casenoid)
{
    $generatedExhibitNo = null;

    $caseid =  DB::table('tbl_registered_cases')->where("id", $casenoid)->value('case_id');

    $tableIsEmpty = DB::table('tbl_case_evidences')->where("evidence_category", $categoryname)->count() === 0;

    if ($tableIsEmpty) {
        $serialno = 1;
    } else {
        $lastevidenceno = DB::table('tbl_case_evidences')->where('evidence_category', $categoryname)->orderBy('id', 'desc')->first();
        $pieces = explode("/", $lastevidenceno->evidence_no);
        $serialno = (int)$pieces[2];
        $serialno++;
    }

    // Format the serial number with leading zeros (3 digits)
    $serialno = sprintf('%03d', $serialno);

    if ($categoryname == "D-Documents") {
        $generatedExhibitNo = $caseid . '/' ."EXHB" . '/' . "D" . '-' . $serialno;
    } elseif ($categoryname == "S-Statements") {
        $generatedExhibitNo = $caseid . '/' ."EXHB" . '/' . "S" . '-' . $serialno;
    } elseif ($categoryname == "O-Objects") {
        $generatedExhibitNo = $caseid . '/' ."EXHB" . '/' . "O" . '-' . $serialno;
    } elseif ($categoryname == "M-Media Files") {
        $generatedExhibitNo = $caseid . '/' ."EXHB" . '/' . "M" . '-' . $serialno;
    } elseif ($categoryname == "P-Photograph") {
        $generatedExhibitNo = $caseid . '/' ."EXHB" . '/' . "P" . '-' . $serialno;
    }

    return response()->json($generatedExhibitNo);
}


    public function showelementforsubstantiate(Request $request)
        {
       
            $elementid = Route::current()->parameter('elementid');
            $data = DB::table('tbl_case_evidence_matrix')->where('element_id', '=', $elementid)->get();

            return response()->json(['data' => $data]);
        }
    

    public function substantiateelement($elementid, $casenoid)
        {
            // $elementid = Route::current()->parameter('elementid');
            // $casenoid = Route::current()->parameter('casenoid');

            DB::table('tbl_case_evidence_matrix')
                ->where('element_id', $elementid)
                ->where('case_no_id', $casenoid)
                ->update([
                    'substantiate' => "Substantiated",
                ]);

            return response()->json(['success' => true]);
        }

    public function addevidencematrix($accusedname, $offencename, $casenoid)
        {
            
             DB::table('tbl_case_evidence_matrix')
                ->where('offence_name', $offencename)
                ->where('accused_name', $accusedname)
                ->where('case_no_id', $casenoid)
                    ->update(array(                                     
                        'saved' => "Yes"
                    ));
        
            return response()->json(['message' => 'You\'ve Successfully saved a matrix']);

        }

     public function deleteevidence($id)
    {
        DB::table('tbl_case_evidences')->where('id', $id)->delete();

        Alert::success('Evidence Deleted Successfully');
                    return Redirect::back(); 
            
                

    }   

}
