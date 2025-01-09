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
                    <div class="card-header" style="font-family:Product Sans"> Complaint List </div>
                        <div class = "card-body">
                            <form method="POST" action="{{route('ces.number.generate.memebers')}}">
                             @csrf
                             {{-- <button type="submit" class="btn btn-warning" style="float:right;margin-bottom: 15px;">Create Complaint Evaluation Committee</button> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        {{-- <th>Complaint Id</th> --}}
                                        <th>Complaint Registration No.</th>
                                        <th>Complaint Registration Date</th>
                                        <th>Complaint Tile</th>
                                        <th>Mode</th>
                                        {{-- <th>Select</th> --}}
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$data->isNotEmpty())
                                       @foreach(@$data as $key=> $value)
                                       <tr>
                                           {{-- <td>{{@$value->complaintID}}</td> --}}
                                           <td>{{@$value->complaintRegNo}}</td>
                                           <td>{{@$value->complaintDateTime}}</td>
                                           <td>{{@$value->complaintTitle}}</td>
                                           <td>{{@$value->complaintmoderelation->modeName}}</td>
                                           {{-- <td>@if(@$value->evaluation_status=="N")<input type="checkbox" name="addmore[{{$key}}][checkbox]" value="{{@$value->complaintID}}">@endif</td> --}}
                                           

                                           <td>
                                              @if(@$value->evalution_coi=="AA")
                                               <a href="{{route('complaint.conflict.interest',['id'=>@$value->complaintID])}}" class="btn btn-info">COI</a>
                                               @else

                                               {{-- @php
                                                $commision = DB::table('evaluation_meeting_person')->where('complaint_id',@$value->complaintID)->where('coi_status','N')->where('score_create','Y')->where('scoring',null)->first();
                                                
                                               @endphp --}}

                                               <a href="{{route('complaint.evaluate.list.view.details',['id'=>@$value->complaintID])}}" class="btn btn-info {{-- @if($commision!="") btn btn-info @else btn btn-danger @endif --}}">{{-- @if($commision=="")Evaluate @else Commision  @endif --}} <i class="fas fa-eye"></i></a>
                                               @endif

                                               {{-- <a href="{{route('asssign.review.team.evaluation',['id'=>@$value->complaintID])}}" class="btn btn-success">Assign Review Team</a> --}}


                                           </td>

                                       </tr>
                                       @endforeach
                                       @endif            
                                </tbody>
                            </table>
                        </form>
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
    [0, "desc"]
  ]
});
});
</script>
@endsection