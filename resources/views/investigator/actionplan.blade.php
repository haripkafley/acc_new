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
                
                    @if(Auth::user()->role == "Investigator")
                        <form id="my-form" action="{{ route('updateinvplanstatus') }}" method="POST">
                            @csrf
                                @if($invcount != 0 && $hypothesiscount != 0 && $actionplancount != 0 && $invstatus == 0)
                                    <input type="hidden" id="casenoidinvstatusupdate" name="casenoidinvstatusupdate" value="{{ $casenoid }}">
                                    <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" >
                                            <span style="font:face:Product Sans">Send for Review</span>
                                    </button>
                                @endif
                        </form>
                        @include('tabs/investigationplan_tab')
                        @if(Auth::user()->email == $teamleader )
                        <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" onclick="addnewactionplan()">
                            <span><i class="fa fa-plus"></i></span>    
                            <span style="font:face:Product Sans">Add Action Plan</span>
                        </button>
                     @endif
                    @endif
                <div class="tab-content" id="custom-tabs-four-tabContent">
                     
                     
	
                    <br>
                    <br>
                      <div class="header" style="height:40px; border-radius:5px; margin-top:10px;">&nbsp;&nbsp;<font color='#000000' size="5.2" face="Product Sans"> Action Plan</font></div>
                      <br>
                        <br><br>
                        @if($actionplans->count())
                        @php($i=0)
                        @foreach($actionplans as $actplans)
                        <!-- action plan accordian -->
                           <div id="accordion" style="margin-top:-40px;">
                                <div class="card">
                                    <div class="card-header custom-header" id="headingOne_{{ $i}}">
                                        <h5 class="mb-0">
                                            &nbsp; &nbsp; 
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo_{{ $i}}" aria-expanded="true" aria-controls="collapseTwo_{{ $i}}">
                                                    <font color='#000000'  size="3"  face="Product Sans"> Week {{ $actplans->weekname}} &nbsp; [{{ \Carbon\Carbon::parse($actplans->actionplanstartdate)->format('d/m/Y')}}  to {{ \Carbon\Carbon::parse($actplans->actionplanenddate)->format('d/m/Y')}}]</font>
                                            </button>
                                            </h5>
                                    </div>

                                    
                                <div id="collapseTwo_{{ $i}}" class="collapse hide" aria-labelledby="headingOne_{{ $i}}" data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- Content Start-->
                                        <table class="table table-bordered" id="maintable">
                                            <thead>
                                                <th>Task Name</th>
                                                <th>Description</th>
                                                <th>Priority</th>
                                                <th>Assigned To</th>
                                                <th>Assigned On</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody id="maintask">
                                                @foreach($taskactivities as $act)  
                                                <tr>
                                                    <td>{{ $act->task}}</td>
                                                    <td>{{ $act->description}}</td>
                                                    <td>{{ $act->priority}}</td>
                                                    <td><?php echo $key=DB::table('users')->where('email',$act->assigned_to)->value('name') ?></td>
                                                    <td>{{ \Carbon\Carbon::parse($act->assigned_on)->format('d/m/Y')}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($act->due_date)->format('d/m/Y')}}</td>
                                                    <td>{{ $act->status}}</td>
                                                    <td>
                                                        @if(Auth::user()->email == $act->assigned_to) 
                                                            @if($act->status != "Complete")                                                     
                                                                <i onclick="editactionplanstatus('{{ $act->id}}')" class="fa fa-edit" style="color:blue; " onmouseover="this.style.color='#333333';" onmouseout="this.style.color='blue';"  data-toggle="tooltip" data-placement="bottom" title="Edit Action plan status"></i>
                                                            @endif
                                                        @endif
                                                      </td>
                                                </tr>
                                                    @if($loop->last)
                                                        <tr>
                                                            <td colspan="7">
                                                                <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 1px 1px; text-decoration: none; background-color: #007bff; color: #ffffff;" onclick="addmoretask('{{ $act->actionplanid}}','{{ $act->case_no_id}}')">
                                                                    <span style="font:face:Product Sans">Add More</span>
                                                                    <span><i class="fa fa-plus"></i></span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                            
                                        <!-- Content End-->
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                       @php($i++)
                        <!-- end action plan -->
                        @endforeach
                        @else
                        &nbsp;&nbsp;&nbsp;No record found
                        @endif


                    <a href="{{route('viewhypo', $casenoid)}}" style="float:right; color:grey"><i class='fa fa-arrow-circle-left'  data-toggle="tooltip" data-placement="bottom" title="Previous"></i> Previous</a> 
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    

