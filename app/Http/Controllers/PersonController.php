<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Alert;
use Redirect;
use DB;
use Storage;
use Session;
use App\Models\Entity;
use App\Models\CaseEntity;

class PersonController extends Controller
{
    public function savemainentity(Request $request)
        {
            $bhutanesename = $request->bhutanesename;
            $bhutanesegender = $request->bhutanesegender;
            $bhutanesedob = $request->bhutanesedob;
            $bhutanesedzongkhag = $request->bhutanesedzongkhag;
            $bhutanesegewog = $request->bhutanesegewog;
            $bhutanesevillage = $request->bhutanesevillage;
            $bhutanesecid = $request->bhutanesecid;
            $bhutanesephone = $request->bhutanesephone;
            $bhutaneseaddress = $request->bhutaneseaddress;
            $bhutaneseemail = $request->bhutaneseemail;
            $persontype = $request->persontype;

                Entity::insert([
                        'name' => $bhutanesename,
                        'gender' => $bhutanesegender,
                        'dateofbirth' => $bhutanesedob,
                        'dzongkhag' => $bhutanesedzongkhag,
                        'gewog' => $bhutanesegewog,
                        'village' => $bhutanesevillage,
                        'identification_no' => $bhutanesecid,
                        'address' => $bhutaneseaddress,
                        'contactno' => $bhutanesephone,
                        'email' => $bhutaneseemail,
                        'type'  => $persontype,
                        
                    ]);
            Session::flash('success', 'Status updated successfully');
            $alldata = Entity::latest('id')->first();
           return response()->json(['data' => $alldata]);
    }

    public function savecaseentity(Request $request)
        {
             DB::beginTransaction();

        try 
            {
                $data = $request->all();
            $type = $data['persontype'];
            $casenoid = $data['personcasenoidadd'];
            $bhutanesephoto = $request->file('bhutanesephoto');  
            $nonbhutanesephoto = $request->file('nonbhutanesephoto');
            $bhutanesefile = $request->file('bhutanesephoto');
            $nonbhutanesefile = $request->file('nonbhutanesephoto');
            $bhutanesecid = $request->file('bhutanesecid');
            $nonbhutanesecid = $request->file('nonbhutanesepermit');


            if ($nonbhutanesefile === null) {
            $file_extention_bhutanese = $request->bhutanesephoto->getClientOriginalExtension();
            $file_name_bhutanese = $request->bhutanesephoto->getClientOriginalName();
            }
            
            if ($bhutanesefile === null) {
            $file_extention_nonbhutanese = $request->nonbhutanesephoto->getClientOriginalExtension();
            $file_name_nonbhutanese = $request->nonbhutanesephoto->getClientOriginalName();
            }
           
                        
            if($type == "Bhutanese")
            {
                
                CaseEntity::insert([
                        'name' => $data['bhutanesename'],
                        'gender' => $data['bhutanesegender'],
                        'dateofbirth' => $data['bhutanesedob'],
                        'dzongkhag' => $data['bhutanesedzongkhag'],
                        'gewog' => $data['bhutanesegewog'],
                        'village' => $data['bhutanesevillage'],
                        'identification_no' => $data['bhutanesecid'],
                        'address' => $data['bhutaneseaddress'],
                        'contactno' => $data['bhutanesephone'],
                        'email' => $data['bhutaneseemail'],
                        'type'  => $type,
                        'case_no_id' => $casenoid,
                        'entitytype' => $data['bhutanesepartytype'],
                        'involvement' => $data['bhutaneseinvolvement'],
                        'photo_name' => $file_name_bhutanese, 
                        'photo_extension' => $file_extention_bhutanese,
                    ]);

                $entities = CaseEntity::latest('id')->first();
                $entity_id = $entities->id;

                $checkbhutanesecidexists =Entity::where('identification_no',$bhutanesecid)->get();
                
                if ($checkbhutanesecidexists->isEmpty()) 
                {
                  Entity::insert([
                        'name' => $data['bhutanesename'],
                        'gender' => $data['bhutanesegender'],
                        'dateofbirth' => $data['bhutanesedob'],
                        'dzongkhag' => $data['bhutanesedzongkhag'],
                        'gewog' => $data['bhutanesegewog'],
                        'village' => $data['bhutanesevillage'],
                        'identification_no' => $data['bhutanesecid'],
                        'address' => $data['bhutaneseaddress'],
                        'contactno' => $data['bhutanesephone'],
                        'email' => $data['bhutaneseemail'],
                        'type'  => $type,
                        'photo_name' => $file_name_bhutanese, 
                        'photo_extension' => $file_extention_bhutanese,
                    ]);  
                }
                
                $file_path = $request->bhutanesephoto->move(public_path('Entity')."/".$entity_id,$file_name_bhutanese);


                    
                }
            
            if($type == "Non Bhutanese")
            {
            
                CaseEntity::insert([
                        'name' => $data['nonbhutanesename'],
                        'gender' => $data['nonbhutanesegender'],
                        'dateofbirth' => $data['nonbhutanesedob'],
                        'permanentaddress' => $data['nonbhutanesepermanentaddress'],
                        'identification_no' => $data['nonbhutanesepermit'],
                        'address' => $data['nonbhutaneseaddress'],
                        'contactno' => $data['nonbhutanesephone'],
                        'email' => $data['nonbhutaneseemail'],
                        'type'  => $type,
                        'case_no_id' => $casenoid,
                        'entitytype' => $data['nonbhutanesepartytype'],
                        'involvement' => $data['nonbhutaneseinvolvement'],
                        'photo_name' => $file_name_nonbhutanese, 
                        'photo_extension' => $file_extention_nonbhutanese,
                    ]);

                $entities = CaseEntity::latest('id')->first();
                $entity_id = $entities->id;

                $checknonbhutanesecidexists =Entity::where('identification_no',$nonbhutanesecid)->get();
                
                if ($checknonbhutanesecidexists->isEmpty()) 
                {
                  Entity::insert([
                        'name' => $data['nonbhutanesename'],
                        'gender' => $data['nonbhutanesegender'],
                        'dateofbirth' => $data['nonbhutanesedob'],
                        'permanentaddress' => $data['nonbhutanesepermanentaddress'],
                        'identification_no' => $data['nonbhutanesepermit'],
                        'address' => $data['nonbhutaneseaddress'],
                        'contactno' => $data['nonbhutanesephone'],
                        'email' => $data['nonbhutaneseemail'],
                        'type'  => $type,
                        'photo_name' => $file_name_nonbhutanese, 
                        'photo_extension' => $file_extention_nonbhutanese,
                    ]);  
                }
                
                $file_path = $request->nonbhutanesephoto->move(public_path('Entity')."/".$entity_id,$file_name_nonbhutanese);

                    
                }
    
                DB::commit();
                Alert::success('Entity added Successfully');
                    return Redirect::back(); 
            } 
        catch (Exception $e) 
            {
                DB::rollBack();

            }
             
        }

