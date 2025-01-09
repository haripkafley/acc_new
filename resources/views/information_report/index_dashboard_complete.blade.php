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
                
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> PENDING ASSIGNMENT </div>
                        <div class = "card-body">
                            
                             <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('member.get.information.report.assignment')) active btn btn-success @endif"  href="{{route('member.get.information.report.assignment')}}"> Ongoing</a>
                                </li>

                                
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('member.get.information.report.assignment.completed')) active btn btn-success @endif"  href="{{route('member.get.information.report.assignment.completed')}}">Completed</a>
                                </li>

                                
                            </ul>
                             
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>IP No.</th>
                                        <th>IR No.</th>
                                        <th>IR Title</th>
                                        <th>Corruption Offence</th>
                                        <th>Agency</th>
                                        <th>Area of Corruption</th>
                                        <th>Date Receipt</th> 
                                        {{-- <th>Source</th> --}}
                                        <th>Reported By & Date</th>
                                        {{-- <th>Days in Queue</th> --}}
                                        <th>Days in Queue</th>
                                        <th>Working Days</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$data->isNotEmpty())
                                       @foreach(@$data as $key=> $value)
                                       <tr>
                                           <td>{{@$value->ip_details->ip_no}}</td>
                                           <td>{{@$value->ir_details->ir_no}}</td>
                                           <td>{{@$value->ir_details->title}}</td>
                                           <td>{{@$value->ir_details->offence_name->offence_type}}</td>
                                           <td>{{@$value->ir_details->agency_name->agencyName}}</td>
                                           <td>{{@$value->ir_details->area_name->area_name}}</td>
                                           <td>{{@$value->ir_details->received_date}}</td>
                                           {{-- <td>{{@$value->source}}</td> --}}
                                           <td>{{@$value->ir_details->user_name->name}} - {{@$value->ir_details->date}}</td>
                                           <td>
                                            @php
                                            $from = Carbon\Carbon::parse(@$value->ir_details->received_date);
                                            $to = Carbon\Carbon::now();
                                            $days =  $from->diffInDays($to);
                                            @endphp

                                            {{@$days}} Days

                                           </td>

                                           <td>
                                            @php
                                            $from_start = DB::table('ir_form_team_member')->where('ir_id',@$value->ir_details->id)->orderBy('id','asc')->first();
                                            $from_work = Carbon\Carbon::parse($from_start->created_at);
                                            $to_work = Carbon\Carbon::now();
                                            $days_work =  $to_work->diffInWeekdays($from_work);
                                            @endphp

                                            {{@$days_work}} Days

                                           </td>
                                           

                                           <td>
                                               @if(@$value->coi_status=="AA")
                                               <a href="{{route('member.get.information.report.assignment.coi',['id'=>@$value->id])}}" class="btn btn-info">COI</a>
                                               @else
                                               <a href="{{route('member.get.information.report.assignment.details.project',['id'=>@$value->ir_id])}}" class="btn btn-success">+ Details Add</a>
                                               @endif
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