<!-- add modal -->
  <form method="POST" action="{{ route('add_action_plan') }}" enctype="multipart/form-data">
                            @csrf
    <div class="modal fade" id="addactionplan" style="font-family: Product Sans;"> 
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Action Plan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="casenoidaddactionplan" id="casenoidaddactionplan" value="{{ $casenoid }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="casetitle">Start Date: </label><br>
                                        {{ \Carbon\Carbon::parse($invplanstartdate)->format('d/m/Y')}}
                                        <input type="hidden" name="startdateactionplan" id="startdateactionplan" value="{{ $invplanstartdate }}">
                                        <input type="hidden" name="startdateactionplanhidden" id="startdateactionplanhidden" value="{{ \Carbon\Carbon::parse($invplanstartdate)->format('d/m/Y')}}">
                                        
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="casetitle">End Date:</label><br>
                                       {{ \Carbon\Carbon::parse($invplanenddate)->format('d/m/Y')}}
                                </div>
                            </div>
                            </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="casetitle">Activity Category:<font color='red'>*</font></label>
                                        <select class="form-control"   name="actionplantaskactivityadd" id="actionplantaskactivityadd" required>
                                            <option value="">Select</option>
                                                @foreach ($tasktypes as $tasktype)
                                                    <option >{{ $tasktype->task_name }}</option>
                                                @endforeach    
                                        </select>
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="casetitle">Cycle:<font color='red'>*</font></label>
                                        <select class="form-control"   name="actionplantaskcycle" id="actionplantaskcycle" onchange="showDates()" required>
                                            <option value="">--Select One--</option>
                                            <option value="Weekly">Weekly</option>
                                            <option value="Fortnightly">Fortnightly</option>
                                            <option value="Monthly">Monthly</option>
                                        </select>
                                    
                                </div>
                            </div>
                            
                        </div>
                        <div id="nextDateContainer" style="display: none;">
                            <b>Cycle Dates:</b> <br><br>
                            From: <span id="firstDate"></span>&nbsp;&nbsp;&nbsp; To: <span id="nextDate"></span>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"> 
                                    <table class="table table-bordered" id="tasktable">
                                        <thead>
                                            <th>Task</th>
                                            <th>Description</th>
                                            <th>Priority</th>
                                            <th>Assigned To</th>
                                            <th>Due Date</th>
                                        </thead>
                                        <tbody id="actionplanbody">
                                            <tr>
                                                <td><input type="text" name="actionplantask[]" id="actionplantask[]" class='form-control' required></td>
                                                <td><input type="text" name="actionplandesc[]" id="actionplandesc[]" class='form-control' required></td>
                                                <td>
                                                    <select class="form-control"   name="actionplanpriority[]" id="actionplanpriority[]" required>
                                                        <option value="">Select Priority</option>
                                                            @foreach ($priority as $priority)
                                                                <option value = "{{ $priority->priority_type }}">{{ $priority->priority_type }}</option>
                                                            @endforeach    
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class  = "form-control" name="actionplanassignedto[]" id="actionplanassignedto[]" onchange="showadhoc()" required>
                                                        <option value="">Select</option>
                                                            @foreach ($useresults as $userusers)
                                                                <option value  = "{{ $userusers->assigned_to }}"><?php echo $key=DB::table('users')->where('email',$userusers->assigned_to)->value('name'); ?> </option>                                                                       </option>
                                                            @endforeach 
                                                    </select>
                                                </td>
                                                <td><input type="date" class  = "form-control" name="duedate[]" id="duedate[]" ></td>
                                                <td><i class="fa fa-plus" style="color:green" onclick="addtask()"></i></td>    
                                            </tr>
                                        </tbody>
                                    </table>
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

<!-- end add modal -->


<!-- add modal -->
  <form method="POST" action="{{ route('updateactionplanstatus') }}" enctype="multipart/form-data">
                            @csrf
    <div class="modal fade" id="editactionplanstatusmodal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="actionplanstatuseditid" id="actionplanstatuseditid">
                        <div class="row">
                            <div class="col-sm-10">
                                <label>Status&nbsp;<font color='red'>*</font></label>
                                    <select name="actionplanstatus" id="actionplanstatus" class="form-control" required>
                                        <option>Please Select</option>
                                        <option value="Complete">Complete</option>
                                        <option value="Discontinue" >Discontinue</option>
                                    </select> 
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Change</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- end add modal -->

