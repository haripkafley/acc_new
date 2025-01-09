<?php

namespace App\Http\Controllers\EvidenceManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evidence\EvidenceTask;
use App\Models\TaskType;
use App\Models\inv_pltbltask;
use App\Models\User;
use App\Models\UserToRole;
use App\Models\RolePermission;
use Alert;
class EvidenceManageController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',51)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }


        $data = [];
        $data['data'] = EvidenceTask::get();
        return view('evidence_task.index',$data);
    }

    public function addTask()
    {
        $data = [];
        $data['task_type'] = TaskType::get();
        $data['tasks'] = inv_pltbltask::get();
        $data['users'] = User::where('is_delete',0)->get();
        return view('evidence_task.add',$data);
    }

    public function fetchUser(Request $request)
    {
        $data = User::where('id',$request->id)->first();
        $response=array();
        $response['users']=$data;
        return response()->json($response);
    }


    public function insertTask(Request $request)
    {
        $new = new EvidenceTask;
        $new->user_id = $request->user_id;
        $new->case_id = $request->case_id;
        $new->type_of_task = $request->type_of_task;
        $new->task = $request->task;
        $new->task_description = $request->task_description;
        $new->status = 'AA';
        $new->date_assignment = date('Y-m-d');
        $new->save();
        Alert::success('Task added successfully');
        return redirect()->route('manage.evidence.task.management');
    }


    public function deleteTask($id)
    {
        EvidenceTask::where('id',$id)->delete();
        Alert::success('Task deleted successfully');
        return redirect()->back();
    }

    public function editTask($id)
    {
        $data = [];
        $data['data'] = EvidenceTask::where('id',$id)->first();
        $data['task_type'] = TaskType::get();
        $data['tasks'] = inv_pltbltask::get();
        $data['users'] = User::where('is_delete',0)->get();
        return view('evidence_task.edit',$data);
    }

    public function updateTask(Request $request)
    {
        $upd = [];
        $upd['case_id'] = $request->case_id;
        $upd['type_of_task'] = $request->type_of_task;
        $upd['task'] = $request->task;
        $upd['task_description'] = $request->task_description;
        EvidenceTask::where('id',$request->id)->update($upd);
        Alert::success('Task updated successfully');
        return redirect()->back();
    }

    public function getCase()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',53)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = EvidenceTask::where('user_id',auth()->user()->id)->get();
        return view('evidence_task.list',$data);
    }

    public function updateDecision($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = EvidenceTask::where('id',$id)->first();
        if(auth()->user()->id!=$data['data']->user_id)
        {
            return redirect()->route('dashboard');
        }
        return view('evidence_task.update',$data);
    }

    public function insertDecision(Request $request)
    {
        EvidenceTask::where('id',$request->id)->update([
            'status'=>$request->status,
            'remarks'=>$request->remarks,
            'status_update_date'=>$request->status_update_date,
        ]);
        Alert::success('Status updated successfully');
        return redirect()->back();
    }
}
