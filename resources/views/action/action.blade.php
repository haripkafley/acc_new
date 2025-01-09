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

                {{-- <div class="row">
                    <div class="col-md-12">
                        
                    </div>
                </div> --}}
                
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> 
                        Actions To Be Taken </div>

                        <div class="card-header" style="font-family:Product Sans"> 
                            <p><b>Complaint Registration No : </b> {{@$complaint->complaintRegNo}}</p>
                            <p><b>Complaint Registration Date : </b> {{@$complaint->complaintDateTime}}</p>
                            <p><b>Complaint Brief : </b> {!!@$complaint->complaintDetails!!}</p>
                            <p><b>Allegation Name : </b> {!!@$offence_details->allegation_name!!}</p>
                            <p><b>Allegation Details : </b> {!!@$offence_details->allegation_description    !!}</p>

                         </div>
                        <div class = "card-body">
                            <a href="{{route('action.taken.list.action-list.add.action.view',@$id)}}" class="btn btn-primary" style="float: right;margin-bottom: 10px;">
                                    + Add New
                                </a>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Letter No.</th>
                                        <th>Letter Date</th>
                                        <th>Action To Be Taken Brief</th>
                                        <th>Submission Deadline</th>
                                        <th>Agency</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$data->isNotEmpty())
                                       @foreach(@$data as $value)
                                       <tr>
                                           <td>{{@$value->letter_no}}</td>
                                           <td>{{@$value->letter_date}}</td>
                                           <td>{{@$value->description_action}}</td>
                                           <td>{{@$value->deadline}}</td>
                                           <td>
                                            @php
                                            $agency_details = DB::table('action_taken_agency')->where('action_id',$value->id)->get();
                                             @endphp
                                               @foreach($agency_details as $agency)
                                                @php
                                                $name = DB::table('pl_tblagency')->where('agencyID',$agency->agency_id)->first();
                                                 @endphp

                                                 {{@$name->agencyName}}

                                                @if (!$loop->last)
                                                ,
                                                @endif
                                               @endforeach

                                           </td>
                                           <td>
                                            
                                            <a class="btn btn-xs btn-success" href="{{route('action.taken.list.action-list.edit.action.view',@$value->id)}}" ><i class="fa fa-edit"></i>Edit</a>

                                            <a class="btn btn-xs btn-danger" href="{{route('action.taken.list.action-list.delete.action.view',@$value->id)}}" ><i class="fa fa-trash"></i>Delete</a>

                                            <a class="btn btn-xs btn-danger" href="{{route('action.taken.list.action-list.extension.action.view',@$value->id)}}" ><i class="fa fa-bus"></i>Extension</a>

                                            <a class="btn btn-xs btn-warning" href="{{route('action.taken.reminder.list',@$value->id)}}" ><i class="fa fa-clock"></i>Reminder</a>

                                            <a class="btn btn-xs btn-info" href="{{route('action.taken.report',@$value->id)}}" ><i class="fa fa-book"></i> ATR</a>

                                                           



                                               
                                            
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