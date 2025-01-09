@extends('layouts.admin')

@section('content')
<br>
@include('investigator/mainheader')
    <!------------------------ end top part ---------------->
<!-- start-->
<div class="col-sm-13" style="margin-top:-9px;">
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            @include('tabs/investigator_tab')
           
        </div>
        <div class="card-body">
             
            @include('tabs/searchandseizure_tab')
                @if(Auth::user()->role == "Investigator")
                    <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;" onclick="addnewsearch()">
                        <span><i class="fa fa-plus"></i></span>    
                        <span style="font:face:Product Sans">Add Search</span>
                    </button>
                @endif
<br>
<br>                    
            <div id="searchindex">
                        <table id = "example3" class="table t2">
                            <thead>
                                <tr>
                                <th scope="col">Type of Search</th>
                                <th scope="col">Request Date</th>
                                <th scope="col">Accused</th>
                                <th scope="col">Application Status</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                @if($searchdetails->count())
                                @foreach ($searchdetails as $search)
                                    <td>{{$search->typeofsearch}}</td>
                                    <td>{{ \Carbon\Carbon::parse($search->applicationdate)->format('d/m/Y')}}</td>
                                    <td><?php echo $key=DB::table('tbl_case_entities')->where('id',$search->suspect)->value('name'); ?></td>
                                    <td>
                                            @if($search->commissionStatus=='Approved')
                                        <label class="text-success">Approved</label>
                                            @elseif($search->commissionStatus=='Rejected')
                                        <label class="text-danger">Rejected</label>
                                            @elseif($search->commissionStatus==0)
                                        <label class="text-warning">Pending</label>
                                            @endif
                                    </td>
                                    <td>
                                        <i class  = "fa fa-eye"   onclick="showsearchdetails('{{ $search->search_id }}')" data-toggle="tooltip" data-placement="bottom" title="View Search Details"></i>      
                                        @if($search->commissionStatus == '0')
                                            @if(Auth::user()->role == "Commission")
                                                <i class="fa fa-pencil" onclick="showsearchdetailsforupdate('{{ $search->search_id }}')" data-toggle="tooltip" data-placement="bottom" title="Update">&nbsp;</i>      
                                            @endif
                                        @endif
                                        
                                                
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" style="text-align: center"> No record found </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                </div> 
     	</div>
    </div>
</div>
<!-- edit modal -->
  <form method="POST" action="{{ route('addsearch') }}" enctype="multipart/form-data">
                            @csrf
    <div class="modal fade" id="addsearchmodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Search</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="searchcasenoidadd" id="searchcasenoidadd" value="{{ $casenoid }}">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="font-family:Product Sans">Search Type Requested&nbsp;<font color='red'>*</font></label>
                                    <select class="form-control" name="typeofsearch">
                                        <option selected>Select an Option</option>
                                        <option value="With Court Warrant">With Court Warrant</option>
                                        <option value="Without Court Warrant">Without Court Warrant</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="font-family:Product Sans">Suspect Name&nbsp;<font color='red'>*</font></label>
                                    <select class="form-control"   name="searchsuspect" id="searchsuspect" >
                                        <option selected>Select an Option</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id}}">{{ $subject->name}} [{{ $subject->identification_no}}]</option>
                                        @endforeach
                                    </select>                                      
                            </div>                                
                        </div>
                    </div>
                    <div class= "row">                  
                        <div class  = "col-md-6">
                            <div class="form-group">
                                <label style="font-family:Product Sans">Application Date&nbsp;<font color='red'>*</font></label>
                                <input type="date" class="form-control" name="searchapplicationdate">
                            </div>
                        </div>
                        <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="font-family:Product Sans">Probable Cause:&nbsp;<font color='red'>*</font></label>
                                        <select class="form-control" name="searchpcause" id="searchpcause" >
                                            <option >Select an Option</option>
                                            @foreach($pcause as $causes)
                                                <option value="{{ $causes->id}}">{{ $causes->cause_name}}</option>
                                            @endforeach
                                        </select> 
                                </div>
                        </div>
                    </div>
                    <div class= "row">                  
                        <div class  = "col-md-6">
                            <div class="form-group">
                                <label style="font-family:Product Sans">Ownership Type&nbsp;<font color='red'>*</font></label>
                                        <select class="form-control select2"  id="ownershiptype" name="ownershiptype">
                                            <option selected>Select an Option</option>
                                            <option value="Public">Public</option>
                                            <option value="Private">Private</option>
                                        </select>
                            </div>
                        </div>
                        <div class  = "col-md-6">
                            <div class="form-group">
                                <label style="font-family:Product Sans">Target Location&nbsp;<font color='red'>*</font></label>
                                        <select class="form-control select2" id="searchtarget" name="searchtarget" required>
                                            <option selected>Select an Option</option>
                                            <option value="Residential Aparmtent">Residential Aparmtent</option>
                                            <option value="Aircraft">Aircraft</option>
                                            <option value="Vehicle">Vehicle</option>
                                            <option value="Office Workspace">Office Workspace</option>
                                            <option value="Godown">Godown</option>
                                            <option value="Shop">Shop</option>
                                            <option value="Warehouse">Warehouse</option>
                                        </select>
                            </div>
                        </div>          
                        <!-- <div class  = "col-md-6">
                            <div class="form-group">
                                <label style="font-family:Product Sans">Search Target&nbsp;<font color='red'>*</font></label>
                                        <select class="form-control select2" onchange="searchTarget()" id="searchtarget" name="searchtarget">
                                            <option selected>Select an Option</option>
                                            <option value="movable">Movable Property</option>
                                            <option value="publicPremise">Premises (Public)</option>
                                            <option value="privatePremise">Premises (Private)</option>
                                        </select>
                            </div>
                        </div> -->
                    </div> 
                    
                    <div id = 'displaymovable' style = "display: none;">
                            <h5 class="text-info"><b>Movable</b></h5>
                        

                        <div class="row">
                            <div class="col-md-2">                   
                                <label style="font-family:Product Sans">Identification No:</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" id="ideNo" class="form-control" name="ideNo" placeholder="Enter Identification Number">
                            </div>

                            <div class="col-md-2">
                                <label style="font-family:Product Sans">Owner Name:</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" id="movableOwner" class="form-control" name="movableOwner" placeholder="Enter Owner Name">
                            </div>
                        </div></div>
                
                        
                        <br>
                        <div id = 'displaypublicpremise' style = "display:none;">
                            <h5 class="text-info"><b>Public Premise</b></h5>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <label style="font-family:Product Sans">Office Name:</label>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" id="publicName" class="form-control" name="publicName" placeholder="Enter Office Name">
                            </div>
                            <div class="col-md-4">
                                <label style="font-family:Product Sans">Location:</label>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" id="publicLocation" class="form-control" name="publicLocation" placeholder="Enter Office Location">
                            </div>
                        </div>
                        </div>
                        
                        <br>
                        <div id = 'displayprivatepremise' style = "display:none;">
                            <h5 class="text-info"><b>Private Premise</b></h5>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <label style="font-family:Product Sans">Location:</label>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" id="privateLocation" class="form-control" name="privateLocation" placeholder="Enter  Location">
                            </div>
                        </div></div>
                        
                        <br>
                        <div id = 'displayperson' style = "display :none;">
                            <h5 class="text-info"><b>Person</b></h5>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <label style="font-family:Product Sans">Name:</label>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" id="first-name" class="form-control" name="warrant_rNo" placeholder="Please Enter Name">
                            </div>

                            <div class="col-md-4">
                                <label style="font-family:Product Sans">CID</label>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" id="personCid" class="form-control" name="personCid" placeholder="Please Enter CID">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">                            
                                <label style="font-family:Product Sans">Contact No:</label>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" id="personContact" class="form-control" name="personContact" placeholder="Please Enter Contact Number">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit for Approval</button>
                </div>
            </div>
        </div>
    </div>
    </form>

