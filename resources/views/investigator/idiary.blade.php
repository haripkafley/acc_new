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
                <div class="tab-content" style="font-family:Product Sans" id="custom-tabs-four-tabContent">
                    @if(Auth::user()->role == "Investigator")
                        <button type="button" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" style="float:right" onclick="addidiary()">
                                <span><i class="fa fa-plus"></i></span>    
                                <span style="font:face:Product Sans">Add Idiary</span>
                        </button>
                    @endif
                    <br><br>
                        <table class="table t2" id="idiarytable">
                        <thead>    
                        <tr>
                                <th class="sorting sorting_asc">Date of Event</th>
                                <th>Activity Category</th>
                                <th>Description</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                        @foreach($idiarydetails as $idetails)
                            <tr>
                                <td> {{ \Carbon\Carbon::parse($idetails->date)->format('d/m/Y')}}</td>
                                <td> {{ $idetails->activity_category }}</td>
                                <td> {{ $idetails->task_to_be_done }}</td>
                                <td>
                                @if($idetails->start_time == "")
                                NA 
                                @else
                                 {{ date('g:i A', strtotime($idetails->start_time)) }}
                                @endif
                                </td>
                                <td>
                                @if($idetails->end_time == "")
                                NA 
                                @else
                                 {{ date('g:i A', strtotime($idetails->end_time)) }}
                                @endif
                                
                                <td> {{ \Carbon\Carbon::parse($idetails->created_at)->format('d/m/Y')}}</td>
                                
                                <td> 
                                @if(Auth::user()->role == "Investigator")
                                    @if($idetails->remarks =="")
                                        <i onclick="showeditidiary('{{ $idetails->id }}')" style="color:grey"  data-toggle="tooltip" data-placement="bottom" title="Edit"  class="fa fa-edit" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='grey';" ></i> &nbsp; 
                                        <a  href="{{ route('deleteidiary', $idetails->id) }}" style="color:red" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='red';" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash"></i></a>&nbsp; 
                                    @endif
                                @endif
                                </td>
                            </tr>
                        @endforeach  
                        </tbody>                                                                                  
                        </table> 
                    <br>
                </div>
            </div>
        <!-- /.card -->
    </div>
</div>


<!--add modal -->
<form method = "POST" action="{{ route('addidiary') }}"  enctype="multipart/form-data" >
      @csrf    
<div class="modal fade" id="addidiary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add iDiary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idiarycasenoadd" id="idiarycasenoadd" value="{{ $caseno }}">
                            <input type="hidden" name="idiarycasenoidadd" id="idiarycasenoidadd" value="{{ $casenoid }}">
                                <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="casetitle">Date of Event:<font color='red'>*</font></label>
                                                        <input type="date" name="idiary_date"  id="idiary_date" class="form-control" required="">
                                                </div>
                                            </div>
                                
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="casetitle">Activity Category:<font color='red'>*</font></label>
                                                    <select class="tasktype"   name="idiarytasktype" id="idiarytasktype" required>
                                                        <option value="">Select</option>
                                                            @foreach ($tasktypes as $tasktype)
                                                                <option >{{ $tasktype->task_name }}</option>
                                                            @endforeach    
                                                    </select>
                                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="casetitle">Start Time (Optional):</label>
                                                        <input type="time" name="idiary_starttime"  id="idiary_starttime" class="form-control" >
                                                </div>
                                            </div>
                                
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="casetitle">End Time (Optional):</label>
                                                    <input type="time" name="idiary_endtime"  id="idiary_endtime" class="form-control">
                                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group"> 
                                            <label for="casetitle">Activity Description:<font color='red'>*</font></label>
                                                    <textarea name="idiarytaskdetails" id="idiarytaskdetails" class="form-control"></textarea>
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
  <form method="POST" action="{{ route('updateidiary') }}" enctype="multipart/form-data">
                            @csrf
    <div class="modal fade" id="editidiary">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Idiary</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idiaryid" id="idiaryid">
                    <div id="editidiaryshow" style="display:none">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    </form>

<!-- end edit modal -->
<script>
function addidiary()
{

     $('#addidiary').modal('show');  
}

function showeditidiary(id)
{
    $('#editidiary').modal('show');     
    $('#idiaryid').val(id);

    var url = '{{ route("showeditidiary", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#idiaryid').val()},
                success: function(responseText) {
                    
                    $("#editidiaryshow").html(responseText);
                    $('#editidiaryshow').show();   
                }
            });
}
</script>
<style>
     .modal-header {
    background: linear-gradient(to top, #BFABA2, #ffffff);
    color: Black;
    font-family: Product Sans;
    border-radius: 5px 5px 0 0;
}
    
.t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
}
</style>
@endsection