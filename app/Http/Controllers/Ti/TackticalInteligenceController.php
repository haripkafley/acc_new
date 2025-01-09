<?php

namespace App\Http\Controllers\Ti;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ti\TackticalInteligence;
use App\Models\Ti\RequestType;
use App\Models\Ti\RelationTi;
use App\Models\Ti\TackticalMember;
use App\Models\Ti\TiSuspect;
use App\Models\Offence;
use App\Models\User;
use Alert;
use Redirect;
use Session;
use Mail;
use App\Mail\AssignGmail;
class TackticalInteligenceController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = TackticalInteligence::orderBy('id','desc')->get();
        Session::put('ti_request_add',url()->current());
        return view('tacktical.ti_request',$data);
    }

    public function indexReportingUser()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('created_by',auth()->user()->id)->orderBy('id','desc')->get();
        Session::put('ti_request_add',url()->current());
        return view('tacktical.ti_request_officer',$data);
    }

    public function add()
    {
        $data = [];
        $data['user'] = User::where('is_delete',0)->get();
        $data['request'] = RequestType::get();
        $data['relation'] = RelationTi::get();
        $data['offence'] = Offence::get();
        return view('tacktical.ti_request_add',$data);
    }

    public function insert(Request $request)
    {
        $new = new TackticalInteligence;
        $new->created_by = auth()->user()->id;
        $new->type_ti = $request->type_ti;
        $new->request_type = $request->request_type;
        $new->relation_to = $request->relation_to;
        $new->requesting_officer = $request->requesting_officer;
        $new->request_date = $request->request_date;
        $new->start_date = $request->start_date;
        $new->end_date = $request->end_date;
        $new->suspect_details = $request->suspect_details;
        $new->reason = $request->reason;

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
        return Redirect::to(Session::get('ti_request_add'));
    }


    public function edit($id)
    {
        $data = [];
        $data['user'] = User::where('is_delete',0)->get();
        $data['request'] = RequestType::get();
        $data['relation'] = RelationTi::get();
        $data['data'] = TackticalInteligence::where('id',$id)->first();
        $data['offence'] = Offence::get();
        return view('tacktical.ti_request_edit',$data);
    }


    public function update(Request $request)
    {
        $upd = [];
        $upd['type_ti'] = $request->type_ti;
        $upd['request_type'] = $request->request_type;
        $upd['relation_to'] = $request->relation_to;
        $upd['requesting_officer'] = $request->requesting_officer;
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
        return Redirect::to(Session::get('ti_request_add'));
    }


    public function addSuspect($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = TiSuspect::where('ti_id',$id)->get();
        return view('tacktical.ti_suspect',$data);
    }


    public function addSuspectInsert(Request $request)
    {
        $new = new TiSuspect;
        $new->ti_id = $request->ti_id;
        $new->cid = $request->cid;
        $new->name = $request->name;
        $new->dob = $request->dob;
        $new->dzonkhag = $request->dzonkhag;
        $new->gewog = $request->gewog;
        $new->village = $request->village;
        $new->presnet_address = $request->presnet_address;
        $new->contact = $request->contact;

        if (@$request->hasFile('cid_photo')) {
                    $file = $request->cid_photo;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ti/',$filename);
                    $new->cid_photo = $filename;
        }

        if (@$request->hasFile('attachment')) {
                    $file = $request->attachment;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path().'/attachment/ti/',$filename);
                    $new->attachment = $filename;
        }
        $new->save();
        Alert::success('You\'ve Successfully Added A Suspect ');
        return Redirect::back();
    }

    public function deleteSuspect($id)
    {
        TiSuspect::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Suspect ');
        return Redirect::back();
    }


    public function delete($id)
    {
        TackticalInteligence::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Request ');
        return Redirect::back();
    }

    public function recommendationsIndex()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('com_decision',null)->orderBy('id','desc')->get();
        return view('tacktical.recom_index',$data);
    }


    public function recommendations($id)
    {
        $data = [];
        $data['user'] = User::where('is_delete',0)->get();
        $data['data'] = TackticalInteligence::where('id',$id)->orderBy('id','desc')->first();
        return view('tacktical.recom_update',$data);
    }


    public function recommendationsUpdate(Request $request)
    {
        $upd = [];
        $upd['recommend_by'] = $request->recommend_by;
        $upd['recommend_date'] = $request->recommend_date;
        $upd['recommend_remarks'] = $request->recommend_remarks;
        $upd['status'] = 'R';
        TackticalInteligence::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully ');
        return Redirect::route('tacktical.inteligence.autorization.form.update.recommendation.index.listing');
    }


    public function comissionDecisionList()
    {
        $data = [];
        $data['data'] = TackticalInteligence::whereIn('status',['R','COM'])->orderBy('id','desc')->get();
        return view('tacktical.commision_index',$data);
    }

    public function comissionDecision($id)
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('id',$id)->first();
        return view('tacktical.commision_update',$data);
    }

    public function comissionDecisionMake(Request $request)
    {
        $details = TackticalInteligence::where('id',$request->id)->first();
        $upd = [];
        $upd['com_decision'] = $request->com_decision;
        $upd['com_date'] = $request->com_date;
        $upd['com_remarks'] = $request->com_remarks;
        $upd['status'] = 'COM';
        if (@$request->com_decision=="AP") {
            $upd['sl_no'] = 'SL-00'.$request->id.'/'.date('Y');
            if ($details->type_ti=="IG") {
                $upd['si_ig_no'] = 'IG-00'.$request->id.'/'.date('Y');
            }else{
                $upd['si_ig_no'] = 'S-00'.$request->id.'/'.date('Y');
            }
        }
        TackticalInteligence::where('id',$request->id)->update($upd);
        Alert::success('Data Updated Successfully ');
        return Redirect::route('tacktical.inteligence.autorization.form.commission-decision.list');
    }





    public function assignTeamMember($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['users'] = User::get();
        $data['data'] = TackticalMember::where('tacktical_id',$id)->get();
        return view('tacktical.team',$data);
    }

    public function assignTeamMemberInsert(Request $request)
    {
        $new = new TackticalMember;
        $new->user_id = $request->user_id;
        $new->role = $request->role;
        $new->tacktical_id = $request->tacktical_id;
        $new->save();
        TackticalInteligence::where('id',$request->tacktical_id)->update(['team_assign'=>'Y']);
        $user_details = User::where('id',$request->user_id)->first();
        $data = [
            'name'=>$user_details->name,
            'email'=>$user_details->email,
            'type'=>'Tacktical Inteligence',
        ];
        // Mail::send(new AssignGmail($data));
        Alert::success('You\'ve Successfully Added A Member');
        return Redirect::back();
    }

    public function assignTeamMemberdelete($id)
    {
        TackticalMember::where('id',$id)->delete();
        Alert::success('You\'ve Successfully Deleted A Member');
        return Redirect::back();
    }


    public function completeDetails($id)
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('id',$id)->first();
        $data['members'] = TackticalMember::where('tacktical_id',$id)->get();
        return view('tacktical.complete_details',$data);
    }


    public function survilancePending()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('com_decision','AP')->where('team_assign','N')->orderBy('id','desc')->where('report_status','!=','A')->where('type_ti','S')->get();
        Session::put('ti_cheif_member',url()->current());
        return view('tacktical.sur_pending',$data);
    }

    public function survilanceongoing()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('com_decision','AP')->where('team_assign','Y')->orderBy('id','desc')->where('report_status','!=','A')->where('type_ti','S')->get();
        Session::put('ti_cheif_member',url()->current());
        return view('tacktical.sur_ongoing',$data);
    }

    public function informationPending()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('com_decision','AP')->where('team_assign','N')->orderBy('id','desc')->where('report_status','!=','A')->where('type_ti','IG')->get();
        Session::put('ti_cheif_member',url()->current());
        return view('tacktical.ig_pending',$data);
    }

    public function informationongoing()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('com_decision','AP')->where('team_assign','Y')->orderBy('id','desc')->where('report_status','!=','A')->where('type_ti','IG')->get();
        Session::put('ti_cheif_member',url()->current());
        return view('tacktical.ig_ongoing',$data);
    }


    public function rejectedSurvilance()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('com_decision','RJ')->where('type_ti','S')->orderBy('id','desc')->get();
        return view('tacktical.sur_rejected',$data);
    }

    public function deferredSurvilance()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('com_decision','DF')->where('type_ti','S')->orderBy('id','desc')->get();
        return view('tacktical.sur_deferred',$data);
    }


    public function completeSurvilance()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('com_decision','AP')->where('report_status','A')->orderBy('id','desc')->where('type_ti','S')->get();
        return view('tacktical.sur_complete',$data);
    }

    public function rejectedInformation()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('com_decision','RJ')->where('type_ti','IG')->orderBy('id','desc')->get();
        return view('tacktical.ig_rejected',$data);
    }



    public function deferredInformation()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('com_decision','DF')->where('type_ti','IG')->orderBy('id','desc')->get();
        return view('tacktical.ig_def',$data);
    }

    public function comepleteInformation()
    {
        $data = [];
        $data['data'] = TackticalInteligence::where('com_decision','AP')->where('report_status','A')->orderBy('id','desc')->where('type_ti','IG')->get();
        return view('tacktical.ig_complete',$data);
    }
}