<!-- add modal -->
  <form method="POST" action="{{ route('saveactionplanaddmore') }}" enctype="multipart/form-data">
        @csrf
    <div class="modal fade" id="addmoreactionplan">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Task</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="actionplanidaddmore" id="actionplanidaddmore">
                    <input type="hidden" name="casenoidaddmore" id="casenoidaddmore">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="casetitle">Task:<font color='red'>*</font></label>
                                        <input type="text" name="tasknameaddmore"  id="tasknameaddmore" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="casetitle">Description:<font color='red'>*</font></label>
                                        <input type="text" name="descriptionaddmore"  id="descriptionaddmore" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <label for="casetitle">Priority:<font color='red'>*</font></label>
                                        <select class="form-control" name="priorityaddmore" id="priorityaddmore" required>
                                            <option value="">Select Priority</option>
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <label for="casetitle">Assigned To:<font color='red'>*</font></label>
                                       <select class  = "form-control" name="assignedtoaddmore" id="assignedtoaddmore"  required>
                                            <option value="">Select</option>
                                                @foreach ($useresults as $userusers)
                                                    <option value  = "{{ $userusers->assigned_to }}"><?php echo $key=DB::table('users')->where('email',$userusers->assigned_to)->value('name'); ?> </option>                                                                       </option>
                                                @endforeach 
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="casetitle">Due Date:<font color='red'>*</font></label>
                                        <input type="date" name="duedateaddmore"  id="duedateaddmore" class="form-control">
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

<!-- end add modal -->

<script>

	function addnewactionplan()
    {
        $('#addactionplan').modal('show');  

    }

    function editactionplanstatus(id)
    {
        $('#editactionplanstatusmodal').modal('show'); 
        $('#actionplanstatuseditid').val(id);
        
    }

    function addtask() {
        
        html = '<tr>';
        html += '<td><input type="text" name="actionplantask[]" id="actionplantask[]" class="form-control"></td><td><input type="text" name="actionplandesc[]" id="actionplandesc[]" class="form-control"></td><td><select class="form-control" name="actionplanpriority[]"><option value="">Select Priority</option><option value="High">High</option> <option value = "Low">Low</option><option value="Medium">Medium</option></select></td><td><select class="form-control" name="actionplanassignedto[]"><option value="">Please Select One</option> @foreach ($useresults as $users)<option value = "{{ $users->assigned_to }}"><?php echo $key=DB::table('users')->where('email',$users->assigned_to)->value('name'); ?></option>@endforeach</select></td><td><input type="date" class  = "form-control" name="duedate[]" id="duedate[]" ></td><td><i class="fa fa-minus" style="color:red" onclick="removetask()"></i></td>'
        html += '</tr>'

        $('#actionplanbody').append(html);
    }
    
    function removetask() 
    {
        var $tableBody = $('#tasktable').find("tbody"),
        $trLast = $tableBody.find("tr:last"),
        $trNew = $trLast.remove();
    }

    function addmoretask(id,casenoid)
    {
        $('#actionplanidaddmore').val(id);
        $('#casenoidaddmore').val(casenoid);
        $('#addmoreactionplan').modal('show');
        

    }
    
    function showDates() {
    var startDate = document.getElementById("startdateactionplanhidden").value;
    var cycle = document.getElementById("actionplantaskcycle").value;

    // Parse the start date using the format 'd/m/Y' to create a JavaScript Date object
    var parsedStartDate = new Date(startDate.split("/").reverse().join("-"));

    // Initialize nextDate with the start date
    var nextDate = new Date(parsedStartDate);

    // Add days to the start date based on the cycle
    if (cycle === "Weekly") {
        nextDate.setDate(parsedStartDate.getDate() + 7);
    } else if (cycle === "Fortnightly") {
        nextDate.setDate(parsedStartDate.getDate() + 14);
    } else if (cycle === "Monthly") {
        nextDate.setDate(parsedStartDate.getDate() + 30);
    } else if (cycle === "") {
        document.getElementById("nextDateContainer").style.display = "none";
    }

    // Format the next date to 'd/m/Y' format
    var formattedNextDate = nextDate.getDate() + "/" + (nextDate.getMonth() + 1) + "/" + nextDate.getFullYear();

    // Display the formatted next date in the nextDateContainer
    document.getElementById("nextDate").textContent = formattedNextDate;
    document.getElementById("firstDate").textContent = startDate;
;

    // Show the nextDateContainer
    document.getElementById("nextDateContainer").style.display = "block";
}






</script>
<style>
    .modal-header {
        background: linear-gradient(to top, grey, #ffffff);
        color: #000;
        border-radius: 5px 5px 0 0;
        font-family: Product Sans;
        }
</style>
@endsection