<!-- end edit modal -->

<!-- edit modal -->
 <form action="{{ route('updateCommissionSearch') }}" method="POST">
                @csrf
    <div class="modal fade" id="updatesearchmodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Search</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="searchdetailsforcommissionupdate" style="display:none">
                        </div>   
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    </form>

<!-- end edit modal -->

<!-- edit modal -->

    <div class="modal fade" id="showsearchdetailsmodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Search Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                     <div id="displaysearchdetailsforseizure" style="display:none">
                                <input type="hidden" name="displaysearchdetailsid" id="displaysearchdetailsid">
                        </div>
                </div>
                
            
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
    

<!-- end edit modal -->
<script>
	
    function addnewsearch()
    {
        $('#addsearchmodal').modal('show');  
        
    }
    

        function searchTarget() {
                var x = document.getElementById("searchtarget").value;
                if(x == 'movable'){
                    $('#displaymovable').show();
                    $('#displaypublicpremise').hide();
                    $('#displayprivatepremise').hide();
                    $('#displayperson').hide();
                }
                else if(x == 'publicPremise'){
                    $('#displaypublicpremise').show();
                    $('#displayprivatepremise').hide();
                    $('#displaymovable').hide();
                    $('#displayperson').hide();
                }
                else if(x == 'privatePremise'){
                    $('#displayprivatepremise').show();
                    $('#displaymovable').hide();
                    $('#displaypublicpremise').hide();
                    $('#displayperson').hide();
                }
                else if(x == 'person'){
                    $('#displayperson').show();
                    $('#displaymovable').hide();
                    $('#displaypublicpremise').hide();
                    $('#displayprivatepremise').hide();
                    
                }
                else {
                    $('#displayperson').hide();
                    $('#displaymovable').hide();
                    $('#displaypublicpremise').hide();
                    $('#displayprivatepremise').hide();
                    
                }
        }

    function showsearchdetailsforupdate(search_id)
        {
            $('#searchidupdate').val(search_id);
            $('#updatesearchmodal').modal('show'); 

            var url = '{{ route("commissionUpdateSearch", ":search_id") }}';
                    url = url.replace(':search_id', search_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#searchidupdate').val()},
                        success: function(responseText) {
                            
                            $("#searchdetailsforcommissionupdate").html(responseText);
                            $("#searchdetailsforcommissionupdate").show();
                            $('#searchindex').hide();
                            $('#addnewsearchdiv').hide();
                            $('#addnewsearchbutt').hide();
                        }
                    });
        }

    function showsearchdetails(search_id)
        {
            $('#displaysearchdetailsid').val(search_id);
             $('#showsearchdetailsmodal').modal('show'); 

            var url = '{{ route("viewsearchdetails", ":search_id") }}';
                    url = url.replace(':search_id', search_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#displaysearchdetailsid').val()},
                        success: function(responseText) {
                            
                            $("#displaysearchdetailsforseizure").html(responseText);
                            $("#displaysearchdetailsforseizure").show();
                            
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
    outline: 1px solid #ccc;
    font-family:Product Sans;
}
</style>
@endsection