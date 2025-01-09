@extends('layouts.admin')

@section('content')
  <style>
    .coi_show {
      display : none;
    }

    .coi_hide {
      display : none;
    }
  </style>

<br>

{{-- <div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
     
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class='breadcrumb-header'>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item text-info">Search and Seizure</li>
        </ol>
      </nav>
    </div>
  </div>
</div> --}}


<section class = "content">
      <div class = "container-fluid">
        <div class = "row">
          <div class = "col-12">
            <div class = "card">
              <div class = "card-header">
                  <h3 class= "card-title text-info"><b>Assigend Cases - Search and Seizure</b></h3>
              </div>

                <div class = "card-body">

                  <table id = "example3" class="table table-bordered table-hover table-responsive">
                    <thead>
                      <tr class="bg-info text-center">
                        <th>Sl No</th>
                        <th>Case Registration No.</th>
                        <th>Case Title</th>
                        <th>Assigned Date</th>
                        <th>Priority</th>
                        <th>Accused Parties</th>
                        <th>Case Registration Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                    @foreach ($showcases as $product)
                     <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $product->case_no }}</td>
                        <td>{{ $product->case_title }}</td>
                        <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y')}}</td>
                        <td>{{ $product->priority }}</td>
                        <td>{{ $product->accused_party }}</td>
                        <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y')}}</td>
                        <td>
                          <a href="{{route('SearchandSeizure', $product->id) }}" class="btn btn-xs btn-info">Search and Seizure</a>
                      </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>

                </div>

      </div>
    </div>
  </div>
</section>


<script>

$(document).ready(function(){
$("#open").click(function(){
$(".coi_show").animate({height: "toggle"}, 500);
$(".coi_hide").hide();
});

$("#close").click(function(){
$(".coi_show").hide();

});
});

</script>
@endsection
