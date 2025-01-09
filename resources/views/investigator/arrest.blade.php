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
            @include('tabs/arrests_tab')
            <div class="tab-content" id="custom-tabs-four-tabContent">
               
                    @if(Auth::user()->role == "Investigator")
                        <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" onclick="addnewarrestrequest()">
                            <span><i class="fa fa-plus"></i></span>    
                            <span style="font:face:Product Sans">Add Arrest</span>
                        </button>
                    @endif
                        <br>
                         <br>
                    <table id = "example3" style="font-family:Product Sans" class="table t2">
                        <thead>
                            <tr>
                                <th >Request Date</th>
                                <th >Type of Arrest</th>
                                <th >Suspect Name</th>
                                <th >Application Status</th>
                                <th >Arrest Date</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            @if($arrests->count())
                            @foreach ($arrests as $data)
                                <td>{{ \Carbon\Carbon::parse($data->applicationdate)->format('d/m/Y')}}</td>
                                <td>{{$data->typeofArrest}}</td>
                                <td><?php echo $key=DB::table('tbl_case_entities')->where('id',$data->suspect)->value('name'); ?> [CID: <?php echo $key=DB::table('tbl_case_entities')->where('id',$data->suspect)->value('identification_no'); ?>]</td>
                                <td>
                                    @if($data->commissionStatus=='Approved')
                                        <label class="text-success">Approved</label>
                                    @elseif($data->commissionStatus=='Rejected')
                                        <label class="text-danger">Rejected</label>
                                    @elseif($data->commissionStatus=='Arrested')
                                        <label class="text-danger">Arrested</label>
                                    @elseif($data->commissionStatus==0)
                                        <label class="text-warning">Pending</label>
                                    @endif
                                </td>
                                <td>
                                    @if($data->arrested_on=='')
                                    No data available
                                    @else
                                    {{ \Carbon\Carbon::parse($data->arrested_on)->format('d/m/Y')}}
                                    @endif

                                </td>
                                <td>
                                    <!-- <button type="button"  class="btn btn-info btn-sm" onclick="addnewremand()" name="add" data-toggle="tooltip" data-placement="bottom" title="Add Remand">Remand</button> -->
                                    @if($data->commissionStatus!= 'Arrested')
                                    <i style="color:gray" class="fa fa-eye" onclick="showarrestdetails('{{ $data->arrest_id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="View Details"></i>
                                    @endif
                                    @if($data->commissionStatus=='Arrested')
                                    <i style="color:gray" class="fa fa-eye" onclick="showarrestdetailsarr('{{ $data->arrest_id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="View Details"></i>
                                    <i style="color:gray" class="fa fa-print" onclick="showarrestdetails('{{ $data->arrest_id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="Generate Arrest Warrant"></i>
                                    @endif
                                @if($data->commissionStatus=='Approved')
                                    @if(Auth::user()->role == "Investigator")
                                    <i style="color:gray" class="fa fa-pencil" onclick="updatearrestdetails('{{ $data->arrest_id }}')"  id="update" name="update" data-toggle="tooltip" data-placement="bottom" title="Update Details"></i>
                                    @endif
                                @endif
                                @if($data->commissionStatus == '0')
                                    @if(Auth::user()->role == "Commission")
                                    <i  class="fa fa-pencil" onclick="showarrestdetailsforupdate('{{ $data->arrest_id }}')" data-toggle="tooltip" data-placement="bottom" title="Update"></i>
                                    @endif
                                @endif
                                </td>
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
        <!-- /.card -->
    </div>
</div></div></div>

<!--add modal -->
<form method = "POST" action="{{ route('addArrestdetails') }}"  enctype="multipart/form-data" >
      @csrf    
<div class="modal fade" id="addarrest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:sans-serif">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Arrest Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                <input type="hidden" name="arrestcasenoadd" id="arrestcasenoadd" value="{{ $caseno }}">
                <input type="hidden" name="arrestcasenoidadd" id="arrestcasenoidadd" value="{{ $casenoid }}">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                Type of Arrest & Detention Requested&nbsp;<font color='red'>*</font>
                                    <select class="form-control" name="typeofArrest">
                                        <option selected>Select an Option</option>
                                        <option value="With Court Warrant">With Court Warrant</option>
                                        <option value="Without Court Warrant">Without Court Warrant</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Suspect Name&nbsp;<font color='red'>*</font></label>
                                    <select class="form-control"   name="suspect" id="suspect" >
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
                                <label>Application Date&nbsp;<font color='red'>*</font></label>
                                <input type="date" class="form-control" name="applicationdate">
                            </div>
                        </div>                  
                        <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Probable Cause:&nbsp;<font color='red'>*</font></label>
                                    <select class="form-control" multiple="multiple"  name="pcause[]" id="pcause" >
                                        <option >Select an Option</option>
                                        @foreach($pcause as $causes)
                                            <option value="{{ $causes->id}}">{{ $causes->name}}</option>
                                        @endforeach
                                    </select> 
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
<!--end add modal -->
<!-- view details modal -->
 
    <div class="modal fade" id="viewarrestdetailsmodal">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Arrest Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                        <div id="viewarrestdetails" style="display:none">
                            <input type="hidden" name="arrestid" id="arrestid">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
                
            </div>
        </div>
    </div>
  

