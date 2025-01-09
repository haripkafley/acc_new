<?php

namespace App\Http\Controllers\Ti;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dare\Source;
use App\Models\Ti\TackticalInteligence;
use App\Models\Ti\TackticalMember;
use App\Models\Ti\TiLogsheet;
use App\Models\Ti\Diary;
use App\Models\Ti\SourceInformation;
use App\Models\Ti\TiSirReport;
use App\Models\Ti\TiReport;
use App\Models\Ti\TiExhibit;
use App\Models\Ti\EntityPerson;
use App\Models\Ti\SirNewReport;
use App\Models\Ti\EntityOrganization;
use App\Models\Ti\TackticalCommissionDirective;
use App\Models\Ti\TiCommissionActivity;
use App\Models\Entity;
use App\Models\User;
use App\Models\Complaint\agencyModel;
use App\Models\Dare\IpStatus;
use App\Models\Ti\EntityAsset;
use App\Models\Dare\Idiary;
use App\Models\Dare\IntelPlan;
use App\Models\Dare\IrTeamMember;
use App\Models\Dare\IrForm;
use Session;
use Alert;
use Redirect;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use PDF;
class TackticalDataSubmission extends Controller
{

    public function indexIg()
    {
        $data = [];
        $data['data'] = TackticalMember::where('user_id',auth()->user()->id)->orderBy('id','desc')->whereHas('tacktical_details',function($query){
            $query->where('type_ti','IG');
        })->whereIn('coi_status',['AA','N'])->get();
        Session::put('ti_type','IG');
        return view('tacktical.indi.index',$data); 
    }

    public function indexSur()
    {
        $data = [];
        $data['data'] = TackticalMember::where('user_id',auth()->user()->id)->orderBy('id','desc')->whereHas('tacktical_details',function($query){
            $query->where('type_ti','S');
        })->whereIn('coi_status',['AA','N'])->get();
        Session::put('ti_type','S');
        return view('tacktical.indi.index_survillance',$data); 
    }


    public function details($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = TackticalInteligence::where('id',$id)->first();
        return view('tacktical.indi.details',$data); 
    }


