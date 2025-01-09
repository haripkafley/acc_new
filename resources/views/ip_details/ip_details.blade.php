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
                @include('ip_details.head_navbar')
        

                <div class="row">
                    <div class="col-sm-12">
                    <div class="card">
                    <p><b>Ir No:</b> {{@$data->ir_no}}</p>

                    <p><b>Ir Title:</b> {{@$data->title}}</p>
                    <p><b>Ir Description:</b> {{@$data->description}}</p>
                    <p><b>Report By:</b> 
                        @php
                                                $explode = explode(',',$data->report_by);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}} 
                                                @if (!$loop->last)
                                                    ,
                                                    @endif
                                            @endforeach</p>

                    <p><b>Received Date:</b> {{@$data->received_date}}</p>
                    <p><b>Occurance From:</b> {{@$data->occurance_from}}</p>
                    <p><b>Occurance Till:</b> {{@$data->occurance_till}}</p>
                    <p><b>Dzongkhag:</b> {{@$data->dzongkhagrelation->dzoName}}</p>
                    <p><b>Gewog:</b> {{@$data->gewogrelation->gewogName}}</p>
                    <p><b>Village:</b> {{@$data->villagerelation->villageName}}</p>

                    <p><b>Source:</b> @if(@$data->source=="Other"){{@$data->source}} - ({{@$data->source_other}}) @else {{@$data->source_name->name}} (Type - {{@$data->source_type}} )  @endif</p>
                    <p><b>Agency Name:</b> {{@$data->agency_name->agencyName}}</p>
                    <p><b>Corruption Offence:</b> {{@$data->offence_name->offence_type}}</p>
                    <p><b>Area:</b> {{@$data->area_name->area_name}}</p>
                    <p><b>Attachment:</b> <a class="btn btn-xs btn-info" href="{{URL::to('attachment/ir')}}/{{$data->attachment}}" target="_blank"><i class="fa fa-eye"></i>View
                    </a></p>

                  </div>
                </div>

                <div class="col-sm-12">
                    <div class="card">
                         <h5>Suspects/Witness</h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Person Type</th>
                                        <th>Nationality</th>
                                        <th>Name Of Suspect</th>
                                        <th>CID</th>
                                        <th>Identification No</th>
                                        <th>Country</th>
                                        <th>Phone</th>
                                        <th>DOB</th>
                                        <th>Address</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @if(@$suspects->isNotEmpty())
                                    @foreach(@$suspects as $att)
                                    <tr>
                                        <td>@if(@$att->person_type=='S') Suspect @else Witness @endif</td>
                                        <td>@if(@$att->nationality=="B")National @else Non-National @endif</td>
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->identity }}</td>
                                        <td>{{ $att->country }}</td>
                                        <td>{{ $att->phone_number }}</td>
                                        <td>{{ $att->dob }}</td>
                                        <td>{{ $att->address }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Suspect Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>


                <div class="col-sm-12">
                    <div class = "card">
                            <h5>Team Members</h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>EID</th>
                                        <th>Tole</th>
                                        <th>COI Status</th>
                                        <th>COI Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$team->isNotEmpty())
                                    @foreach(@$team as $att)
                                    <tr>
                                        
                                        <td>{{ @$att->user_details->name }} @if(@$att->user_details->unit!="") (Unit : {{$att->user_details->unit}}) @endif</td>
                                        <td>{{ @$att->user_details->eid }}</td>
                                        <td>@if(@$att->role=="TL") Team Lead @elseif(@$att->role=="M") Member @else Legal Representative @endif</td>
                                        <td>@if(@$att->coi_status=="AA") Awaiting COI @elseif(@$att->coi_status=="Y") Yes @else No @endif</td>
                                        <td>@if(@$att->describe_coi!=""){{ @$att->describe_coi }}@else -- @endif</td>
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


            

             

                

</section>




@endsection