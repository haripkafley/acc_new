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
                    <div class="col-md-6">

                        <a href="{{route('complaint-register.list')}}"  class="btn btn-success">Registered Complaints</a>

                    <a href="{{route('acc.app.complaint')}}"  class="btn btn-warning">My Acc Complaints</a>

                </div>
                @if(@$add=="Y")
               <div class="col-md-6"> <a href="{{route('complaint.registration.add.view')}}" style="float: right;" class="btn btn-primary">+ Register Complaint</a> </div>
               @endif
                </div>
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> My Acc Complaints </div>
                        <div class = "card-body">
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Tracking Number</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Address</th>
                                        <th>Offence</th>
                                        <th>Area</th>
                                        <th>Complaint</th>                            
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$app_complaint->isNotEmpty())
                                       @foreach(@$app_complaint as $value)
                                       @if(!in_array($value->cims,@$web_complaint))
                                       <tr>
                                           <td>{{@$value->reg_no}}</td>
                                           <td>{{@$value->name}}</td>
                                           <td>{{@$value->designation}}</td>
                                           <td>{{@$value->address}}</td>
                                           <td>{{@$value->offence_name->offence_type}}</td>
                                           <td>{{@$value->area_name->area}}</td>
                                           <td>{{@$value->complaint}}</td>
                                           <td>
                                               {{-- @if(@$add=="Y") --}}
                                               <a href="{{route('complaint.registration.add.view',['id'=>@$value->reg_no])}}" class="btn btn-info" title="register"><i class="fas fa-sign-in-alt"></i></a>
                                               {{-- @endif --}}
                                           </td>

                                       </tr>
                                       @endif
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