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


<!-- MAIN TBALE -->
<section id="tables" class = "content">
  <div class = "container-fluid">
    <div class = "row">
      <div class = "col-12">
        @if (session('status'))
                <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif
        <div class = "card">
          <div class = "card-header">
            <h2 class = "card-title text-info"><b>SEIZURES DETAILS - Passport</b></h2>
          </div>

          <div class = "card-body">
            <div class="d-flex justify-content-center">
              <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                  <div class="navbar-nav">
                    <a class="nav-item nav-link text-info" href="{{route('seizuresDetails',$seizure_id) }}">General Items</a>
                    <a class="nav-item nav-link text-info" href="{{route('seizuresDetailsDigital',$seizure_id) }}">Digital Items</a>
                    <a class="nav-item nav-link text-info" href="{{ route('seizuresDetailsE',$seizure_id) }}">Emails</a>
                    <a class="nav-item nav-link text-info" href="{{ route('seizuresDetailsSMA',$seizure_id) }}">Social media Accounts</a>
                    <a class="nav-item nav-link active text-info info text-light bg-info">Passport<span class="sr-only">(current)</span></a>
                    
                  </div>
                </div>
              </nav>
            </div>

            <br>
            <table id = "example3" class="table table-bordered table-hover ">
              <thead class="bg-info text-center">
                <tr>
                  <th>Sl No</th>
                  <th>Case Number</th>
                  <th>Case Title</th>
                  <th>Suspect</th>
                  <th>Date of Operation</th>
                  <th>Item Type</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ( $seizurepassports as $data )
                <tr>
                  
                    <td>{{ ++$i }}</td>
                    <td>{{ $data->case_no }}</td>
                    <td>{{ $data->case_title }}</td>
                    <td>{{ $data->suspect }}</td>
                    <td>{{ $data->searchDate }}</td>
                    <td>{{ $data->itemtype }}</td>
                    <td class="text-center">
                        <a href="{{route('SeizurePassportViewsDetails',$data->spp_id) }}" class="btn btn-info btn-sm">Details</a>
                    </td>
                </tr>
                @endforeach
               
              </tbody>
            </table>
            <br>
            <div class="col-md-4 justify-content-end">
              <a href="{{route('SeizurePassportViews',$seizure_id) }}" class="btn btn-info btn-md text-white">Add New</a>
              </div> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<script>

function showform1() {
        $('#table1s').show(1000);
    }

function hideDetails() {
        $('#table1s').hide(1000);
    }

    function showmember1() {
        $('#memberDiv').show(1000);
}

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
