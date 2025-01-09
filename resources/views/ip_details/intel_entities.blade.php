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
                              
                                <button type="button" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" style="float:right" onclick="showaddperson()">
                                    <span><i class="fa fa-plus"></i></span>    
                                    <span style="font:face:Product Sans">Add Person</span>
                                </button>
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('ip_details.member_navbar')

                                    <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('member.get.information.report.assignment.entities.person.manage')) active btn btn-success @endif"  href="{{route('member.get.information.report.assignment.entities.person.manage',@$id)}}">Person</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('member.get.information.report.assignment.entities.organization.manage')) active btn btn-success @endif"  href="{{route('member.get.information.report.assignment.entities.organization.manage',@$id)}}"> Organization</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('member.get.information.report.assignment.entities.asset.manage')) active btn btn-success @endif"  href="{{route('member.get.information.report.assignment.entities.asset.manage',@$id)}}"> Asset</a>
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
                                            <a style="color:grey" href="{{ route('member.get.information.report.assignment.entities.person.manage.delete.person.Details',$person->id) }}" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Are you sure you want to delete this record?') || event.preventDefault();"><i class="fa fa-trash"></i></a> &nbsp;
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
   <form  method = "POST" action="{{ route('member.get.information.report.assignment.entities.person.manage.savepersonDetails') }}" enctype="multipart/form-data">
    @csrf 
