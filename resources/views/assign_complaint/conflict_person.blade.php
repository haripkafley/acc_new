@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link  " href="{{route('assign.complaint.coi.view',['id'=>@$id])}}">Complaint Details</a>
        </li>
       
        <li class="nav-item">
          <a class="nav-link active btn btn-info" href="{{route('assign.complaint.coi.person.involved',['id'=>@$id])}}" >Person Involved</a>
        </li>
      </ul>


        @include('components.person_involved')


    </div>
</section>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>




@endsection