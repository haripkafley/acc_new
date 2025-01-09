@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link " href="{{route('commission-cases.listing.details',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('commission-cases.listing.details.attachment',['id'=>@$id])}}">Attachment Details</a>
        </li>

         <li class="nav-item">
          <a class="nav-link "  href="{{route('commission-casescase-details.listing.details.financial-implication-details',['id'=>@$id])}}">Financial Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link"  href="{{route('commission-casescase-details.listing.details.social-implication-details',['id'=>@$id])}}">Social Implication</a>
        </li>

        
        <li class="nav-item">
          <a class="nav-link active btn btn-info" href="{{route('commission-casescase-details.listing.details.person-involved-details',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="{{route('commission-casescase-details.listing.details.case-link-details',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>


        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Person Involved List </div>

                        <div class = "card-body">
                            <h5>
                              <small>List of accused, witness(es) and complainant</small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>CID</th>
                                        <th>Other ID</th>
                                        <th>Category</th>
                                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$person->isNotEmpty())
                                    @foreach(@$person as $att)
                                    <tr>
                                        <td>{{ @$att->personID }}</td>
                                        <td>{{ @$att->fname }} {{ @$att->mname }} {{ @$att->lname }}</td>
                                        <td>{{ @$att->cid }}</td>
                                        <td>{{ @$att->otherIdentificationNo }}</td>
                                        <td>{{ @$att->categoryName }}</td>
                                       
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Person Involved Againt This Complaint</td></tr>
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