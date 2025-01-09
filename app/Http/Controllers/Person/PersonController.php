<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Complaint\personCategoryModel;
use App\Models\Complaint\personModel;
use App\Models\Complaint\GenderModel;
use App\Models\Dzongkhag;
use App\Models\Gewog;
use App\Models\Village;
use Redirect;
use Alert;
use App\Models\Complaint\linkComplaintPersonModel;
use App\Models\Complaint\complaintRegistrationModel;
use App\Models\Complaint\complaintReceivedByModel;
use App\Models\Complaint\ComplaintAssignUser;
use App\Models\Complaint\RegionalOffice;
use App\Models\User;
use App\Models\Complaint\Attachment;
use App\Models\Complaint\link_Repeated_Complaint;
use App\Models\UserToRole;
use App\Models\RolePermission;
class PersonController extends Controller
{

    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',7)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',7)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',7)->where('edit_option','Y')->first();


        
        return $next($request);
    });
  }



    public function index()
    {
        $permission = $this->view_option;
        $addpermission = $this->add_option;
        $editpermission = $this->edit_option;

        
        if (@$permission && @$permission->view_option=="Y") {

        $data = [];
        $data['data'] = personModel::get();

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


        return view('personManage.index',$data);

        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function add()
    {
        $addpermission = $this->add_option;
        if(@$addpermission->add_option=="Y"){
        $data = [];
        $data['dzongkhag'] = Dzongkhag::get();
        $data['gender'] = GenderModel::get();
        return view('personManage.add',$data);
        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function insert(Request $request)
    {
        
        $newperson = new personModel;
        $newperson->uniqueID = md5(microtime());
        $newperson->fname = $request->fname;
        $newperson->mname = $request->mname;
        $newperson->lname = $request->lname;
        if (@$request->Nationlityradio=="1") {
           $newperson->cid = $request->PIcid;
           $newperson->permAddDzongkhag = $request->permAddDzongkhag;
           $newperson->permAddGewog = $request->permAddGewog; 
           $newperson->permAddVillage = $request->permAddVillage;

           $newperson->permAddHouse_no = $request->permAddHouse_no; 
           $newperson->permAddThram_no = $request->permAddThram_no; 
        }else{
            // return $request;
            $newperson->otherIdentificationNo = $request->otherIdentification;
        }
        $newperson->gender = $request->gender;
        $newperson->employID = $request->empID;
        $newperson->dob = $request->DOB;

        $newperson->birthPlace = $request->birthPlace;
        $newperson->nationality = $request->nationality;
        $newperson->religion = $request->religion;
        // $newperson->gender = $request->gender;

        $newperson->blood_group = $request->blood_group;
        $newperson->height = $request->height;
        $newperson->weight = $request->weight;
        $newperson->remarks = $request->remarks;


        $newperson->save();
        Alert::success('You\'ve Successfully Added A Person');
        return redirect()->route('manage.person.linked.view',$newperson->personID);


    }


    public function edit($id)
    {
        $editpermission = $this->edit_option;
        if(@$editpermission->add_option=="Y"){
        $data = [];
        $data['data'] = personModel::where('personID',$id)->first(); 
        $data['dzongkhag'] = Dzongkhag::get();
        $data['gewog'] = Gewog::get();
        $data['village'] = Village::get();
        $data['gender'] = GenderModel::get();
        return view('personManage.edit',$data);
        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }

    }

    public function insupdateert(Request $request)
    {
        
         if (@$request->Nationlityradio=="1") {

           $cid = $request->PIcid;
           $permAddDzongkhag = $request->permAddDzongkhag;
           $permAddGewog = $request->permAddGewog; 
           $permAddVillage = $request->permAddVillage;
           $otherIdentificationNo = '';
           $permAddHouse_no = $request->permAddHouse_no; 
           $permAddThram_no = $request->permAddThram_no; 
         }else{
           $cid = '';
           $permAddDzongkhag = '';
           $permAddGewog = ''; 
           $permAddVillage = '';
           $otherIdentificationNo = $request->otherIdentification;
           $permAddHouse_no = ''; 
           $permAddThram_no = '';
         }

         // return $cid;
         personModel::where('personID',$request->personID)->update([
            'fname'=>$request->fname,
            'mname'=>$request->mname,
            'lname'=>$request->lname,
            'cid'=>$cid,
            'permAddDzongkhag'=>$permAddDzongkhag,

            'permAddGewog'=>$permAddGewog,
            'permAddVillage'=>$permAddVillage,
            'permAddHouse_no'=>$permAddHouse_no,
            'permAddThram_no'=>$permAddThram_no,
            'otherIdentificationNo'=>$otherIdentificationNo,


            'gender'=>$request->gender,
            'employID'=>$request->empID,
            'dob'=>$request->DOB,
            'birthPlace'=>$request->birthPlace,
            'nationality'=>$request->nationality,

            'religion'=>$request->religion,
            'blood_group'=>$request->blood_group,
            'height'=>$request->height,
            'weight'=>$request->weight,
            'remarks'=>$request->remarks,


         ]);

        Alert::success('You\'ve Successfully Updated A Person');
        return redirect()->back();


    }

    public function viewDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = personModel::where('personID',$id)->first();
        return view('personManage.view',$data);
    }

    public function viewDetailsComplaint($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = linkComplaintPersonModel::where('personID',$id)->get();
        return view('personManage.complaint',$data);
    }

    public function complaint($id)
    {
        $data = [];
        $data['data'] = complaintRegistrationModel::where('complaintID',$id)->first();
        $data['id'] = $id;
        $data['received_users'] = complaintReceivedByModel::where('complaintID',$id)->get();
        $data['user'] = User::get();
        $data['regional_office'] = RegionalOffice::get();
        $data['assignUsers'] = ComplaintAssignUser::where('complaint_id',$id)->pluck('user_id')->toArray();
        return view('personManage.complaint_view',$data);
    }

    public function complaintattach($id)
    {
        $data = [];
        $data['data'] = Attachment::where('complaintID',$id)->get();
        $data['id'] = $id;
        return view('personManage.attachment',$data);
    }

    public function person($id)
    {
        $data = [];
        $data['person'] =   DB::table('cr_linkcomplaint_person_category')
            ->LeftJoin('tblperson', 'cr_linkcomplaint_person_category.personID', '=', 'tblperson.personID')
            ->LeftJoin('cr_pltblpersoncategory', 'cr_pltblpersoncategory.personCategoryID', '=', 'cr_linkcomplaint_person_category.personCatID')
            ->LeftJoin('cr_tblcomplaintregistration', 'cr_linkcomplaint_person_category.complaintID', '=', 'cr_tblcomplaintregistration.complaintID')
            ->select('tblperson.personID', 'tblperson.fname', 'tblperson.mname', 'tblperson.lname', 'tblperson.cid', 'tblperson.otherIdentificationNo', 'cr_pltblpersoncategory.categoryName')
            ->where(['cr_linkcomplaint_person_category.complaintID' => $id, 'tblperson.isDelete' => 0])
            ->get();
            $data['id'] = $id;
        return view('personManage.person_involved',$data);
    }

    public function caseLink($id)
    {
        $data = [];
        $data['person_involved'] = link_Repeated_Complaint::where('newComplaintID',$id)->where('isDelete','0')->with('repeatedComplaint_registrationRelation','repeatedComplaint_registrationRelation.complaintmoderelation','repeatedComplaint_registrationRelation.complaintTyperelation')->get();
        $data['id'] = $id;
        return view('personManage.case_link',$data);
    }

    public function linkedPerson($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['category'] = personCategoryModel::get();
        $data['data'] = linkComplaintPersonModel::where('personID',$id)->get();
        return view('personManage.linked',$data);
    }

    public function linkedPersonInsert(Request $request)
    {
        $reg = complaintRegistrationModel::where('complaintRegNo',$request->complaintID)->first();
        $check = linkComplaintPersonModel::where('personID',$request->personID)->where('complaintID',$reg->complaintID)->first();
        if ($check) {
            Alert::error('Link already added');
            return redirect()->back();
        }else{
            $linkcomplaintPerson = new linkComplaintPersonModel;
            $linkcomplaintPerson->complaintID = $reg->complaintID;
            $linkcomplaintPerson->personID = $request->personID;
            $linkcomplaintPerson->personCatID = $request->personCategory;
            $linkcomplaintPerson->save();
            Alert::success('You\'ve Successfully Linked A Person In A Complaint');
            return redirect()->back();
        }
    }

    public function linkedPersonDelete($id)
    {
        linkComplaintPersonModel::where('linkComplaintPersonCatID',$id)->delete();
        Alert::success('You\'ve Successfully Delete A Person From A Complaint');
       return redirect()->back();
    }

    public function imageUploadView($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = personModel::where('personID',$id)->first();
        return view('personManage.image',$data);
    }

    public function imageUpload(Request $request)
    {
        $upd = [];
        if ($request->hasFile('image')){
           $image = $request->image;
           $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
           $image->move("storage/app/public/person",$filename);
           $upd['userPic'] = $filename;
           personModel::where('personID',$request->personID)->update($upd);
        }
        Alert::success('Data updated successfully');
       return redirect()->back();
    }

    public function checkCid(Request $request)
    {
        if($request->id)
        {
            $check = personModel::where('cid',$request->cid)->where('personID','!=',$request->id)->first();
            if (@$check!="") {
                return 'found';
            }else{
                return 'notfound';
            }
        }else{
            $check = personModel::where('cid',$request->cid)->first();
            if (@$check!="") {
                return 'found';
            }else{
                return 'notfound';
            }
        }
    }

    public function checkOther(Request $request)
    {
        if($request->id)
        {
            $check = personModel::where('otherIdentificationNo',$request->otherIdentification)->where('personID','!=',$request->id)->first();
            if (@$check!="") {
                return 'found';
            }else{
                return 'notfound';
            }
        }else{
            $check = personModel::where('otherIdentificationNo',$request->otherIdentification)->first();
            if (@$check!="") {
                return 'found';
            }else{
                return 'notfound';
            }
        }
    }
}
