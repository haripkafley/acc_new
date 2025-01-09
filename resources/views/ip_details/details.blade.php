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
                @include('ip_details.member_navbar')
        

                <div class="row">
                    <div class="col-sm-6">
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
                    <p><b>Source:</b> @if(@$data->source=="Other"){{@$data->source}} - ({{@$data->source_other}}) @else {{@$data->source_name->name}}  @endif</p>
                    <p><b>Agency Name:</b> {{@$data->agency_name->agencyName}}</p>
                    <p><b>Corruption Offence:</b> {{@$data->offence_name->offence_type}}</p>
                    <p><b>Area:</b> {{@$data->area_name->area_name}}</p>
                    <p><b>Attachment:</b> <a class="btn btn-xs btn-info" href="{{URL::to('attachment/ir')}}/{{$data->attachment}}" target="_blank"><i class="fa fa-eye"></i>View
                    </a></p>

                  </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Person Type</th>
                                        <th>Nationality</th>
                                        <th>Name Of Suspect</th>
                                        <th>EID</th>
                                        <th>Identification No</th>
                                        <th>Country</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @if(@$suspects->isNotEmpty())
                                    @foreach(@$suspects as $att)
                                    <tr>
                                        <td>@if(@$att->person_type=="S")Suspect @else Witness @endif</td>
                                        <td>@if(@$att->nationality=="B")National @else Non-National @endif</td>
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->identity }}</td>
                                        <td>{{ $att->country }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Suspect Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>



        </div>
    </div>


            

             

                

</section>




@endsection