@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link " href="{{route('complaint.view.details.regional',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.view.details.attachment.details.regional',['id'=>@$id])}}">Attachment Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.view.details.financial-implication-details.regional',['id'=>@$id])}}">Financial Implication</a>
        </li>

        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.view.details.social-implication-details.regional',['id'=>@$id])}}">Social Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link " href="{{route('complaint.view.details.aperson-involved-details.regional',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active btn btn-info" href="{{route('complaint.view.details.case-link-details.regional',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>


        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Linked Case List </div>

                        <div class = "card-body">
                         
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Date</th>
                                        <th>Complaint Reg. No.</th>
                                        <th>Complaint Title</th>
                                        <th>Mode</th>
                                        <th>Type</th>
                                        <th>Link Status</th>  
                                                 
                                    </tr>
                                </thead>
                                <tbody>

                                    


                                    @if(@$person_involved->isNotEmpty())
                                    @foreach(@$person_involved as $value)
                                    <tr>
                                    {{-- <td>{{@$value->repeatedID}}</td> --}}
                                    <td>{{@$value->repeatedComplaint_registrationRelation->updated_at}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintRegNo}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintTitle}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintmoderelation->modeName}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintTyperelation->complainttypeName}}</td>
                                    <td> Linked</td>
                                    
                                </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>



    </div>
</section>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>




@endsection