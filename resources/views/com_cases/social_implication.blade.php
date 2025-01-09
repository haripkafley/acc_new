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
          <a class="nav-link active btn btn-info"  href="{{route('commission-casescase-details.listing.details.social-implication-details',['id'=>@$id])}}">Social Implication</a>
        </li>

        
        <li class="nav-item">
          <a class="nav-link " href="{{route('commission-casescase-details.listing.details.person-involved-details',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="{{route('commission-casescase-details.listing.details.case-link-details',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>



      @include('components.social')



    </div>
</section>




@endsection