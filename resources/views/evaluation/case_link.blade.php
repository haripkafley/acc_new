@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link " href="{{route('complaint.evaluate.list.view.details',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.evaluate.list.attachment.details.regional',['id'=>@$id])}}">Attachment Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.evaluate.list.financial-implication-details.regional',['id'=>@$id])}}">Financial Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.evaluate.list.social-implication-details.regional',['id'=>@$id])}}">Social Implication</a>
        </li>



        <li class="nav-item">
          <a class="nav-link" href="{{route('complaint.evaluate.list.aperson-involved-details.regional',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active btn btn-info" href="{{route('complaint.evaluate.list.case-link-details.regional',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>


    @include('components.link_case')



    </div>
</section>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>




@endsection