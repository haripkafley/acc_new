@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link " href="{{route('manage.person.view.details',['id'=>@$id])}}">Person Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active btn btn-info"  href="{{route('manage.person.view.details.complaint',['id'=>@$id])}}">Complaint Details</a>
        </li>
      </ul>



        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Complaint Details List </div>

                        <div class = "card-body">
                           
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Complaint Registration No</th>
                                        <th>Person Category</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->linkComplaintPersonCatID }}</td>
                                        <td>{{ $att->complaint_details->complaintRegNo}}</td>
                                        <td>{{ $att->linkcomplaint_person_categoryName->categoryName}}</td>
                                        <td><a href="{{route('manage.person.view.complaint',['id'=>$att->complaintID])}}" class="btn btn-warning" target="_blank">View</a></td>
                                       
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No  Complaint Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>



    </div>
</section>




@endsection