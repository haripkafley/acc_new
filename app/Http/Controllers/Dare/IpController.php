<?php

namespace App\Http\Controllers\Dare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dare\Source;
use App\Models\Dare\IrForm;
use App\Models\Dare\IrSuspect;
use App\Models\Area;
use App\Models\Complaint\agencyModel;
use App\Models\Offence;
use App\Models\User;
use App\Models\Dare\IrTeamMember;
use App\Models\Dare\IntelProject;
use App\Models\Dare\IpComission;
use App\Models\Dare\ComissionMember;
use App\Models\Dare\IpStatus;
use App\Models\Dare\IpReport;
use App\Models\Dare\Idiary;
use App\Models\Dare\IntelPlan;
use App\Models\Dare\IpSirReport;
use App\Models\Dare\IntelEventPlan;
use App\Models\Dare\IpExhbit;
use App\Models\Dare\IpEntities;
use App\Models\Dare\IpEntityOrganization;
use App\Models\Dare\Iphypothesis;
use App\Models\Dare\IpRcModel;
use App\Models\Entity;
use App\Models\Dare\IpAsset;
use App\Models\Ti\TackticalInteligence;
use App\Models\Ti\RequestType;
use App\Models\Ti\RelationTi;
use App\Models\Ti\TackticalMember;
use Redirect;
use Alert;
use Session;
use DB;
use Illuminate\Support\Facades\Route;
class IpController extends Controller
{
    public function index()
    {
        $data = [];
        $ids = IpReport::pluck('ip_id')->toArray();
        $data['data'] = IrForm::whereNotIn('id',$ids)->where('is_delete','N')->where('status','UP')->get();
        Session::put('ip_back_url',url()->current());
        Session::put('assign_member_url',url()->current());
        return view('ip_details.ip_list',$data);
    }

    public function completed()
    {
        $data = [];
        $ids = IpReport::pluck('ip_id')->toArray();
        $data['data'] = IrForm::whereIn('id',$ids)->get();
        Session::put('ip_back_url',url()->current());
        return view('ip_details.ip_complete_list',$data);
    }

    public function details($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['suspects'] = IrSuspect::where('ir_id',$id)->get();
        $data['team'] = IrTeamMember::where('ir_id',$id)->get();
        $data['id'] = $id;
        Session::put('assign_member_url',url()->current());
        return view('ip_details.ip_details',$data);
    }

    public function commissionDetails($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['decision'] = IpComission::where('ip_id',$id)->get();
        $data['status'] = DB::table('commission_decision')->get();
        $data['id'] = $id;
        return view('ip_details.commission_details',$data);
    }

    public function commissionDetailsView($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = IpComission::where('id',$id)->first();
        $data['members'] = ComissionMember::where('ir_id',$id)->get();
        return view('ip_details.commission_view_details',$data);
    }

