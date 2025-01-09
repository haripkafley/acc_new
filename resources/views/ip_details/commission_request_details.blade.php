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
                              <div class="row"><div class="col-md-12 text-right"><a class=" active btn btn-success text-left"  href="{{route('ip.commission.request.list')}}"> Back</a></div></div>
                                
                               
                            </div>
                          </div>
                          
                    </div>

                        <div class="row">

                            <div class="col-sm-6 card-body">
                                
                                <p><b>Ir No:</b> {{@$ir_details->ir_no}}</p>

                                <p><b>Ir Title:</b> {{@$ir_details->title}}</p>
                                <p><b>Ir Description:</b> {{@$ir_details->description}}</p>
                                <p><b>Report By:</b> {{@$ir_details->user_name->name}}</p>

                                <p><b>Received Date:</b> {{@$ir_details->received_date}}</p>
                                <p><b>Source:</b> @if(@$ir_details->source=="Other"){{@$ir_details->source}} - ({{@$ir_details->source_other}}) @else {{@$ir_details->source_name->name}}  @endif</p>
                                <p><b>Agency Name:</b> {{@$ir_details->agency_name->agencyName}}</p>
                                <p><b>Corruption Offence:</b> {{@$ir_details->offence_name->offence_type}}</p>
                                <p><b>Area:</b> {{@$ir_details->area_name->area_name}}</p>
                                <p><b>Attachment:</b> <a class="btn btn-xs btn-info" href="{{URL::to('attachment/ir')}}/{{$ir_details->attachment}}" target="_blank"><i class="fa fa-eye"></i>View
                                </a></p>


                            </div>

                            
                            <div class="col-md-6 card-body">
                                <p><b>Commission Meeting No</b> : {{@$data->activity}}</p>
                                <p><b>Meeting Date</b> : {{@$data->activity_date}}</p>
                                <p><b>Start Time</b> : {{@$data->start_time}}</p>
                                <p><b>End Time</b> : {{@$data->end_time}}</p>
                                <p><b>Created On (Date)</b> : {{@$data->created_on_date}}</p>
                                <p><b>Decision</b> : {{ $data->status_details->name }}</p>
                                <p><b>Attachment</b> :  
                                    @if(@$data->attachment!="")
                                    <a class="btn btn-xs btn-info" href="{{URL::to('attachment/ir')}}/{{$data->attachment}}" target="_blank"><i class="fa fa-eye"></i>View
                                    </a>
                                @endif</p>
                                <p><b>Remarks</b> : {{ $data->remarks }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 card-body">
                                <form method="post" action="{{route('ip.commission.request.list.insert.head.approval')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{@$id}}">
                                    <div class="form-group">
                                        <label> Approval</label>
                                        <select name="head_decision" class="form-control">
                                            <option value="AA" @if(@$data->head_decision=="AA") selected @endif)> Awaiting Approval</option>
                                            <option value="A" @if(@$data->head_decision=="A") selected @endif> Accept</option>
                                            <option value="R" @if(@$data->head_decision=="R") selected @endif> Reject</option>
                                        </select>
                                        
                                    </div>

                                    <div class="form-group">
                                        <label> Remarks</label>
                                        <textarea class="form-control" name="head_remark" required>{{@$data->head_remark}}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                </form>
                            </div>
                        </div>


                        <div class = "card-body">
                           
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Member Name</th>
                                        <th>Decision</th>
                                        <th>Remarks / Reason</th>
                                                
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$members->isNotEmpty())
                                    @foreach(@$members as $att)
                                    <tr>
                                        <td>{{ $att->user_details->name}}</td>
                                        <td>@if(@$att->status=="AA") Awaiting Approval @elseif(@$att->status=="A") Accept @else Reject @endif</td>
                                        <td>@if(@$att->remarks=="") -- @else {{@$att->remarks}} @endif</td>
                                        
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