@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link " href="{{route('complaint.view.details.director',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.view.details.attachment.details.director',['id'=>@$id])}}">Attachment Details</a>
        </li>

          <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.view.details.financial-implication-details.director',['id'=>@$id])}}">Financial Implication</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.view.details.social-implication-details.director',['id'=>@$id])}}">Social Implication</a>
        </li>



        <li class="nav-item">
          <a class="nav-link" href="{{route('complaint.view.details.aperson-involved-details.director',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active btn btn-info" href="{{route('complaint.view.details.case-link-details.director',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>


    @include('components.link_case')



    </div>
</section>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>




@endsection