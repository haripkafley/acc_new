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
                    <div class="card-header" style="font-family:Product Sans"> SURVEILLANCE ASSIGNMENT </div>
                        <div class = "card-body">
                            
                             @csrf


                            <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.get.assignment.information-gathering')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.individual.get.assignment.information-gathering')}}"> INFORMATION GATHERING</a>
                                    </li>

                                    
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.get.assignment.surveillance')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.individual.get.assignment.surveillance')}}">SURVEILLANCE</a>
                                    </li>

                             </ul>
                             
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>IG No.</th>
                                        <th>Request Type</th>
                                        <th>Suspect Details</th>
                                        <th>In Relation To</th>
                                        <th>Start Date</th>
                                        <th>End Date</th> 
                                        <th>Status</th> 
                                        <th>Running Days</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$data->isNotEmpty())
                                       @foreach(@$data as $key=> $value)
                                       <tr>
                                           <td>{{@$value->tacktical_details->sl_no}}</td>
                                           <td>{{@$value->tacktical_details->si_ig_no}}</td>
                                           <td>{{@$value->tacktical_details->request_type_details->name}}</td>
                                           <td>{{@$value->tacktical_details->suspect_details}}</td>
                                           <td>{{@$value->tacktical_details->relation_to}}</td>
                                           <td>{{@$value->tacktical_details->start_date}}</td>
                                           <td>{{@$value->tacktical_details->end_date}}</td>
                                           <td>@if(@$value->tacktical_details->report_status=="A") Completed @else Ongoing @endif</td>
                                           <td>
                                            @php
                                            $from = Carbon\Carbon::parse(@$value->tacktical_details->request_date);
                                            $to = Carbon\Carbon::now();
                                            $days =  $from->diffInDays($to);
                                            @endphp

                                            {{@$days}} Days

                                           </td>
                                           <td>
                                               @if(@$value->coi_status=="AA")
                                               <a href="{{route('tacktical.inteligence.autorization.individual.log.sheet.form.page.coi.page',['id'=>@$value->id])}}" class="btn btn-info">COI</a>
                                               @else
                                               <a href="{{route('tacktical.inteligence.autorization.individual.details.page',['id'=>@$value->tacktical_id ])}}" class="btn btn-success">+ Details Add</a>
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
$("#maintable").dataTable();
});
</script>
@endsection