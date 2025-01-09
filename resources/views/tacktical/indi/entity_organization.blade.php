@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> 
                        {{-- Embassy List --}}
                        <div class="row" style="font-family:Product Sans">
                            <div class="col-sm">
                              Organization
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              @if(@$check->report_status!="A")
                                <button type="button" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" style="float:right" onclick="showaddorganization()">
                            <span><i class="fa fa-plus"></i></span>    
                            <span style="font:face:Product Sans">Add Organization</span>
                        </button>
                        @endif
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('tacktical.indi.navbar')
                            <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.ti-entity.information.page')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.individual.ti-entity.information.page',@$id)}}">Person</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.ti-entity.information.organization.page')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.individual.ti-entity.information.organization.page',@$id)}}"> Organization</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.ti-entity.information.asset.page')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.individual.ti-entity.information.asset.page',@$id)}}"> Asset</a>
                                    </li>
                                </ul>
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
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
                                                    {{-- <i class="fa fa-pencil" style="color:grey" onclick="vieworganizationdetailsforedit('{{ $organization->id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="Edit Details"></i> --}} &nbsp;
                                                &nbsp;
                                                @if(@$check->report_status!="A")
                                                    <a style="color:gray" href="{{ route('tacktical.inteligence.autorization.individual.ti-entity.information.organization.page.delete.data',$organization->id) }}" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Are you sure you want to delete this record?') || event.preventDefault();"><i class="fa fa-trash"></i></a></td>
                                                    @endif
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
<form method = "POST" action="{{ route('tacktical.inteligence.autorization.individual.ti-entity.information.organization.page.insert.data') }}" enctype="multipart/form-data">
    @csrf  
<div class="modal fade" id="addorganization" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add Organization</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><input type="hidden" name="organizationcasenoid" value="{{ $id}}">
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
                                                        <input name="businesslicenseno" id="businesslicenseno" class="form-control" type="text" placeholder="Search License No"/><button class ="search-btn" type="button" onclick="getDetailsByLicense()">Search</button>
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
                                                    <input  name="businessname" id="businessname"  class="form-control" type="text" placeholder="Business Name"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Location&nbsp;<font color='red'>*</font></label>
                                                    <input  name="businesslocation" id="businesslocation"  class="form-control" type="text" placeholder="Location"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Owners&nbsp;<font color='red'>*</font></label>
                                                    <input  name="businessowners" id="businessowners"  class="form-control" type="text" placeholder="Owners"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">License Issue Date&nbsp;<font color='red'>*</font></label>
                                                    <input  name="businesslicenseissuedate" id="businesslicenseissuedate"  class="form-control" type="date" placeholder="License Issue Date"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">License Expiry Date&nbsp;<font color='red'>*</font></label>
                                                    <input  name="businesslicenseexpirydate" id="businesslicenseexpirydate"  class="form-control" type="date" placeholder="Search CID"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row">
                                        <div class   = "col-md-12">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Activity&nbsp;<font color='red'>*</font></label>
                                                <input type="text"  name="businessactivity" id="businessactivity"  class="form-control" >
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
                                                    <input  name="governmentlocation" id="governmentlocation"  class="form-control" type="text" placeholder="Location"/>
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
                                                    <input  name="corplocation" id="corplocation"  class="form-control" type="text" placeholder="Location"/>
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


</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    

        var url = '{{ route("tacktical.inteligence.autorization.individual.ti-entity.information.organization.page.show.data", ":id") }}';
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
/* Style for the modal container */
#enlargedImgModal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black background */
  z-index: 9999; /* Make the modal appear on top of other content */
  overflow: auto;
}

/* Style for the enlarged image */
#enlargedImg {
  display: block;
  max-width: 90%;
  max-height: 90%;
  margin: 50px auto; /* Center the image vertically and horizontally */
}

/* Style for the close button */
#closeBtn {
  display: none;
  position: absolute;
  top: 10px;
  right: 10px;
  color: #fff;
  font-size: 30px;
  cursor: pointer;
}

/* Style for the close button on hover */
#closeBtn:hover {
  color: #ff0000; /* Change the color to red on hover */
}

    .modal-header {
    background: linear-gradient(to top, grey, #ffffff);
    color: #fff;
    border-radius: 5px 5px 0 0;
    font-family: Product Sans;
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

.t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
}
</style>



@endsection