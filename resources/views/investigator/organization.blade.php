@extends('layouts.admin')
@section('content')
<br>
@include('investigator/mainheader')
    <!------------------------ end top part ---------------->  
<div class="col-sm-13" style="margin-top:-9px;">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                @include('tabs/investigator_tab')
            </div>
            <div class="card-body">
                @include('tabs/entity_tab')
                <div class="tab-content" id="custom-tabs-four-tabContent">
                       <br>
                        @if(Auth::user()->role == "Investigator")
                            <button type="button" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" style="float:right" onclick="showaddorganization()">
                            <span><i class="fa fa-plus"></i></span>    
                            <span style="font:face:Product Sans">Add Organization</span>
                        </button>
                        @endif
                        <br>
                        <div class="header" style="height:40px; border-radius:5px; margin-top:10px;">&nbsp;&nbsp;<font color='#000000' size="5.2" face="Product Sans"> Organization</font></div>
                        
                            <table class="table t2 ">
                                <thead>
                                    <tr>
                                        <th>Type</th>    
                                        <th>Name</th>
                                        <th>Location</th>                                                                        
                                        <th>Contact Person</th>                                                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($entityorganization->count())
                                        @foreach ($entityorganization as $organization)
                                            <tr>   
                                                <td>{{ $organization->organization_type }}</td>
                                                <td>
                                                    @if($organization->organization_type == "Government")
                                                        <?php echo $key=DB::table('tbl_agencynames_lookup')->where('agency_name_id',$organization->organization_name)->value('agency_name') ?>
                                                    @elseif($organization->organization_type == "Corporation")
                                                        <?php echo $key=DB::table('tbl_agencynames_lookup')->where('agency_name_id',$organization->organization_name)->value('agency_name') ?>
                                                    @else
                                                        {{ $organization->organization_name }}
                                                    @endif
                                                </td>
                                                <td>{{ $organization->business_location }}</td>                                                                        
                                                <td>{{ $organization->contact_person}}</td>
                                                <td>
                                                    <i style="color:gray" class="fa fa-eye" onclick="vieworganizationdetails('{{ $organization->id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="View Details"></i> &nbsp;
                                                    <i class="fa fa-pencil" style="color:grey" onclick="vieworganizationdetailsforedit('{{ $organization->id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="Edit Details"></i> &nbsp;
                                                &nbsp;
                                                    <a style="color:gray" href="{{ route('deleteorganization',$organization->id) }}" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Are you sure you want to delete this record?') || event.preventDefault();"><i class="fa fa-trash"></i></a></td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" style="text-align: center"> No record found </td>
                                            </tr>
                                        @endif
                                </tbody>
                            </table>
                </div>
            </div>
        </div>
</div>


<!--add modal -->
<form method = "POST" action="{{ route('savecaseorganization') }}" enctype="multipart/form-data">
    @csrf  
