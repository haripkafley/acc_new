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
            <li class="breadcrumb-item"><a href="{{route('SearchandSeizuresHome') }}">Search and Seizure</a></li>
            @foreach ($showcases as $product)
            <li class="breadcrumb-item"><a href="{{route('SearchandSeizure', $product->id) }}">Search and Seizure List</a></li>
            @endforeach
            <li class="breadcrumb-item active text-info" aria-current="page">Search Warrant ACC</li>
          </ol>
        </nav>
      </div>
    </div>
  </div> --}}

<div class="main-content container-fluid">
<section id="itemPrint">
  <div class="row match-height">
      <div class="col-md-12 col-12">
      <div class="card" id="dvPrintp">
          <div class="card-header bg-white">
              <img src="{{ asset('dist/img/accnew.gif') }}" class="img-fluid" alt="Responsive image" srcset="" width="100%">
          </div>
          <div class="card-content">
          <div class="card-body">

            <form class="form form-horizontal" action="" method="">
              @csrf
              @foreach ($Mainseizure as $data)
              <div class="form-body container">
                <div>
                    <div style="float:left">
                        <label><b>{{ $data->case_no }}</b></label>
                    </div>
                    <div style="float:right">
                        <label><b>Date: <span id="dateID"></span></b></label>
                    </div>
                </div>
                  <br>
                  <br>

                  <div style="text-align: center;">
                    <div style="text-align: center;">
                          <label><h5><b>SEARCH WARRANT</b></h5></label>
                      </div>
                  </div>
                  <br>
                

                  <div class="row">
                      <div class="col-md-12">
                          <p class="text-justify">The Commission  in exercise if its powers under section 88 and 93 of the Anti-Corruption Act of Bhutan 2011,
                              hereby authorize Mr./Ms. <b>{{ $data->name }}</b>, investigation officer of the Anti-Corruption Commission and his / her    
                              team to conduct search and seizure operation of the premise of the suspect named below:
                          </p>
                      </div>
                  </div>
                  <br>

                  <div class="row">
                      <div class="col-md-4">
                          <label>Name: <b>{{ $data->suspect }}</b></label>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-4">
                          <label>CID No: <b>Test</b></label>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-4">
                          <label>Village: <b>Test</b></label>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-4">
                          <label>Gewog: <b>Test</b></label>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-4">
                          <label>Dzongkhag: <b>Test</b></label>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-4">
                          <label>Address/Location: <b>{{ $data->location }}</b></label>
                      </div>
                  </div>
                  <br>

                  <div class="row">
                      <div class="col-md-12">
                          <p class="text-justify">
                              In relation to its investigation into the alleged / suspected corrupt practices in the <b>{{ $data->pcause }}</b>.
                          </p>
                      </div>
                  </div>
                  <br>

                  <div class="row">
                      <div class="col-md-12">
                          <p class="text-justify">
                              Issued under the authority and seal of the Anti-Corruption Commission on <b><span id="date_ID"></span></b>.
                          </p>
                      </div>
                  </div>
                  <br>
                  <br>

                  <div class="row">
                      <div class="col-md-12 d-flex justify-content-end">
                          <label><b>(Chair Person)</b></label>
                      </div>
                  </div>
                  <br>
                  <br>
              </div>
              <br>
              @endforeach

              {{-- <div class="col-sm-12 d-flex justify-content-start">
                  <button type="button" class="btn btn-warning me-1 mb-1" onclick="return printPage();">Print</button>
                  <button type="cancel" class="btn btn-light-secondary me-1 mb-1 border-dark">Cancel</button>
              </div> --}}
            </form>

          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
          <button type="button" class="btn btn-info me-1 mb-1" onclick="return printPage();">Print</button>
          <button type="cancel" class="btn btn-warning me-1 mb-1">Cancel</button>
      </div>
    </div>
      
  </div>
</section>
</div>




<script>

function printPage() {
        var dataToPrint = document.getElementById("dvPrintp");
        var a = document.write(dataToPrint.innerHTML);
        window.print(a);
    }

    var today = new Date();
    var date = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
    $('#dateID').html(date);
    $('#date_ID').html(date);

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
