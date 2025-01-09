<?php

namespace App\Http\Controllers\CecCom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\CecComCrud;
use App\Models\User;
use App\Models\Department;
use Alert;
use Redirect;
class CrudController extends Controller
{
    public function index()
    {
        $data = [];
        $data['deparment'] = Department::where('is_delete',0)->get();
        // return $data['deparment'];
        $data['data'] = CecComCrud::where('user_type','CEC')->where('status','A')->get();
        return view('cec_com_add.cec_index',$data);
    }

    public function deparmentUser($id)
    {
        $response = User::where('department',$id)->get();
        return $response;
    }

    public function insertUser(Request $request)
    {
        $check = CecComCrud::where('user_id',$request->user_id)->where('user_type','CEC')->where('status','!=','D')->first();
        if (@$check!="") {
            Alert::error('Duplicate Entry');
            return Redirect::back();
        }
        $new = new CecComCrud;
        $new->user_id = $request->user_id;
        $new->user_type = 'CEC';
        $new->status = "A";
        $new->save();
        Alert::success('CEC User Added Successfully');
        return Redirect::back();
    }

    public function deleteUser($id)
    {
        CecComCrud::where('id',$id)->update(['status'=>'D']);
        Alert::success('User Deleted Successfully');
        return Redirect::back();
    }

    public function indexCom()
    {
        $data = [];
        $data['deparment'] = Department::where('is_delete',0)->get();
        // return $data['deparment'];
        $data['data'] = CecComCrud::where('user_type','COM')->where('status','A')->get();
        return view('cec_com_add.com_index',$data);
    }

    public function insertUserCommission(Request $request)
    {
        $check = CecComCrud::where('user_id',$request->user_id)->where('user_type','COM')->where('status','!=','D')->first();
        if (@$check!="") {
            Alert::error('Duplicate Entry');
            return Redirect::back();
        }
        $new = new CecComCrud;
        $new->user_id = $request->user_id;
        $new->user_type = 'COM';
        $new->status = "A";
        $new->save();
        Alert::success('Commission User Added Successfully');
        return Redirect::back();
    }


    





}
