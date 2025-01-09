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
                <div class="row">
                   {{--  <div class="col-md-6">
                    <a href="{{route('complaint.registration.add.view')}}"  class="btn btn-success">Registered Complaints</a>
                    </div> --}}
               @if(@$add=="Y") 
               <div class="col-md-12"> <a href="{{route('complaint.registration.add.view')}}" style="float: right;" class="btn btn-primary">+ Register Complaint</a> </div>
               @endif
                </div>
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Complaint List </div>
                        <div class = "card-body">
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Complaint Id</th>
                                        <th>Date</th>
                                        <th>Registration No</th>
                                        <th>Title</th>
                                        <th>Occurrence From</th>
                                        <th>Occurrence Till</th>
                                        <th>Mode</th>                            
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$data->isNotEmpty())
                                       @foreach(@$data as $value)
                                       <tr>
                                            <td>{{@$value->complaintID}}</td>
                                           <td>{{@$value->complaintDateTime}}</td>
                                           <td>{{@$value->complaintRegNo}}</td>
                                           <td>{{@$value->complaintTitle}}</td>
                                           <td>{{@$value->occurrencePeriodFrom}}</td>
                                           <td>{{@$value->occurrencePeriodTill}}</td>
                                           <td>{{@$value->complaintmoderelation->modeName}}</td>
                                           <td>
                                            @if(@$edit=="Y")
                                               <a href="{{route('complaint.registration.edit.view',['id'=>@$value->complaintID])}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
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