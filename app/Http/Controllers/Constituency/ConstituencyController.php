<?php

namespace App\Http\Controllers\Constituency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use App\Models\Dzongkhag;
use App\Models\Complaint\constituencyModel;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class ConstituencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',16)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',16)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',16)->where('edit_option','Y')->first();

        $this->delete_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',16)->where('delete_option','Y')->first();


        
        return $next($request);
    });
  }


    public function index()
    {
        $permission = $this->view_option;
        $addpermission = $this->add_option;
        $editpermission = $this->edit_option;
        $deletepermission = $this->delete_option;
        if (@$permission && @$permission->view_option=="Y") {
        $data = [];
        $Dzonkhag = [];
        $data['data'] = constituencyModel::with('getDzongkhagDetails')->orderBy('constituencyID','desc')->where('isDelete',0)->get();
        $data['processing'] = Dzongkhag::where('isDelete',0)->get();
        if(@$addpermission->add_option=="Y")
        {
            $data['add'] = 'Y';
        }else{
            $data['add'] = 'N';
        }

        if(@$editpermission->edit_option=="Y")
        {
            $data['edit'] = 'Y';
        }else{
            $data['edit'] = 'N';
        }

        if(@$deletepermission->delete_option=="Y")
        {
            $data['delete'] = 'Y';
        }else{
            $data['delete'] = 'N';
        }
        // dd($data);
        return view('constituency.list', $data);
        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  dd($request);
         $dzonkhag = new constituencyModel();
         $dzonkhag->constituencyName = $request->constituencyName;
         $dzonkhag->DzoID = $request->DzoID;
         $dzonkhag->isDelete = 0;
         $dzonkhag->save();
 
         Alert::success('You\'ve Successfully Added A Constituency ');
         return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteConsti($id){
        // dd($id);
        constituencyModel::where(['constituencyID' => $id])->delete();
        Alert::success(' constituency Deleted Successfully');
        return redirect()->back();
    }

    public function EditConstituency(Request $request){
        // dd($request);
        $person = new constituencyModel;
        $person->where(['constituencyID' => $request->constituencyID])->update([
            'DzoID' => $request->DzoID,
            'constituencyName' => $request->constituencyName
        ]);

        Alert::success(' constituency Updated Successfully');
        return redirect()->back();
    }
}
