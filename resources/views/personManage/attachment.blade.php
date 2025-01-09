@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link " href="{{route('manage.person.view.complaint',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active btn btn-info"  href="{{route('manage.person.view.complaint.attachment',['id'=>@$id])}}">Attachment Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('manage.person.view.complaint.person',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('manage.person.view.complaint.case-link',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>



      @include('components.attachment')



    </div>
</section>




@endsection