@extends('layouts.admin')

@section('content')
<br>
@include('investigator/mainheader')
<!------------------------ end top part ---------------->
<!-- start -->
<div class="col-sm-13" style="margin-top:-9px;">
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            @include('tabs/investigator_tab')
        </div>
        <div class="card-body ">
            
            @if(Auth::user()->role == "Investigator")
            <form id="my-form" action="{{ route('updateinvplanstatus') }}" method="POST">
                @csrf
                    @if($invcount != 0 && $hypothesiscount != 0 && $actionplancount != 0 && $invstatus == 0)
                        <input type="hidden" id="casenoidinvstatusupdate" name="casenoidinvstatusupdate" value="{{ $casenoid }}">
                        <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" onclick="sendforevaluation('{{ $casenoid }}')">
                                <span style="font:face:Product Sans">Send for Review</span>
                        </button>
                    @endif
            </form>
            @include('tabs/investigationplan_tab')
                @if($invcount ==0 && Auth::user()->role == "Investigator")
                    <button type="button" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" style="float:right" onclick="addnewinvplan()">
                        <span><i class="fa fa-plus"></i></span>    
                        <span style="font:face:Product Sans">Add Investigation Plan</span>
                    </button>
                        <br> <br>
                    <div class="header" style="height:40px; border-radius:5px; margin-top:10px;">&nbsp;&nbsp;<font color='#000000' size="5.2" face="Product Sans">  Overview</font></div>
                    <br>
                    &nbsp;&nbsp;No Plan Found
                @else
                    @foreach($investigationplans as $invplan)  
                    <br>@if($invcount != 0 && Auth::user()->role == "Investigator")
                            <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;" onclick="editnewinvplan('{{ $invplan->id}}')">
                                <span><i class="fa fa-pencil"></i></span>
                                <span style="font:face:Product Sans">Edit</span>
                            </button>
                            @endif
                    <br><br>
                        <div class="header" style="height:40px; border-radius:5px; margin-top:10px;">&nbsp;&nbsp;<font color='#000000' size="5.2" face="Product Sans"> Overview</font></div>
                            <div class="card-body gray-border">
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="Black">Start Date:</font>
                                    </div>
                                    <div class="col-md-9">
                                        <font face="Product Sans" color="Grey">{{ \Carbon\Carbon::parse($invplan->case_start_date)->format('d/m/Y')}}</font>
                                    </div>
                                </div>
                                <hr class="hrnew"></hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="black">End Date:</font>
                                    </div>
                                    <div class="col-md-9">
                                        <font face="Product Sans" color="grey">{{ \Carbon\Carbon::parse($invplan->case_end_date)->format('d/m/Y')}}</font>
                                    </div>
                                </div>
                                <hr  class="hrnew"></hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="black">Allegations/Background:</font>
                                    </div>
                                    <div class="col-md-9">
                                        <font face="Product Sans" color="grey">{{ $invplan->allegations}}</font>
                                    </div>
                                </div>
                                <hr class="hrnew"></hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="black">Objectives of Investigation:</font>
                                    </div>
                                    <div class="col-md-9">
                                        <font face="Product Sans" color="grey">{{ $invplan->objectives }}</font>
                                    </div>
                                </div>
                                <hr  class="hrnew"></hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="black">Scope of Investigation:</font>
                                    </div>
                                    <div class="col-md-9">
                                        <font face="Product Sans" color="grey">{{ $invplan->scope }}</font>
                                    </div>
                                </div>
                                <hr  class="hrnew"></hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="black">Probable Offences:</font>
                                    </div>
                                    <div class="col-md-9">
                                        @foreach($investigationplanoffences as $offenceinv)
                                            <font face="Product Sans" color="grey"> {{ $offenceinv->offence_type }}</font> <br>
                                        @endforeach
                                    </div>
                                </div>
                                <a href="{{route('viewhypo', $casenoid)}}" style="float:right; color:grey"><i class='fa fa-arrow-circle-right'  data-toggle="tooltip" data-placement="bottom" title="Next"></i> Next</a>
                        </div>
                    @endforeach
                @endif
                @endif
                <div id="divToPrint">
                @if(Auth::user()->role == "Chief")
                @if($invstatus == 0 )
                    <div class="header" style="height:40px; text-decoration: underline;  border-radius:5px; margin-top:10px;"><font color='#000000' size="5.2" face="Product Sans">  Overview</font></div>
                    <br>
                    No Plan Found
                @else
                <div class="header" style="height:40px; text-decoration: underline;  border-radius:5px; margin-top:10px;"><font color='#000000' size="5.2" face="Product Sans"> Overview </font><i style="float:right; color:black; margin-top: 10px;" onclick="printDiv()" class="fa fa-print" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='grey';"  data-toggle="tooltip" data-placement="bottom" title="Print Investigation Plan"></i></div>
                    @foreach($investigationplans as $invplan)  
                        
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="Black">Start Date:</font>
                                    </div>
                                    <div class="col-md-9">
                                        <font face="Product Sans" color="Grey">{{ \Carbon\Carbon::parse($invplan->case_start_date)->format('d/m/Y')}}</font>
                                    </div>
                                </div>
                                <hr class="hrnew"></hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="black">End Date:</font>
                                    </div>
                                    <div class="col-md-9">
                                        <font face="Product Sans" color="grey">{{ \Carbon\Carbon::parse($invplan->case_end_date)->format('d/m/Y')}}</font>
                                    </div>
                                </div>
                                <hr  class="hrnew"></hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="black">Allegations/Background:</font>
                                    </div>
                                    <div class="col-md-9">
                                        <font face="Product Sans" color="grey">{{ $invplan->allegations}}</font>
                                    </div>
                                </div>
                                <hr class="hrnew"></hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="black">Objectives of Investigation:</font>
                                    </div>
                                    <div class="col-md-9">
                                        <font face="Product Sans" color="grey">{{ $invplan->objectives }}</font>
                                    </div>
                                </div>
                                <hr  class="hrnew"></hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="black">Scope of Investigation:</font>
                                    </div>
                                    <div class="col-md-9">
                                        <font face="Product Sans" color="grey">{{ $invplan->scope }}</font>
                                    </div>
                                </div>
                                <hr  class="hrnew"></hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <font face="Product Sans" color="black">Probable Offences:</font>
                                    </div>
                                    <div class="col-md-9">
                                        @foreach($investigationplanoffences as $offenceinv)
                                            <font face="Product Sans" color="grey"> {{ $offenceinv->offence_type }}</font> <br>
                                        @endforeach
                                    </div>
                                </div>
                    @endforeach
                @endif
                <br>
                @if(Auth::user()->role == "Chief")
                
                <div class="header" style="height:40px;text-decoration: underline;  border-radius:5px; margin-top:10px;"><font color='#000000' size="5.2" face="Product Sans">Hypothesis</font></div>
                        <br>
                    @if($invstatus == 0 )
                        
                        No Record Found
                    @else
                        <table class="table t2" id="hypothesistable">
                            <tr>
                                <th class="sorting sorting_asc">Hypothesis</th>
                                <th>Evidence</th>
                                <th>Evaluation Status</th>
                                <th>Evaluated On</th>
                                <th>Action</th>
                            </tr>
                                @if($hypothesis->count())
                                @foreach ($hypothesis as $hypo)
                                    <tr>
                                        <td>{{ $hypo->hypotheses}}</td>
                                        <td>
                                           <ul>
                                                @foreach ($hypoevidence->where('hypothesis_id', $hypo->id) as $hypoevi)
                                                    <li>{{ $hypoevi->evidences }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            @if($hypo->evaluation_status == "Not Evaluated")
                                                Not Evaluated
                                            @else
                                                <?php echo $key=DB::table('tbl_assessment_types_lookup')->where('id',$hypo->evaluation_status)->value('name') ?>
                                            @endif
                                        </td>
                                        <td>
                                            @if($hypo->evaluated_on == "")
                                                NA
                                            @else
                                                {{ \Carbon\Carbon::parse($hypo->evaluated_on)->format('d/m/Y')}}
                                            @endif
                                        </td>

                                        <td>
                                            @if(Auth::user()->role == "Investigator")
                                                @if($hypo->evaluation_status == "Not Evaluated")
                                                    <i class="fa fa-pencil"  onclick="showevaluateevidence('{{ $hypo->id }}')"></i>&nbsp; &nbsp;
                                                @endif
                                                <a  href="{{ route('deletehypothesis', $hypo->id) }}" style="color:grey" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='grey';" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Are you sure you want to delete this record?') || event.preventDefault();"><i class="fa fa-trash"></i></a>&nbsp; 
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="5"> No record found </td>
                            </tr>
                            @endif
                        </table>  
                        @endif
                        @endif
                        @if(Auth::user()->role == "Chief")
                        <div class="header" style="height:40px; border-radius:5px;text-decoration: underline;  margin-top:10px;"><font color='#000000' size="5.2" face="Product Sans">Action Plan</font></div>
                        <br>
                    @if($invstatus == 0 )
                        
                        No Record Found
                    @else
                      @if($actionplans->count())
                        @php($i=0)
                        @foreach($actionplans as $actplans)
                        <!-- action plan accordian -->
                           <!-- <div id="accordion" style="margin-top:-40px;">
                                <div class="card">
                                    <div class="card-header custom-header" id="headingOne_{{ $i}}">
                                        <h5 class="mb-0">
                                            &nbsp; &nbsp; 
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo_{{ $i}}" aria-expanded="true" aria-controls="collapseTwo_{{ $i}}">
                                                    <font color='#000000'  size="3"  face="Product Sans"> Week {{ $actplans->weekname}} &nbsp; [{{ \Carbon\Carbon::parse($actplans->actionplanstartdate)->format('d/m/Y')}}  to {{ \Carbon\Carbon::parse($actplans->actionplanenddate)->format('d/m/Y')}}]</font>
                                            </button>
                                            </h5>
                                    </div>
                                <div id="collapseTwo_{{ $i}}" class="collapse hide" aria-labelledby="headingOne_{{ $i}}" data-parent="#accordion"> -->
                                    <div class="card-body">
                                        <!-- Content Start-->
                                        <table class="table table-bordered" id="tasktable">
                                            <thead>
                                                <td>Sl No</td>
                                                <th>Task Name</th>
                                                <th>Description</th>
                                                <th>Priority</th>
                                                <th>Assigned To</th>
                                                <th>Assigned On</th>
                                                <th>Due Date</th>
                                            </thead>
                                            <tbody id="actionplanbody">
                                                @foreach($taskactivities as $act)  
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $act->task}}</td>
                                                    <td>{{ $act->description}}</td>
                                                    <td>{{ $act->priority}}</td>
                                                    <td><?php echo $key=DB::table('users')->where('email',$act->assigned_to)->value('name'); ?></td>
                                                    <td>{{ \Carbon\Carbon::parse($act->assigned_on)->format('d/m/Y')}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($act->due_date)->format('d/m/Y')}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!-- Content End-->
                                    </div>
                                </div>
                            <br>
                            <br>
                       @php($i++)
                        <!-- end action plan -->
                        @endforeach
                        @else
                        No record found
                        @endif
                @endif

                @endif