<div class="modal fade" id="addorganization" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add Organization</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><input type="hidden" name="organizationcasenoid" value="{{ $casenoid}}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Organization Type </label> &nbsp;&nbsp;
                                <input type="radio" name="organizationtype"  value="Business" onclick="showbusinessdiv();"> Business &nbsp;
                                <input type="radio" name="organizationtype" value="Government" onclick="showgovtdiv()"> Government  </label>
                                <input type="radio" name="organizationtype" value="Corporation" onclick="showcorporationdiv()"> Corporation  </label>
                        </div>
                    </div>
                    <br>
                                <div id="businessdiv" style="display:none">
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">License No&nbsp;<font color='red'>*</font></label>
                                                    <div class = "input-group">
                                                        <input name="businesslicenseno" id="businesslicenseno" class="form-control" type="text" placeholder="Search CID"/><button class ="search-btn" type="button" onclick="getDetailsByLicense()">Search</button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                <div id="showdetailsbusiness" style="display:none">
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Business Name&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="businessname" id="businessname"  class="form-control" type="text" placeholder="Search CID"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Location&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="businesslocation" id="businesslocation"  class="form-control" type="text" placeholder="Search CID"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Owners&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="businessowners" id="businessowners"  class="form-control" type="text" placeholder="Search CID"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">License Issue Date&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="businesslicenseissuedate" id="businesslicenseissuedate"  class="form-control" type="text" placeholder="Search CID"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">License Expiry Date&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="businesslicenseexpirydate" id="businesslicenseexpirydate"  class="form-control" type="text" placeholder="Search CID"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row">
                                        <div class   = "col-md-12">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Activity&nbsp;<font color='red'>*</font></label>
                                                <input type="text" value="xyz" readonly name="businessactivity" id="businessactivity"  class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Contact Details</h3>
                                    <br>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Contact Person&nbsp;<font color='red'>*</font></label>
                                                    <input name="businesscontactperson" id="businesscontactperson"  class="form-control" type="text" placeholder="Name"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Phone/Mobile Number&nbsp;<font color='red'>*</font></label>
                                                    <input name="businessphone" id="businessphone"  class="form-control" type="number" placeholder="Phone"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Email&nbsp;(optional)</label>
                                                    <input name="businessemail" id="businessemail"  class="form-control" type="text" placeholder="Email"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                </div>
                                <div id="govtdiv" style="display:none">
                                    
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Parent Agency&nbsp;<font color='red'>*</font></label>
                                                    <select class="form-control" name="govtparentagency" id="govtparentagency" >
                                                        <option value="">Select Agency Type</option>
                                                            @foreach ($parentagency as $pagency)
                                                                <option value="{{ $pagency->parent_agency_id }}">{{ $pagency->parent_agency }}</option>
                                                            @endforeach    
                                                    </select>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Agency Name&nbsp;<font color='red'>*</font></label>
                                                    <select class="form-control" name="govtagencyname" id="govtagencyname" >
                                                        <option value="">Select Agency Name</option>
                                                            @foreach ($agencyname as $agency)
                                                                <option value="{{ $agency->agency_name_id }}">{{ $agency->agency_name }}</option>
                                                            @endforeach    
                                                    </select>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Location&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="governmentlocation" id="governmentlocation"  class="form-control" type="text" placeholder="Search CID"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h3>Contact Details</h3>
                                    <br>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Contact Person&nbsp;<font color='red'>*</font></label>
                                                    <input name="govtcontactperson" id="govtcontactperson"  class="form-control" type="text" placeholder="Contact person"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Phone/Mobile Number&nbsp;<font color='red'>*</font></label>
                                                    <input name="govtcontactphone" id="govtcontactphone"  class="form-control" type="number" placeholder="Phone no"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Email&nbsp;(optional)</label>
                                                    <input name="govtcontactemail" id="govtcontactemail"  class="form-control" type="text" placeholder="Email"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div id="corporationdiv" style="display:none">
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Agency Name&nbsp;<font color='red'>*</font></label>
                                                    <select class="form-control" name="corpagencyname" id="corpagencyname" >
                                                        <option value="">Select Agency Name</option>
                                                            @foreach ($agencyname as $agency)
                                                                <option value="{{ $agency->agency_name_id }}">{{ $agency->agency_name }}</option>
                                                            @endforeach    
                                                    </select>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Location&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="corplocation" id="corplocation"  class="form-control" type="text" placeholder="Location"/>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Contact Details</h3>
                                    <br>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Contact Person&nbsp;<font color='red'>*</font></label>
                                                    <input name="corpcontactperson" id="corpcontactperson"  class="form-control" type="text" placeholder="Contact Person"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Phone/Mobile Number&nbsp;<font color='red'>*</font></label>
                                                    <input name="corpcontactphone" id="corpcontactphone"  class="form-control" type="number" placeholder="Phone No"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Email&nbsp;</label>
                                                    <input name="corpcontactemail" id="corpcontactemail"  class="form-control" type="text" placeholder="Email"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                          
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="return validateForm() ">Add</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end add modal -->

<!-- show entity details modal -->
<div class="modal fade" id="show_organization_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Organization Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="organizationid" id="organizationid">
                        <div id="organizationdetailsshow" style="display:none;"></div>
                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->
    <!-- show entity details modal -->
