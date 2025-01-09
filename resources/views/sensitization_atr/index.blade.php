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

                <div class="card-body">
                    <a href="{{route('sensitization.list.action-list',@$offence_details->id)}}" class="btn btn-primary" style="float: right;">
                        Back
                    </a>
                </div>

                
                
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Sensitization Reports </div>
                    <div class="card-header" style="font-family:Product Sans"> 
                            <p><b>Complaint Registration No : </b> {{@$complaint->complaintRegNo}}</p>
                            <p><b>Complaint Registration Date : </b> {{@$complaint->complaintDateTime}}</p>
                            <p><b>Complaint Brief : </b> {!!@$complaint->complaintDetails!!}</p>

                         </div>

                         
                        <div class = "card-body">
                            <a href="{{route('sensitization.action.taken.report.add.view',@$id)}}" class="btn btn-primary" style="float: right;margin-bottom: 10px;">
                                    + Add New Atr
                                </a>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>ATR Date</th>
                                        <th>ATR Letter No.</th>
                                        <th>ATR Letter</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$data->isNotEmpty())
                                       @foreach(@$data as $value)
                                       <tr>
                                           <td>{{@$value->letter_no}}</td>
                                           <td>{{@$value->letter_date}}</td>
                                           <td><a class="btn btn-xs btn-info" href="{{URL::to('attachment/action')}}/{{$value->attach_letter}}" target="_blank"><i class="fa fa-eye"></i>View Attachment</a></td>
                                           <td>
                                               <a href="{{route('sensitization.atr.edit.decision',['id'=>@$value->id])}}" class="bnt btn-info">Edit/View</a>

                                               <a href="{{route('sensitization-report.cec.view',['id'=>@$value->id])}}" class="bnt btn-warning">CEC/Commission</a>
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