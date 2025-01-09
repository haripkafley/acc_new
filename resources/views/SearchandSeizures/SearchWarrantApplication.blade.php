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
          <li class="breadcrumb-item active text-info" aria-current="page">Search Warrant Application</li>
        </ol>
      </nav>
    </div>
  </div>
</div> --}}

<!-- SEARCH AND WARRENT APPLICATION FORM -->
<section id="table1s" class = "content">
  <div class = "container-fluid">
    <div class = "row">
      <div class = "col-12">
        <div class = "card">
          <div class = "card-header">
            <h2 class = "card-title text-info"><b>SEARCH WARRENT APPLICATION FORM</b></h2>
            <div class="d-flex justify-content-end">
            </div>
          </div>
            <!-- content -->
            <div class = "card-body">
                  <h5 class="text-info"><b>Applicant Details</b></h5>

                  <form action="{{ route('saveForm') }}" method="POST" enctype="multipart/form-data">
                    @csrf                

                    <div class="row">
                      <div class="col-md-2">
                          <label>ACC Case No:</label>
                      </div>
                      <div class="col-md-4 form-group">
                          <input type="text" value="{{ $caseNo }}" class="form-control" name="case_no" readonly>
                      </div>

                      <div class="col-md-2">
                          <label>Suspect:</label>
                      </div>
                      <div class="col-md-4 form-group">
                          <input type="text" id="first-name" class="form-control" name="Suspect" placeholder="Please Enter Suspect">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-2">
                        <input type="hidden" value="{{ $caseID }}" name="sid"/>
                          <label>CID:</label>
                      </div>
                      <div class="col-md-4 form-group">
                          <input type="text" id="first-name" class="form-control" name="cid" placeholder="Please Enter CID">
                      </div>

                      <div class="col-md-2">
                          <label>Location:</label>
                      </div>
                      <div class="col-md-4 form-group">
                          <textarea type="text" id="first-name" class="form-control" name="Location" placeholder="Please Enter Location"></textarea>
                      </div>
                    </div>


                  <h5 class="text-info"><b>Application Details</b></h5>

                    <div class="row">
                      <div class="col-md-2">
                          <label>Case Brief:</label>
                      </div>
                      <div class="col-md-4 form-group">
                          <textarea type="text" id="first-name" class="form-control" name="caseBrief" placeholder="Please Enter Case Brief"></textarea>
                      </div>

                      <div class="col-md-2">
                        <label>Court:</label>
                      </div>
                      <div class="col-md-4 form-group">
                        <select class="form-control select2" Name="Court" >
                          <option selected>Select an Option</option>
                          @foreach ($Courts as $getData)
                            <option value="{{ $getData->court_type }}">{{ $getData->court_type }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-3 mb-3">
                        <label>Attach Document:</label>
                        <input type="file" class="form-control" name="fileX">
                      </div>
                    </div>

                    <div class="col-md-4 mb-4">
                      <button type="submit" class="btn btn-info">Submit</button>
                      <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                  </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- MAIN TBALE -->
{{-- <section id="tables" class = "content">
  <div class = "container-fluid">
    <div class = "row">
      <div class = "col-12">
        @if (session('status'))
                <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif
        <div class = "card">
          <div class = "card-header">
            <h2 class = "card-title text-info"><b>SEARCH WARRENT APPLICATION</b></h2>
          </div>

          <div class = "card-body">
            <div class="d-flex justify-content-start">
              <button type="button" class="btn btn-info" onclick="return showform();">Add Application</button>
            </div>
            <br>
            <table id = "example3" class="table table-bordered table-hover">
              <thead class="bg-info text-center">
                <tr>
                  <th scope="col">Sl No</th>
                  <th scope="col">Case Number</th>
                  <th scope="col">Suspect</th>
                  <th scope="col">CID</th>
                  <th scope="col">Location</th>
                  <th scope="col">Case Breif</th>
                  <th scope="col">Court</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  @foreach ($searchwarrantapplications as $data)

                    <td>{{ ++$i }}</td> --}}
                    {{-- <td>{{$data['case_no']}}</td>
                    <td>{{$data['suspect']}}</td>
                    <td>{{$data['cid']}}</td>
                    <td>{{$data['location']}}</td>
                    <td>{{$data['case_brief']}}</td>
                    <td>{{$data['court_type']}}</td> --}}
                    {{-- <td>{{$data->case_no}}</td>
                    <td>{{$data->suspect}}</td>
                    <td>{{$data->cid}}</td>
                    <td>{{$data->location}}</td>
                    <td>{{$data->case_brief}}</td>
                    <td>{{$data->court_type}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <br> --}}
            {{-- <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-info" onclick="return showform();">Add Application</button>
            </div> --}}

          {{-- </div>
        </div>
      </div>
    </div>
  </div>
</section> --}}


<script>

// function showform() {
//   $('#table1s').show(1000);
// }
// function hideDetails2() {
//   $('#table1s').hide(1000);
// }

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
