@extends('layouts.admin')

@section('content')
<br>
@include('investigator/mainheader')

    <!------------------------ end top part ---------------->

    <div class="card  card-tabs">
  		<h6 class="card-header">@include('tabs/investigator_tab')</h6>
  			<div class="card-body">
			  	<div class="row">
                    <div class="col-12 col-sm-12">
                        @include('tabs/searchandseizure_tab')     
                        <br>
                        
                        <div id="suspensionshow">
                        @if(Auth::user()->role == "Investigator")
                            <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;" onclick="addsuspension()">
                                <span><i class="fa fa-plus"></i></span>   
                                <span style="font:face:Product Sans">Add Suspension</span>
                            </button>
                        @endif
                            <br>
                            <br>
                                <table  class="table t2">
                                    <thead >
                                        <tr>
                                            <th>Suspension Type</th>
                                            <th>CID No/License No</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Issue Date</th> 
                                            <th>Revoke Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($suspensions->count())
                                    @foreach ($suspensions as $suspension)

                                    <tr>
                                        <td>{{ $suspension->suspension_type }}</td>
                                        <td>{{ $suspension->identification_no }}</td>
                                        <td>{{ $suspension->name }}</td>
                                        <td>
                                                @if($suspension->suspension_status == "")
                                                    Not available
                                                @elseif($suspension->suspension_status == "Suspended")    
                                                    <label class="text-danger">{{ $suspension->suspension_status }}</label>
                                                @else
                                                    <label class="text-success">{{ $suspension->suspension_status }}</label>
                                                @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($suspension->suspended_on)->format('d/m/Y')}}</td>
                                        <td>
                                            @if($suspension->revoke_date == "")
                                            Not Available
                                            @else
                                            {{ \Carbon\Carbon::parse($suspension->revoke_date)->format('d/m/Y')}}
                                            @endif
                                        </td>
                                        <td>
                                                @if($suspension->suspension_status == "Suspended")
                                                    <button  class="btn btn-primary btn-sm" title="Revoke" onclick="showsuspensiiondetails('{{ $suspension->id }}')">Revoke</button>
                                                    <button  class="btn btn-primary btn-sm" >Notify Authority</button> 
                                                @elseif($suspension->suspension_status == "Revoked")
                                                    <button  class="btn btn-primary btn-sm" >Notify Authority</button> 
                                                @endif
                                        </td>
                                    </tr>
                                        @endforeach
                                        @else
                                <tr>
                                    <td colspan="6" style="text-align: center"> No record found </td>
                                </tr>
                                @endif
                                    </tbody>
                                    </table> 
                                                
                            </div>
                            <!-- ADD suspension -->
<form  method = "POST" action="{{ route('addsuspension') }}" enctype="multipart/form-data">
    @csrf 
<div class="modal fade" id="addsuspensionshow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add Suspension</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-family:Product Sans">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Type: </label><br> &nbsp;&nbsp;
                                    <input type="radio" name="suspensiontype"  value="Public" onclick="showpublicservantdiv();"> Public Servant &nbsp;
                                    <input type="radio" name="suspensiontype" value="Business" onclick="showbusinessdiv()"> Business  </label>
                                    <input type="hidden" name="suspensioncasenoidadd" id="suspensioncasenoidadd" value="{{ $casenoid }}">
                            </div>
                        </div>
                            <br>
                            
                            
                            <div id="publicservantdiv" style="display:none"> 
                            <input type="hidden" name="token" id="token" value="34596348-6abb-382a-b0a0-9d939b1d8d24"><br>
                                <div class= "row"> 
                                    <div class   = "col-md-6">
                                        <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">CID&nbsp;<font color='red'>*</font></label>
                                                <div class = "input-group">
                                                    <input name="bhutanesecid" id="bhutanesecid" class="form-control" type="text" placeholder="Search CID"/><button class ="search-btn" type="button" onclick="getZestDetailsByCID();">Search</button>
                                                </div> 
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div id="showcitizendetails" style="display:none">
                                    
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Name&nbsp;</label>
                                                    <input readonly  name="civilservantname" id="civilservantname"  class="form-control" type="text" value="testvlaue"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Employeeno&nbsp;</label>
                                                    <input readonly name="civilservantemployeeno" id="civilservantemployeeno"  class="form-control" type="text" value="testvlaue"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Date of Appointment&nbsp;</label>
                                                    <input  readonly name="civilservantappointmentdate" id="civilservantappointmentdate"  class="form-control" type="text" value="01/01/2010">
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Position Title&nbsp;</label>
                                                    <input readonly  name="civilservantpositiontitle" id="civilservantpositiontitle"  class="form-control" type="text" value="testvlaue"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Parent Agency&nbsp;</label>
                                                    <input readonly name="civilservantparentagency" id="civilservantparentagency"  class="form-control" type="text" value="testvlaue"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Working Agency&nbsp;</label>
                                                    <input  readonly name="civilservantworkingagency" id="civilservantworkingagency"  class="form-control" type="text" value="01/01/2010">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h3>Suspension Details</h3>
                                    <br>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Suspended On&nbsp;<font color='red'>*</font></label>
                                                    <input name="suspensiondatepublic" id="suspensiondatepublic"  class="form-control" type="date" placeholder="Current Address"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-12">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Reason for Suspension&nbsp;<font color='red'>*</font></label>
                                                    <textarea name="suspensionreasonpublic" id="suspensionreasonpublic"  class="form-control"rows="6"></textarea>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    
                                    
                                </div>

                            </div>
                            <br>
                            <div  id="businessdiv" style="display:none"> 
                                <div class= "row"> 
                                    <div class   = "col-md-6">
                                        <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">License No&nbsp;<font color='red'>*</font></label>
                                                <input name="businesslicenseno" id="businesslicenseno" onchange="getDetailsByPermit()" class="form-control" type="text" placeholder="Search Permit"/>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div id="showcitizendetailsnonbhutanese" style="display:none">
                                
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
                                    <h3>Suspension Details</h3>
                                    <br>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Suspended On&nbsp;<font color='red'>*</font></label>
                                                    <input name="suspensiondatebusiness" id="suspensiondatebusiness"  class="form-control" type="date" placeholder="Current Address"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-12">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Reason for Suspension&nbsp;<font color='red'>*</font></label>
                                                    <textarea name="suspensionreasonbusiness" id="suspensionreasonbusiness"  class="form-control"rows="6"></textarea>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    
                                    </div>
                            </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary"  name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Save" >Save</button> 
                </div>
            </div>
        </div>
    </div>
