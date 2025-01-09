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
use App\Models\CaseEvidence;
use App\Models\User;
use App\Models\CaseEvidenceMatrixOne;
use App\Models\CaseEvidenceMatrixTwo;
use App\Models\CaseEvidenceMatrixThree;
use App\Models\RegisteredCase;
use App\Models\ElementLookup;
use App\Models\EvidenceCategory;
use App\Models\CollectionMethod;

class EvidenceController extends Controller
{
    /////////////////////// EVIDENCE ///////////////////////////////////////////

     public function getLastExhibitNumber($categoryname, $casenoid)
{
    $generatedExhibitNo = null;

    // Get the case ID based on $casenoid
    $caseid = RegisteredCase::where("id", $casenoid)->value('case_id');

    // Find the last evidence number for the given category and case ID
    $lastevidenceno = CaseEvidence::where('evidence_category', $categoryname)
        ->where('case_no_id', $casenoid)
        ->orderBy('id', 'desc')
        ->first();

    if (!$lastevidenceno) {
        // If no previous record exists, initialize the serial number to 1
        $serialno = 1;
    } else {
        // Extract the last serial number and increment it
        $pieces = explode("-", $lastevidenceno->evidence_no);
        $lastSerialNumber = (int)end($pieces);
        $serialno = $lastSerialNumber + 1;
    }

    // Format the serial number with leading zeros (3 digits)
    $serialno = sprintf('%03d', $serialno);

    // Construct the generated exhibit number
    //$generatedExhibitNo = "$caseid/abc/EXHB/$categoryname-$serialno";

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

     
    public function addevidences(Request $request)
    {
        DB::beginTransaction();

        try 
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
        );
        
        CaseEvidence::insert($data);

        $evidences    = CaseEvidence::latest('id')->first();
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
        
         DB::commit();
        Alert::success('You\'ve Successfully added an Evidence');
        return Redirect::back(); 
    
               
            } 
        catch (Exception $e) 
            {
                DB::rollBack();

            }
    }

    public function editevid($caseno)
    {
        $evidences= CaseEvidence::where('id',$caseno)->get();
        
        $officers = User::where('role', "Investigator")->get();
        
        $collectionmethods = CollectionMethod::get();

        return view('evidences.editevidences',compact('evidences','officers','collectionmethods'));
    }

    public function viewevid($caseno)
    {
        $evidences= CaseEvidence::where('id',$caseno)->get();
        

        return view('evidences.viewevidences',compact('evidences'));
    }

    public function updateevid(Request $request)
    {
        
        $id                = $request->input('evidenceid');
        $caseno            = $request->input('evicasenoupdate');
        $evidescription    = $request->input('evidescription');        
        $evidname          = $request->input('evidname'); 
        $collectedon       = $request->input('collected_on'); 
        $collectedby       = $request->input('evidcollectedby');
        $evisource         = $request->input('evidsource');

        CaseEvidence::where('id', $id)
                    ->update(array(                                     
                        'evidence_description'=>$evidescription,
                        'evidence_name'=>$evidname,
                        'collected_on'=> $collectedon,
                        'collected_by'=> $collectedby,
                        'collected_from'=>$evisource,
                        'updated_at' => Carbon::now()
                             ));

        Alert::success('You\'ve Successfully updated an Evidence');
        return Redirect::back();

                           
    }

    public function deleteevidence($id)
    {
        CaseEvidence::where('id', $id)->delete();

        Alert::success('Evidence Deleted Successfully');
                    return Redirect::back(); 
            
                

    } 

    //////////////////////// EVIDENCE MATRIX ///////////////////////////////////

    public function addmainevidencematrix($accusedid, $offenceid, $casenoid, $description)
        {
            
            CaseEvidenceMatrixOne::create([
                'accused_id'      => $accusedid,
                'offence_id'      => $offenceid,
                'description'     => $description,
                'case_no_id'      => $casenoid,
                
            ]);

            $matrix   = CaseEvidenceMatrixOne::latest('id')->first();
            $matrix_id = $matrix->id;
            $sourceData = ElementLookup::where('offence_id', $offenceid)->get();
            

            $insertData = [];

            foreach ($sourceData as $data) {
                $insertData[] = [
                    'table_one_id'   => $matrix_id,
                    'element_id'     => $data->id,
                    'required'       => $data->required,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now()
                ];
            }

            CaseEvidenceMatrixTwo::insert($insertData);

            $value = CaseEvidenceMatrixTwo::latest('id')->first();
            $evidencematrixid = $value->table_one_id; 
        
             return response()->json(['evidencematrixid' => $evidencematrixid]);

        }

    public function showelements($matrixid)
        {
            
            $elements = CaseEvidenceMatrixTwo::join('tbl_elements_lookup','tbl_case_evidence_matrix_two.element_id','=','tbl_elements_lookup.id')
                ->where('tbl_case_evidence_matrix_two.table_one_id', $matrixid)
                ->select('tbl_elements_lookup.element_name','tbl_case_evidence_matrix_two.id')
                ->get();

            return response()->json(['elements' => $elements]);

        }
    
     public function updateevidencematrix($draggedId, $value, $elementid)
    {
       
            CaseEvidenceMatrixThree::create([
                    'table_two_id'  => $draggedId,
                    'evidence_id' => $elementid,
                    'textdetails' => $value
                ]);

                $result = CaseEvidenceMatrixThree::latest('id')->first();
                $matrixevidenceid = $result->id;
            
            return response()->json(['matrixevidenceid' => $matrixevidenceid ]);
    }

    public function showtextdetails($id)
    {
       
       $elements =CaseEvidenceMatrixThree::select('id','textdetails')
        ->where('id', $id)
        ->get();
        
        $textareaValue = $elements->first()->textdetails;
        
            return response()->json([
                    'id' => $id,
                    'textareaValue' => $textareaValue,
                ]);
        
    }

    public function deletetextdetails($id)
    {
        CaseEvidenceMatrixThree::where('id', $id)->delete();
    }

    public function substantiateelement($elementid)
        {

            CaseEvidenceMatrixTwo::where('id', $elementid)
                ->update([
                    'substantiate' => "Substantiated",
                ]);

            return response()->json(['success' => true]);
        }
    
    public function findValues($elementid)
        {
            $offenceid = CaseEvidenceMatrixTwo::where('id', $elementid)->value('table_one_id');

            $totalRequiredYes = CaseEvidenceMatrixTwo::where('table_one_id', $offenceid)
                ->where('required', 'Yes')
                ->count();

            $totalRequiredYesAndSubstantiate = CaseEvidenceMatrixTwo::where('table_one_id', $offenceid)
                ->where('required', 'Yes')
                ->where('substantiate', 'Substantiated')
                ->count();
            
            $totalRequiredNoAndSubstantiate = CaseEvidenceMatrixTwo::where('table_one_id', $offenceid)
            ->where('required', 'No')
            ->where('substantiate', 'Substantiated')
            ->first();


            if ( $totalRequiredYes == $totalRequiredYesAndSubstantiate && $totalRequiredNoAndSubstantiate !== null) 
            {
                $substantiatevalue = "Yes";
            }
            else
            {
                $substantiatevalue = "No";
            }

            return response()->json(['substantiatevalue' => $substantiatevalue]);

        }

    public function unsubstantiateelement($elementid)
        {

           CaseEvidenceMatrixTwo::where('id', $elementid)
                ->update([
                    'substantiate' => "Unsubstantiated",
                ]);

            return response()->json(['success' => true]);
        }

   public function addevidencematrix($matrixid)
{
    $accusedId = CaseEvidenceMatrixOne::where('id', $matrixid)->value('accused_id');
    $offenceId = CaseEvidenceMatrixOne::where('id', $matrixid)->value('offence_id');

    $lastCount = CaseEvidenceMatrixOne::where('accused_id', $accusedId)
        ->where('offence_id', $offenceId)
        ->where('saved', 'Yes')
        ->orderBy('id', 'desc')
        ->value('count');

    $newCount = ($lastCount) ? $lastCount + 1 : 1;

    CaseEvidenceMatrixOne::where('id', $matrixid)
        ->update(['count' => $newCount, 'saved' => 'Yes']);

    return response()->json(['message' => 'You\'ve Successfully saved a matrix']);
}

public function showelementsfrommatrix($id)
        {
          $elements = CaseEvidenceMatrixOne::join('tbl_case_evidence_matrix_two as matrix_two', 'tbl_case_evidence_matrix_one.id', '=', 'matrix_two.table_one_id')
            ->leftJoin('tbl_case_evidence_matrix_three', 'tbl_case_evidence_matrix_three.table_two_id', '=', 'matrix_two.id')
            ->where('matrix_two.substantiate', 'Substantiated')
            ->where('tbl_case_evidence_matrix_one.id', $id)
            ->select('matrix_two.*', 'tbl_case_evidence_matrix_three.evidence_id as evidence_id_from_three')
            ->get();


            return view('evidences.showsavedelements', compact('elements'));
        }
}
