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
                                Assigned Tasks
                            </div>

                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <a  href="{{route('manage.evidence.task.management.add')}}" class="btn btn-primary" >
                                    Add Task
                                </a>
                                
                            </div>
                           </div>


                    </div>

                    


                        <div class = "card-body">
                            
                              
                            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        
                                        <th>Name of Staff</th>
                                        <th>CID</th>
                                        <th>Type of Task</th>
                                        <th>Assigned Task</th> 
                                        <th>Assigned Task Details</th> 
                                        <th>Date of Assignment</th> 
                                        <th>Status</th> 
                                        {{-- <th>Completion</th> --}}
                                        <th>Turn Around Time</th>   
                                        <th>Action</th>         
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$data->isNotEmpty())
                                    
                                    @foreach(@$data as $key=> $att)
                                    <tr>
                                        <td>{{ @$att->user_details->name}}</td>
                                        <td>{{ $att->user_details->cid}}</td>
                                        <td>{{ $att->task_type->task_name }}</td>
                                        <td>{{ $att->task_name->invTaskName }}</td>
                                        <td>{{ $att->task_description}}</td>
                                        <td>{{ $att->date_assignment}}</td>
                                        <td>@if($att->status=="AA") Awaiting Approval @else {{@$att->status}}  @endif</td>
                                        {{-- <td>{{ $att->completion}}</td> --}}
                                        <td>
                                            @if(@$att->status=="Completed")
                                            @php
                                            $from = Carbon\Carbon::parse(@$att->date_assignment);
                                            $to = Carbon\Carbon::parse(@$att->status_update_date);
                                            $days =  $to->diffInWeekdays($from);
                                            @endphp

                                            {{@$days}} days
                                            @else

                                            @php
                                            $from = Carbon\Carbon::parse(@$att->date_assignment);
                                            $to = Carbon\Carbon::parse(date('Y-m-d'));
                                            $days =  $to->diffInWeekdays($from);
                                            @endphp

                                            {{@$days}} days


                                            @endif
                                        </td>
                                        
                                        <td>
                                           
                                                <a href="{{route('manage.evidence.task.management.delete',$att->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                
                                                
                                                <a href="{{route('manage.evidence.task.management.edit',@$att->id)}}" data-status="{{@$att->status}}" data-remarks="{{@$att->remarks}}"  class="btn btn-warning mt-2 "><i class="fa fa-edit"></i>+<i class="fa fa-eye"></i></a>
                                                
                                            

                                        </td>
                                    </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>
                                  
                        </div>
                </div>
            </div>
        </div>

                <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Complaint Mode</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('complaint-type-master.update')}}">@csrf
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Status</label>
                                  <input type="text" class="form-control" id="status" disabled name="status" aria-describedby="emailHelp">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Remarks</label>
                                  <textarea type="text" class="form-control" disabled id="remarks" name="remarks" aria-describedby="emailHelp"></textarea>
                                 </div>

                                 
                             
                              </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
</section>



<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" charset="utf8"
    src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});


</script>
<script type="text/javascript">
    $('.view_button').on('click',function(){
            $('#status').val($(this).data('status'));
            $('#remarks').val($(this).data('remarks'));
            
            $('#exampleModaEdit').modal('show');
        })
</script>

@endsection