    public function saveforinterviewentity(Request $request)
        {
            $data = $request->all();
            $type = $data['persontype'];
            $casenoid = $data['personcasenoidadd'];

            if($type == "Bhutanese")
            {
                DB::table('tbl_case_interviewees')->insert([
                        'name' => $data['bhutanesename'],
                        'gender' => $data['bhutanesegender'],
                        'dateofbirth' => $data['bhutanesedob'],
                        'dzongkhag' => $data['bhutanesedzongkhag'],
                        'gewog' => $data['bhutanesegewog'],
                        'village' => $data['bhutanesevillage'],
                        'identification_no' => $data['bhutanesecid'],
                        'address' => $data['bhutaneseaddress'],
                        'contactno' => $data['bhutanesephone'],
                        'email' => $data['bhutaneseemail'],
                        'type'  => $data['persontype'],
                        'case_no_id' => $casenoid,
                    ]);
                }
            
            if($type == "NonBhutanese")
            {
            
                DB::table('tbl_case_interviewees')->insert([
                        'name' => $data['nonbhutanesename'],
                        'gender' => $data['nonbhutanesegender'],
                        'dateofbirth' => $data['nonbhutanesedob'],
                        'permanentaddress' => $data['nonbhutanesepermanentaddress'],
                        'identification_no' => $data['nonbhutanesepermit'],
                        'address' => $data['nonbhutaneseaddress'],
                        'contactno' => $data['nonbhutanesephone'],
                        'email' => $data['nonbhutaneseemail'],
                        'type'  => $data['persontype'],
                        'case_no_id' => $casenoid,
                    ]);
                }

            $alldata = DB::table('tbl_case_interviewees')->latest('id')->first();
                       return response()->json(['data' => $alldata]);
             
        }

       

        public function deleteentity(Request $request)
    {
        $id = Route::current()->parameter('id');

        CaseEntity::where('id', $id)->delete();

        Alert::success('Delete Successful');
                    return Redirect::back(); 
    }

    public function saveeditentity(Request $request)
    {
        $bhutanesephoto = $request->file('bhutanesephoto');
        $id = $request->input('entityidedit');
        $person = $request->input('personname');
        $identificationno = $request->input('identificationno');
        $nationality = $request->input('nationality');
        $dateofbirth = $request->input('dateofbirth');
        $gender = $request->input('gender');
        $phoneno = $request->input('phoneno');
        $email = $request->input('email');
        $dzongkhag = $request->input('dzongkhag');
        $gewog = $request->input('gewog');
        $village = $request->input('village');
        $permanentaddress = $request->input('paddress');

        if ($bhutanesephoto != null) {
            $file_extention_bhutanese = $request->bhutanesephoto->getClientOriginalExtension();
            $file_name_bhutanese = $request->bhutanesephoto->getClientOriginalName();
            }
        
        CaseEntity::where('id', $id)
            ->update(array( 
                'name'=> $person,
                'identification_no'=> $identificationno,
                'gender'=> $gender,
                'type'=> $nationality,
                'dateofbirth'=> $dateofbirth,
                'contactno'=> $phoneno,
                'dzongkhag'=> $dzongkhag,
                'email' => $email,
                'gewog'=> $gewog,
                'village'=> $village,
                'permanentaddress'=> $permanentaddress,
                'photo_name' => $file_name_bhutanese, 
                'photo_extension' => $file_extention_bhutanese,
            ));

            $file_path = $request->bhutanesephoto->move(public_path('Entity')."/".$id,$file_name_bhutanese);

            Alert::success('Update Successful');
                    return Redirect::back();
    }

    public function checkCID($cid, $casenoid)
    {
       
        $data = DB::table('tbl_case_interviewees')->where('identification_no', $cid)->where('case_no_id', $casenoid)->get();

        return response()->json(['data' => $data]);
    }
    public function checkCIDcreatecase($cid)
    {
       
        $data = Entity::where('identification_no', $cid)->get();

        return response()->json(['data' => $data]);
    }

    public function checkCIDaddentity($cid, $casenoid)
    {
       
        $data = CaseEntity::where('identification_no', $cid)->where('case_no_id', $casenoid)->get();

        return response()->json(['data' => $data]);
    }
    
}
