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
<section id="table1s" class = "content">
  <div class = "container-fluid">
    <div class = "row">
      <div class = "col-12">
        @if (session('status'))
                <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif
        <div class = "card">
          <div class = "card-header">
            <h2 class = "card-title text-info"><b>Search Details - Commission</b></h2>
          </div>

          <div class = "card-body">
            <form>
              
              <div class="row">
                <div class="col-md-4">
                  <label for="validationCustom04">Case Registration No</label>
                  <input value="{{ $caseNo }}" type="text" class="form-control" readonly>
                </div>

                <div class="col-md-4">
                  <label for="validationCustom05">Case Title</label>
                  <input value="{{ $caseTitle }}" type="text" class="form-control" readonly>
                </div>
              </div>
             
            </form>
            <br>

            <table id = "example3" class="table table-bordered table-hover ">
              <thead class="bg-info text-center">
                <tr>
                  <th scope="col">Sl No</th>
                  <th scope="col">Applicant</th>
                  <th scope="col">Branch</th>
                  <th scope="col">Request Date</th>
                  <th scope="col">Type of Arrest</th>
                  {{-- <th scope="col">Status</th> --}}
                  <th scope="col">Approvel Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  @foreach ($newData as $data)
                  <th>{{ ++$i }}</th>
                    <td>{{$data->name}}</td>
                    <td>{{$data->branch}}</td>
                    <td>{{$data->applicationdate}}</td>
                    <td>{{$data->typeofseizure}}</td>
                    {{-- <td>N/A</td> --}}
                    <td>
                      @if($data->commissionStatus=='Recommended')
                        <a class="btn btn-info btn-sm text-white">Recommended</a></td>
                      @elseif($data->commissionStatus=='Reject')
                        <a class="btn btn-danger btn-sm text-white">Rejected</a></td>
                      @elseif($data->commissionStatus==0)
                        <a class="btn btn-warning btn-sm text-white">Pending</a></td>
                      @endif
                      <td>
                        <a href="{{route('CommissionUpdate', $data->seizure_id) }}" class="btn btn-info btn-sm text-white">Details</a>      
                      </td>
                </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<script>

  // function Details(id){
  //   window.location.href="SearchandSeizures/Details.php?id="+id;
  // }

function SearchDetails() {
        $('#table1s').show(1000);
    }

function hideDetails() {
        $('#table1s').hide(1000);
    }

function showform1() {
        $('#table2s').show(1000);
    }

function hideDetails1() {
        $('#table2s').hide(1000);
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
