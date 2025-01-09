@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

                <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link " href="{{route('complaint.complete.details.full',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.complete.details.full.attachment',['id'=>@$id])}}">Attachment Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active btn btn-info"  href="{{route('complaint.complete.details.full.finance',['id'=>@$id])}}">Financial Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.complete.details.full.social',['id'=>@$id])}}">Social Implication</a>
        </li>



        <li class="nav-item">
          <a class="nav-link " href="{{route('complaint.complete.details.full.person',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="{{route('complaint.complete.details.full.link.case',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>


        @include('components.finance')


    </div>
</section>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>




@endsection