<div class="modal fade" id="addpersondiv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add Person</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Individual Type: </label><br> &nbsp;&nbsp;
                                    <input type="radio" name="persontype"  value="Bhutanese" onclick="showbhutanesediv();"> Bhutanese &nbsp;
                                    <input type="radio" name="persontype" value="Non Bhutanese" onclick="shownonbhutanesediv()"> Non Bhutanese  </label>
                                    <input type="hidden" name="personcasenoidadd" id="personcasenoidadd" value="{{ $id }}">
                            </div>
                        </div>
                        <br>
                        <div id="bhutanesediv" style="display:none"> 
                            <input type="hidden" name="token" id="token" value="d4f6b858-8c7e-3ec7-ab7a-8f6c610a48c4"><br>
                                <div class= "row"> 
                                    <div class   = "col-md-6">
                                        <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">CID&nbsp;<font color='red'>*</font></label>
                                                <div class = "input-group">
                                                    <input name="bhutanesecid" id="bhutanesecid" class="form-control" type="text" placeholder="Search CID"/><button class ="search-btn" type="button" onclick="checkcid('{{ $id }}');">Search</button>
                                                </div>    
                                        </div>
                                    </div>
                                </div>
                            <br>
                            <div id="showcitizendetailsbhutanese" style="display:none">
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Photo&nbsp;<font color='red'>*</font>(accepted format: jpg,jpeg,png,gif)</label>
                                                    <input  name="bhutanesephoto" id="bhutanesephoto"  class="form-control" type="file" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Name&nbsp;<font color='red'>*</font></label>
                                                    <input   name="bhutanesename" id="bhutanesename"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Gender&nbsp;<font color='red'>*</font></label>
                                                    <input  name="bhutanesegender" id="bhutanesegender"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Date of Birth&nbsp;<font color='red'>*</font></label>
                                                    <input   name="bhutanesedob" id="bhutanesedob"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Dzongkhag&nbsp;<font color='red'>*</font></label>
                                                    <input   name="bhutanesedzongkhag" id="bhutanesedzongkhag"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Gewog&nbsp;<font color='red'>*</font></label>
                                                    <input   name="bhutanesegewog" id="bhutanesegewog"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Village&nbsp;<font color='red'>*</font></label>
                                                    <input   name="bhutanesevillage" id="bhutanesevillage"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Contact Details</h3>
                                    <br>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Address&nbsp;<font color='red'>*</font></label>
                                                    <input name="bhutaneseaddress" id="bhutaneseaddress"  class="form-control" type="text" placeholder="Current Address"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Phone/Mobile Number&nbsp;<font color='red'>*</font></label>
                                                    <input name="bhutanesephone" id="bhutanesephone"  class="form-control"  type="number" placeholder="Mobile No" title="Please enter exactly 8 digits" oninput="javascript: if (this.value.length > 8) this.value = this.value.slice(0, 8);">
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Email&nbsp;</label>(optional)
                                                    <input name="bhutaneseemail" id="bhutaneseemail"  class="form-control" type="text" placeholder="Email"/>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Involvement</h3>
                                    <br>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Association Type&nbsp;<font color='red'>*</font></label>
                                                    <select class="form-control" name="bhutanesepartytype" id="bhutanesepartytype" >
                                                        <option value="">Select Association Type</option>
                                                            @foreach ($partytypes as $ptypes)
                                                                <option value="{{ $ptypes->party_type}}">{{ $ptypes->party_type }}</option>
                                                            @endforeach    
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-12">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Involvement&nbsp;<font color='red'>*</font></label>
                                                    <textarea name="bhutaneseinvolvement" id="bhutaneseinvolvement"  class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>
                            <br>
                            <div  id="nonbhutanesediv" style="display:none"> 
                                <div class= "row"> 
                                    <div class   = "col-md-6">
                                        <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">Work Permit&nbsp;<font color='red'>*</font></label>
                                                <div class = "input-group">
                                                        <input name="nonbhutanesepermit" id="nonbhutanesepermit" class="form-control" type="text" placeholder="Search CID"/><button class ="search-btn" type="button" onclick="getDetailsByPermit();">Search</button>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div id="showcitizendetailsnonbhutanese" style="display:none">
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Photo&nbsp;<font color='red'>*</font>(accepted format: jpg,jpeg,png,gif)</label>
                                                    <input  name="nonbhutanesephoto" id="nonbhutanesephoto"  class="form-control" type="file" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Name&nbsp;<font color='red'>*</font></label>
                                                    <input  name="nonbhutanesename" id="nonbhutanesename"  class="form-control" type="text" placeholder="Enter Name"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Gender&nbsp;<font color='red'>*</font></label>
                                                    <input  name="nonbhutanesegender" id="nonbhutanesegender"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Date of Birth&nbsp;<font color='red'>*</font></label>
                                                    <input name="nonbhutanesedob" id="nonbhutanesedob"  class="form-control" type="date" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h3>Permanent Address</h3>
                                    <div class= "row">
                                        <div class   = "col-md-12">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Address&nbsp;<font color='red'>*</font></label>
                                                <textarea name="nonbhutanesepermanentaddress" id="nonbhutanesepermanentaddress"  class="form-control" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Contact Details</h3>
                                    <br>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Address&nbsp;<font color='red'>*</font></label>
                                                    <input name="nonbhutaneseaddress" id="nonbhutaneseaddress"  class="form-control" type="text" placeholder="Address"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Phone/Mobile Number&nbsp;<font color='red'>*</font></label>
                                                    <input name="nonbhutanesephone" id="nonbhutanesephone"  class="form-control" type="number" placeholder="Mobile No"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Email&nbsp;(optional)</label>
                                                    <input name="nonbhutaneseemail" id="nonbhutaneseemail"  class="form-control" type="text" placeholder="Email"/>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Involvement</h3>
                                    <br>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Association Type&nbsp;<font color='red'>*</font></label>
                                                    <select class="form-control" name="nonbhutanesepartytype" id="nonbhutanesepartytype" >
                                                        <option value="">Select Association Type</option>
                                                            @foreach ($partytypes as $ptypes)
                                                                <option value="{{ $ptypes->party_type }}">{{ $ptypes->party_type }}</option>
                                                            @endforeach    
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-12">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Involvement&nbsp;<font color='red'>*</font></label>
                                                    <textarea name="nonbhutaneseinvolvement" id="nonbhutaneseinvolvement"  class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                            </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary"  name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" onclick="return validateForm()" title="Save" >Save</button> 
                </div>
            </div>
        </div>
    </div>
</form>

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
<!-- show entity details modal -->
<form  method = "POST" action="{{ route('member.get.information.report.assignment.entities.person.manage.savepersonDetails') }}" enctype="multipart/form-data">
    @csrf 
<div class="modal fade" id="show_entity_details_view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Entity Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden"  name="entityidedit" id="entityidedit">
                        <div id="entitydetailseditshow" style="display:none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Update</button>
                </div>
            </div>
        </div>
    </div>
</form>


