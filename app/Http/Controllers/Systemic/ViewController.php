<?php

namespace App\Http\Controllers\Systemic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemRegistration;
use App\Models\SystemRecommendation;
use App\Models\SystemicFollowReview;
use App\Models\SystemAgencyFurther;
use App\Models\SystemicFollowClose;
use Alert;
use DB;
use App\Models\UserToRole;
use App\Models\RolePermission;
class ViewController extends Controller
{
    public function index()
    {

        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',36)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }

        
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->get();
        return view('systemic_view.index',$data);
    }

    public function registerView($id)
    {
        $data = [];
        $data['data'] = SystemRegistration::where('case_id',$id)->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('systemic_view.registration',$data);
    }

    public function followView($id)
    {
        $data = [];
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['data'] = SystemicFollowReview::where('case_id',$id)->orderBy('id','desc')->get();
        $data['case_id'] = $id;
        return view('systemic_view.review',$data);
    }

    public function actionView($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['data'] = SystemAgencyFurther::where('type','AG')->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('systemic_view.action_agency',$data);
    }

    public function futherView($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['data'] = SystemAgencyFurther::where('type','FA')->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('systemic_view.futher',$data);   
    }

    public function closeView($id)
    {
        $data = [];
        $data['data'] = SystemicFollowClose::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('systemic_view.close_action',$data);
    }
}
