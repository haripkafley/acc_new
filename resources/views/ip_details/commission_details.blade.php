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
                              Commission Decision
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                             
                                
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                             @include('ip_details.head_navbar')
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Commission Meeting No</th>
                                        <th>Meeting Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Created On (Date)</th>
                                        <th>Decision</th>
                                        <th>Attachment</th>
                                        <th>Chief Decision</th>
                                        <th>Action</th>         
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$decision->isNotEmpty())
                                    @foreach(@$decision as $att)
                                    <tr>
                                        <td>{{ $att->activity}}</td>
                                        <td>{{ $att->activity_date }}</td>
                                        <td>{{ $att->start_time }}</td>
                                        <td>{{ $att->end_time }}</td>
                                        <td>{{ $att->created_on_date }}</td>
                                        <td>{{ $att->status_details->name }}</td>

                                        <td>
                                            @if(@$att->attachment!="")
                                            <a class="btn btn-xs btn-info" href="{{URL::to('attachment/ir')}}/{{$att->attachment}}" target="_blank"><i class="fa fa-eye"></i>View
                                            </a>
                                            @endif
                                        </td>
                                        <td>@if(@$att->chief_decision=="AA") Awaiting Approval @elseif(@$att->chief_decision=="A")Accept @else Reject @endif</td>
                                        <td><a class="btn btn-xs btn-success" href="{{route('manage.ip.lists.head.chief.details.commission.details.view',['id'=>$att->id])}}" ><i class="fa fa-eye"></i>
                                                                View/Decision
                                         </a>
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


        <!-- Modal -->


    </div>
</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#activity').val($(this).data('activity'));
            $('#activity_date').val($(this).data('activity_date'));
            $('#start_time').val($(this).data('start_time'));
            $('#end_time').val($(this).data('end_time'));
            $('#decision').val($(this).data('decision')).change();

            $('#id').val($(this).data('id'));
            
            $('#exampleModaEdit').modal('show');
        })
</script>


@endsection