<div class="modal fade" id="show_organization_details_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Organization Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="organizationidedit" id="organizationidedit">
                        <div id="organizationdetailsshowedit" style="display:none;"></div>
                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->

<script>
	 function showaddorganization()
     {
        $('#addorganization').modal('show');
     }

     
    function showbusinessdiv() 
        {
            $('#businessdiv').show(1000); 
            $('#corporationdiv').hide();  
            $('#govtdiv').hide();                      
        }
    function showgovtdiv()
        {
            $('#businessdiv').hide(); 
            $('#corporationdiv').hide();  
            $('#govtdiv').show(1000); 
        }
    function showcorporationdiv()
        {
            $('#businessdiv').hide(); 
            $('#corporationdiv').show(1000);  
            $('#govtdiv').hide(); 
        }
    function getDetailsByLicense()
        {
            $('#showdetailsbusiness').show(700);
        }
    function vieworganizationdetails(id){
    
        $('#organizationid').val(id);
        $('#show_organization_details').modal('show');
    

        var url = '{{ route("showorganizationdetails", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#organizationid').val()},
                success: function(result) {
                    
                    $("#organizationdetailsshow").html(result);
                    $("#organizationdetailsshow").show();
                    
                }
            });
        }
        function vieworganizationdetailsforedit(id){
    
        $('#organizationidedit').val(id);
        $('#show_organization_details_edit').modal('show');
    

        var url = '{{ route("editorganizationdetails", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#organizationidedit').val()},
                success: function(result) {
                    
                    $("#organizationdetailsshowedit").html(result);
                    $("#organizationdetailsshowedit").show();
                    
                }
            });
        }
    function validateForm() {
        var organizationtype       = document.querySelector('input[name="organizationtype"]:checked');
        var businesslicenseno      = document.getElementById("businesslicenseno");
        var businesscontactperson  = document.getElementById("businesscontactperson");
        var businessphone          = document.getElementById("businessphone");
        var govtparentagency       = document.getElementById("govtparentagency");
        var govtagencyname         = document.getElementById("govtagencyname");
        var govtcontactperson      = document.getElementById("govtcontactperson");
        var govtcontactphone       = document.getElementById("govtcontactphone");
        
        var corpagencyname         = document.getElementById("corpagencyname");
        var corpcontactperson      = document.getElementById("corpcontactperson");
        var corpcontactphone       = document.getElementById("corpcontactphone");
        

        if (!organizationtype) {
            alert('Please select a organization type (Business/Government/Corporation).');
            return false; // Prevent form submission
        }

        if (organizationtype.value === "Business" ) {
            if (businesslicenseno.value === "") {
                alert("Please Enter License No");
                return false;
            }
            if(businesscontactperson.value === "")
            {
                alert("Please contact no");
                return false;
            }
            
            if (businessphone.value === "") {
                alert("Please Enter Phone No");
                return false;
            }
        }

        if (organizationtype.value === "Government") {
            if (govtparentagency.value === "") {
                alert("Please select Parent Agency");
                return false;
            }
            if(govtagencyname.value === "")
            {
                alert("Please select Agency Name");
                return false;
            }
            
            if (govtcontactperson.value === "") {
                alert("Please Enter Contact Person");
                return false;
            }
            if (govtcontactphone.value === "") {
                alert("Please Enter Phone no");
                return false;
            }
            
        }

        if (organizationtype.value === "Corporation") {
            if (corpagencyname.value === "") {
                alert("Please select Agency");
                return false;
            }
            if(corpcontactperson.value === "")
            {
                alert("Please enter contact person");
                return false;
            }
            
            if (corpcontactphone.value === "") {
                alert("Please Enter Phone no");
                return false;
            }
            
        }

        return true;
    }

    
</script>

<style>
    .modal-header {
    background: linear-gradient(to top, grey, #ffffff);
    color: #fff;
    border-radius: 5px 5px 0 0;
    font-family: Product Sans;
}
.t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
}
.search-btn {
  background-color: #337ab7;
  color: #fff;
  border: none;
  padding: 8px 16px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.search-btn:hover {
  background-color: #286090;
}

.search-btn:focus {
  outline: none;
}
</style>
@endsection