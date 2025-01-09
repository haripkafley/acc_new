@extends('layouts.admin')

@section('content')
<br>

<section class = "content">   
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
                        <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" onclick="addnewdetention()">
                            <span><i class="fa fa-plus"></i></span>    
                            <span style="font:face:Product Sans">Add Detention</span>
                        </button>
                        @endif
                            <br>
                     <br>
                    <table id = "example3" style="font-family:Product Sans" class="table t2">
                        <thead>
                            <tr>
                                <th >Detainee</th>
                                <th >Gender</th>                              
                                <th >Detained On</th>
                                <th >Detained From</th>
                                <th >Days Detained</th>
                                <th >Status</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($detentions->count())
                            @foreach ($detentions as $data)
                                <tr>
                                    <td><?php echo $key=DB::table('tbl_case_entities')->where('id',$data->suspect)->value('name'); ?> [CID: <?php echo $key=DB::table('tbl_case_entities')->where('id',$data->suspect)->value('identification_no'); ?>]</td>
                                    <td>{{ $data->gender}}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->detained_on)->format('d/m/Y')}}</td>
                                    <td>{{ $data->detained_from}}</td>
                                    <td>{{ date_diff(new \DateTime($data->detained_on), new \DateTime())->format(" %d days"); }}</td>
                                    <td>
                                        @if($data->status=='Detained')
                                        <label class="text-danger">Under Custody</label>
                                        @elseif($data->status=='Released')
                                        <label class="text-success">Released</label>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline btn-sm" onclick="showdetentiondetails('{{ $data->detention_id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="View Details"><i class="fa fa-eye"></i></button>
                                        @if(Auth::user()->role == "Investigator")
                                            @if($data->status != "Released")
                                                <button class="btn btn-outline-success btn-sm" type="button" onclick="showremanddetails('{{ $data->detention_id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="Remand">Remand</button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="7" style="text-align: center"> No record found </td>
                                </tr>
                            @endif
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    
<!--add modal -->
 <form method="POST" action="{{ route('detentiondetailsadd') }}" enctype="multipart/form-data">
                            @csrf   
<div class="modal fade" id="adddetention" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                <h5 class="modal-title" id="exampleModalLabel">Add Detention</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="detentioncasenoidadd" id="detentioncasenoidadd" value="{{ $casenoid }}">
                    <div class="row">
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Detained From&nbsp;<font color='red'>*</font></label>
                                     <textarea type="text" id="detained_from" class="form-control" name="detained_from" placeholder="Please Enter Detained From"></textarea>                                   
                            </div>                                
                        </div>
                    </div>
                    <div class= "row">                  
                        <div class  = "col-md-6">
                            <div class="form-group">
                                <label>Detained On&nbsp;<font color='red'>*</font></label>
                                <input type="date" id="detained_on" class="form-control" name="detained_on" placeholder="Please Enter Detained On">
                            </div>
                        </div>
                        <div class  = "col-md-6">
                            <div class="form-group">
                                <label>Detention Facility:&nbsp;<font color='red'>*</font></label>
                                    <select class="form-control select2" name="detained_location" id="detained_location">
                                        <option selected>Select an Option</option>
                                        <option value="ACC Premise, Thimphu">ACC Premise, Thimphu</option>
                                        <option value="ACC Premise, Pling">ACC Premise, Pling</option>
                                        <option value="ACC Premise, Bumthang">ACC Premise, Bumthang</option>
                                        <option value="RBP">RBP</option>
                                    </select>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Arrested By&nbsp;<font color='red'>*</font></label>
                                    <select class  = "form-control" name="detainedby" id="detainedby">
                                        <option>Select</option>
                                            @foreach ($users as $user)
                                                <option value  = "{{ $user->email }}">{{ $user->name }} </option>                                                                       </option>
                                            @endforeach 
                                    </select>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-12">
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
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end add modal -->
<!-- view details after detention modal -->
 
    <div class="modal fade" id="viewdetentiondetailsmodal">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detention Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                        <div id="viewdetentiondetailsshow" style="display:none">
                            <input type="hidden" name="detentiondetailsid" id="detentiondetailsid">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
                
            </div>
        </div>
    </div>
  

<!-- end view details modal -->
<!-- view details remand modal -->
 <form method="POST" action="{{ route('addremanddetails') }}" enctype="multipart/form-data">
                            @csrf  
    <div class="modal fade" id="addremandmodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remand Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="detentionidforremand" id="detentionidforremand">
                    <input type="hidden" name="casenoidforemand" id="casenoidforemand" value="{{ $casenoid }}">

                        <div id="viewdetentiondetailsforremandshow" style="display:none"></div>
                        <hr>
                        <div id="viewremanddetails" style="display:none"></div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Remand Type&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                        <input type="radio" name="remandtype"  value="Under Custody" onclick="showremanddiv();" required> Under Custody &nbsp;
                                        <input type="radio" name="remandtype" value="Released" onclick="showreleaseddiv()"> Released  </label>
                                </div>
                            </div>
                        </div>
                        <!-- remand div -->
                        <div id="remanddiv" style="display:none">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Remanded Until&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                            <input type="date" name="remandeduntil" class="form-control"> 
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Court&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                            <select class="form-control" name="court">
                                                <option selected>Select an Option</option>
                                                <option value="Supreme Court">Supreme Court</option>
                                                <option value="High Court">High Court</option>
                                                <option value="Dzongkhag Court">Dzongkhag Court</option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Attach Document&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                            <input type="file" name="remanddocument" class="form-control"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- remand div -->
                          <!-- release div -->
                        <div id="releasediv" style="display:none">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Released On&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                            <input type="date" name="releasedon" class="form-control"> 
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Type of Release&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                            <select class="form-control" name="typeofrelease" onchange="myFunction()" id="mySelect">
                                                <option selected>Select an Option</option>
                                                <option value="Bail">Bail</option>
                                                <option value="Surety">Surety</option>
                                                <option value="Both">Both</option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div id = 'displaybail' style = "display:none;">
                            <!-- bail div -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Bail Amount&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                                <input type="text" name="bailamt" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Bail Document&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                                <input type="file" id="baildocument" class="form-control" name="baildocument">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Bail and Bond Undertaking&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                                <input type="file" name="bailbondundertaking" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Bond Receipt&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                                <input type="file" id="bondreceipt" class="form-control" name="bondreceipt">
                                        </div>
                                    </div>
                                </div>
                            <!-- bail div -->
                            </div>
                            <br>
                            <div id = 'displaysurety' style = "display :none;">
                                <!-- surety div -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Name&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                                <input type="text" name="suretyname" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>CID&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                                <input type="text" id="suretycid" class="form-control" name="suretycid">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Relationship with Suspect&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                                <input type="text" name="suretyrelation" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Contact No&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                                <input type="text" id="suretycontactno" class="form-control" name="suretycontactno">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Surety Undertaking&nbsp;<font color='red'>*</font></label> &nbsp;&nbsp;
                                                <input type="file" name="suretyundertaking" class="form-control"> 
                                        </div>
                                    </div>
                                </div>
                            <!-- surety div -->
                            </div>
                        </div>
                         <!-- release div -->
                </div>
                 <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- end view details modal -->
</section>
<script>
    function addnewdetention()
    {
        $('#adddetention').modal('show');
    }

    function showdetentiondetails(detention_id)
        {
            $('#detentiondetailsid').val(detention_id);
            $('#viewdetentiondetailsmodal').modal('show');
            

            var url = '{{ route("detentiondetailsdisplay", ":detention_id") }}';
                    url = url.replace(':detention_id', detention_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#detentiondetailsid').val()},
                        success: function(responseText) {
                            
                            $("#viewdetentiondetailsshow").html(responseText);
                            $("#viewdetentiondetailsshow").show();
                            
                        }
                    });
        }

    function showremanddetails(detention_id)
        {
            $('#detentionidforremand').val(detention_id);
            $('#addremandmodal').modal('show');
            

            var url = '{{ route("detentiondetailsdisplay", ":detention_id") }}';
                    url = url.replace(':detention_id', detention_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#detentionidforremand').val()},
                        success: function(responseText) {
                            
                            $("#viewdetentiondetailsforremandshow").html(responseText);
                            $("#viewdetentiondetailsforremandshow").show();
                            
                        }
                    });
            
            var url = '{{ route("remanddetailsdisplay", ":detention_id") }}';
                    url = url.replace(':detention_id', detention_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#detentionidforremand').val()},
                        success: function(responseText) {
                            
                            $("#viewremanddetails").html(responseText);
                            $("#viewremanddetails").show();
                            
                        }
                    });
        }

        function showremanddiv()
        {
            $('#remanddiv').show(1000); 
            $('#releasediv').hide();  
        }

        function showreleaseddiv()
        {
            $('#remanddiv').hide(); 
            $('#releasediv').show(1000);  
        }

        function myFunction() {
            var x = document.getElementById("mySelect").value;
            if(x == 'Bail'){
                $('#displaybail').show();
                $('#displaysurety').hide();
            }
            else if(x == 'Surety'){
                $('#displaysurety').show();
                $('#displaybail').hide();
            }
            else if(x == 'Both'){
                $('#displaysurety').show();
                $('#displaybail').show();
            }
            else{
                $('#displaysurety').hide();
                $('#displaybail').hide();
            }
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