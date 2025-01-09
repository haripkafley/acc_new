<?php

namespace App\Http\Controllers\Dare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dare\Source;
use App\Models\Dare\IrForm;
use App\Models\Dare\IrSuspect;
use App\Models\Dare\FiscalYear;
use App\Models\Area;
use App\Models\Country;
use App\Models\Complaint\agencyModel;
use App\Models\Offence;
use App\Models\User;
use App\Models\Dare\IrTeamMember;
use App\Models\Dare\IntelProject;
use App\Models\Dare\IpReport;
use App\Models\Ti\TackticalInteligence;
use App\Models\Ti\TackticalMember;
use App\Models\Dzongkhag;
use App\Models\Gewog;
use App\Models\Village;
use Redirect;
use Alert;
use Session;
use Mail;
use App\Mail\AssignGmail;
class IrController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = IrForm::where('is_delete','N')->where('status','AA')->orderBy('received_date','asc')->get();
        Session::put('ir_report_type','head');
        return view('information_report.index',$data);
    }

    public function irrCPageView()
    {
        $data = [];
        $data['data'] = IrForm::where('is_delete','N')->orderBy('received_date','asc')->get();
        Session::put('ir_report_type','irrc');
        return view('information_report.irrc_page',$data);
    }

    public function chiefDashboardNew()
    {
        $data = [];
        $data['pending_ir'] = IrForm::where('is_delete','N')->where('status','AA')->count();
        $data['drop_ir'] = IrForm::where('is_delete','N')->where('status','DP')->count();
        $data['deffer_ir'] = IrForm::where('is_delete','N')->where('status','DR')->count();
        $data['share_ir'] = IrForm::where('is_delete','N')->where('status','SR')->count();
        $data['upgrade_ir'] = IrForm::where('is_delete','N')->where('status','UP')->count();

        $ids = IpReport::pluck('ip_id')->toArray();
        $data['intel_project_ongoing'] = IrForm::whereNotIn('id',$ids)->where('is_delete','N')->where('status','UP')->count();
        $data['intel_project_complete'] = IrForm::whereIn('id',$ids)->count();


        $data['ti_ongoing'] = TackticalInteligence::where('com_decision','AP')->where('team_assign','Y')->where('complete_task','N')->count();
        $data['ti_completed'] = TackticalInteligence::where('com_decision','AP')->where('team_assign','Y')->where('complete_task','Y')->count();
        
        return view('information_report.chief_new_dashboard',$data);

    }

    public function add()
    {
        $data = [];
        $data['sources'] = Source::where('status','A')->get();
        $data['area'] = Area::get();
        $data['agency'] = agencyModel::where('isDelete',0)->get();
        $data['offence'] = Offence::get();
        $data['user'] = User::get();
        $data['dzongkhag'] = Dzongkhag::get();
        return view('information_report.add',$data);
    }

    public function getSource($id)
    {
        $response = Source::where('source_type',$id)->where('status','A')->get();
        return $response;
    }

    public function insert(Request $request)
    {
        $implode = implode(',',@$request->members);
        $new = new IrForm;
        $new->report_by = $implode;
        $new->received_date = $request->received_date;
        $new->title = $request->title;
        $new->description = $request->description;
        $new->source = $request->source;
        $new->user_id = auth()->user()->id;
        $new->source_type = $request->source_type;
        if(@$request->source=="Other")
        {
            $new->source_other = $request->source_other;
        }

        $new->agency = $request->agency;
        $new->corruption = $request->corruption;
        $new->area = $request->area;
        $new->date = date('Y-m-d');


        $new->occurance_from = $request->occurance_from;
        $new->occurance_till = $request->occurance_till;
        $new->dzongkhag_id = $request->dzongkhag;
        $new->gewog_id = $request->gewog;
        $new->village = $request->village;


        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ir/',$filename);
                    $new->attachment = $filename;
        }

        $new->save();

        $fiscal_year = FiscalYear::whereDate('start_date', '<=', date('Y-m-d'))
            ->whereDate('end_date', '>=',date('Y-m-d'))->first();
        if ($fiscal_year=="") {
            $ir_no = 'IR-00'.$new->id.'/'.date('Y');
        }else{
            $ir_no = 'IR-00'.$new->id.'/'.$fiscal_year->year;
        }    

        
        IrForm::where('id',$new->id)->update(['ir_no'=>$ir_no]);
        Alert::success('You\'ve Successfully Added A IR');
        return Redirect::route('manage.information.report.form.edit.ir',$new->id);


    }

    public function edit($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['sources'] = Source::where('status','A')->get();
        $data['area'] = Area::get();
        $data['agency'] = agencyModel::where('isDelete',0)->get();
        $data['offence'] = Offence::get();
        $data['user'] = User::get();
        $data['data'] = IrForm::where('id',$id)->first();
        $data['user_array'] = explode(',',$data['data']->report_by);
        $data['suspects'] = IrSuspect::where('ir_id',$data['data']->id)->get();
        $data['country'] = Country::get();
        $data['dzongkhag'] = Dzongkhag::get();
        $data['gewog'] = Gewog::get();
        $data['village'] = Village::get();
        return view('information_report.edit',$data);
    }


    public function update(Request $request)
    {
        $implode = implode(',',@$request->members);
        $upd = [];
        $upd['report_by'] = $implode;
        $upd['received_date'] = $request->received_date;
        $upd['title'] = $request->title;
        $upd['description'] = $request->description;
        $upd['source'] = $request->source;
        if(@$request->source=="Other")
        {
            $upd['source_other'] = $request->source_other;
        }
        $upd['agency'] = $request->agency;
        $upd['corruption'] = $request->corruption;
        $upd['area'] = $request->area;

        $upd['occurance_from'] = $request->occurance_from;
        $upd['occurance_till'] = $request->occurance_till;
        $upd['dzongkhag_id'] = $request->dzongkhag;
        $upd['gewog_id'] = $request->gewog;
        $upd['village'] = $request->village;

        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ir/',$filename);
                    $upd['attachment'] = $filename;
        }

        IrForm::where('id',$request->id)->update($upd);
        Alert::success('You\'ve Successfully Updated A IR');
        return Redirect::back();


    }


    public function suspect($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = IrForm::where('id',$id)->first();
        $data['suspects'] = IrSuspect::where('ir_id',$data['data']->id)->get();
        return view('information_report.suspect',$data);
    }

    public function suspectInsert(Request $request)
    {
        $new = new IrSuspect;
        $new->nationality = $request->nationality;
        $new->name = $request->name;
        $new->person_type = $request->person_type;
        $new->dob = $request->dob;
        $new->phone_number = $request->phone_number;
        $new->address = $request->address;

        
        $new->ir_id = $request->ir_id;
        if($request->nationality=="B")
        {
            $new->cid = $request->cid;
            $new->country = 'Bhutan';
        }else{
            $new->identity = $request->identity;
            $new->country = $request->country;
        }

        if (@$request->hasFile('photo')) {
                    $file = $request->photo;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ir/',$filename);
                    $new->photo = $filename;
        }

        $new->save();

        Alert::success('You\'ve Successfully Added A IR Suspect');
        return Redirect::back();
    }


    public function suspectdelete($id)
    {
        IrSuspect::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A IR Suspect');
        return Redirect::back();
    }

    public function decisionPage($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['sources'] = Source::where('status','A')->get();
        $data['area'] = Area::get();
        $data['agency'] = agencyModel::where('isDelete',0)->get();
        $data['offence'] = Offence::get();
        $data['user'] = User::get();
        $data['data'] = IrForm::where('id',$id)->first();
        $data['suspects'] = IrSuspect::where('ir_id',$data['data']->id)->get();
        $data['user_array'] = explode(',',$data['data']->report_by);
        $data['dzongkhag'] = Dzongkhag::get();
        $data['gewog'] = Gewog::get();
        $data['village'] = Village::get();
        $data['explode_member'] = explode(',', $data['data']->members);
        return view('information_report.decision',$data);

    }


    public function decisionPageUpdate(Request $request)
    {
        $details = IrForm::where('id',$request->id)->first();
        $upd = [];
        $upd['status'] = $request->status;
        if(@$request->status=="UP")
        {
            $upd['decision_remark'] = $request->decision_remark;
            $upd['decision_reason'] = '';
            $check = IntelProject::where('ir_id',$request->id)->first();
            if(@$check=="")
            {   

                $fiscal_year = FiscalYear::whereDate('start_date', '<=', date('Y-m-d'))
                ->whereDate('end_date', '>=',date('Y-m-d'))->first();
                if ($fiscal_year=="") {
                    $ip_no = 'IP-00'.$details->id.'/'.date('Y');
                }else{
                    $ip_no = 'IP-00'.$details->id.'/'.$fiscal_year->year;
                }
                $new = new IntelProject;
                $new->ir_id = $request->id;
                $new->save();
                // $ip_no = 'IP-00'.$new->id.'/'.date('Y');
                IntelProject::where('id',$new->id)->update(['ip_no'=>$ip_no]);
            }
        }else{
            $upd['decision_remark'] = '';
            $upd['decision_reason'] = $request->decision_reason;
        }

        $implode = implode(',',@$request->members);
        $upd['members'] = $implode;

        IrForm::where('id',$request->id)->update($upd);
        Alert::success('You\'ve Successfully Updated The Decision');
        return redirect()->back();
        // if(@$request->status=="UP")
        // {
        //     return redirect()->route('manage.information.report.form.upgrade.assignment');
        // }elseif(@$request->status=="DR"){
        //     return redirect()->route('manage.information.report.form.deffer.assignment');
        // }elseif(@$request->status=="DP"){
        //     return redirect()->route('manage.information.report.form.drop.assignment');
        // }elseif(@$request->status=="SR"){
        //     return redirect()->route('manage.information.report.form.share.assignment');
        // }else{
        //     return redirect()->back();
        // }
        
    }


    public function upgradeAssignment()
    {
        $data = [];
        $data['data'] = IrForm::where('is_delete','N')->where('status','UP')->get();
        Session::put('assign_member_url',url()->current());
        return view('information_report.upgrade',$data);
    }

    public function defferAssignment()
    {
        $data = [];
        $data['data'] = IrForm::where('is_delete','N')->where('status','DR')->get();
        return view('information_report.deffer',$data);
    }

    public function dropAssignment()
    {
        $data = [];
        $data['data'] = IrForm::where('is_delete','N')->where('status','DP')->get();
        return view('information_report.drop',$data);
    }

    public function shareAssignment()
    {
        $data = [];
        $data['data'] = IrForm::where('is_delete','N')->where('status','SR')->get();
        return view('information_report.share',$data);
    }

    public function teamMember($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['users'] = User::get();
        $data['data'] = IrTeamMember::where('ir_id',$id)->get();
        return view('information_report.team',$data);
    }

    public function teamMemberInsert(Request $request)
    {
        $new = new IrTeamMember;
        $new->user_id = $request->user_id;
        $new->role = $request->role;
        $new->ir_id = $request->ir_id;
        $new->save();
        $user_details = User::where('id',$request->user_id)->first();
        $data = [
            'name'=>$user_details->name,
            'email'=>$user_details->email,
            'type'=>'Information Report',
        ];
        Mail::send(new AssignGmail($data));
        Alert::success('You\'ve Successfully Added A Member');
        return Redirect::back();
    }


    public function teamMemberDelete($id)
    {
        IrTeamMember::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Member');
        return Redirect::back();
    }

    public function reportingOfficer()
    {
        $data = [];
        $data['data'] = IrForm::where('is_delete','N')->where('status','AA')->where('user_id',auth()->user()->id)->get();
        Session::put('ir_report_type','reporting_officer');
        return view('information_report.index_reporting_officer',$data);
    }

    public function chiefDashboard()
    {
        $fiscal_year = FiscalYear::whereDate('start_date', '<=', date('Y-m-d'))
            ->whereDate('end_date', '>=',date('Y-m-d'))->first();

        $ir_total = IrForm::count();

        if (@$fiscal_year=="") {
            $data['ip_completed'] = 0;
        }else{
            $data['ip_completed'] = IrForm::whereHas('ir_report',function($query){
                $query->where('report_date','!=',null);
            })->where('ir_no','LIKE','%'.'/'.@$fiscal_year->year.'%')->count();
        }

        $total_ip_complete = IrForm::whereHas('ir_report',function($query){
                $query->where('report_date','!=',null);
            })->count();

        $total_ip_complete_ids = IrForm::whereHas('ir_report',function($query){
                $query->where('report_date','!=',null);
            })->pluck('id')->toArray();

        if (@$fiscal_year=="") {
            $fiscal_completed_ids = IrForm::whereHas('ir_report',function($query){
                $query->where('report_date','!=',null);
            })->pluck('id')->toArray();
        }else{
            $fiscal_completed_ids = IrForm::whereHas('ir_report',function($query){
                $query->where('report_date','!=',null);
            })->where('ir_no','LIKE','%'.'/'.@$fiscal_year->year.'%')->pluck('id')->toArray();
        }



        
        $data['ip_ongoing'] = $ir_total-$total_ip_complete;


        $data['ip_ongoing_ui_one'] = IrTeamMember::whereNotIn('ir_id',$total_ip_complete_ids)->where('coi_status','N')->whereHas('user_details',function($query){
            $query->where('unit','u1');
        })->count();

        $data['ip_ongoing_ui_two'] = IrTeamMember::whereNotIn('ir_id',$total_ip_complete_ids)->where('coi_status','N')->whereHas('user_details',function($query){
            $query->where('unit','u2');
        })->count();

        $data['ip_ongoing_ui_three'] = IrTeamMember::whereNotIn('ir_id',$total_ip_complete_ids)->where('coi_status','N')->whereHas('user_details',function($query){
            $query->where('unit','u3');
        })->count();


        $data['ip_completed_ui_one'] = IrTeamMember::whereIn('ir_id',$fiscal_completed_ids)->where('coi_status','N')->whereHas('user_details',function($query){
            $query->where('unit','u1');
        })->count();

        $data['ip_completed_ui_two'] = IrTeamMember::whereIn('ir_id',$fiscal_completed_ids)->where('coi_status','N')->whereHas('user_details',function($query){
            $query->where('unit','u2');
        })->count();

        $data['ip_completed_ui_three'] = IrTeamMember::whereIn('ir_id',$fiscal_completed_ids)->where('coi_status','N')->whereHas('user_details',function($query){
            $query->where('unit','u3');
        })->count();


        





        if (@$fiscal_year=="") {
            $data['ip_completed'] = 0;
        }else{
            $data['ip_completed'] = IrForm::whereHas('ir_report',function($query){
                $query->where('report_date','!=',null);
            })->where('ir_no','LIKE','%'.'/'.@$fiscal_year->year.'%')->count();
        }


        

        $data['ti_ongoing'] = TackticalInteligence::where('com_decision','AP')->where('team_assign','Y')->where('complete_task','N')->where('type_ti','S')->count();
        $data['ti_completed'] = TackticalInteligence::where('com_decision','AP')->where('team_assign','Y')->where('complete_task','Y')->where('type_ti','S')->count();


        $data['ti_ongoing_ig'] = TackticalInteligence::where('com_decision','AP')->where('team_assign','Y')->where('complete_task','N')->where('type_ti','IG')->count();
        $data['ti_completed_ig'] = TackticalInteligence::where('com_decision','AP')->where('team_assign','Y')->where('complete_task','Y')->where('type_ti','IG')->count();


        return view('ip_details.ip_dashboard',$data);
    }

    public function individualDashboard()
    {
        $data = [];
        $ids = IpReport::pluck('ip_id')->toArray();

        $data['ip_ongoing'] = IrTeamMember::where('coi_status','N')->whereNotIn('ir_id',$ids)->where('user_id',auth()->user()->id)->count();


        $data['ip_completed'] = IrTeamMember::where('coi_status','N')->whereIn('ir_id',$ids)->where('user_id',auth()->user()->id)->count();

        
        $data['ti_ongoing'] = TackticalMember::where('coi_status','N')->where('user_id',auth()->user()->id)->whereHas('tacktical_details',function($query){
            $query->where('complete_task','N')->where('team_assign','Y');
        })->count();
       


        $data['ti_completed'] = TackticalMember::where('coi_status','N')->where('user_id',auth()->user()->id)->whereHas('tacktical_details',function($query){
            $query->where('complete_task','Y')->where('team_assign','Y');
        })->count();
        return view('ip_details.ip_dashboard_indi',$data);
    }




}
