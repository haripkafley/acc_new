<?php

namespace App\Http\Controllers\Village;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Gewog;
use App\Models\Village;
use App\Models\Dzongkhag;
use Alert;
use Redirect;
use App\Models\UserToRole;
use App\Models\RolePermission;


class VillageController extends Controller
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
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',15)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',15)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',15)->where('edit_option','Y')->first();

        $this->delete_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',15)->where('delete_option','Y')->first();


        
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
        $data['data'] = Village::with('getGewogDetails')->orderBy('villageID','desc')->where('isDelete',0)->get();
        $data['processing'] = Gewog::where('isDelete',0)->get();
        $data['processingDz'] = Dzongkhag::where('isDelete',0)->get();
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
        return view('village.list', $data);
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
        // dd($request);
        $dzonkhag = new Village();
        $dzonkhag->villageName = $request->villageName;
        $dzonkhag->dzoID = $request->dzooID;
        $dzonkhag->gewogID = $request->gewogID;
        $dzonkhag->isDelete = 0;
        $dzonkhag->save();

        Alert::success('You\'ve Successfully Added A Gewog ');
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

    public function deleteVj($id){
        // dd($id);
        Village::where(['villageID' => $id])->delete();
        Alert::success(' Village Deleted Successfully');
        return redirect()->back();
    }

    public function gewoglistAsperDzongkhag($id){
        $data = Gewog::where('isDelete',0)->where('dzoID',$id)->get();
        return $data;
    }

    public function EditVillage(Request $request){
        // dd($request);
        $person = new Village;
        $person->where(['villageID' => $request->villageID])->update([
            'DzoID' => $request->dzooID,
            'gewogID' => $request->gewogID,
            'villageName' => $request->villageNamea
        ]);

        Alert::success(' Village Updated Successfully');
        return redirect()->back();
    }
}