    public function commissionDetailsViewUpdateDecision(Request $request)
    {
        IpComission::where('id',$request->id)->update([
            'chief_decision'=>$request->chief_decision,
            'chief_remark'=>$request->chief_remark,

        ]);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function projectReport($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['decision'] = IpReport::where('ip_id',$id)->get();
        $data['id'] = $id;
        return view('ip_details.report_details',$data);
    }

    public function idiary($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['decision'] = Idiary::where('ip_id',$id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['plan'] = IntelPlan::where('ip_id',$id)->where('status',2)->get();
        $data['sir'] = IpSirReport::where('ip_id',$id)->get();
        return view('ip_details.idiary_details',$data);
    }

    public function plan(Request $request,$id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        if($request->hypo_id){
            $data['plan'] = IntelPlan::where('ip_id',$id)->orderBy('status','asc')->where('hypo_id',$request->hypo_id)->get();
        }else{
            $data['plan'] = IntelPlan::where('ip_id',$id)->orderBy('status','asc')->get();
        }
        $data['source'] = Source::where('status','A')->get();
        $data['users'] = User::where('is_delete',0)->get();
        $data['status'] = IpStatus::get();
        $data['id'] = $id;
        $data['hypo'] = Iphypothesis::where('ip_id',$id)->get();
        return view('ip_details.intel_plan_details',$data);
    }

    public function sirPlan($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['sir'] = IpSirReport::where('ip_id',$id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        return view('ip_details.sir_plan_details',$data);
    }

    public function event($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['event'] = IntelEventPlan::where('ip_id',$id)->orderBy('event_date','desc')->orderBy('event_time','desc')->get();
        $data['id'] = $id;
        return view('ip_details.event_plan_details',$data);
    }

    public function exhibit($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['exhibit'] = IpExhbit::where('ip_id',$id)->get();
        $data['id'] = $id;
        return view('ip_details.exhibit_details',$data);
    }

    public function entities($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['entityperson'] = IpEntities::where('ip_id',$id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')->get();
        $data['prev_suspect'] = IrSuspect::where('ir_id',$id)->get();
        return view('ip_details.intel_entities_details',$data);
    }

    public function entitiesOrganization($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['entityorganization'] = DB::table('ip_organizations')
          ->where('ip_id', $id)
          ->get();
        $data['parentagency'] = DB::table('tbl_parentagencies_lookup')->get();
        $data['agencyname'] = DB::table('tbl_agencynames_lookup')->get();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')->get();
        return view('ip_details.intel_organization_details',$data);
    }

    public function entitiesasset($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')
          ->get();
        $data['id'] = $id;  
        $data['entityasset'] = DB::table('ip_case_assets')
        ->where('ip_id',$id)
        ->get();
        return view('ip_details.intel_asset_details',$data);
    }

    public function hypothesis($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['plan'] = Iphypothesis::where('ip_id',$id)->get();
        $data['id'] = $id;
        return view('ip_details.hypothesis_details',$data);
    }

    public function commissionRequest()
    {
        $data = [];
        $data['decision'] = IpComission::orderBy('id','desc')->where('chief_decision','A')->get();
        return view('ip_details.commission_request',$data);
    }

    public function commissionRequestDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = IpComission::where('id',$id)->first();
        $data['members'] = ComissionMember::where('ir_id',$id)->get();
        $data['ir_details'] = IrForm::where('id',$data['data']->ip_id)->first();
        return view('ip_details.commission_request_details',$data);
    }

    public function insertHeadApproval(Request $request)
    {
        IpComission::where('id',$request->id)->update(['head_decision'=>$request->head_decision,'head_remark'=>$request->head_remark]);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function individualCommission()
    {
        $data = [];
        $data['data'] = ComissionMember::whereHas('commission_details',function($query){
            $query->where('head_decision','A');
        })->where('user_id',auth()->user()->id)->get();
        return view('ip_details.commission_request_indi_member',$data);
    }

    public function individualCommissionViewDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['memberDetails'] = ComissionMember::where('id',$id)->first();
        $data['data'] = IpComission::where('id',$data['memberDetails']->ir_id)->first();
        $data['ir_details'] = IrForm::where('id',$data['data']->ip_id)->first();
        return view('ip_details.commission_request_indi_member_details',$data);
    }

    public function updateDecision(Request $request)
    {
        ComissionMember::where('id',$request->id)->update(['status'=>$request->status,'remarks'=>$request->remarks]);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }

    public function tackticalRequest($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['tacktical'] = TackticalInteligence::where('ir_id',$id)->where('type_format','IR')->get();
        $data['id'] = $id;
        $data['user'] = User::where('is_delete',0)->get();
        $data['request'] = RequestType::get();
        $data['relation'] = RelationTi::get();
        $data['offence'] = Offence::get();
        return view('ip_details.ti_request_details',$data);
    }

    public function iprcDecisionChief($id)
    {
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['id'] = $id;
        $data['user'] = User::where('is_delete',0)->get();
        $data['decision'] = IpRcModel::where('ip_id',$id)->first();
        return view('ip_details.iprc_decision_chief',$data);
    }
}
