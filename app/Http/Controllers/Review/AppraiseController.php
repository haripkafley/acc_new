<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\complaintRegistrationModel;
use App\Models\User;
use App\Models\EvaluationReviewTeam;
use App\Models\ComplaintReviewActivity;
use App\Models\Appraise;
use App\Models\UserToRole;
use App\Models\RolePermission;
use Alert;
use Redirect;
use DB;
use App\Models\Complaint\CompalintEveOffence;
class AppraiseController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',24)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = Appraise::get();
        return view('appraise.director',$data);
    }

    public function decisionDirectorView($id)
    {
        $data = [];
        $data['data'] = Appraise::where('id',$id)->first();
        $data['id'] = $id;
        $data['activities'] = ComplaintReviewActivity::where('eve_offence_id',$data['data']->eve_offence_id)->get();
        return view('appraise.director_view',$data);
    }

    public function decisionDirectorUpdate(Request $request)
    {
        $upd = [];

        $upd['director_acitivity_type'] = $request->director_acitivity_type;
        $upd['director_acitivity_date'] = $request->director_acitivity_date;
        $upd['director_acitivity_description'] = $request->director_acitivity_description;
        $upd['director_acitivity_status'] = $request->director_acitivity_status;
        $upd['appraise_direcor_status'] = 'A';
        if (@$request->hasFile('director_attachment')) {

            $file = $request->director_attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/review_activity/',$filename);
            $upd['director_attachment'] = $filename;
        }

        if($request->director_acitivity_status=="Brief Agency")
        {
            $upd['brief_agency_status'] = "O";
            $upd['review_crud'] = "N";
        }

        Appraise::where('id',$request->id)->update($upd);


        Alert::success('Data updated successfully');
        return Redirect::back();

    }


    public function briefIndex()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',25)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = Appraise::where('brief_agency_status','O')->where('appraise_direcor_status','A')->get();
        return view('appraise.agency',$data);
    }

    public function decisionAgencyView($id)
    {
        $data = [];
        $data['data'] = Appraise::where('id',$id)->first();
        $data['id'] = $id;
        $data['activities'] = ComplaintReviewActivity::where('eve_offence_id',$data['data']->eve_offence_id)->get();
        return view('appraise.agency_view',$data);
    }


    public function decisionAgencyUpdate(Request $request)
    {
        $upd = [];
        $upd['agency_activity_type'] = $request->agency_activity_type;
        $upd['letter_date'] = $request->letter_date;
        $upd['letter_no'] = $request->letter_no;
        $upd['agency_remarks'] = $request->agency_remarks;
        $upd['brief_agency_status_assign'] = 'A';
        if (@$request->hasFile('agency_attachment')) {

            $file = $request->agency_attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/review_activity/',$filename);
            $upd['agency_attachment'] = $filename;
        }

        if($request->agency_activity_type=="Appraise Comission")
        {
            $upd['comission_menu_status'] = "O";
        }

        Appraise::where('id',$request->id)->update($upd);


        Alert::success('Data updated successfully');
        return Redirect::back();

    }


    public function comissionIndex()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',26)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = Appraise::where('comission_menu_status','O')->where('brief_agency_status_assign','A')->get();
        return view('appraise.comission',$data);
    }

    public function decisionComissionView($id)
    {
        $data = [];
        $data['data'] = Appraise::where('id',$id)->first();
        $data['id'] = $id;
        $data['activities'] = ComplaintReviewActivity::where('eve_offence_id',$data['data']->eve_offence_id)->get();
        return view('appraise.comission_view',$data);
    }

    public function decisionComissionUpdate(Request $request)
    {
        // return $request;
        $upd = [];
        if (@$request->comission_status=="More Review") {
            $upd['com_more_review'] = 'Y';
            $upd['appraise_direcor_status'] = 'IN';
            $upd['brief_agency_status_assign'] = 'IN';
            $upd['appraise_com_status'] = 'IN';
            $upd['review_crud'] = 'Y';
        }else{
            $upd['com_more_review'] = 'AA';
            $upd['appraise_direcor_status'] = 'A';
            $upd['brief_agency_status_assign'] = 'A';
            $upd['appraise_com_status'] = 'A';
            $upd['review_crud'] = 'N';
        }
        
        $upd['comission_activity_type'] = $request->comission_activity_type;
        $upd['meeting_date'] = $request->meeting_date;
        $upd['comission_status'] = $request->comission_status;
        $upd['comission_remarks'] = $request->comission_remarks;
        if (@$request->hasFile('comission_attachment')) {

            $file = $request->comission_attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/review_activity/',$filename);
            $upd['comission_attachment'] = $filename;
        }

        

        Appraise::where('id',$request->id)->update($upd);


        Alert::success('Data updated successfully');
        return Redirect::back();
    }
}
