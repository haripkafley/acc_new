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
use App\Models\User;
use App\Models\Complaint\agencyModel;
use App\Models\Dare\IpStatus;
use App\Models\Ti\EntityPerson;
use App\Models\Ti\EntityOrganization;
use App\Models\Entity;
use App\Models\Ti\EntityAsset;
use App\Models\Dare\Idiary;
use App\Models\Dare\IntelPlan;
use App\Models\Dare\IrTeamMember;
use App\Models\Dare\IrForm;
use App\Models\Ti\TackticalCommissionDirective;
use App\Models\Ti\TiCommissionActivity;
use App\Models\Ti\SirNewReport;
use App\Models\Complaint\InformationGatheringComplaint;
use Session;
use Alert;
use Redirect;
use DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;

class TackticalHead extends Controller
{
    public function details($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = TackticalInteligence::where('id',$id)->first();
        $data['members'] = TackticalMember::where('tacktical_id',$id)->get();
        Session::put('ti_cheif_member',url()->current());
        return view('tacktical.head.details',$data); 
    }

    public function siOwnPage($id)
    {
        $data = [];
        $data['users'] = User::where('is_delete',0)->get();
        $data['id'] = $id;
        $data['sir'] = SirNewReport::where('ti_id',$id)->where('created_by',auth()->user()->id)->get();
        $data['agency'] = agencyModel::where('isDelete',0)->get();
        $data['status'] = IpStatus::get();
        $data['source'] = Source::where('status','A')->get();
        return view('tacktical.head.source',$data);
    }


    public function siIndiVidualPage($id)
    {
        $data = [];
        $data['users'] = User::where('is_delete',0)->get();
        $data['id'] = $id;
        $data['data'] = SirNewReport::where('ti_id',$id)->get();
        $data['agency'] = agencyModel::where('isDelete',0)->get();
        $data['status'] = IpStatus::get();
        return view('tacktical.head.source_indi',$data);
    }


    public function logSheet($id)
    {
        $data = [];
        $data['data'] = TiLogsheet::where('ti_id',$id)->get();
        $data['users'] = User::where('is_delete',0)->get();
        $data['id'] = $id;
        return view('tacktical.head.log_sheet',$data);
    }

    public function diaryOwnPage()
    {
        $diary = Diary::where('created_by',auth()->user()->id)->get();
        $idiary = Idiary::where('created_by',auth()->user()->id)->get();
        $plan = IntelPlan::where('created_by',auth()->user()->id)->get();
        $mergedData = (new Collection)
            ->merge($diary)
            ->merge($idiary)
            ->merge($plan);

        // Optionally sort the merged data if needed
        $sortedMergedData = $mergedData->sortByDesc('created_at')->values();
        $data['data'] = $sortedMergedData;
        $assign_ti_ids = TackticalMember::pluck('tacktical_id')->toArray();
        $assign_ir_ids = IrTeamMember::pluck('ir_id')->toArray();


        $data['tiList'] = TackticalInteligence::whereIn('id',$assign_ti_ids)->get();
        $data['irList'] = IrForm::whereIn('id',$assign_ir_ids)->get();
        return view('tacktical.head.diary_own',$data);
    }

    public function diaryindividualPage()
    {
        $diary = Diary::where('created_by','!=',auth()->user()->id)->get();
        $idiary = Idiary::where('created_by','!=',auth()->user()->id)->get();
        $plan = IntelPlan::where('created_by','!=',auth()->user()->id)->get();
        $mergedData = (new Collection)
            ->merge($diary)
            ->merge($idiary)
            ->merge($plan);

        // Optionally sort the merged data if needed
        $sortedMergedData = $mergedData->sortByDesc('created_at')->values();
        $data['data'] = $sortedMergedData;
        return view('tacktical.head.diary_indi',$data);
    }

    public function siplanIndividual($id)
    {
        $data = [];
        $data['sir'] = TiSirReport::where('ti_id',$id)->where('created_by','!=',auth()->user()->id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        return view('tacktical.head.si_plan_indi',$data);
    }

    public function reportIndividual($id)
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('id',$id)->first();
        $data['id'] = $id;
        return view('tacktical.head.report_indi',$data);
    }

    public function reviewChiefDecision(Request $request)
    {
        $check = TackticalInteligence::where('id',$request->id)->first();
        if (@$check->tacktical_from=="COM" && $request->report_status=="A") {

        $checking_tacktical = InformationGatheringComplaint::where('tacktical_id',$request->id)->first();
             if ($checking_tacktical=="") {
                 $new = new InformationGatheringComplaint;
                 $new->complaint_id = $check->complaint_id;
                 $new->evidence_allegation = $check->offence_allegation;
                 $new->created_by = auth()->user()->id;
                 $new->tacktical_id = $request->id;
                 $new->save();
             }
        }
        $upd = [];
        $upd['report_status'] = $request->report_status;
        $upd['report_remarks'] = $request->report_remarks;
        $upd['review_date'] = $request->review_date;
        $upd['review_by'] = auth()->user()->id;
        TackticalInteligence::where('id',$request->id)->update($upd);
        Alert::success('Decision made successfully');
        return redirect()->back();
    }

    public function exhibitIndividual($id)
    {
        $data = [];
        $data['exhibit'] = TiExhibit::where('ti_id',$id)->get();
        $data['id'] = $id;
        return view('tacktical.head.exhibit_indi',$data);
    }

    public function entityIndividual($id)
    {
        $data = [];
        $data['entityperson'] = EntityPerson::where('ti_id',$id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')->get();
        return view('tacktical.head.entity_person_details',$data);
    }

    public function entityorganisationIndividual($id)
    {
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
        return view('tacktical.head.entity_organization_details',$data);
    }

    public function entityassetIndividual($id)
    {
        $data = [];
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')
          ->get();
        $data['id'] = $id;  
        $data['entityasset'] = DB::table('ti_case_assets')
        ->where('ti_id',$id)
        ->get();
        return view('tacktical.head.entity_asset_details',$data);
    }

    public function commissionDirective($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = TackticalCommissionDirective::where('ti_id',$id)->get();
        $data['users'] = User::where('is_delete',0)->get();
        return view('tacktical.head.com_directive',$data);
    }

    public function commissionDirectivesActivity(Request $request,$id)
    {
        $data = [];
        $data['id'] = $id;
        if(@$request->com_id){
            $data['decision'] = TiCommissionActivity::where('ti_id',$id)->where('com_id',$request->com_id)->get();
        }else{
            $data['decision'] = TiCommissionActivity::where('ti_id',$id)->get();
        }
        $data['users'] = User::where('is_delete',0)->get();
        $data['directives'] = TackticalCommissionDirective::where('ti_id',$id)->get();
        return view('tacktical.head.com_directive_activity',$data);
    }

    public function commissionDirectivesActivityUpdateDecision(Request $request)
    {
        $upd = [];
        $upd['chief_decision'] = $request->chief_decision;
        $upd['chief_remark'] = $request->chief_remark;
        TiCommissionActivity::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }
}
