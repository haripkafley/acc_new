<?php

namespace App\Http\Controllers\AdminReferCase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseEntity;
use App\Models\AdminReferCaseSanction;
use App\Models\AdminReferCaseFines;
use App\Models\AdminReferCaseReferLetter;
use App\Models\AdminReferCaseAgencyRefer;
use App\Models\AdminReferCaseStatus;
use App\Models\AdminReferFollowReview;
use App\Models\AdminReferFollowAgencyAction;
use App\Models\AdminReferFollowOwnAction;
use App\Models\AdminReferFollowFurtherAction;
use App\Models\AdminReferFollowClose;
use Alert;
use DB;
use App\Models\UserToRole;
use App\Models\RolePermission;
class ChiefController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',35)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->get();
        return view('admin_refer_case.index_view',$data);
    }

    public function registerView($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['data'] = CaseEntity::where('case_no_id',$id)->get();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_case.regi_view',$data);
    }

    public function followView($id)
    {
        $data = [];
        $data['data'] = AdminReferFollowReview::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_case.follow_view',$data);
    }

    public function agencyView($id)
    {
        $data = [];
        $data['data'] = AdminReferFollowAgencyAction::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_case.action_agency',$data);
    }

    public function ownView($id)
    {
        $data = [];
        $data['data'] = AdminReferFollowOwnAction::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_case.own_action',$data);
    }

    public function futherView($id)
    {
        $data = [];
        $data['data'] = AdminReferFollowFurtherAction::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_case.futher_action',$data);
    }

    public function closedView($id)
    {
        $data = [];
        $data['data'] = AdminReferFollowClose::where('case_id',$id)->get();
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('admin_refer_case.close_action',$data);
    }
}
