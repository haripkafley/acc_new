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
use App\Models\Dare\IpAsset;
use App\Models\Dare\Iphypothesis;
use App\Models\Dare\IpRcModel;
use App\Models\Ti\TackticalInteligence;
use App\Models\Ti\RequestType;
use App\Models\Ti\RelationTi;
use App\Models\Dare\IpFinalReport;
use App\Models\Dare\HypoReport;
use App\Models\Dare\ExhibitReport;
use App\Models\Entity;
use Redirect;
use Alert;
use DB;
use Illuminate\Support\Facades\Route;
use App\Models\CaseAsset;
use Session;
use PDF;
class GetIrAssignmentController extends Controller
{
    public function index()
    {
        $data = [];
        $ids = IpReport::pluck('ip_id')->toArray();
        $data['data'] = IrTeamMember::whereNotIn('ir_id',$ids)->whereIn('coi_status',['AA','N'])->where('user_id',auth()->user()->id)->get();
        Session::put('ip_back_url_indi',url()->current());
        return view('information_report.index_dashboard',$data); 
    }

    public function completed()
    {
        $ids = IpReport::pluck('ip_id')->toArray();
        $data['data'] = IrTeamMember::whereIn('ir_id',$ids)->whereIn('coi_status',['AA','N'])->where('user_id',auth()->user()->id)->get();
        Session::put('ip_back_url_indi',url()->current());
        return view('information_report.index_dashboard_complete',$data); 
    }

    public function coi($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = IrTeamMember::where('user_id',auth()->user()->id)->where('id',$id)->first();
        return view('information_report.coi',$data); 
    }

    public function coiDesicion(Request $request)
    {
        $upd = [];
        $upd['coi_status'] = $request->evaluation;
        if(@$request->evaluation=="Y")
        {
            $upd['describe_coi'] = $request->describe;
        }else{
            $upd['describe_coi'] = '';
        }

        IrTeamMember::where('id',$request->id)->update($upd);

        Alert::success('Decision updated successfully');
        return redirect()->route('member.get.information.report.assignment');

    }


    public function details($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        // return $id;
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['id'] = $id;
        $data['suspects'] = IrSuspect::where('ir_id',$id)->get();
        return view('ip_details.details',$data);
    }


    



    public function commissionDecisionPage($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['decision'] = IpComission::where('ip_id',$id)->where('created_by',auth()->user()->id)->get();
        $data['status'] = DB::table('commission_decision')->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['decision_iprc'] = IpRcModel::where('ip_id',$id)->first();
        return view('ip_details.commission',$data);
    }


    public function commissionDecisionPageInsert(Request $request)
    {

        $new = new IpComission;
        $new->ip_id = $request->ip_id;
        $new->activity = $request->activity;
        $new->activity_date = $request->activity_date;
        $new->start_time = $request->start_time;
        $new->end_time = $request->end_time;
        $new->decision = $request->decision;
        $new->remarks = $request->remarks;
        $new->created_on_date = date('Y-m-d');
        $new->created_by = auth()->user()->id;
        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ir/',$filename);
                    $new->attachment = $filename;
        }
        $new->save();
        if(count(@$request->members)>0)
        {
            foreach(@$request->members as $val)
            {
                $member = new ComissionMember;
                $member->ir_id = $new->id;
                $member->user_id = $val;
                $member->save();
            }
        }
        
