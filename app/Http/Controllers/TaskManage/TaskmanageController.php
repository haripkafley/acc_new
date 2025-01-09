<?php

namespace App\Http\Controllers\TaskManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskManage;
use App\Models\TaskType;
use App\Models\inv_pltbltask;
use App\Models\User;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class TaskmanageController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',33)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }


        $data = [];
        $data['data'] = TaskManage::get();
        return view('case_task_manage.index',$data);
    }

    public function addTask()
    {
        $data = [];
        $data['task_type'] = TaskType::get();
        $data['tasks'] = inv_pltbltask::get();
        $data['users'] = User::where('is_delete',0)->get();
        return view('case_task_manage.add',$data);
    }

    public function fetchUser(Request $request)
    {
        $data = User::where('id',$request->id)->first();
        $response=array();
        $response['users']=$data;
        return response()->json($response);
    }

    public function insert(Request $request)
    {
        $new = new TaskManage;
        $new->user_id = $request->user_id;
        $new->case_id = $request->case_id;
        $new->type_of_task = $request->type_of_task;
        $new->task = $request->task;
        $new->task_description = $request->task_description;
        $new->status = 'AA';
        $new->date_assignment = date('Y-m-d');
        $new->save();
        Alert::success('Task added successfully');
        return redirect()->route('manage.task-manage-case');
    }

    public function edit($id)
    {
        $data = [];
        $data['data'] = TaskManage::where('id',$id)->first();
        $data['task_type'] = TaskType::get();
        $data['tasks'] = inv_pltbltask::get();
        $data['users'] = User::where('is_delete',0)->get();
        return view('case_task_manage.edit',$data);
    }

    public function update(Request $request)
    {
        $upd = [];
        $upd['case_id'] = $request->case_id;
        $upd['type_of_task'] = $request->type_of_task;
        $upd['task'] = $request->task;
        $upd['task_description'] = $request->task_description;
        TaskManage::where('id',$request->id)->update($upd);
        Alert::success('Task updated successfully');
        return redirect()->back();

    }


    public function getCase()
    {

        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',37)->where('view_option','Y')->where('is_delete',0)->first();

        if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }


        $data = [];
        $data['data'] = TaskManage::where('user_id',auth()->user()->id)->get();
        return view('case_task_manage.list',$data);
    }

    public function updateDecision($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = TaskManage::where('id',$id)->first();
        if(auth()->user()->id!=$data['data']->user_id)
        {
            return redirect()->route('dashboard');
        }
        return view('case_task_manage.update',$data);
    }

    public function insertDecision(Request $request)
    {
        TaskManage::where('id',$request->id)->update([
            'status'=>$request->status,
            'remarks'=>$request->remarks,
            'status_update_date'=>$request->status_update_date,
        ]);
        Alert::success('Status updated successfully');
        return redirect()->back();
    }

    public function delete($id)
    {
        TaskManage::where('id',$id)->delete();
        Alert::success('Task deleted successfully');
        return redirect()->back();
    }
}
