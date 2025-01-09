<?php

namespace App\Http\Controllers\ChiefLegal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Legal\Taskmanage;
use App\Models\TaskType;
use App\Models\inv_pltbltask;
use App\Models\User;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class TaskController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',41)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }


        $data = [];
        $data['data'] = Taskmanage::get();
        return view('legal_task_manage.index',$data);
    }

    public function addView()
    {
        $data = [];
        $data['task_type'] = TaskType::get();
        $data['tasks'] = inv_pltbltask::get();
        $data['users'] = User::where('is_delete',0)->get();
        return view('legal_task_manage.add',$data);
    }

    public function insert(Request $request)
    {
        $new = new Taskmanage;
        $new->user_id = $request->user_id;
        $new->case_id = $request->case_id;
        $new->type_of_task = $request->type_of_task;
        $new->task = $request->task;
        $new->task_description = $request->task_description;
        $new->status = 'AA';
        $new->date_assignment = date('Y-m-d');
        $new->save();
        Alert::success('Task added successfully');
        return redirect()->route('manage.task.management.legal.chief');
    }

    public function deleteView($id)
    {
        TaskManage::where('id',$id)->delete();
        Alert::success('Task deleted successfully');
        return redirect()->back();
    }

    public function getCase()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',46)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }


        $data = [];
        $data['data'] = Taskmanage::where('user_id',auth()->user()->id)->get();
        return view('legal_task_manage.list',$data);
    }

    public function updateDecision($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = Taskmanage::where('id',$id)->first();
        if(auth()->user()->id!=$data['data']->user_id)
        {
            return redirect()->route('dashboard');
        }
        return view('legal_task_manage.update',$data);
    }

    public function insertDecision(Request $request)
    {
        Taskmanage::where('id',$request->id)->update([
            'status'=>$request->status,
            'remarks'=>$request->remarks,
            'status_update_date'=>$request->status_update_date,
        ]);
        Alert::success('Status updated successfully');
        return redirect()->back();
    }


    public function editView($id)
    {
        $data = [];
        $data['data'] = Taskmanage::where('id',$id)->first();
        $data['task_type'] = TaskType::get();
        $data['tasks'] = inv_pltbltask::get();
        $data['users'] = User::where('is_delete',0)->get();
        return view('legal_task_manage.edit',$data);
    }


    public function update(Request $request)
    {
        $upd = [];
        $upd['case_id'] = $request->case_id;
        $upd['type_of_task'] = $request->type_of_task;
        $upd['task'] = $request->task;
        $upd['task_description'] = $request->task_description;
        Taskmanage::where('id',$request->id)->update($upd);
        Alert::success('Task updated successfully');
        return redirect()->back();

    }
}
