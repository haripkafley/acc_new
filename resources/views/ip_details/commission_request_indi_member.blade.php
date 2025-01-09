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
                              Commission Meeting Request
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            
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
                                        <th>Your Decision</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->commission_details->activity}}</td>
                                        <td>{{ $att->commission_details->activity_date }}</td>
                                        <td>{{ $att->commission_details->start_time }}</td>
                                        <td>{{ $att->commission_details->end_time }}</td>
                                        <td>{{ $att->commission_details->created_on_date }}</td>
                                        <td>{{ $att->commission_details->status_details->name }}</td>
                                        
                                        <td>
                                            @if(@$att->commission_details->attachment!="")
                                            <a class="btn btn-xs btn-info" href="{{URL::to('attachment/ir')}}/{{$att->commission_details->attachment}}" target="_blank"><i class="fa fa-eye"></i>View
                                            </a>
                                            @endif
                                        </td>

                                        <td>@if(@$att->status=="AA") Awaiting Approval @elseif(@$att->status=="A") Accept @else Reject @endif </td>

                                        
                                        <td>
                                                        
                                                            
                                                             
                                                            
                                                            <a class="btn btn-xs btn-success" href="{{route('ip.commission.member.get.request.view.details',['id'=>$att->id])}}" ><i class="fa fa-users"></i>
                                                                View Details
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


</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


@endsection