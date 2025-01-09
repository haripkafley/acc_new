@extends('layouts.admin')

@section('content')
    <style type="text/css">
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
        .tox .tox-notification--warn, .tox .tox-notification--warning {
            display: none;
        }
            
        .card{
            padding: 25px;
        }

            </style>
<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                    <div class="card">
                    @if(@$data->sl_no!="")    
                    <p><b>SL No:</b> {{@$data->sl_no}}</p>
                    @endif
                    @if(@$data->type_ti=="S" && @$data->si_ig_no!="")
                    <p><b>SI NO:</b> {{@$data->si_ig_no}}</p>
                    @elseif(@$data->type_ti=="IG" && @$data->si_ig_no!="")
                    <p><b>IG NO:</b> {{@$data->si_ig_no}}</p>
                    @endif
                    <p><b>Request Type:</b> {{@$data->request_type_details->name}}</p>
                    <p><b>Reason:</b> {{@$data->reason}}</p>
                    <p><b>Suspect Details:</b> {{@$data->suspect_details}}</p>
                    <p><b>In Relation To:</b> {{@$data->relation_to}}</p>
                    <p><b>Requesting Officer:</b> {{@$data->officer_details->name}}</p>

                    <p><b>Request Date:</b> {{@$data->request_date}}</p>
                    <p><b>Start Date:</b> {{@$data->start_date}}</p>
                    <p><b>End Date:</b> {{@$data->end_date}}</p>

                    @php
                      $from = Carbon\Carbon::parse(@$data->request_date);
                      $to = Carbon\Carbon::now();
                      $days =  $from->diffInDays($to);
                    @endphp


                    <p><b>Running Days:</b> {{@$days}} Days</p>

                    @if(@$data->recommend_date!="")
                    <p><b>Recommended By:</b> {{@$data->recommend_details->name}}</p>
                    <p><b>Recommended Date:</b> {{@$data->recommend_date}}</p>
                    <p><b>Recommended Remarks:</b> {{@$data->recommend_remarks}}</p>
                    @endif


                    @if(@$data->com_date!="")
                    <p><b>Commission Decision:</b> 
                        @if(@$data->com_decision=="AP") Approved @elseif(@$data->com_decision=="DF") Deferred @else Rejected @endif

                    </p>
                    <p><b>Commission Date:</b> {{@$data->com_date}}</p>
                    <p><b>Commission Remarks:</b> {{@$data->com_remarks}}</p>
                    @endif
                    

                  </div>
                </div>



                @if(@$members->isNotEmpty())
                <div class="col-md-6">
                <div class="card card-primary card-outline card-outline-tabs">

                    <div class="card-header" style="font-family:Product Sans"> Team Members </div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>CID</th>
                                        <th>Role</th>
                                        <th>COI Status</th>
                                        <th>COI Description</th>
                                                
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$members->isNotEmpty())
                                    @foreach(@$members as $att)
                                    <tr>
                                        
                                        <td>{{ $att->user_details->name }}</td>
                                        <td>{{ $att->user_details->cid }}</td>
                                        <td>@if(@$att->role=="TL") Team Lead @else Member @endif</td>
                                        <td>@if(@$att->coi_status=="Y") Yes @elseif(@$att->coi_status=="N") No @else Awating Approval @endif</td>
                                        <td>{{ @$att->describe_coi }}</td>
                                        
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Member Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
            @endif

            </div>
    </div>


            

             

                

</section>




@endsection