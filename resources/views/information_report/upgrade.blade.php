@extends('layouts.admin')

@section('content')
<link
rel="stylesheet"
type="text/css"
href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"
/>

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('information_report.navbar')
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> UPGRADE ASSIGNMENT </div>
                        <div class = "card-body">
                            
                             
                             
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>IR No.</th>
                                        <th>IP No.</th>
                                        <th>IR Title</th>
                                        <th>Corruption Offence</th>
                                        <th>Agency</th>
                                        <th>Area of Corruption</th>
                                        <th>Date Receipt</th> 
                                        {{-- <th>Source</th> --}}
                                        <th>Reported By & Date</th>
                                        <th>Days in Queue</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$data->isNotEmpty())
                                       @foreach(@$data as $key=> $value)
                                       @php

                                       @endphp
                                       <tr>
                                           {{-- <td>{{@$value->complaintID}}</td> --}}
                                           <td>{{@$value->ir_no}}</td>
                                           <td>{{@$value->ip_details->ip_no}}</td>
                                           <td>{{@$value->title}}</td>
                                           <td>{{@$value->offence_name->offence_type}}</td>
                                           <td>{{@$value->agency_name->agencyName}}</td>
                                           <td>{{@$value->area_name->area_name}}</td>
                                           <td>{{@$value->received_date}}</td>
                                           {{-- <td>{{@$value->source}}</td> --}}
                                           <td>@php
                                                $explode = explode(',',$value->report_by);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}} 
                                                @if (!$loop->last)
                                                    ,
                                                    @endif
                                            @endforeach - {{@$value->date}}</td>
                                           <td>
                                            @php
                                            $from = Carbon\Carbon::parse(@$value->received_date);
                                            $to = Carbon\Carbon::now();
                                            $days =  $from->diffInDays($to);
                                            @endphp

                                            {{@$days}} Days

                                           </td>
                                           

                                           <td>
                                              
                                               <a href="{{route('information.report.form.team.member',['id'=>@$value->id])}}" class="btn btn-info">Assign Member</a>
                                              
                                           </td>

                                       </tr>
                                       @endforeach
                                       @endif            
                                </tbody>
                            </table>
                       
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>
<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
$(function() {
$("#maintable").dataTable({
    "order": [
    [5, "desc"]
  ]
});
});
</script>
@endsection