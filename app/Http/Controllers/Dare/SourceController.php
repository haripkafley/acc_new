<?php

namespace App\Http\Controllers\Dare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dare\Source;
use Redirect;
use Alert;
use DB;
use Str;
class SourceController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = Source::where('status','!=','D')->get();
        $data['agencys'] = DB::table('pl_tblagency')->get();


         
            

        $year = date('y');  // Get the current year in YY format


        $fullName = trim(auth()->user()->name);

        $nameParts = explode(' ', $fullName);

        // Get the first and last names
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? $nameParts[count($nameParts) - 1] : $firstName; // Use first 




        $firstName = strtoupper($firstName);
        $lastName = strtoupper($lastName);
        
        // Check if a code already exists for this user
        $existingCode = DB::table('source_code_uniq_id')->where('user_id', auth()->user()->id)->value('code');
       
        if ($existingCode) {
            $code = $existingCode;
        }else{
                    $firstInitial = $firstName[0];
        $initialIndex = 1;  // Start with the last letter of the last name

        while (true) {
            // Attempt to get the letter for the current index
            $lastNameLetter = strlen($lastName) >= $initialIndex ? $lastName[strlen($lastName) - $initialIndex] : null;

            // If no more letters are available in the last name, switch to the first name
            if (!$lastNameLetter) {
                $lastNameLetter = strlen($firstName) >= $initialIndex ? $firstName[strlen($firstName) - $initialIndex] : null;
            }
            
            // If letters are exhausted, break to avoid infinite loop
            if (!$lastNameLetter) {
                break;
            }
            
            // Generate initials with the selected letter
            $initials = $firstInitial . $lastNameLetter;
            
            // Check if a code with these initials already exists
            $conflictCount = DB::table('source_code_uniq_id')
                ->where('code', 'LIKE', "$initials%")
                ->count();
            
            if ($conflictCount == 0) {
                // No conflicts, assign the code
                $code = "$initials";
                break;
            } else {
                // Code exists with these initials, increment suffix
                $code = "$initials";
            }
            
            // Move to the next letter in the sequence
            $initialIndex++;
        
        }

         DB::table('source_code_uniq_id')->insert([
            'code'=>$code,
            'user_id'=>auth()->user()->id,
         ]);

        
        }


        $latest_source_id = Source::orderBy('id','desc')->first();
        $source_code = $year.'-'.$code.'- 0'.$latest_source_id->id+1;
        $data['source_address'] = $source_code;



        return view('dare.source_master',$data);
    }

    public function insert(Request $request)
    {
        $new = new Source;
        $new->source_type = $request->source_type;
        $new->name = $request->name;
        if($request->source_type=="Humint" || $request->source_type=="DS")
        {
            $new->agency = $request->agency;
        }else{
            $new->agency = null;
        }
        
        $new->save();
        Alert::success('You\'ve Successfully Added A Source');
        return Redirect::back();
    }

    public function update(Request $request)
    {

        $upd = [];
        $upd['name'] = $request->name;
        if($request->source_type=="Humint" || $request->source_type=="DS")
        {
            $upd['agency'] = $request->agency;
        }else{
            $upd['agency'] = null;
        }

        Source::where('id',$request->id)->update($upd);
        Alert::success('You\'ve Successfully Updated A Source');
        return Redirect::back();
    }

    public function delete($id)
    {
        Source::where('id',$id)->update(['status'=>'D']);
        Alert::success('You\'ve Successfully Deleted A Source');
        return Redirect::back();
    }
}
