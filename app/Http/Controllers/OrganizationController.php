<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Alert;
use Redirect;
use DB;
use App\Models\CaseOrganization;

class OrganizationController extends Controller
{
    public function savecaseorganization(Request $request)
        {
            $data = $request->all();
            $type = $data['organizationtype'];
            $casenoid = $data['organizationcasenoid'];
                        
            if($type == "Business")
            {
                
                CaseOrganization::insert([
                        'business_license_no' => $data['businesslicenseno'],
                        'business_location' => $data['businesslocation'],
                        'business_owner' => $data['businessowners'],
                        'business_license_issue_date' => $data['businesslicenseissuedate'],
                        'business_license_expiry_date' => $data['businesslicenseexpirydate'],
                        'business_activity' => $data['businessactivity'],
                        'organization_name' => $data['businessname'],
                        'contact_person' => $data['businesscontactperson'],
                        'phone_no' => $data['businessphone'],
                        'email' => $data['businessemail'],
                        'organization_type'  => $type,
                        'case_no_id' => $casenoid,
                    ]);

                }
            
            if($type == "Government")
            {
            
                CaseOrganization::insert([
                        'parent_agency' => $data['govtparentagency'],
                        'organization_name' => $data['govtagencyname'],
                        'business_location' => $data['governmentlocation'],
                        'contact_person' => $data['govtcontactperson'],
                        'phone_no' => $data['govtcontactphone'],
                        'email' => $data['govtcontactemail'],
                        'organization_type'  => $type,
                        'case_no_id' => $casenoid,
                        
                    ]);
                }

            if($type == "Corporation")
                {
            
                CaseOrganization::insert([
                        'organization_name' => $data['corpagencyname'],
                        'business_location' => $data['corplocation'],
                        'contact_person' => $data['corpcontactperson'],
                        'phone_no' => $data['corpcontactphone'],
                        'email' => $data['corpcontactemail'],
                        'organization_type'  => $type,
                        'case_no_id' => $casenoid,
                        
                    ]);
                }

                Alert::success('Organization Added Successfully');
                    return Redirect::back(); 
            
        }

    public function showorganizationdetails(Request $request)
        {        
            $id = Route::current()->parameter('id');
            $orgdetailsshow =  CaseOrganization::where('id', $id)->get();
            
            return view('organization.showorganizationdetails',compact('orgdetailsshow'));
        }
    public function editorganizationdetails(Request $request)
        {        
            $id = Route::current()->parameter('id');
            $orgdetailsshow =  CaseOrganization::where('id', $id)->get();
            
            return view('organization.editorganizationdetails',compact('orgdetailsshow'));
        }
    
    public function deleteorganization(Request $request)
    {
            $id = Route::current()->parameter('id');

            CaseOrganization::where('id', $id)->delete();

            Alert::success('Delete Successful');
                        return Redirect::back(); 
            
    }
    
}