    public function coiPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = TackticalMember::where('user_id',auth()->user()->id)->where('id',$id)->first();
        return view('tacktical.indi.coi_page',$data); 
    }

    public function coiPageDecision(Request $request)
    {
        $upd = [];
        $upd['coi_status'] = $request->evaluation;
        if(@$request->evaluation=="Y")
        {
            $upd['describe_coi'] = $request->describe;
        }else{
            $upd['describe_coi'] = '';
        }

        TackticalMember::where('id',$request->id)->update($upd);

        Alert::success('Decision updated successfully');
        if (Session::get('ti_type')=="S") {
            return redirect()->route('tacktical.inteligence.autorization.individual.get.assignment.surveillance');
        }else{
            return redirect()->route('tacktical.inteligence.autorization.individual.get.assignment.information-gathering');
        }
        
    }

    public function logSheet($id)
    {
        $check = TackticalMember::where('user_id',auth()->user()->id)->where('tacktical_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }

        $data['data'] = TiLogsheet::where('ti_id',$id)->where('created_by',auth()->user()->id)->get();
        $data['users'] = User::where('is_delete',0)->get();
        $data['id'] = $id;
        $data['check'] = TackticalInteligence::where('id',$id)->first();
        return view('tacktical.indi.log_sheet',$data);
    }


    public function logSheetInsert(Request $request)
    {
        $new = new TiLogsheet;
        $new->ti_id = $request->ti_id;
        $new->activity = $request->activity;
        $new->date_event = $request->date_event;
        $new->start_time = $request->start_time;
        $new->end_time = $request->end_time;
        $new->expenditure = $request->expenditure;
        $new->expenditure_details = $request->expenditure_details;
        $new->remarks = $request->remarks;
        $new->created_by = auth()->user()->id;
        $implode = implode(',',@$request->members);
        $new->members = $implode;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function logSheetupdate(Request $request)
    {
        $upd = [];
        $upd['activity'] = $request->activity;
        $upd['date_event'] = $request->date_event;
        $upd['start_time'] = $request->start_time;
        $upd['end_time'] = $request->end_time;
        $upd['expenditure'] = $request->expenditure;
        $upd['expenditure_details'] = $request->expenditure_details;
        $upd['remarks'] = $request->remarks;
        $implode = implode(',',@$request->members);
        $upd['members'] = $implode;
        TiLogsheet::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();

    }


    public function logSheetdelete($id)
    {
        TiLogsheet::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function diaryPage()
    {
        // $check = TackticalMember::where('user_id',auth()->user()->id)->where('tacktical_id',$id)->first();
        // if (@$check=="") {
        //     Alert::error('Unauthorized Access');
        //     return redirect()->route('dashboard');
        // }

        $user_id = auth()->user()->id;
        $diary = Diary::where('created_by',auth()->user()->id)->get();
        $idiary = Idiary::where(function($query) use ($user_id){

                    $query->where('created_by',$user_id)
                          ->orwhereRaw("FIND_IN_SET(?, members)", [$user_id]);
                })
                ->get();

        
        
        $plan = IntelPlan::where(function($query) use ($user_id){

                    $query->where('created_by',$user_id)
                          ->orwhereRaw("FIND_IN_SET(?, officer_assign_id)", [$user_id]);
                })
                ->get();

       $logSheet = TiLogsheet::where(function($query) use ($user_id){

                    $query->where('created_by',$user_id)
                          ->orwhereRaw("FIND_IN_SET(?, members)", [$user_id]);
                })
                ->get();

                


        


        $mergedData = (new Collection)
            ->merge($diary)
            ->merge($idiary)
            ->merge($logSheet)
            ->merge($plan);

        // Optionally sort the merged data if needed
        $sortedMergedData = $mergedData->sortByDesc('created_at')->values();
        $data['data'] = $sortedMergedData;
        $assign_ti_ids = TackticalMember::where('user_id',auth()->user()->id)->pluck('tacktical_id')->toArray();
        $assign_ir_ids = IrTeamMember::where('user_id',auth()->user()->id)->pluck('ir_id')->toArray();


        $data['tiList'] = TackticalInteligence::whereIn('id',$assign_ti_ids)->get();
        $data['irList'] = IrForm::whereIn('id',$assign_ir_ids)->get();
        return view('tacktical.diary_indi',$data);
    }


    public function diaryPageInsert(Request $request)
    {   
        // return $request;
        $new = new Diary;
        $new->ti_id = $request->ti_id;
        $new->activity = $request->activity;
        $new->event = $request->event;
        $new->date_of_event = $request->date_of_event;
        $new->start_time = $request->start_time;
        $new->end_time = $request->end_time;
        $new->remarks = $request->remarks;
        $new->created_by = auth()->user()->id;
        $new->type_of_file = $request->type_of_file;

        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function diaryPageupdate(Request $request)
    {

        $upd = [];
        $upd['activity'] = $request->activity;
        $upd['event'] = $request->event;
        $upd['date_of_event'] = $request->date_of_event;
        $upd['start_time'] = $request->start_time;
        $upd['end_time'] = $request->end_time;
        $upd['remarks'] = $request->remarks;
        Diary::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }


    public function diaryPagedelete($id)
    {
        Diary::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function sourcePage($id)
    {
        $check = TackticalMember::where('user_id',auth()->user()->id)->where('tacktical_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['users'] = User::where('is_delete',0)->get();
        $data['id'] = $id;
        $data['sir'] = SirNewReport::where('ti_id',$id)->where('created_by',auth()->user()->id)->get();
        $data['agency'] = agencyModel::where('isDelete',0)->get();
        $data['status'] = IpStatus::get();
        $data['source'] = Source::where('status','A')->get();
        $data['check'] = TackticalInteligence::where('id',$id)->first();
        return view('tacktical.indi.sir_indi_new',$data);
    }

    public function sourcePageInsert(Request $request)
    {

        $implode = implode(',',@$request->members);
        $new = new SirNewReport;
        $new->ti_id = $request->ti_id;
        $new->source_code = $request->source_code;
        $new->source_type = $request->source_type;
        $new->received_date = $request->received_date;
        $new->start_time = $request->start_time;
        $new->end_time = $request->end_time;
        $new->details = $request->details;
        $new->officers = $implode;
        $new->created_by = auth()->user()->id;
        $new->save();

        $sir_no = 'SIR-00'.$new->id.'/'.date('Y');
        SirNewReport::where('id',$new->id)->update(['sir_no'=>$sir_no]);
        Alert::success('Data inserted successfully');
        return redirect()->back();


        // $new = new SourceInformation;
        // $new->ti_id = $request->ti_id;
        // $new->source_type = $request->source_type;
        // $new->source_code = $request->source_code;
        // $new->date = date('Y-m-d');
        // $new->status = 'Active';
        // $new->created_by = auth()->user()->id;
        // $new->save();
        // Alert::success('Data inserted successfully');
        // return redirect()->back();
    }


    public function sourcePageupdate(Request $request)
    {

        $implode = implode(',',@$request->members);
        $upd = [];
        // $upd['source_code'] = $request->source_code;
        $upd['received_date'] = $request->received_date;
        $upd['start_time'] = $request->start_time;

        $upd['end_time'] = $request->end_time;
        $upd['details'] = $request->details;
        $upd['officers'] = $implode;
        SirNewReport::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
        // $upd = [];
        // $upd['source_code'] = $request->source_code;
        // SourceInformation::where('id',$request->id)->update($upd);
        // Alert::success('Data updated successfully');
        // return redirect()->back();
    }

    public function sourcePagedelete($id)
    {
        SirNewReport::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function siPage($id)
    {
        $check = TackticalMember::where('user_id',auth()->user()->id)->where('tacktical_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['plan'] = TiSirReport::where('ti_id',$id)->where('created_by',auth()->user()->id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['source'] = Source::where('status','A')->get();
        $data['status'] = IpStatus::get();
        return view('tacktical.indi.si_plan',$data);
    }


    public function siPageInsert(Request $request)
    {
        // $implode = implode(',',@$request->members);
        // $new = new TiSirReport;
        // $new->ti_id = $request->ti_id;
        // $new->source_code = $request->source_code;
        // $new->received_date = $request->received_date;
        // $new->start_time = $request->start_time;
        // $new->end_time = $request->end_time;
        // $new->details = $request->details;
        // $new->officers = $implode;
        // $new->created_by = auth()->user()->id;
        // $new->save();

        // $sir_no = 'SIR-00'.$new->id.'/'.date('Y');
        // TiSirReport::where('id',$new->id)->update(['sir_no'=>$sir_no]);
        $implode = implode(',',@$request->members);
        $new = new TiSirReport;
        $new->ti_id = $request->ti_id;
        $new->task = $request->task;
        $new->start_date = $request->start_date;
        $new->end_date = $request->end_date;
        $new->collected_from = $request->collected_from;
        $new->source = $request->source;
        $new->source_type = $request->source_type;
        $new->status = $request->status;
        $new->officer_assign_id = $implode;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }

    public function siPageupdate(Request $request)
    {
        // $implode = implode(',',@$request->members);
        // $upd = [];
        // $upd['source_code'] = $request->source_code;
        // $upd['received_date'] = $request->received_date;
        // $upd['start_time'] = $request->start_time;

        // $upd['end_time'] = $request->end_time;
        // $upd['details'] = $request->details;
        // $upd['officers'] = $implode;
        // TiSirReport::where('id',$request->id)->update($upd);
        $implode = implode(',',@$request->members);
        $upd = [];
        $upd['task'] = $request->task;
        $upd['start_date'] = $request->start_date;
        $upd['end_date'] = $request->end_date;

        $upd['collected_from'] = $request->collected_from;
        // $upd['source'] = $request->source;
        $upd['status'] = $request->status;


        $upd['officer_assign_id'] = $implode;
        TiSirReport::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
        // Alert::success('Data updated successfully');
        // return redirect()->back();
    }

    public function siPagedelete($id)
    {
        TiSirReport::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function tiReportPage($id)
    {
        $check = TackticalMember::where('user_id',auth()->user()->id)->where('tacktical_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }

        $data = [];
        $data['data'] = TackticalInteligence::where('id',$id)->first();
        $data['id'] = $id;
        return view('tacktical.indi.report',$data);
    }

    public function prepareReport($id)
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('id',$id)->first();
        $data['id'] = $id;
        return view('tacktical.indi.report_prepare',$data);
    }

    public function updateReport(Request $request)
    {
        $upd = [];
        $upd['background'] = $request->background;
        $upd['findings'] = $request->findings;
        $upd['recomendation'] = $request->recomendation;
        $upd['other_information'] = $request->other_information;
        $upd['completation_date'] = $request->completation_date;
        $upd['submitted_by'] = auth()->user()->id;
        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ti/',$filename);
                    $upd['attachment'] = $filename;
        }
        TackticalInteligence::where('id',$request->id)->update($upd);
        Alert::success('Report made successfully');
        return redirect()->route('tacktical.inteligence.autorization.individual.ti-report.information.page',$request->id);

    }

    public function downloadReport($id)
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('id',$id)->first();
        $data['id'] = $id;
        $pdf = PDF::loadView('tacktical.indi.report_prepare_pdf',$data);
        return $pdf->download($data['data']->id.'.pdf');
    }


    public function tiReportPageInsert(Request $request)
    {
        $new = new TiReport;
        $new->ti_id = $request->ti_id;
        $new->recomendation = $request->recomendation;
        $new->condut_on = $request->condut_on;
        $new->created_by = auth()->user()->id;
        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ir/',$filename);
                    $new->attachment = $filename;
        }
        $new->save();
        TackticalInteligence::where('id',$request->ti_id)->update(['complete_task'=>'Y']);
        Alert::success('Report inserted successfully.Data moved to complete tab successfully');
        return redirect()->back();
    }

    public function tiReportPageupdate(Request $request)
    {
        $upd = [];
        $upd['condut_on'] = $request->condut_on;
        $upd['recomendation'] = $request->recomendation;
        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ir/',$filename);
                    $upd['attachment'] = $filename;
        }

        TiReport::where('id',$request->id)->update($upd);
        Alert::success('Report updated successfully');
        return redirect()->back();
    }

    public function tiReportPagedelete($id)
    {
        TiReport::where('id',$id)->delete();
        Alert::success('Report deleted successfully');
        return redirect()->back();
    }

    public function tiexhibitPage($id)
    {
        $check = TackticalMember::where('user_id',auth()->user()->id)->where('tacktical_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['exhibit'] = TiExhibit::where('ti_id',$id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['check'] = TackticalInteligence::where('id',$id)->first();
        return view('tacktical.indi.exhibit',$data);
    }

    public function tiexhibitPageInsert(Request $request)
    {
        // return $request;
        $implode = implode(',',@$request->members);
        $new = new TiExhibit;
        $new->ti_id = $request->ti_id;
        $new->name = $request->name;
        $new->created_on = $request->created_on;
        $new->code = $request->code;
        $new->collected_by = $implode;
        $new->description = $request->description;
        $new->created_by = auth()->user()->id;
        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ir/',$filename);
                    $new->attachment = $filename;
        }
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }

    public function tiexhibitPageupdate(Request $request)
    {
        $implode = implode(',',@$request->members);
        $upd = [];
        $upd['name'] = $request->name;
        $upd['created_on'] = $request->created_on;
        $upd['code'] = $request->code;
        $upd['collected_by'] = $implode;
        $upd['description'] = $request->description;
        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ir/',$filename);
                    $upd['attachment'] = $filename;
        }
        TiExhibit::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function tiexhibitPagedelete($id)
    {
        TiExhibit::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function tientityPage($id)
    {
        $check = TackticalMember::where('user_id',auth()->user()->id)->where('tacktical_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['entityperson'] = EntityPerson::where('ti_id',$id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')->get();
        $data['check'] = TackticalInteligence::where('id',$id)->first();
        return view('tacktical.indi.entity_person',$data);
    }

    public function etientityPageCheckIdentity($cid, $id)
    {
        $data = EntityPerson::where('identification_no',$cid)->where('ti_id',$id)->get();
        return response()->json(['data' => $data]);
    }

    public function tientityPageInsert(Request $request)
    {
        DB::beginTransaction();

        try 
            {
            $data = $request->all();
            $type = $data['persontype'];
            $ti_id = $data['personcasenoidadd'];
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
                
                EntityPerson::insert([
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
                        'ti_id' => $ti_id,
                        'entitytype' => $data['bhutanesepartytype'],
                        'involvement' => $data['bhutaneseinvolvement'],
                        'photo_name' => $file_name_bhutanese, 
                        'photo_extension' => $file_extention_bhutanese,
                    ]);

                $entities = EntityPerson::latest('id')->first();
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
            
                EntityPerson::insert([
                        'name' => $data['nonbhutanesename'],
                        'gender' => $data['nonbhutanesegender'],
                        'dateofbirth' => $data['nonbhutanesedob'],
                        'permanentaddress' => $data['nonbhutanesepermanentaddress'],
                        'identification_no' => $data['nonbhutanesepermit'],
                        'address' => $data['nonbhutaneseaddress'],
                        'contactno' => $data['nonbhutanesephone'],
                        'email' => $data['nonbhutaneseemail'],
                        'type'  => $type,
                        'ti_id' => $ti_id,
                        'entitytype' => $data['nonbhutanesepartytype'],
                        'involvement' => $data['nonbhutaneseinvolvement'],
                        'photo_name' => $file_name_nonbhutanese, 
                        'photo_extension' => $file_extention_nonbhutanese,
                    ]);

                $entities = EntityPerson::latest('id')->first();
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

    public function tientityPageview($id)
    {
        $id = Route::current()->parameter('id');
        $entitydetailsshow =  EntityPerson::where('id', $id)->get();
        $entityid = EntityPerson::where('id', $id)->value('identification_no');
        $casenoid = EntityPerson::where('id', $id)->value('ti_id');
        $othercasesdtls = EntityPerson::where('identification_no', $entityid)->where('ti_id','!=', $id)->get();
        
        return view('tacktical.indi.showentitiesdetails',compact('entitydetailsshow', 'othercasesdtls'));
    }

    public function tientityPagedelete($id)
    {
        $id = Route::current()->parameter('id');
        EntityPerson::where('id', $id)->delete();
        Alert::success('Delete Successful');
        return redirect()->back();
    }

    public function tientityOrganizationPage($id)
    {
        $check = TackticalMember::where('user_id',auth()->user()->id)->where('tacktical_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['entityorganization'] = DB::table('ti_organizations')
          ->where('ti_id', $id)
          ->get();
        $data['parentagency'] = DB::table('tbl_parentagencies_lookup')->get();
        $data['agencyname'] = DB::table('tbl_agencynames_lookup')->get();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')->get();
        $data['check'] = TackticalInteligence::where('id',$id)->first();
        return view('tacktical.indi.entity_organization',$data);
    }

    public function tientityOrganizationPageInsert(Request $request)
    {
        $data = $request->all();
            $type = $data['organizationtype'];
            $casenoid = $data['organizationcasenoid'];
                        
            if($type == "Business")
            {
                
                EntityOrganization::insert([
                        'business_license_no' => $data['businesslicenseno'],
                        'business_location' => $data['businesslocation'],
                        'business_owner' => $data['businessowners'],
                        'business_license_issue_date' => $data['businesslicenseissuedate'],
                        'business_license_expiry_date' => $data['businesslicenseexpirydate'],
                        'business_activity' => $data['businessactivity'],
                        'organization_name' => $data['businessname'],
                        'contact_person' => $data['businesscontactperson'],
                        'phone_no' => $data['businessphone'],
                        'email' => $data['businessemail'],
                        'organization_type'  => $type,
                        'ti_id' => $casenoid,
                    ]);

                }
            
            if($type == "Government")
            {
            
                EntityOrganization::insert([
                        'parent_agency' => $data['govtparentagency'],
                        'organization_name' => $data['govtagencyname'],
                        'business_location' => $data['governmentlocation'],
                        'contact_person' => $data['govtcontactperson'],
                        'phone_no' => $data['govtcontactphone'],
                        'email' => $data['govtcontactemail'],
                        'organization_type'  => $type,
                        'ti_id' => $casenoid,
                        
                    ]);
                }

            if($type == "Corporation")
                {
            
                EntityOrganization::insert([
                        'organization_name' => $data['corpagencyname'],
                        'business_location' => $data['corplocation'],
                        'contact_person' => $data['corpcontactperson'],
                        'phone_no' => $data['corpcontactphone'],
                        'email' => $data['corpcontactemail'],
                        'organization_type'  => $type,
                        'ti_id' => $casenoid,
                        
                    ]);
                }

              Alert::success('Organization Added Successfully');
              return Redirect::back(); 
    }


    public function tientityOrganizationPageShow($id)
    {
        $id = Route::current()->parameter('id');
        $orgdetailsshow =  EntityOrganization::where('id', $id)->get();
        return view('tacktical.indi.showorganizationdetails',compact('orgdetailsshow'));
    }

    public function tientityOrganizationPagedelete($id)
    {
        $id = Route::current()->parameter('id');

            EntityOrganization::where('id', $id)->delete();

            Alert::success('Delete Successful');
                        return Redirect::back(); 
    }


    public function tientityassetPage($id)
    {
        $check = TackticalMember::where('user_id',auth()->user()->id)->where('tacktical_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')
          ->get();
        $data['id'] = $id;  
        $data['entityasset'] = DB::table('ti_case_assets')
        ->where('ti_id',$id)
        ->get();
        $data['check'] = TackticalInteligence::where('id',$id)->first();
        return view('tacktical.indi.entity_asset',$data);
    }

    public function tientityassetPageInsert(Request $request)
    {
        $data = $request->all();
            $type = $data['assettype'];
            $casenoid = $data['assetcasenoid'];
            $landcid = $data['landcid'];
            
            $assetplotno =$request->assetplotno;
            $vehicleowner =$request->vehicleowner;
            

            if($type == "Land"  && $assetplotno != '' )
            {
                
                DB::table('ti_case_assets')->insert([
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
                        'ti_id' => $casenoid,
                    ]);
            }
            
            if($type == "Vehicle"  && $vehicleowner != '' )
            {
            
                DB::table('ti_case_assets')->insert([
                        'cidno' => $data['assetvehiclecid'],
                        'vehicletype' => $data['vehicletype'],
                        'vehicle_registrationno' => $data['vehicleregistrationno'],
                        'vehicle_registrationdate' => $data['vehicleregistrationdate'],
                        'owner' => $data['vehicleowner'],
                        'asset_type'  => $type,
                        'ti_id' => $casenoid,
                        
                    ]);
            }

            if($type == "Building")
                {
            
                DB::table('ti_case_assets')->insert([
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
                        'ti_id' => $casenoid,
                        
                    ]);
                }

                if($type == "Bank")
                {
            
                DB::table('ti_case_assets')->insert([
                        'bank_name' => $data['bankname'],
                        'bank_accounttype' => $data['bankaccounttype'],
                        'owner' => $data['bankaccountowner'],
                        'bank_accountno' => $data['bankaccountno'],
                        'asset_type'  => $type,
                        'ti_id' => $casenoid,
                        
                    ]);
                }

                Alert::success('Successful');
                    return Redirect::back(); 
    }


    public function tientityassetPageView($id)
    {
        $id = Route::current()->parameter('id');
        $assetdtls =  DB::table('ti_case_assets')->where('id', $id)->get();
        return view('ip_details.showassetdetails',compact('assetdtls'));
    }

    public function tientityassetPagedelete($id)
    {
        $id = Route::current()->parameter('id');
        DB::table('ti_case_assets')->where('id', $id)->delete();
        Alert::success('Delete Successful');
        return Redirect::back(); 
    }


    public function commissionDirectives($id)
    {
        $data = [];
        $check = TackticalMember::where('user_id',auth()->user()->id)->where('tacktical_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['id'] = $id;
        $data['check'] = TackticalInteligence::where('id',$id)->first();
        $data['data'] = TackticalCommissionDirective::where('ti_id',$id)->get();
        return view('tacktical.indi.com_directive',$data);
    }

    public function commissionDirectivesUpdate(Request $request)
    {
        // return $request;
        // $check = TackticalCommissionDirective::where('ti_id',$request->id)->first();
        // if (@$check=='') {
            $new = new TackticalCommissionDirective;
            $new->ti_id = $request->id;
            $new->description = $request->description;
            $new->save();
        // }else{
        //     TackticalCommissionDirective::where('ti_id',$request->id)->update(['description'=>$request->description]);
        // }
        Alert::success('Data updated successfully');
        return Redirect::back(); 
    }

    public function commissionDirectivesDelete($id)
    {
        TackticalCommissionDirective::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return Redirect::back(); 
    }

    public function commissionDirectivesActivity(Request $request,$id)
    {
        $data = [];
        // $check = TackticalMember::where('user_id',auth()->user()->id)->where('tacktical_id',$id)->first();
        // if (@$check=="") {
        //     Alert::error('Unauthorized Access');
        //     return redirect()->route('dashboard');
        // }
        $data['id'] = $id;
        // if(@$request->com_id){
        //     $data['decision'] = TiCommissionActivity::where('ti_id',$id)->where('com_id',$request->com_id)->where('created_by',auth()->user()->id)->get();
        // }else{
            $data['decision'] = TiCommissionActivity::where('ti_id',$id)->where('created_by',auth()->user()->id)->get();
        // }
        
        $data['users'] = User::where('is_delete',0)->get();
        $data['directives'] = TackticalCommissionDirective::where('ti_id',$id)->get();
        $data['check'] = TackticalInteligence::where('id',$id)->first();
        return view('tacktical.indi.com_directive_activity',$data);
    }

    public function commissionDirectivesActivityInsert(Request $request)
    {
        $implode = implode(',',@$request->members);
        $new = new TiCommissionActivity;
        $new->ti_id = $request->ip_id;
        $new->activity = $request->activity;
        $new->start_date = $request->start_date;
        $new->end_date = $request->end_date;
        $new->created_on = $request->created_on;
        $new->members = $implode;
        $new->created_by = auth()->user()->id;


        $new->com_id = $request->com_id;
        $new->source_information = $request->source_information;
        $new->collection_method = $request->collection_method;
        $new->remarks = $request->remarks;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }

    public function commissionDirectivesActivityupdate(Request $request)
    {
        $implode = implode(',',@$request->members);
        $upd = [];
        $upd['activity'] = $request->activity;
        $upd['start_date'] = $request->start_date;
        $upd['end_date'] = $request->end_date;
        $upd['members'] = $implode;


        $upd['source_information'] = $request->source_information;
        $upd['collection_method'] = $request->collection_method;
        $upd['remarks'] = $request->remarks;
        TiCommissionActivity::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }

}