</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    function showaddperson()
        {
            $('#addpersondiv').modal('show'); 
        }
        
    function closeaddperson()
        {
            $('#persondiv').hide();
            $('#addperson').show();
            $('#indexbhutanese').show();
        }
    function showbhutanesediv() 
        {
            $('#bhutanesediv').show(1000); 
            $('#nonbhutanesediv').hide();                       
        }

    function shownonbhutanesediv()
        {
            $('#bhutanesediv').hide()
            $('#nonbhutanesediv').show(1000);
        }

    
        
    function getDetailsByPermit()
        {
            var permit = $('#nonbhutanesepermit').val();
         if(permit == "")
         {
            alert("Please enter work permit number");
         }
         else
         {
            $('#showcitizendetailsnonbhutanese').show(700);
         }
        }
        
        function gettoken()
       {
         var cid = $('#bhutanesecid').val();
         if(cid == "")
         {
            alert("Please enter CID");
         }
         else
         {
         var url = "{{ route('gettoken')}}";
            $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: url,
            success: function (data) {
                console.log(data);
                $('#token').val(data);
            },
            error: function() { 
                console.log('error');
            }
        });

        getDetailsByCID();
       }
    }
    function getDetailsByCID(){
        // console.log(_token);
         var cid = $('#bhutanesecid').val();
         var token = $('#token').val();
        // console.log(cid);
        $('#showcitizendetailsbhutanese').show(700);
        var settings = {
            "url": "https://apim.staging.api.gov.bt/dcrc_citizen_details_api/1.0.0/citizendetails/"+cid,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Authorization": "Bearer " + token,
                // "Cookie": "route=1658042636.829.53.968004"
            },
        };

        $.ajax(settings).done(function (response) {
            console.log(response.citizenDetailsResponse);
            var data = response.citizenDetailsResponse.citizenDetail[0];
            var middlename;
          if(response.citizenDetailsResponse.citizenDetail[0].middleName == null){
                middlename = '';
            } else {
                middlename = response.citizenDetailsResponse.citizenDetail[0].middleName;
            }
            if(response.citizenDetailsResponse.citizenDetail[0].gender == 'F'){
                gender = 'Female';
            } else {
                 gender = 'Male';
            }

            var dobString = response.citizenDetailsResponse.citizenDetail[0].dob;
            var parts = dobString.split('/');

            if (parts.length === 3) {
            var year = parts[2];
            var month = String(parts[1]).padStart(2, '0'); 
            var day = String(parts[0]).padStart(2, '0'); 

            var sqlFormattedDate = year + '-' + month + '-' + day;
            }
            if(response.citizenDetailsResponse.citizenDetail.length >= 0){
                
                $("#bhutanesename").val(response.citizenDetailsResponse.citizenDetail[0].firstName +' '+ middlename +' '+ response.citizenDetailsResponse.citizenDetail[0].lastName); 
                $("#bhutanesedzongkhag").val(response.citizenDetailsResponse.citizenDetail[0].dzongkhagName); 
                $("#bhutanesevillage").val(response.citizenDetailsResponse.citizenDetail[0].gewogName); 
                $("#bhutanesegewog").val(response.citizenDetailsResponse.citizenDetail[0].villageName);
                $("#bhutanesedob").val(sqlFormattedDate); 
                $("#bhutanesegender").val(gender);  
                 
            } else {
                alert('No details found');
            }
        });
        }

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

        function viewentitydetailsforedit(id){
    
        $('#entityidedit').val(id);
        $('#show_entity_details_view').modal('show');
    

        var url = '{{ route("viewentitydetailsforedit", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#entityidedit').val()},
                success: function(result) {
                    
                    $("#entitydetailseditshow").html(result);
                    $("#entitydetailseditshow").show();
                    
                }
            });
        }

        function checkcid(id) {
            var cid = document.getElementById('bhutanesecid').value;
            var url = '{{ route("member.get.information.report.assignment.entities.person.manage.checkCIDaddentity", [":cid", ":id"]) }}';
            url = url.replace(':cid', cid);
            url = url.replace(':id', id);

            $.ajax({
                type: "GET",
                url: url,
                success: function(result) {
                    
                if (result.data.length > 0) {
                    alert("Already exists");
                    document.getElementById('bhutanesecid').value = "";

                } else {
                    gettoken();
                }
                },
                error: function() {
                alert('An error occurred while fetching data.');
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