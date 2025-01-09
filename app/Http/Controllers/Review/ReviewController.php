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
use App\Models\Complaint\CompalintEveOffence;
use Alert;
use Redirect;
use DB;
class ReviewController extends Controller
{
    // public function __construct(){      
    //     $this->middleware(function ($request, $next) {      
    //         $user_id = auth()->user()->id;
    //         $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
    //         $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',21)->where('view_option','Y')->where('is_delete',0)->first();
    //         if ($this->view_option=="") {
    //             Alert::error('You are not allowed to access this page');
    //            return redirect()->route('home');

    //         }


            
    //         return $next($request);
    //     });
    // }


    public function index()
    {

        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',23)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }

        $data = [];
        $data['data'] = EvaluationReviewTeam::where('user_id',auth()->user()->id)->with(['eve_offence_details','eve_offence_details.complaint_details'])->whereIn('coi_status',['AA','N'])->get();


        return view('review.index',$data);
    }

    public function coi($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = EvaluationReviewTeam::where('id',$id)->first();
        if ($data['data']->user_id!=auth()->user()->id) {
            return redirect()->route('welcome.dashboard.view');
        }
        return view('review.coi',$data);
    }

    public function coiDecision(Request $request)
    {
        EvaluationReviewTeam::where('id',$request->id)->update([
            'coi_status'=>$request->evaluation,
            'describe_coi'=>$request->describe,
        ]);
        Alert::success('Details updated successfully');
        return redirect()->route('assign.review.complaint.listing');
    }

    public function activity($id)
    {
        $data = [];
        $data['data'] = EvaluationReviewTeam::where('id',$id)->first();
        $data['eve_offence_details'] = CompalintEveOffence::where('id',$data['data']->eve_offence_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['eve_offence_details']->complaint_id)->first();
        $data['activities'] = ComplaintReviewActivity::where('eve_offence_id',$data['data']->eve_offence_id)->get();
        $data['eve_offence_id'] = $data['data']->eve_offence_id;
        return view('review.activity',$data);
    }

    public function insertActivity(Request $request)
    {
        $new = new ComplaintReviewActivity;
        $new->activity_date = $request->activity_date;
        $new->activity_type = $request->activity_type;
        $new->description = $request->description;
        $new->user_id = auth()->user()->id;
        $new->eve_offence_id = $request->eve_offence_id;

        if (@$request->hasFile('attachment')) {

            $file = $request->attachment;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/attachment/review_activity/',$filename);
            $new->attachment = $filename;
        }
        $new->save();

        $check = Appraise::where('eve_offence_id',$request->eve_offence_id)->first();
        if ($check=="") {
            $new = new Appraise;
            $new->eve_offence_id = $request->eve_offence_id;
            $new->save();
        }

        Alert::success('You\'ve Successfully Added A Activity');
        return Redirect::back();

    }

    public function deleteActivity($id)
    {
        ComplaintReviewActivity::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Activity');
        return Redirect::back();
    }


    public function complaintChief()
    {
            $user_id = auth()->user()->id;
            $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',21)->where('view_option','Y')->where('is_delete',0)->first();
            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

            }
        $data = [];
        $data['data'] = CompalintEveOffence::where('review_assign_by','C')->where('com_decision','AI')->get();
        return view('review.chief',$data);
    }

    public function complaintChiefCoi($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['offence_details'] = CompalintEveOffence::where('id',$id)->first();
        $data['data'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        return view('review.chief_coi',$data);
    }

    public function complaintChiefCoiDecision(Request $request)
    {
        CompalintEveOffence::where('id',$request->id)->update([
            'review_coi_status'=>$request->evaluation,
            'review_coi_description'=>$request->describe,
        ]);
        if($request->evaluation=="Y")
        {
            CompalintEveOffence::where('id',$request->id)->update([
            'review_assign_by'=>'D',
            ]);
            Alert::success('Complaint assign to director successfully');
            return redirect()->route('assign.review.team.by.chief');
        }
        Alert::success('Details updated successfully');
        return redirect()->route('assign.review.team.by.chief');
    }

    public function complaintDirector()
    {
        // return 'sayan';
            $user_id = auth()->user()->id;
            $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
            $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',22)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

            }
        $data = [];
        $data['data'] = CompalintEveOffence::where('review_assign_by','D')->where('com_decision','AI')->get();
        return view('review.director',$data);
    }
}
