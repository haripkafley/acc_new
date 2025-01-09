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
                              
                                
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('tacktical.head.navbar')
                            <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page',@$id)}}">Person</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page.organisation')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page.organisation',@$id)}}"> Organization</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page.asset')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page.asset',@$id)}}"> Asset</a>
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