</div>
                @endif
        </div>
    </div>
</div>
<!-- end -->

<!--add modal -->
<form method = "POST" action="{{ route('add_investigation_plan') }}"  enctype="multipart/form-data" >
      @csrf    
<div class="modal fade" id="addinvplan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content">                                                                                                                                                                                         <div class="modal-header alert-info">
                <h5 class="modal-title" id="exampleModalLabel">Add Overview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <font face="Product Sans" color="Grey">Start Date:<font color='red'>*</font></font>
                                <input type="date" name="case_start_date" id="case_start_date" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <font face="Product Sans" color="Grey">Expected End Date:<font color='red'>*</font></font>
                                <input type="date" name="case_end_date" onchange="validateDateRange()" id="case_end_date" class="form-control" required="">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="invplancasenoadd" id="invplancasenoadd" value="{{ $caseno }}">
                    <input type="hidden" name="invplancasenoidadd" id="invplancasenoidadd" value="{{ $casenoid }}">
                    <input type="hidden" name="dayscalculated" id="dayscalculated" value="">
                    <input type="hidden" name="registration_date_invplan" class="form-control" id="registration_date_invplan" value="{{ $caseregistrationdate }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <font face="Product Sans" color="Grey">Allegations/Background:<font color='red'>*</font></font>
                                <textarea name="case_allegations" id="case_allegations" class="form-control"
                                    required=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <font face="Product Sans" color="Grey">Objectives:<font color='red'>*</font></font>
                                <textarea name="case_objectives" id="case_objectives" class="form-control"
                                    required=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <font face="Product Sans" color="Grey">Probable Offence:<font color='red'>*</font></font>
                                <select class="offence_type_invplan" multiple="multiple" name="offence_type_invplan[]" required>
                                    <option value="">Select Offence Type</option>
                                    @foreach ($offencetypes as $offence)
                                    <option>{{ $offence->offence_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <font face="Product Sans" color="Grey">Scope:<font color='red'>*</font></font>
                                <textarea name="case_scope" id="case_scope" class="form-control" required=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end add modal -->

<!-- edit modal -->
  <form method="POST" action="{{ route('updateinvplan') }}" enctype="multipart/form-data">
                            @csrf
    <div class="modal fade" id="editinvplanmodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Plan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="invplaneditid" id="invplaneditid">
                    <input type="hidden" name="invplancasenoupdate" id="invplancasenoupdate" value="{{ $caseno }}">
                    <input type="hidden" name="invplancasenoidupdate" id="invplancasenoidupdate" value="{{ $casenoid }}">
                    <div id="showeditinvplan" style="display:none;"> </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    </form>

<!-- end edit modal -->

<style>
.hrnew {
  border: none;
  border-top: 2px dotted #ccc;
  height: 15px;
  margin: 10px 0;
}


.tabs {
    display: block;
    justify-content: space-between;
    margin-bottom: 10px;
    width: 600px;
}

.tablinks {
    background-color: #fff;
    border: none;
    color: grey;
    font-family: Product Sans;
    cursor: pointer;
    padding: 10px;
    width: 17.33%;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

/* Change the background color of active tab */
.tablinks.active {
    border-bottom: 3px solid #007BFF;
    font-family: Product Sans;
    color: #007BFF;
    
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 20px;
    background-color: #fff;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
}

/* Show the active tab */
.tabcontent.show {
    display: block;
}

    .modal-header {
    background: linear-gradient(to top, #BFABA2, #ffffff);
    color: #000;
    font-family: Product Sans;
    border-radius: 5px 5px 0 0;
}
.gray-border {
    border: 1px solid gray;
  }
</style>
<script>

function validateDateRange() {
     var startDate = new Date(document.getElementById('case_start_date').value);
    var endDate = new Date(document.getElementById('case_end_date').value);
    var sevenDaysLater = new Date(startDate);
    sevenDaysLater.setDate(startDate.getDate() + 7); // Adding 7 days

    if (endDate < sevenDaysLater) {
        alert("End date should be at least one week after the start date.");
        // Clear the value of case_end_date to enforce user compliance
        document.getElementById('case_end_date').value = "";
    }
}


function addnewinvplan() {
    
    $('#addinvplan').modal('show');  

}

function editnewinvplan(id)
{
    $('#editinvplanmodal').modal('show'); 
    $('#invplaneditid').val(id);

    var url = '{{ route("editinvplan", ":id") }}';
    url = url.replace(':id', id);

    $.ajax({

        type: "GET",
        url: url,
        data: {
            search: $('#invplaneditid').val()
        },
        success: function(responseText) {

            $("#showeditinvplan").html(responseText);
            $("#showeditinvplan").show();
        }
    });
}

function printDiv() {
        // Get the content of the div you want to print
        var divContents = document.getElementById('divToPrint').innerHTML;
        // Create a new window for printing
        var printWindow = window.open('', '_blank', 'height=600,width=800');
        // Write the div content to the new window
        printWindow.document.write('<html><head><title>Print</title></head><body>' + divContents + '</body></html>');
        // Close the document stream to start the printing process
        printWindow.document.close();
        // Call the print() method to print the new window
        printWindow.print();
    }

    

</script>

@endsection