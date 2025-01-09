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
                    <div class="card-header" style="font-family:Product Sans"> Information Enrichment Commission </div>
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
                                           <td>{{@$value->information_details->complaint_details->complaintRegNo}}</td>
                                           <td>{{@$value->information_details->complaint_details->complaintDateTime}}</td>
                                           <td>{{@$value->information_details->complaint_details->complaintTitle}}</td>
                                           <td>{{@$value->information_details->complaint_details->com_date}}</td>
                                           <td>{{@$value->information_details->allegation_name}}</td>
                                           
                                           <td>
                                               

                                               
                                               @if(@$value->coi_status=="AA")
                                               <a href="{{route('information.enrichment.get.user.list.coi',['id'=>@$value->id])}}" class="btn btn-warning">COI</a>

                                               @else

                                               <a href="{{route('information.enrichment.get.user.list.cec.com.list.view',['type'=>'com','id'=>@$value->id])}}" class="btn btn-danger">View</a>
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