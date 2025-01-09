<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\complaintRegistrationModel;
use Carbon\Carbon;
use App\Models\AtrDetails;
use App\Models\SensitizationAtrDetails;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $data['data'] = complaintRegistrationModel::orderBy('id','desc');
        if (@$request->year_filter) {
            $data['data'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter);
        

            $data['january'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 1)->count();
            $data['february'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 2)->count();
            $data['march'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 3)->count();
            $data['april'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 4)->count();
            $data['may'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 5)->count();
            $data['june'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 6)->count();
            $data['july'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 7)->count();
            $data['august'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 8)->count();
            $data['september'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 9)->count();
            $data['october'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 10)->count();
            $data['november'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 11)->count();
            $data['december'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 12)->count();








        }else{
            $data['data'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'));


        

            $data['january'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 1)->count();
            $data['february'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 2)->count();
            $data['march'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 3)->count();
            $data['april'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 4)->count();
            $data['may'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 5)->count();
            $data['june'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 6)->count();
            $data['july'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 7)->count();
            $data['august'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 8)->count();
            $data['september'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 9)->count();
            $data['october'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 10)->count();
            $data['november'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 11)->count();
            $data['december'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 12)->count();
        }

        $years = range(Carbon::now()->year, 2014);
        $data['years'] = $years;
        
        $data['pending_cec'] = complaintRegistrationModel::where('cec_date',null)->count();
        $data['pending_com'] = complaintRegistrationModel::where('com_date',null)->count();
        $action_cec = AtrDetails::where('cec_date',null)->count();
        $sensi_cec = SensitizationAtrDetails::where('cec_date',null)->count();
        $data['atr_pending_cec'] = $action_cec+$sensi_cec;

        $action_com = AtrDetails::where('com_date',null)->count();
        $sensi_com = SensitizationAtrDetails::where('com_date',null)->count();
        $data['atr_pending_com'] = $action_com+$sensi_com;

        $data['for_action'] = complaintRegistrationModel::where('agency_outcome','For Action')->count();
        $data['sensitization'] = complaintRegistrationModel::where('agency_outcome','Sensitization')->count();



        $data['head_office_complaint'] = complaintRegistrationModel::where('assign_to','H')->where('com_date','!=',null)->count();
        
        $data['head_office_atr'] = complaintRegistrationModel::where('assign_to','H')->where('com_date','!=',null)->whereHas('action_atr_list',function($query){
            $query->whereHas('atr_details',function($query_inner){
                $query_inner->where('com_venue',null);
            });
        })->count();

        $data['head_office_sensi_atr'] = complaintRegistrationModel::where('assign_to','H')->where('com_date','!=',null)->whereHas('sensi_atr_list',function($query){
            $query->whereHas('atr_details',function($query_inner){
                $query_inner->where('com_venue',null);
            });
        })->count();
        
        $data['total_head_office_atr'] = $data['head_office_atr']+$data['head_office_sensi_atr'];


        $data['tashigangcomplaint'] = complaintRegistrationModel::where('assign_to','R')->where('regional_office',2)->where('com_date','!=',null)->count();
        $data['parocomplaint'] = complaintRegistrationModel::where('assign_to','R')->where('regional_office',3)->where('com_date','!=',null)->count();
        $data['phuncomplaint'] = complaintRegistrationModel::where('assign_to','R')->where('regional_office',1)->where('com_date','!=',null)->count();



        return view('updated_dashboard.index',$data);
    }

    public function indexChief(Request $request)
    {
                $data = [];
        $data['data'] = complaintRegistrationModel::orderBy('id','desc');
        if (@$request->year_filter) {
            $data['data'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter);
        

            $data['january'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 1)->count();
            $data['february'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 2)->count();
            $data['march'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 3)->count();
            $data['april'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 4)->count();
            $data['may'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 5)->count();
            $data['june'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 6)->count();
            $data['july'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 7)->count();
            $data['august'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 8)->count();
            $data['september'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 9)->count();
            $data['october'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 10)->count();
            $data['november'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 11)->count();
            $data['december'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 12)->count();








        }else{
            $data['data'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'));


        

            $data['january'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 1)->count();
            $data['february'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 2)->count();
            $data['march'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 3)->count();
            $data['april'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 4)->count();
            $data['may'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 5)->count();
            $data['june'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 6)->count();
            $data['july'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 7)->count();
            $data['august'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 8)->count();
            $data['september'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 9)->count();
            $data['october'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 10)->count();
            $data['november'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 11)->count();
            $data['december'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 12)->count();
        }

        $years = range(Carbon::now()->year, 2014);
        $data['years'] = $years;
        
        $data['pending_cec'] = complaintRegistrationModel::where('cec_date',null)->count();
        $data['pending_com'] = complaintRegistrationModel::where('com_date',null)->count();
        $action_cec = AtrDetails::where('cec_date',null)->count();
        $sensi_cec = SensitizationAtrDetails::where('cec_date',null)->count();
        $data['atr_pending_cec'] = $action_cec+$sensi_cec;

        $action_com = AtrDetails::where('com_date',null)->count();
        $sensi_com = SensitizationAtrDetails::where('com_date',null)->count();
        $data['atr_pending_com'] = $action_com+$sensi_com;

        $data['for_action'] = complaintRegistrationModel::where('agency_outcome','For Action')->count();
        $data['sensitization'] = complaintRegistrationModel::where('agency_outcome','Sensitization')->count();



        $data['head_office_complaint'] = complaintRegistrationModel::where('assign_to','H')->where('com_date','!=',null)->count();
        
        $data['head_office_atr'] = complaintRegistrationModel::where('assign_to','H')->where('com_date','!=',null)->whereHas('action_atr_list',function($query){
            $query->whereHas('atr_details',function($query_inner){
                $query_inner->where('com_venue',null);
            });
        })->count();

        $data['head_office_sensi_atr'] = complaintRegistrationModel::where('assign_to','H')->where('com_date','!=',null)->whereHas('sensi_atr_list',function($query){
            $query->whereHas('atr_details',function($query_inner){
                $query_inner->where('com_venue',null);
            });
        })->count();
        
        $data['total_head_office_atr'] = $data['head_office_atr']+$data['head_office_sensi_atr'];


        $data['tashigangcomplaint'] = complaintRegistrationModel::where('assign_to','R')->where('regional_office',2)->where('com_date','!=',null)->count();
        $data['parocomplaint'] = complaintRegistrationModel::where('assign_to','R')->where('regional_office',3)->where('com_date','!=',null)->count();
        $data['phuncomplaint'] = complaintRegistrationModel::where('assign_to','R')->where('regional_office',1)->where('com_date','!=',null)->count();



        return view('updated_dashboard.index_chief',$data);
    }


    public function indexRegional(Request $request)
    {
                        $data = [];
        $data['data'] = complaintRegistrationModel::orderBy('id','desc');
        if (@$request->year_filter) {
            $data['data'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter);
        

            $data['january'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 1)->count();
            $data['february'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 2)->count();
            $data['march'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 3)->count();
            $data['april'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 4)->count();
            $data['may'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 5)->count();
            $data['june'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 6)->count();
            $data['july'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 7)->count();
            $data['august'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 8)->count();
            $data['september'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 9)->count();
            $data['october'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 10)->count();
            $data['november'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 11)->count();
            $data['december'] = complaintRegistrationModel::whereYear('created_at', '=', @$request->year_filter)->whereMonth('created_at', '=', 12)->count();








        }else{
            $data['data'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'));


        

            $data['january'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 1)->count();
            $data['february'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 2)->count();
            $data['march'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 3)->count();
            $data['april'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 4)->count();
            $data['may'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 5)->count();
            $data['june'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 6)->count();
            $data['july'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 7)->count();
            $data['august'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 8)->count();
            $data['september'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 9)->count();
            $data['october'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 10)->count();
            $data['november'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 11)->count();
            $data['december'] = complaintRegistrationModel::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 12)->count();
        }

        $years = range(Carbon::now()->year, 2014);
        $data['years'] = $years;
        
        $data['pending_cec'] = complaintRegistrationModel::where('cec_date',null)->count();
        $data['pending_com'] = complaintRegistrationModel::where('com_date',null)->count();
        $action_cec = AtrDetails::where('cec_date',null)->count();
        $sensi_cec = SensitizationAtrDetails::where('cec_date',null)->count();
        $data['atr_pending_cec'] = $action_cec+$sensi_cec;

        $action_com = AtrDetails::where('com_date',null)->count();
        $sensi_com = SensitizationAtrDetails::where('com_date',null)->count();
        $data['atr_pending_com'] = $action_com+$sensi_com;

        $data['for_action'] = complaintRegistrationModel::where('agency_outcome','For Action')->count();
        $data['sensitization'] = complaintRegistrationModel::where('agency_outcome','Sensitization')->count();



        $data['head_office_complaint'] = complaintRegistrationModel::where('assign_to','H')->where('com_date','!=',null)->count();
        
        $data['head_office_atr'] = complaintRegistrationModel::where('assign_to','H')->where('com_date','!=',null)->whereHas('action_atr_list',function($query){
            $query->whereHas('atr_details',function($query_inner){
                $query_inner->where('com_venue',null);
            });
        })->count();

        $data['head_office_sensi_atr'] = complaintRegistrationModel::where('assign_to','H')->where('com_date','!=',null)->whereHas('sensi_atr_list',function($query){
            $query->whereHas('atr_details',function($query_inner){
                $query_inner->where('com_venue',null);
            });
        })->count();
        
        $data['total_head_office_atr'] = $data['head_office_atr']+$data['head_office_sensi_atr'];


        $data['tashigangcomplaint'] = complaintRegistrationModel::where('assign_to','R')->where('regional_office',2)->where('com_date','!=',null)->count();
        $data['parocomplaint'] = complaintRegistrationModel::where('assign_to','R')->where('regional_office',3)->where('com_date','!=',null)->count();
        $data['phuncomplaint'] = complaintRegistrationModel::where('assign_to','R')->where('regional_office',1)->where('com_date','!=',null)->count();



        return view('updated_dashboard.index_regional',$data);
    }


    public function cmdDashboard()
    {
        return view('updated_dashboard.cmd_dashboard');
    }
}
