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
                                My Assignment
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
                                           
                                                <a href="{{route('get.tasks.assignment.list.case.update.decision',$att->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                

                                            

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

$(".radio_option:radio").on('change',function(){
   
    $('.id_value').val($(this).data('id'));
    $('.optradio_value').val($(this).val());
    
    $('#form_submit').submit();
});
</script>


@endsection