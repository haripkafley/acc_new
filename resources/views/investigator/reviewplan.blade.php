@extends('layouts.admin')

@section('content')
<br>

<section class = "content">   
    <div class = "card" >
        <div class = "card-header"> <input type="hidden" id="maincaseno" name="maincaseno" value="{{ $caseno }}">
        <input type="hidden" id="maincasenoid" name="maincasenoid" value="{{ $casenoid }}">
            @foreach ($showcases as $cases)
                <div class="row" > 
	                <div class="col-md-3">
                        <div class="form-group">
                            <label>Case Number: </label> &nbsp; {{ $cases->case_no }}
                                    <input type="hidden" id="maincaseno" name="maincaseno" value="{{ $caseno }}"></br>
                            <label>Case Title: </label> &nbsp; {{ $cases->case_title }}
                                    <input type="hidden" readonly name="registration_date"  class="form-control" id="registration_date" value="{{ \Carbon\Carbon::parse($cases->case_reg_date)->format('d/m/Y')}}">
                                    <input type="hidden"  name="registration_date_ss"  class="form-control" id="registration_date_ss" value="{{ $cases->case_reg_date }}">
                                    <br>
                            <label>Case Creation Date: </label> &nbsp; {{ \Carbon\Carbon::parse($cases->case_reg_date)->format('d/m/Y')}}
                            <br>
                            <label>Complaint Details: </label> &nbsp; {{ $cases->allegation_details }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sector Type: </label> &nbsp; {{ $cases->sector_type }}
                                    <br>
                            <label>Sector Sub Type: </label> &nbsp; {{ $cases->sector_sub_type }}
                                    <br>
                            <label>Area: </label> &nbsp; {{ $cases->area }}
                            <br>
                            <label>Institution Type: </label> &nbsp; {{ $cases->institution_type }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Priority: </label> &nbsp; {{ $cases->priority }}
                                    <br>
                            <label>Probable Offence: </label> &nbsp;
                                <br>
                                @foreach ($offences as $offence)
                                    {{ $offence->offence_type }}
                                @endforeach
                                    
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            
                            <label>Change Case Status: </label> &nbsp; 
                                <select name="casestatus" id="casestatus" onchange="changestatus('{{ $casenoid }}')">
                                    <option value="">Select Status</option>
                                        <option selected>{{ $cases->case_substatus }}</option>
                                        @foreach ($casesubstatus as $status)
                                            <option value="{{ $status->status_name }}">{{ $status->status_name }}</option>
                                        @endforeach    
                                </select>  
                                <br>
                                <input type="text" class="form-control" style="display:none" placeholder="Remarks" name="changestatusremarks" id="changestatusremarks">  
                                <button type="submit" id="changestatusbutton" name="changestatusbutton" style="display:none;float:right;" class="btn btn-light"  data-toggle="tooltip" data-placement="bottom" title="Save" ><i class="fa fa-save"></i></button>  
                            
                        </div>
                    </div>
                </div>
        @endforeach
        </div>
    </div>
    <!------------------------ end top part ---------------->

    

	<div class="card  card-tabs">
  		<h6 class="card-header">@include('investigator_tab')</h6>
  			<div class="card-body">
			  	<div class="row">
                    <div class="col-12 col-sm-12">
                        @include('investigationplan_tab')
                        <div style="float:right"> 
                        @if(Auth::user()->role == "Investigator")
                            <button type="button"  class="btn btn-outline-primary" onclick="showaddtask()" name="showaddtaskbutt" id="showaddtaskbutt" data-toggle="tooltip" data-placement="bottom" title="Assign Task"><i class="fa fa-plus"></i></button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-outline-primary" onclick="showmytask()" name="showmytaskbutt" id="showmytaskbutt" data-toggle="tooltip" data-placement="bottom" title="My Task"><i class="fa fa-book"></i></button></div><br>
                         @endif   
                        </div>
                            <br>    
                            
                            <div id="taskindexshow">
                                    <table class="table table-bordered table-hover">
                                            <tr>
                                                <th>Date</th>
                                                <th>Task</th>
                                                <th>Assigned To </th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        @foreach($taskdetails as $details)
                                            <tr>
                                                <td  >{{ \Carbon\Carbon::parse($details->date)->format('d/m/Y')}}</td>
                                                <td  >{!! $details->task_to_be_done !!}</td>
                                                <td  ><?php echo $key=App\Models\User::where('email',$details->assigned_to)->value('name'); ?></td>
                                                <td  >{{ $details->status }}</td>                           
                                                <td>
                                                @if(Auth::user()->role == "Investigator")
                                                <button class="btn btn-outline-primary" type="button" onclick="showedittaskactivity('{{ $details->id }}','{{ $casenoid }}')" data-toggle="tooltip" data-placement="bottom" title="Edit" ><i class="fa fa-edit"></i></button>
                                                @endif
                                            </td>
                                            </tr>
                                        @endforeach                                                                                    
                                    </table> 
                                </div>
                                <div id="mytaskindexshow" style="display:none">
                                
                                    <table class="table table-bordered table-hover">
                                            <tr>
                                                <th>Date</th>
                                                <th>Task</th>
                                                <th>Assigned To </th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        @foreach($taskdetails as $details)
                                        @if (Auth::user()->email== $details->assigned_to)
                                            <tr>
                                                <td  >{{ \Carbon\Carbon::parse($details->date)->format('d/m/Y')}}</td>
                                                <td  >{!! $details->task_to_be_done !!}</td>
                                                <td  ><?php echo $key=App\Models\User::where('email',$details->assigned_to)->value('name'); ?></td>
                                                <td  >{{ $details->status }}</td>                           
                                                <td><button class="btn btn-outline-primary" type="button" onclick="showedittaskactivityindividual('{{ $details->id }}')" data-toggle="tooltip" data-placement="bottom" title="Edit" ><i class="fa fa-edit"></i></button></td>
                                            </tr>
                                        
                                            @endif
                                        @endforeach                                                                                    
                                    </table> 
                                    <button type="button" style="float:right;" class="btn btn-outline-primary" onclick="closemytask()" name="closemytaskbutt" id="closemytaskbutt" data-toggle="tooltip" data-placement="bottom" title="Close" ><i class="fa fa-times"></i></button>
                                </div>
                                <div id="addtaskshow" style="display:none">
                                    
                                    <form method = "POST" action="{{ route('addtaskindividual') }}"  enctype="multipart/form-data" >
                                                @csrf    
                                                <input type="hidden" name="addtaskcasenoid" id="addtaskcasenoid" value="{{ $casenoid }}">
                                                    <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="casetitle">Date:<font color='red'>*</font></label>
                                                                            <input type="date" name="task_date"  id="task_date" class="form-control" required="">
                                                                    </div>
                                                                </div>
                                                    
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="casetitle">Activity:<font color='red'>*</font></label>
                                                                        <select class="form-control"   name="taskactivity" id="taskactivity" required>
                                                                            <option value="">Select</option>
                                                                                @foreach ($activities as $tact)
                                                                                    <option >{!! $tact->task_description !!}</option>
                                                                            
                                                                            @endforeach    
                                                                        </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group"> 
                                                                <label for="casetitle">Task:<font color='red'>*</font></label>
                                                                        <textarea name="taskdtls" id="taskdtls"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group"> 
                                                                <label for="casetitle">Assigned To:<font color='red'>*</font></label>
                                                                        <select class="form-control" id="taskassignedto"  name="taskassignedto" id="offence_type_invplan" required>
                                                                            <option value="">Select</option>
                                                                                @foreach ($useresults as $usr)
                                                                                    <option value="{{ $usr->email }}">{{ $usr->name }}</option>
                                                                                @endforeach    
                                                                        </select>
                                                            </div>
                                                        </div>
                                                    
                                                        
                                                    </div>
                                                    
                                                    
                                                    <button type="submit" style="float:right;" class="btn btn-primary"   data-toggle="tooltip" data-placement="bottom" title="Assign" ><i class="fa fa-save"></i></button> 
                                            </form>
                                            <button type="button" style="float:right;" class="btn btn-outline-primary" onclick="closeaddtask()" name="closeaddtaskbutt" id="closeaddtaskbutt" data-toggle="tooltip" data-placement="bottom" title="Close" ><i class="fa fa-times"></i></button> 
                                            
                                </div>
                                <form method = "POST" action="{{ route('updatetask') }}"  enctype="multipart/form-data" >
                                    @csrf 
                                <div id="showedittask" style="display:none">
                                
                                <input type="hidden" id="activityid" name="activityid">
                                </div>
                                </form>
                                <form method = "POST" action="{{ route('updatetaskindividual') }}"  enctype="multipart/form-data" >
                                    @csrf 
                                <div id="showedittaskindividual" style="display:none">
                                
                                <input type="hidden" id="activityidindividual" name="activityidindividual">
                                </div>
                                </form>
                        
                                <form method = "POST" action="{{ route('updatetaskteamleader') }}"  enctype="multipart/form-data" >
                                    @csrf 
                                
                                
                                <input type="hidden" id="activityidteamleader" name="activityidteamleader">
                                <input type="hidden" id="casenoidedittaskteamleader" name="casenoidedittaskteamleader">
                                <div id="showedittaskteamleader" style="display:none">
                                </div>
                                </form>
                        </div> 
  			        </div>
                </div>
            </div>
	</div>
</section>
<script>
	function showaddtask()
{
    $("#addtaskshow").show();
    $("#showaddtaskbutt").hide();
    $("#taskindexshow").hide();
    $("#mytaskindexshow").hide();
    $("#showmytaskbutt").hide();
    $("#closeaddtaskbutt").show();
    
}

function showmytask()
{
    $("#addtaskshow").hide();
    $("#showaddtaskbutt").hide();
    $("#taskindexshow").hide();
    $("#mytaskindexshow").show();
    $("#closeaddtaskbutt").hide();
    $("#showmytaskbutt").hide();
    
}

function closeaddtask()
{
    $("#addtaskshow").hide();
    $("#showaddtaskbutt").show();
    $("#taskindexshow").show();
    $("#closeaddtaskbutt").hide();
    $("#showmytaskbutt").show();
}

function closemytask()
{
    $("#addtaskshow").hide();
    $("#showaddtaskbutt").show();
    $("#taskindexshow").show();
    $("#mytaskindexshow").hide();
    $("#closeaddtaskbutt").hide();
    $("#showmytaskbutt").show();
}

function showedittaskactivity(id,casenoid)
{
    $('#activityid').val(id);
       
    var url = '{{ route("edittask", ['id' => ':id', 'casenoid' => ':casenoid']) }}';
            url = url.replace(':casenoid', casenoid);
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#activityid').val()},
                success: function(responseText) {
                    
                    $("#showedittask").html(responseText);
                    $("#showedittask").show();
                    $('#showaddtaskbutt').hide(); 
                    $("#taskindexshow").hide();
                    $("#showmytaskbutt").hide();
                    $("#mytaskindexshow").hide();
                }
            });
}

function showedittaskactivityindividual(id)
{
    $('#activityidindividual').val(id);
    
   
    var url = '{{ route("edittaskindividual", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#activityidindividual').val()},
                success: function(responseText) {
                    
                    $("#showedittaskindividual").html(responseText);
                    $("#showedittaskindividual").show();
                    $('#showaddtaskbutt').hide(); 
                    $("#taskindexshow").hide();
                    $("#showmytaskbutt").hide();
                    $("#mytaskindexshow").hide();
                }
            });
}

function closeedittask()
{  
        $('#taskindexshow').show(); 
        $('#mytaskindexshow').hide();  
        $('#showaddtaskbutt').show();
        $('#showmytaskbutt').show(); 
        $('#showedittask').hide();

        
        
}
function changestatus(casenoid)
        {
           
            $('#changestatusremarks').show();
            $('#changestatusbutton').show();
            var status = $('#casestatus').val();
            
                        $.ajax({
                            type:'POST',
                            enctype: 'multipart/form-data',
                            url:"{{ route('changestatusinvestigator',["+casenoid+","+status+"]) }}",
                            data: formdata,
                            success:function(data){
                                alert(data.success);
                            }
                            });
        }
</script>
@endsection