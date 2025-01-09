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
                              Person
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('ip_details.head_navbar')

                                    <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.entities.intel')) active btn btn-success @endif"  href="{{route('manage.ip.lists.head.chief.details.entities.intel',@$id)}}">Person</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.entities.intel.organization')) active btn btn-success @endif"  href="{{route('manage.ip.lists.head.chief.details.entities.intel.organization',@$id)}}"> Organization</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.entities.intel.asset')) active btn btn-success @endif"  href="{{route('manage.ip.lists.head.chief.details.entities.intel.asset',@$id)}}"> Asset</a>
                                    </li>
                                </ul>
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Profile Pic</th>
                                        <th>Name</th>
                                        <th>Identification No</th>  
                                        <th>Nationality</th> 
                                        <th>Gender</th>
                                        <th>Phone No</th> 
                                        <th>Type</th> 
                                        <th>Action</th>           
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach(@$entityperson as $person)
                                    <tr>
                                        <td>
                                            @if($person->photo_name == "")
                                            No Photo Available
                                            @else

                                            <img src="{{ asset('Entity/' .$person->id.'/' .$person->photo_name) }}"  class="rounded-circle header-profile-user" alt="User Image" style="height:35px;width:35px;" onclick="showBiggerImage('{{ asset('Entity/' .$person->id.'/' .$person->photo_name) }}')"></td>
                                            @endif
                                        <td>{{ $person->name }}</td>
                                        <td>{{ $person->identification_no }}</td> 
                                        <td>{{ $person->type }}</td>
                                        <td>{{ $person->gender }}</td>
                                        <td>{{ $person->contactno }}</td> 
                                        <td>{{ $person->entitytype }}</td>                                                                           
                                        <td>
                                            {{-- <i class="fa fa-pencil" style="color:grey" onclick="viewentitydetailsforedit('{{ $person->id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="Edit Details"></i> &nbsp; --}}
                                            <i class="fa fa-eye" style="color:grey" onclick="viewentitydetailscoi('{{ $person->id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="View Details"></i> &nbsp;
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                   
                                   @foreach(@$prev_suspect as $att)
                                        <tr>
                                        <td>@if(@$att->photo!="") <img src="{{URL::to('attachment/ir')}}/{{$att->photo}}" style="width:80px;height: 80px;"> @else No Photo Found @endif</td>

                                        <td>{{ $att->name }}</td>
                                        <td>@if(@$att->nationality=="B") {{ @$att->cid }} @else {{ @$att->identity }} @endif</td> 
                                        <td>@if(@$att->nationality=="B")National @else Non-National @endif</td>
                                        <td>--</td>
                                        <td>{{ $att->phone_number }}</td> 
                                        <td>Suspect</td>   
                                        <td></td>
                                    </tr>
                                    @endforeach
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>

     <!-- ADD Person -->
   

<!-- FINISH ADD Person -->
<!-- show entity details modal -->
<div class="modal fade" id="show_entity_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Entity Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value=""  name="entityidcoi" id="entityidcoi">
                        <div id="entitydetailsshow" style="display:none;"></div>
                            
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


        function viewentitydetailscoi(id){
    
        $('#entityidcoi').val(id);
        $('#show_entity_details').modal('show');
    

        var url = '{{ route("member.get.information.report.assignment.entities.person.manage.view.person.Details", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#entityidcoi').val()},
                success: function(result) {
                    
                    $("#entitydetailsshow").html(result);
                    $("#entitydetailsshow").show();
                    
                }
            });
        }





function showBiggerImage(imageSrc) {
  // Get the modal and the image elements
  var modal = document.getElementById('enlargedImgModal');
  var img = document.getElementById('enlargedImg');
  var closeBtn = document.getElementById('closeBtn');

  // Set the image source to the clicked image source
  img.src = imageSrc;

  // Show the modal and close button
  modal.style.display = 'block';
  closeBtn.style.display = 'block';
}

// Function to close the modal when the user clicks the close button
function closeBiggerImage() {
  var modal = document.getElementById('enlargedImgModal');
  var closeBtn = document.getElementById('closeBtn');

  // Hide the modal and close button
  modal.style.display = 'none';
  closeBtn.style.display = 'none';
}

// Function to close the modal when the user clicks outside the image or close button
window.onclick = function(event) {
  var modal = document.getElementById('enlargedImgModal');
  if (event.target === modal) {
    closeBiggerImage();
  }
};

   function validateForm() {
    var persontype           = document.querySelector('input[name="persontype"]:checked');
    var bhutanesecid         = document.getElementById("bhutanesecid");
    var nonbhutanesepermit   = document.getElementById("nonbhutanesepermit");
    var bhutanesephoto       = document.getElementById("bhutanesephoto");
    var bhutaneseaddress     = document.getElementById("bhutaneseaddress");
    var bhutanesephone       = document.getElementById("bhutanesephone");
    var bhutanesepartytype   = document.getElementById("bhutanesepartytype");
    var bhutaneseinvolvement = document.getElementById("bhutaneseinvolvement");
    
    var nonbhutanesephoto       = document.getElementById("nonbhutanesephoto");
    var nonbhupermanentaddress = document.getElementById("nonbhutanesepermanentaddress");
    var nonbhutaneseaddress     = document.getElementById("nonbhutaneseaddress");
    var nonbhutanesephone       = document.getElementById("nonbhutanesephone");
    var nonbhutanesepartytype   = document.getElementById("nonbhutanesepartytype");
    var nonbhutaneseinvolvement = document.getElementById("nonbhutaneseinvolvement");

    if (!persontype) {
        alert('Please select a person type (Bhutanese or Non Bhutanese).');
        return false; // Prevent form submission
    }

    if (persontype.value === "Bhutanese" ) {
        if (bhutanesecid.value === "") {
            alert("Please Enter CID");
            return false;
        }
        if(bhutanesephoto.value === "")
        {
            alert("Please Upload Photo");
            return false;
        }
        
        if (bhutaneseaddress.value === "") {
            alert("Please Enter Address");
            return false;
        }
        if (bhutanesephone.value === "") {
            alert("Please Enter Phone No");
            return false;
        }
        if(bhutanesepartytype.value === "")
        {
            alert("Please select Association Type");
            return false;
        }
        if(bhutaneseinvolvement.value === "")
        {
            alert("Please enter Involvement");
            return false;
        }
    }

    if (persontype.value === "Non Bhutanese") {
        if (nonbhutanesepermit.value === "") {
            alert("Please Enter Work Permit number");
            return false;
        }
        if(nonbhutanesephoto.value === "")
        {
            alert("Please Upload Photo");
            return false;
        }
        
        if (nonbhupermanentaddress.value === "") {
            alert("Please Enter Permanent Address");
            return false;
        }
        if (nonbhutaneseaddress.value === "") {
            alert("Please Enter Address");
            return false;
        }
        if (nonbhutanesephone.value === "") {
            alert("Please Enter Phone No");
            return false;
        }
        if(nonbhutanesepartytype.value === "")
        {
            alert("Please select Association Type");
            return false;
        }
        if(nonbhutaneseinvolvement.value === "")
        {
            alert("Please enter Involvement");
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