</form>

<!-- FINISH ADD Person -->
                                    
					</div>
				</div>
  			</div>
	</div>

       
<!-- edit modal -->
  <form  method = "POST" action="{{ route('revokesuspensionorder') }}" enctype="multipart/form-data">
    @csrf 
<div class="modal fade" id="displaysuspensionmodalforrevoke" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Revoke Suspension</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-family:Product Sans">
                    <input type="hidden" name="suspensionidrevoke" id="suspensionidrevoke">
                    <div id="displaysuspensiondetails" style="display:none"></div>
                    <hr >        
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Revoke Date </label><br>
                                      <input class="form-control" type="date" name="suspensionrevokedate" >                              
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Details&nbsp;</label><br>
                                       <textarea class="form-control" name="revokedetails" id="revokedetails" cols="5"></textarea> 
                                </div>
                            </div>
                        </div>
                         
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary"  name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Update" >Print Revoke Order</button> 
                </div>
            </div>
        </div>
    </div>
</form>
<!-- end edit modal -->
    
</section>
<script>
	function addsuspension()
    {
         $('#addsuspensionshow').modal('show');
    }
        
    function showpublicservantdiv() 
        {
            $('#publicservantdiv').show(1000); 
            $('#businessdiv').hide();                       
        }

    function showbusinessdiv()
        {
            $('#publicservantdiv').hide()
            $('#businessdiv').show(1000);
        }
    
    function getDetailsByPermit()
    {
        $('#showcitizendetailsnonbhutanese').show(700);
    }

    function getZestDetailsByCID(){
        // console.log(_token);
         var cid = $('#bhutanesecid').val();
         var token = $('#token').val();
         $('#showcitizendetails').show(700);
        // console.log(cid);
        var settings = {
            "url": "https://staging-datahub-apim.dit.gov.bt/rcsc_zestemployeedetailserviceapi/1.0.0/employeedetailbycid/"+cid,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Authorization": "Bearer " + token,
                // "Cookie": "route=1658042636.829.53.968004"
            },
        };

        $.ajax(settings).done(function (response) {
            console.log(response.employeedetails);
            var middlename;
          if(response.employeedetails.employeedetail[0].middleName == null){
                middlename = '';
            } else {
                middlename = response.employeedetails.employeedetail[0].middleName;
            }
            
            if(response.employeedetails.employeedetail.length >= 0){
                
                
                $("#civilservantname").val(response.employeedetails.employeedetail[0].firstName +' '+ middlename +' '+ response.employeedetails.employeedetail[0].lastName);
                $("#civilservantappointmentdate").val(response.employeedetails.employeedetail[0].dateOfAppointment); 
                $("#civilservantemployeeno").val(response.employeedetails.employeedetail[0].employeeNumber);
                $("#civilservantpositiontitle").val(response.employeedetails.employeedetail[0].positionTitle); 
                $("#civilservantparentagency").val(response.employeedetails.employeedetail[0].parentAgency); 
                $("#civilservantworkingagency").val(response.employeedetails.employeedetail[0].mainWorkingAgency);
                
                 

            } else {
                alert('No details found');
            }
        });
        }

 function showsuspensiiondetails(suspensionid)
    {
        $('#suspensionidrevoke').val(suspensionid);
            $('#displaysuspensionmodalforrevoke').modal('show');

            var url = '{{ route("displayassetdetailsforsuspension", ":suspensionid") }}';
                    url = url.replace(':suspensionid', suspensionid);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#suspensionidrevoke').val()},
                        success: function(responseText) {
                            
                            $("#displaysuspensiondetails").html(responseText);
                            $("#displaysuspensiondetails").show();
                           
                        }
                    });
     }
</script>
<style>
    .modal-header {
    background: linear-gradient(to top, grey, #ffffff);
    color: #fff;
    border-radius: 5px 5px 0 0;
}
.t2{
    outline: 2px dotted #ccc;
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