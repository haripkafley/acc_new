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
                    <div class="card-header" style="font-family:Product Sans"> Completed Information Protocol </div>
                        <div class = "card-body">
                            
                             <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('manage.ip.lists.head.chief')) active btn btn-success @endif"  href="{{route('manage.ip.lists.head.chief')}}"> Ongoing</a>
                                </li>

                                
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.completed')) active btn btn-success @endif"  href="{{route('manage.ip.lists.head.chief.completed')}}">Completed</a>
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
                                        <th>Reported By & Date</th>
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
                                           <td>{{@$value->ir_no}}</td>
                                           <td>{{@$value->title}}</td>
                                           <td>{{@$value->offence_name->offence_type}}</td>
                                           <td>{{@$value->agency_name->agencyName}}</td>
                                           <td>{{@$value->area_name->area_name}}</td>
                                           <td>{{@$value->received_date}}</td>
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
                                            @php
                                            $from_start = DB::table('ir_form_team_member')->where('ir_id',@$value->id)->orderBy('id','asc')->first();
                                            $from_work = Carbon\Carbon::parse($from_start->created_at);
                                            $to_work = Carbon\Carbon::now();
                                            $days_work =  $to_work->diffInWeekdays($from_work);
                                            @endphp

                                            {{@$days_work}} Days

                                           </td>
                                           

                                           <td>
                                               
                                               <a href="{{route('manage.ip.lists.head.chief.details',['id'=>@$value->id])}}" class="btn btn-info">Details</a>
                                               
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