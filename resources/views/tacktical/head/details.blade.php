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
                
                @include('tacktical.head.navbar')

                <div class="row">
                    <div class="col-sm-6">
                    <div class="card">
                    <p><b>SL No:</b> {{@$data->sl_no}}</p>
                    @if(@$data->type_ti=="S")
                    <p><b>SI NO:</b> {{@$data->si_ig_no}}</p>
                    @else
                    <p><b>IG NO:</b> {{@$data->si_ig_no}}</p>
                    @endif
                    <p><b>Request Type:</b> {{@$data->request_type->name}}</p>
                    <p><b>Reason:</b> {{@$data->reason}}</p>
                    <p><b>Suspect Details:</b> {{@$data->suspect_details}}</p>
                    <p><b>In Relation To:</b> {{@$data->relation_details->name}}</p>
                    <p><b>Requesting Officer:</b> {{@$data->officer_details->name}}</p>

                    <p><b>Request Date:</b> {{@$data->request_date}}</p>
                    <p><b>Start Date:</b> {{@$data->start_date}}</p>
                    <p><b>End Date:</b> {{@$data->end_date}}</p>
                    <p><b>Recommended By:</b> {{@$data->recommend_details->name}}</p>
                    <p><b>Recommended Date:</b> {{@$data->recommend_date}}</p>
                    <p><b>Recommended Remarks:</b> {{@$data->recommend_remarks}}</p>

                    <p><b>Commission Decision:</b> Approved</p>
                    <p><b>Commission Date:</b> {{@$data->com_date}}</p>
                    <p><b>Commission Remarks:</b> {{@$data->com_remarks}}</p>
                    
                    

                  </div>
                </div>

                <div class="col-md-6">
                <div class="card card-primary card-outline card-outline-tabs">

                    <div class="card-header" style="font-family:Product Sans"> Team Members </div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>EID</th>
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
                                        <td>{{ $att->user_details->eid }} @if(@$att->user_details->unit!="") (Unit : {{$att->user_details->unit}}) @endif</td>
                                        <td>@if(@$att->role=="TL") Team Lead @elseif(@$att->role=="M") Member @else Legal Representative @endif</td>
                                        <td>@if(@$att->coi_status=="Y") Yes @elseif(@$att->coi_status=="N") No @else Awating COI @endif</td>
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
            </div>
    </div>


            

             

                

</section>




@endsection