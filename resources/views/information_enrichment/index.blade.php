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
                    <div class="card-header" style="font-family:Product Sans"> Information Enrichment </div>
                        <div class = "card-body">
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Complaint Registration No.</th>
                                        <th>Complaint Registration Date</th>
                                        <th>Complaint Title</th>
                                        <th>Commission Meeting Date</th>
                                        <th>Allegation Name</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$data->isNotEmpty())
                                       @foreach(@$data as $value)
                                       <tr>
                                           <td>{{@$value->complaint_details->complaintRegNo}}</td>
                                           <td>{{@$value->complaint_details->complaintDateTime}}</td>
                                           <td>{{@$value->complaint_details->complaintTitle}}</td>
                                           <td>{{@$value->complaint_details->com_date}}</td>
                                           <td>{{@$value->allegation_name}}</td>
                                           
                                           <td>
                                            
                                               <a href="{{route('complaint.complete.details.full',['id'=>@$value->complaint_id])}}" class="btn btn-info" target="_blank">Complaint Details</a>

                                               <a href="{{route('information.enrichment.view',['id'=>@$value->id])}}" class="btn btn-warning">Actions</a>

                                               <a href="{{route('information.enrichment.view.assgin.member',['id'=>@$value->id])}}" class="btn btn-success">+ Assign Member</a>
                                            
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