<!-- end view details modal -->
<!-- view details after arrest modal -->
 
    <div class="modal fade" id="viewarrestdetailsarrmodal">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Arrest Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" >
                        <div id="viewarrestdetailsarr" style="display:none">
                            <input type="hidden" name="arrestidarr" id="arrestidarr">
                        </div>
                </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
                
            </div>
        </div>
    </div>
  

<!-- end view details modal -->
<!-- edit status -->
<form method="POST" action="{{ route('updateCommissionArrest') }}" enctype="multipart/form-data">
        @csrf
    <div class="modal fade" id="viewarrestdetailsforupdatemodal">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Arrest Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                        <div id="viewarrestdetailsforupdate" >
                                <input type="text" name="arrestidupdate" id="arrestidupdate">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- end edit status -->

<!-- update arrest details modal -->
<form method="POST" action="{{ route('updatearrestdetails') }}" enctype="multipart/form-data">
        @csrf
    <div class="modal fade" id="viewarrestdetailsupdatemodal">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Arrest Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                     <input type="hidden" name="arrestidforupdate" id="arrestidforupdate">
                        <div id="viewarrestdetailsdivforupdate" style="display:none">
                           
                        </div>
                         <hr style="height: 1px;  background: teal; margin: 10px 0;   box-shadow: 0px 0px 4px 2px rgba(204,204,204,1);">

                         <input type="hidden" name="arrestcasenoidadd" id="arrestcasenoidadd" value="{{ $casenoid }}">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Arrested On&nbsp;<font color='red'>*</font></label>
                                    <input type="date" class="form-control" name="arrest_date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Arrested By&nbsp;<font color='red'>*</font></label>
                                    <select class  = "form-control" name="arrestedby" id="arrestedby">
                                        <option>Select</option>
                                            @foreach ($users as $user)
                                                <option value  = "{{ $user->email }}">{{ $user->name }} </option>                                                                       </option>
                                            @endforeach 
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Arrested From&nbsp;<font color='red'>*</font></label>
                                        <input type="text" class="form-control" name="arrestedfrom">
                                </div>
                            </div>
                     </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Remarks&nbsp;<font color='red'>*</font></label>
                                 <textarea type="text" class="form-control" name="arrestremarks" id="arrestremarks" placeholder="Enter remarks"></textarea>                                      
                            </div>                                
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                
            </div>
        </div>
    </div>
</form>

<!-- end update arrest details modal -->


<script>
	function addnewarrestrequest()
        {
            $('#addarrest').modal('show');
        }
    
    function showarrestdetails(arrest_id)
        {
            $('#arrestid').val(arrest_id);
            $('#viewarrestdetailsmodal').modal('show');
            

            var url = '{{ route("arrestdetailsview", ":arrest_id") }}';
                    url = url.replace(':arrest_id', arrest_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#arrestid').val()},
                        success: function(responseText) {
                            
                            $("#viewarrestdetails").html(responseText);
                            $("#viewarrestdetails").show();
                            
                        }
                    });
        }
        function showarrestdetailsarr(arrest_id)
        {
            $('#arrestidarr').val(arrest_id);
            $('#viewarrestdetailsarrmodal').modal('show');
            

            var url = '{{ route("arrestdetailsviewarr", ":arrest_id") }}';
                    url = url.replace(':arrest_id', arrest_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#arrestidarr').val()},
                        success: function(responseText) {
                            
                            $("#viewarrestdetailsarr").html(responseText);
                            $("#viewarrestdetailsarr").show();
                            
                        }
                    });
        }

        function updatearrestdetails(arrest_id)
        {
            $('#arrestidforupdate').val(arrest_id);
            $('#viewarrestdetailsupdatemodal').modal('show');
            

            var url = '{{ route("arrestdetailsview", ":arrest_id") }}';
                    url = url.replace(':arrest_id', arrest_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#arrestidforupdate').val()},
                        success: function(responseText) {
                            
                            $("#viewarrestdetailsdivforupdate").html(responseText);
                            $("#viewarrestdetailsdivforupdate").show();
                            
                        }
                    });
        }

        function showarrestdetailsforupdate(arrest_id)
        {
            $('#arrestidupdate').val(arrest_id);
             $('#viewarrestdetailsforupdatemodal').modal('show');

            var url = '{{ route("commissionUpdateAnD", ":arrest_id") }}';
                    url = url.replace(':arrest_id', arrest_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#arrestidupdate').val()},
                        success: function(responseText) {
                            
                            $("#viewarrestdetailsforupdate").html(responseText);
                            $("#viewarrestdetailsforupdate").show();
                            
                        }
                    });
        }

        
</script>
<style>
     .modal-header {
    background: linear-gradient(to top, grey, #ffffff);
    color: #fff;
    font-family: Product Sans;
    border-radius: 5px 5px 0 0;
}

.t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
}
</style>
@endsection