        Alert::success('Decision inserted successfully');
        return redirect()->back();
    }

    public function commissionDecisionPageupdate(Request $request)
    {
        $upd = [];
        $upd['activity'] = $request->activity;
        $upd['activity_date'] = $request->activity_date;
        $upd['start_time'] = $request->start_time;
        $upd['end_time'] = $request->end_time;
        $upd['decision'] = $request->decision;
        $upd['remarks'] = $request->remarks;
        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ir/',$filename);
                    $upd['attachment'] = $filename;
        }

        IpComission::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->back();
    }


    public function commissionDecisionPagedelete($id)
    {
        $check = IpComission::where('id',$id)->first();
        if(@$check->created_by==auth()->user()->id)
        {
            IpComission::where('id',$id)->delete();
            Alert::success('Decision deleted successfully');
            return redirect()->back();
        }else{
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
    }

    public function memberPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = ComissionMember::where('ir_id',$id)->get();
        $data['comdetails'] = IpComission::where('id',$id)->first();
        $data['users'] = User::where('is_delete',0)->get();
        return view('ip_details.com_member',$data);
    }

    public function memberPageDelete($id)
    {
        ComissionMember::where('id',$id)->delete();
        Alert::success('Member deleted successfully');
        return redirect()->back();
    }

    public function memberPageInsert(Request $request)
    {
        $member = new ComissionMember;
        $member->ir_id = $request->id;
        $member->user_id = $request->member;
        $member->save();
        Alert::success('Member added successfully');
        return redirect()->back();
    }

    public function reportPage($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['decision'] = IpReport::where('ip_id',$id)->where('created_by',auth()->user()->id)->get();
        $data['id'] = $id;
        return view('ip_details.report',$data);
    }

    public function prepareReport($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = IrForm::where('id',$id)->first();
        $data['suspects'] = IrSuspect::where('ir_id',$id)->where('person_type','S')->get();
        $data['witness'] = IrSuspect::where('ir_id',$id)->where('person_type','W')->get();
        $data['hypo'] = Iphypothesis::where('ip_id',$id)->get();
        $data['commission_directive'] = IpComission::where('ip_id',$id)->select('remarks')->get();
        $data['report'] = IpFinalReport::where('ir_id',$id)->first();
        $data['suspect_number'] = IrSuspect::where('ir_id',$id)->where('person_type','S')->count();
        $data['witness_number'] = IrSuspect::where('ir_id',$id)->where('person_type','W')->count();
        $data['selected_hypo'] = HypoReport::where('ip_id',$id)->pluck('hypo_id')->toArray();
        $data['selected_exhibit'] = ExhibitReport::where('ip_id',$id)->pluck('exhi_id')->toArray();
        $data['exhibit'] = IpExhbit::where('ip_id',$id)->get();
        return view('ip_details.prepare_report',$data);
    }

    public function updateHypothesis(Request $request)
    {
        HypoReport::where('ip_id',$request->id)->delete();
        if (count(@$request->check)>0) {
            
            foreach(@$request->check as $value)
            {
                $new = new HypoReport;
                $new->ip_id = $request->id;
                $new->hypo_id = $value;
                $new->save();
            }
        }
        Alert::success('Data Updated successfully');
        return redirect()->back();
    }

    public function updateExhibit(Request $request)
    {
        ExhibitReport::where('ip_id',$request->id)->delete();
        if (count(@$request->addmore)>0) {
            
            foreach(@$request->addmore as $value)
            {
                $new = new ExhibitReport;
                $new->ip_id = $request->id;
                $new->exhi_id = $value['check'];
                $new->text = $value['note'];
                $new->save();
            }
        }
        Alert::success('Data Updated successfully');
        return redirect()->back();
    }

    public function prepareReportUpdate(Request $request)
    {
        $check = IpFinalReport::where('ir_id',$request->id)->first();
        
        if(@$check=="")
        {
            $new = new IpFinalReport;
            $new->background = $request->background;
            $new->what_we_know = $request->what_we_know;
            $new->what_dont_know = $request->what_dont_know;
            $new->what_we_think = $request->what_we_think;
            $new->recommendation = $request->recommendation;
            $new->ir_id = $request->id;
            $new->report_date = date('Y-m-d');
            $new->save();

        }else{
            $upd = [];
            $upd['background'] = $request->background;
            $upd['what_we_know'] = $request->what_we_know;
            $upd['what_dont_know'] = $request->what_dont_know;
            $upd['what_we_think'] = $request->what_we_think;
            $upd['recommendation'] = $request->recommendation;
            $upd['report_date'] = date('Y-m-d');
            IpFinalReport::where('ir_id',$request->id)->update($upd);
        }
        Alert::success('Report submitted successfully');
        return redirect()->back();
    }

    public function prepareReportView($id)
    {
        $selected_hypo = HypoReport::where('ip_id',$id)->pluck('hypo_id')->toArray();
        $selected_exhibit = ExhibitReport::where('ip_id',$id)->pluck('exhi_id')->toArray();


        $data = [];
        $data['id'] = $id;
        $data['data'] = IrForm::where('id',$id)->first();
        $data['suspects'] = IrSuspect::where('ir_id',$id)->where('person_type','S')->get();
        $data['witness'] = IrSuspect::where('ir_id',$id)->where('person_type','W')->get();
        $data['hypo'] = Iphypothesis::where('ip_id',$id)->whereIn('id',$selected_hypo)->get();
        $data['commission_directive'] = IpComission::where('ip_id',$id)->select('remarks','head_remark')->get();
        $data['report'] = IpFinalReport::where('ir_id',$id)->first();
        $data['suspect_number'] = IrSuspect::where('ir_id',$id)->where('person_type','S')->count();
        $data['witness_number'] = IrSuspect::where('ir_id',$id)->where('person_type','W')->count();
        $data['exhibit'] = IpExhbit::where('ip_id',$id)->whereIn('id',$selected_exhibit)->get();

        return view('ip_details.view_report',$data);
    }

    public function pdfReport($id)
    {
        ini_set('max_execution_time', 300);
        $selected_hypo = HypoReport::where('ip_id',$id)->pluck('hypo_id')->toArray();
        $selected_exhibit = ExhibitReport::where('ip_id',$id)->pluck('exhi_id')->toArray();
        $data = [];
        $data['id'] = $id;
        $data['data'] = IrForm::where('id',$id)->first();
        $data['suspects'] = IrSuspect::where('ir_id',$id)->where('person_type','S')->get();
        $data['witness'] = IrSuspect::where('ir_id',$id)->where('person_type','W')->get();
        $data['hypo'] = Iphypothesis::where('ip_id',$id)->whereIn('id',$selected_hypo)->get();
        $data['commission_directive'] = IpComission::where('ip_id',$id)->select('remarks','head_remark')->get();
        $data['report'] = IpFinalReport::where('ir_id',$id)->first();
        $data['suspect_number'] = IrSuspect::where('ir_id',$id)->where('person_type','S')->count();
        $data['witness_number'] = IrSuspect::where('ir_id',$id)->where('person_type','W')->count();
        $data['exhibit'] = IpExhbit::where('ip_id',$id)->whereIn('id',$selected_exhibit)->get();
        /*return view('ip_details.pdf',$data);*/
        $pdf = PDF::loadView('ip_details.pdf',$data);
        // return $pdf->stream('ip_details'.'.pdf', array("Attachment" => false));
        // $pdf = PDF::loadView('ip_details.pdf',$data)->setOptions(['defaultFont' => 'sans-serif']);;
        return $pdf->download($data['data']->id.'.pdf');
    }

    public function reportPageInsert(Request $request)
    {
        $new = new IpReport;
        $new->ip_id = $request->ip_id;
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
        Alert::success('Report inserted successfully');
        return redirect()->back();
    }

    public function reportPageupdate(Request $request)
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

        IpReport::where('id',$request->id)->update($upd);
        Alert::success('Report updated successfully');
        return redirect()->back();
    }


    public function reportPagedelete($id)
    {
        IpReport::where('id',$id)->delete();
        Alert::success('Report deleted successfully');
        return redirect()->back();
    }


    public function idiaryPage($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['decision'] = Idiary::where('ip_id',$id)->where('created_by',auth()->user()->id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['plan'] = IntelPlan::where('ip_id',$id)->where('created_by',auth()->user()->id)->where('status',2)->get();
        $data['sir'] = IpSirReport::where('ip_id',$id)->where('created_by',auth()->user()->id)->get();
        // return $data['users'];
        return view('ip_details.idiary',$data);
    }

    public function idiaryPageInsert(Request $request)
    {
        $implode = implode(',',@$request->members);
        $new = new Idiary;
        $new->ip_id = $request->ip_id;
        $new->activity = $request->activity;
        $new->start_date = $request->start_date;
        $new->end_date = $request->end_date;
        $new->created_on = $request->created_on;
        $new->members = $implode;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function idiaryPageupdate(Request $request)
    {
        $implode = implode(',',@$request->members);
        $upd = [];
        $upd['activity'] = $request->activity;
        $upd['start_date'] = $request->start_date;
        $upd['end_date'] = $request->end_date;
        $upd['members'] = $implode;
        Idiary::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function idiaryPagedelete($id)
    {
        Idiary::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function intelPlan(Request $request,$id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        // if (@$check=="") {
        //     Alert::error('Unauthorized Access');
        //     return redirect()->route('dashboard');
        // }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        if($request->hypo_id){
            $data['plan'] = IntelPlan::where('ip_id',$id)->where('created_by',auth()->user()->id)->orderBy('status','asc')->where('hypo_id',$request->hypo_id)->get();
        }else{
            $data['plan'] = IntelPlan::where('ip_id',$id)->where('created_by',auth()->user()->id)->orderBy('status','asc')->get();
        }
        
        $data['source'] = Source::where('status','A')->get();
        $data['users'] = User::where('is_delete',0)->get();
        $data['status'] = IpStatus::get();
        $data['id'] = $id;
        $data['hypo'] = Iphypothesis::where('ip_id',$id)->where('created_by',auth()->user()->id)->get();
        return view('ip_details.intel_plan',$data);
    }

    public function intelPlanInsert(Request $request)
    {
        
        $implode = implode(',',@$request->members);
        $new = new IntelPlan;
        $new->hypo_id = $request->hypo_id;
        $new->ip_id = $request->ip_id;
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
    }


    public function intelPlanupdate(Request $request)
    {
        $implode = implode(',',@$request->members);
        $upd = [];
        $upd['task'] = $request->task;
        $upd['start_date'] = $request->start_date;
        $upd['end_date'] = $request->end_date;

        $upd['collected_from'] = $request->collected_from;
        // $upd['source'] = $request->source;
        $upd['status'] = $request->status;


        $upd['officer_assign_id'] = $implode;
        IntelPlan::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }


    public function intelPlandelete($id)
    {
        IntelPlan::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function tackticalRequest($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['tacktical'] = TackticalInteligence::where('created_by',auth()->user()->id)->where('ir_id',$id)->where('type_format','IR')->get();
        $data['id'] = $id;
        $data['user'] = User::where('is_delete',0)->get();
        $data['request'] = RequestType::get();
        $data['relation'] = RelationTi::get();
        $data['ir_form'] = IrForm::where('id',$id)->first();
        $data['offence'] = Offence::get();
        return view('ip_details.ti_request',$data);
    }

    public function tackticalRequestInsert(Request $request)
    {

        $new = new TackticalInteligence;
        $new->created_by = auth()->user()->id;
        $new->type_ti = $request->type_ti;
        $new->request_type = $request->request_type;
        $new->relation_to = $request->relation_to;
        $new->requesting_officer = auth()->user()->id;
        $new->request_date = $request->request_date;
        $new->start_date = $request->start_date;
        $new->end_date = $request->end_date;
        $new->suspect_details = $request->suspect_details;
        $new->reason = $request->reason;
        $new->type_format = 'IR';
        $new->ir_id = $request->ir_id;

        $new->arrest_type = $request->arrest_type;
        $new->corruption = $request->corruption;
        $new->focal_name = $request->focal_name;
        $new->focal_dept = $request->focal_dept;
        $new->focal_designation = $request->focal_designation;

        if (@$request->hasFile('arrest_attachement')) {
                    $file = $request->arrest_attachement;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ti/',$filename);
                    $new->arrest_attachement = $filename;
        }

        if (@$request->request_type==1) {
            $new->activity_nature = $request->activity_nature;
            $new->activity_location = $request->activity_location;
            $new->activity_other = $request->activity_other;
        }

        $new->save();
        Alert::success('You\'ve Successfully Added A Request ');
        return redirect()->back();
    }

    public function tackticalRequestupdate(Request $request)
    {
        $upd = [];
        $upd['type_ti'] = $request->type_ti;
        $upd['request_type'] = $request->request_type;
        $upd['relation_to'] = $request->relation_to;
        $upd['requesting_officer'] = auth()->user()->id;
        $upd['request_date'] = $request->request_date;
        $upd['start_date'] = $request->start_date;
        $upd['end_date'] = $request->end_date;
        $upd['suspect_details'] = $request->suspect_details;
        $upd['reason'] = $request->reason;

        $upd['arrest_type'] = $request->arrest_type;
        $upd['corruption'] = $request->corruption;
        $upd['focal_name'] = $request->focal_name;
        $upd['focal_dept'] = $request->focal_dept;
        $upd['focal_designation'] = $request->focal_designation;


        if (@$request->request_type==1) {
            $upd['activity_nature'] = $request->activity_nature;
            $upd['activity_location'] = $request->activity_location;
            $upd['activity_other'] = $request->activity_other;
        }else{
            $upd['activity_nature'] = null;
            $upd['activity_location'] = null;
            $upd['activity_other'] = null;
        }


        if (@$request->hasFile('arrest_attachement')) {
                    $file = $request->arrest_attachement;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ti/',$filename);
                    $upd['arrest_attachement'] = $filename;
        }

        
        TackticalInteligence::where('id',$request->id)->update($upd);
        Alert::success('You\'ve Successfully Updated A Request ');
        return redirect()->back();
    }

    public function tackticalRequestdelete($id)
    {
        TackticalInteligence::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Request ');
        return redirect()->back();
    }

    public function iprcDecisionPage($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['id'] = $id;
        $data['user'] = User::where('is_delete',0)->get();
        $data['ir_form'] = IrForm::where('id',$id)->first();
        $data['decision'] = IpRcModel::where('ip_id',$id)->first();
        return view('ip_details.iprc_decision',$data);
    }

    public function iprcDecisionUpdate(Request $request)
    {
        $check = IpRcModel::where('ip_id',$request->ip_id)->first();
        if (@$check=="") {
           $new = new IpRcModel;
           $new->ip_id = $request->ip_id;
           $new->decision = $request->decision;
           $new->information = $request->information;
           $new->created_by = auth()->user()->id;
           $new->save();
        }else{
            IpRcModel::where('ip_id',$request->ip_id)->update([
                'decision'=>$request->decision,
                'information'=>$request->information,
                'created_by'=>auth()->user()->id,
            ]);
        }
        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function intelHypothesis($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['plan'] = Iphypothesis::where('ip_id',$id)->where('created_by',auth()->user()->id)->get();
        $hypo_number = Iphypothesis::where('ip_id',$id)->orderBy('id','desc')->first();
        if($hypo_number=="")
        {
            $data['hypo_number'] = 1;
        }else{
            $data['hypo_number'] = $hypo_number->hypo_number+1;
        }
        $data['id'] = $id;
        return view('ip_details.hypothesis',$data);
    }


    public function intelHypothesisInsert(Request $request)
    {
        $hypo_number = Iphypothesis::where('ip_id',$request->ip_id)->orderBy('id','desc')->first();
        if($hypo_number=="")
        {
            $data['hypo_number'] = 1;
        }else{
            $data['hypo_number'] = $hypo_number->hypo_number+1;
        }

        $new = new Iphypothesis;
        $new->ip_id = $request->ip_id;
        $new->hypo_sl_number = 'Hypothesis'.''.$data['hypo_number'];
        $new->name = 'Hypothesis'.''.$data['hypo_number'];
        $new->hypo_number = $data['hypo_number'];
        $new->description = $request->description;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }

    public function intelHypothesisupdate(Request $request)
    {
        $upd = [];
        // $upd['name'] = $request->name;
        $upd['description'] = $request->description;
        Iphypothesis::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function intelHypothesisdelete($id)
    {
        Iphypothesis::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function sirPlan($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['sir'] = IpSirReport::where('ip_id',$id)->where('created_by',auth()->user()->id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['source'] = Source::where('status','A')->get();
        return view('ip_details.sir_plan',$data);
    }

    public function sirPlanInsert(Request $request)
    {
        $implode = implode(',',@$request->members);
        $new = new IpSirReport;
        $new->ip_id = $request->ip_id;
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
        IpSirReport::where('id',$new->id)->update(['sir_no'=>$sir_no]);
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }

    public function sirPlandelete($id)
    {
        IpSirReport::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function sirPlanupdate(Request $request)
    {
        $implode = implode(',',@$request->members);
        $upd = [];
        // $upd['source_code'] = $request->source_code;
        $upd['received_date'] = $request->received_date;
        $upd['start_time'] = $request->start_time;

        $upd['end_time'] = $request->end_time;
        $upd['details'] = $request->details;
        $upd['officers'] = $implode;
        IpSirReport::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }


    public function intelEvent($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['event'] = IntelEventPlan::where('ip_id',$id)->orderBy('event_date','desc')->orderBy('event_time','desc')->where('created_by',auth()->user()->id)->get();
        $data['id'] = $id;
        return view('ip_details.intel_event',$data);
    }


    public function intelEventInsert(Request $request)
    {
        $new = new IntelEventPlan;
        $new->ip_id = $request->ip_id;
        $new->name = $request->name;
        $new->event_date = $request->event_date;
        $new->event_time = $request->event_time;
        $new->description = $request->description;
        $new->created_by = auth()->user()->id;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }

    public function intelEventupdate(Request $request)
    {
        $upd = [];
        $upd['name'] = $request->name;
        $upd['event_date'] = $request->event_date;
        $upd['event_time'] = $request->event_time;
        $upd['description'] = $request->description;
        IntelEventPlan::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function intelEventdelete($id)
    {
        IntelEventPlan::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function exhibitPlan($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['exhibit'] = IpExhbit::where('ip_id',$id)->where('created_by',auth()->user()->id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        return view('ip_details.intel_exhibit',$data);
    }

    public function exhibitPlanInsert(Request $request)
    {
        $implode = implode(',',@$request->members);

        $new = new IpExhbit;
        $new->ip_id = $request->ip_id;
        $new->name = $request->name;
        $new->created_on = $request->created_on;
        $new->code = $request->code;
        // $new->created_method = $request->created_method;
        $new->collected_by = $implode;
        // $new->collected_by = $request->collected_by;
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

    public function exhibitPlanupdate(Request $request)
    {
        // return $request;
        $implode = implode(',',@$request->members);
        $upd = [];
        $upd['name'] = $request->name;
        $upd['created_on'] = $request->created_on;
        $upd['code'] = $request->code;
        // $upd['created_method'] = $request->created_method;
        $upd['collected_by'] = $implode;
        $upd['description'] = $request->description;
        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ir/',$filename);
                    $upd['attachment'] = $filename;
        }
        IpExhbit::where('id',$request->id)->update($upd);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function exhibitPlandelete($id)
    {
        IpExhbit::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function entitesPerson($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['entityperson'] = IpEntities::where('ip_id',$id)->where('created_by',auth()->user()->id)->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')->get();
        $data['prev_suspect'] = IrSuspect::where('ir_id',$id)->get();
        return view('ip_details.intel_entities',$data);
    }

    public function checkCIDaddentity($cid, $id)
    {
       
        $data = IpEntities::where('identification_no',$cid)->where('ip_id',$id)->get();
        return response()->json(['data' => $data]);
    }

    public function savepersonDetails(Request $request)
    {
        DB::beginTransaction();

        try 
            {
            $data = $request->all();
            $type = $data['persontype'];
            $ip_id = $data['personcasenoidadd'];
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
                
                IpEntities::insert([
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
                        'ip_id' => $ip_id,
                        'entitytype' => $data['bhutanesepartytype'],
                        'involvement' => $data['bhutaneseinvolvement'],
                        'photo_name' => $file_name_bhutanese, 
                        'photo_extension' => $file_extention_bhutanese,
                        'created_by' =>auth()->user()->id,
                    ]);

                $entities = IpEntities::latest('id')->first();
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
            
                IpEntities::insert([
                        'name' => $data['nonbhutanesename'],
                        'gender' => $data['nonbhutanesegender'],
                        'dateofbirth' => $data['nonbhutanesedob'],
                        'permanentaddress' => $data['nonbhutanesepermanentaddress'],
                        'identification_no' => $data['nonbhutanesepermit'],
                        'address' => $data['nonbhutaneseaddress'],
                        'contactno' => $data['nonbhutanesephone'],
                        'email' => $data['nonbhutaneseemail'],
                        'type'  => $type,
                        'ip_id' => $ip_id,
                        'entitytype' => $data['nonbhutanesepartytype'],
                        'involvement' => $data['nonbhutaneseinvolvement'],
                        'photo_name' => $file_name_nonbhutanese, 
                        'photo_extension' => $file_extention_nonbhutanese,
                        'created_by' =>auth()->user()->id,
                    ]);

                $entities = IpEntities::latest('id')->first();
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

    public function viewentitydetailsforedit(Request $request)
    {
        $id = Route::current()->parameter('id');
        $entitydetailsshow =  IpEntities::where('id',$id)->get();
        
        return view('ip_details.showentitiesdetailsedit',compact('entitydetailsshow'));
    }

    public function searchentitydetails(Request $request)
    {        
        $id = Route::current()->parameter('id');
        $entitydetailsshow =  IpEntities::where('id', $id)->get();
        $entityid = IpEntities::where('id', $id)->value('identification_no');
        $casenoid = IpEntities::where('id', $id)->value('ip_id');
        $othercasesdtls = IpEntities::where('identification_no', $entityid)->where('ip_id','!=', $casenoid)->get();
        
        return view('ip_details.showentitiesdetails',compact('entitydetailsshow', 'othercasesdtls'));
    }

    public function deletePerson($id)
    {
        $id = Route::current()->parameter('id');
        IpEntities::where('id', $id)->delete();
        Alert::success('Delete Successful');
        return redirect()->back();
    }

    public function entitesOrganization($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['entityorganization'] = DB::table('ip_organizations')
          ->where('ip_id', $id)->where('created_by',auth()->user()->id)
          ->get();
        $data['parentagency'] = DB::table('tbl_parentagencies_lookup')->get();
        $data['agencyname'] = DB::table('tbl_agencynames_lookup')->get();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')->get();
        $data['id'] = $id;
        $data['users'] = User::where('is_delete',0)->get();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')->get();
        return view('ip_details.intel_organization',$data);
    }

    public function entitesOrganizationInsert(Request $request)
    {
        $data = $request->all();
            $type = $data['organizationtype'];
            $casenoid = $data['organizationcasenoid'];
                        
            if($type == "Business")
            {
                
                IpEntityOrganization::insert([
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
                        'ip_id' => $casenoid,
                        'created_by'=>auth()->user()->id,
                    ]);

                }
            
            if($type == "Government")
            {
            
                IpEntityOrganization::insert([
                        'parent_agency' => $data['govtparentagency'],
                        'organization_name' => $data['govtagencyname'],
                        'business_location' => $data['governmentlocation'],
                        'contact_person' => $data['govtcontactperson'],
                        'phone_no' => $data['govtcontactphone'],
                        'email' => $data['govtcontactemail'],
                        'organization_type'  => $type,
                        'ip_id' => $casenoid,
                        'created_by'=>auth()->user()->id,
                        
                    ]);
                }

            if($type == "Corporation")
                {
            
                IpEntityOrganization::insert([
                        'organization_name' => $data['corpagencyname'],
                        'business_location' => $data['corplocation'],
                        'contact_person' => $data['corpcontactperson'],
                        'phone_no' => $data['corpcontactphone'],
                        'email' => $data['corpcontactemail'],
                        'organization_type'  => $type,
                        'ip_id' => $casenoid,
                        'created_by'=>auth()->user()->id,
                        
                    ]);
                }

              Alert::success('Organization Added Successfully');
              return Redirect::back(); 
    }

    public function entitesOrganizationShow(Request $request)
    {        
            $id = Route::current()->parameter('id');
            $orgdetailsshow =  IpEntityOrganization::where('id', $id)->get();
            
            return view('ip_details.showorganizationdetails',compact('orgdetailsshow'));
    }

    public function entitesOrganizationdelete($id)
    {
            $id = Route::current()->parameter('id');

            IpEntityOrganization::where('id', $id)->delete();

            Alert::success('Delete Successful');
                        return Redirect::back(); 
    }


    public function entitesasset($id)
    {
        $check = IrTeamMember::where('user_id',auth()->user()->id)->where('ir_id',$id)->first();
        if (@$check=="") {
            Alert::error('Unauthorized Access');
            return redirect()->route('dashboard');
        }
        $data = [];
        $data['data'] = IrForm::where('id',$id)->first();
        $data['partytypes'] = DB::table('tbl_partytypes_lookup')
          ->get();
        $data['id'] = $id;  
        $data['entityasset'] = DB::table('ip_case_assets')->where('created_by',auth()->user()->id)
        ->where('ip_id',$id)
        ->get();
        return view('ip_details.intel_asset',$data);
    }

    public function getLandDetailsByCIDAPI(Request $request)
    {
       
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://datahub-apim.dit.gov.bt/token',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=access_token',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic RE9TNEhBUmlacjZXaDNIQ21jcGFFMjg2cTVJYTpGVUpBQUE1SEpKWEFXeWV5bFRhenVMZzZFeTBh',
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $token = json_decode($response)->access_token;

        $landcid = $request->input('landcid');
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://datahub-apim.dit.gov.bt/nlcs_landdetailapi/1.0.0/landdetailsbycid/'.$landcid.'',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response;

        // Return the response
        return $response;
    }


    public function getVehicleDetailsByCIDAPI(Request $request)
    {
       
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://datahub-apim.dit.gov.bt/token',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=access_token',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic RE9TNEhBUmlacjZXaDNIQ21jcGFFMjg2cTVJYTpGVUpBQUE1SEpKWEFXeWV5bFRhenVMZzZFeTBh',
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $token = json_decode($response)->access_token;

        $assetvehiclecid = $request->input('assetvehiclecid');
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://datahub-apim.dit.gov.bt/rsta_licenseandvehicleinformationapi/1.0.0/vehicledetailsbycid/'.$assetvehiclecid.'',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response;

        // Return the response
        return $response;
    }

    public function savecaseassetVehicleAPI(Request $request)
    {
    $data = $request->all();
    $assetvehiclecid = $request->input('assetvehiclecid');
    $vehicleDetails = $request->input('vehicleDetails');


    foreach ($vehicleDetails as $vehicleDetail) 
    {
    IpAsset::create([
    'cidno' => $assetvehiclecid,
    'vehicletype' => $vehicleDetail['Vehicle_Type_Name'],
    'vehicle_registrationno' => $vehicleDetail['Vehicle_Number'],
    'vehicle_registrationdate' => $vehicleDetail['Registration_Date'], // Assuming 'plotNetArea' is the correct key
    'owner' => $vehicleDetail['ownerName'], // Assuming 'ownerName' is the correct key
    'asset_type' => 'Vehicle', // Assuming $type is defined elsewhere
    'ip_id' => $vehicleDetail['case_no_id_vehicle'], // Assuming $casenoid is defined elsewhere
    'created_by'=>auth()->user()->id,
    ]);
    }
    Alert::success('Successful');
    return Redirect::back(); 
    }


    public function saveAsset(Request $request)
        {
            $data = $request->all();
            $type = $data['assettype'];
            $casenoid = $data['assetcasenoid'];
            $landcid = $data['landcid'];
            
            $assetplotno =$request->assetplotno;
            $vehicleowner =$request->vehicleowner;
            

            if($type == "Land"  && $assetplotno != '' )
            {
                
                DB::table('ip_case_assets')->insert([
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
                        'ip_id' => $casenoid,
                        'created_by'=>auth()->user()->id,
                    ]);
            }
            
            if($type == "Vehicle"  && $vehicleowner != '' )
            {
            
                DB::table('ip_case_assets')->insert([
                        'cidno' => $data['assetvehiclecid'],
                        'vehicletype' => $data['vehicletype'],
                        'vehicle_registrationno' => $data['vehicleregistrationno'],
                        'vehicle_registrationdate' => $data['vehicleregistrationdate'],
                        'owner' => $data['vehicleowner'],
                        'asset_type'  => $type,
                        'ip_id' => $casenoid,
                        'created_by'=>auth()->user()->id,
                        
                    ]);
            }

            if($type == "Building")
                {
            
                DB::table('ip_case_assets')->insert([
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
                        'ip_id' => $casenoid,
                        'created_by'=>auth()->user()->id,
                        
                    ]);
                }

                if($type == "Bank")
                {
            
                DB::table('ip_case_assets')->insert([
                        'bank_name' => $data['bankname'],
                        'bank_accounttype' => $data['bankaccounttype'],
                        'owner' => $data['bankaccountowner'],
                        'bank_accountno' => $data['bankaccountno'],
                        'asset_type'  => $type,
                        'ip_id' => $casenoid,
                        'created_by'=>auth()->user()->id,
                        
                    ]);
                }

                Alert::success('Successful');
                    return Redirect::back(); 
            
        }

        public function showAsset($id)
        {
            $id = Route::current()->parameter('id');
            $assetdtls =  DB::table('ip_case_assets')->where('id', $id)->get();
            
            return view('ip_details.showassetdetails',compact('assetdtls'));
        }

        public function deleteAsset(Request $request)
        {
            $id = Route::current()->parameter('id');

            DB::table('ip_case_assets')->where('id', $id)->delete();

            Alert::success('Delete Successful');
                        return Redirect::back(); 
                
        }
}
