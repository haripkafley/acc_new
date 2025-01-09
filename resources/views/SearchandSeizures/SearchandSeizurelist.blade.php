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
          <li class="breadcrumb-item active text-info" aria-current="page">Search and Seizure List</li>
        </ol>
      </nav>
    </div>
  </div>
</div> --}}

<!-- Details Form -->
<section id="table2s" class = "content" style='display : none;'>
  <div class = "container-fluid">
    <div class = "row">
      <div class = "col-12">
        <div class = "card">
          <div class = "card-header">
            <h2 class = "card-title text-info"><b>New Request</b></h2>
            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-info btn-sm" aria-label="Close" onclick="return hideDetails1();"><b>X</b></button>
            </div>
          </div>

            <!-- content -->
            <div class = "card-body"> 
              <form action="{{ route('saveSeizuresDatas') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-2">
                      <label class="text-info"><b>Applicant Details</b></label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                      <label>Case No:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <input type="hidden" value="{{ $id }}" name="caseid" />
                      <input type="text" value="{{ $caseNo }}" class="form-control" name="case_no" readonly>
                  </div>
  
                  <div class="col-md-2">
                      <label>Case Title:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" value="{{ $caseTitle }}" class="form-control" name="case_title" readonly>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                      <label>Name:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" value="{{ $Teamleader }}" class="form-control" name="name" readonly>
                  </div>
  
                  <div class="col-md-2">
                      <label>Branch/Department:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" value="{{ $Branch }}" class="form-control" name="branch" readonly>
                  </div>
                </div>
                
                {{-- <div class="row">
                  <div class="col-md-2">
                      <label>Designation:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" id="first-name" class="form-control" name="case_no" placeholder="Please Enter Name">
                  </div>
                </div> --}}

                <div class="row">
                  <div class="col-md-2">
                      <label class="text-info"><b>Application Details:</b></label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <label>Type of Search & Seizure Requested:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <select class="form-control select2" name="typeofseizure">
                      <option selected>Select an Option</option>
                      @foreach ($Typeseizures as $getData1)
                        <option value="{{ $getData1->typeofseizure }}">{{ $getData1->typeofseizure }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                    <label>Suspect:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <select class="form-control select2" Name="suspect">
                      <option selected>Select an Option</option>
                      <option value="Test 1">Test 1</option>
                      <option value="Test 2">Test 2</option>
                      <option value="Test 2">Test 3</option>
                    </select>
                  </div>
  
                  <div class="col-md-2">
                      <label>Location:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" class="form-control" name="location" placeholder="Please Enter Location" >
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                      <label>Probable Cause:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <textarea type="text" class="form-control" name="pcause" placeholder="Please Enter Probable Cause"></textarea>
                  </div>

                  <div class="col-md-2">
                    <label>Applicant’s Signature:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <input type="file" id="first-name" class="form-control" name="fileY"> 
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                      <label>Application Date:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="date" class="form-control" name="applicationdate">
                  </div>
  
                  <div class="col-md-2">
                      <label>Attached Document:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <input type="file" id="first-name" class="form-control" name="fileX">
                  </div>
                </div>

                <div class="col-md-5 mb-5">
                  <button type="submit" class="btn btn-info">Submit</button>
                  <button type="reset" class="btn btn-warning">Cancel</button>
                </div>
              </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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
            <h2 class = "card-title text-info"><b>Search Consent Details</b></h2>
          </div>

          <div class = "card-body">
            <form>
              {{-- @foreach ($showcases as $product) --}}
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
              {{-- @endforeach --}}
            </form>
            <br>

            <table id = "example3" class="table table-bordered table-hover">
              <thead class="bg-info text-center">
                <tr>
                  <th scope="col">Sl No</th>
                  <th scope="col">Applicant</th>
                  <th scope="col">Branch</th>
                  <th scope="col">Request Date</th>
                  <th scope="col">Type of Seizure</th>
                  {{-- <th scope="col">Status</th> --}}
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
                      @if ($data->typeofseizure=='With Court Warrant')
                        <div class="row">
                          <div class="col-md-2">
                            <a href="{{route('DetailsMain', $data->seizure_id) }}" class="btn btn-info btn-sm">Details</a>
                          </div>
                          &nbsp 
                            <div class="col-md-4">
                              <a href="{{route('seizuresDetails', $data->seizure_id) }}" class="btn btn-info btn-sm">Seizures Details</a>
                            </div>
                          {{-- &nbsp --}}
                          <div class="col-md-3">
                            <a href="{{route('SearchWarrantApplication', $data->seizure_id) }}" class="btn btn-info btn-sm">Search Warrant Application</a>
                          </div>  
                        </div>
                      
                      @elseif($data->typeofseizure=='Without Court Warrant')
                        <div class="row">
                          <div class="col-md-2">
                            <a href="{{route('DetailsMain', $data->seizure_id) }}" class="btn btn-info btn-sm">Details</a>
                          </div>
                          &nbsp 
                          <div class="col-md-4">
                            <a href="{{route('seizuresDetails', $data->seizure_id) }}" class="btn btn-info btn-sm">Seizures Details</a>
                          </div> 
                          {{-- &nbsp --}}
                          <div class="col-md-4">
                            <a href="{{route('showACC', $data->seizure_id) }}" class="btn btn-info btn-sm">Search Warrant ACC</a>
                          </div>
                        </div>

                      @elseif($data->typeofseizure=='With Consent of Third Person')
                        <div class="row">
                          <div class="col-md-2">
                            <a href="{{route('DetailsMain', $data->seizure_id) }}" class="btn btn-info btn-sm">Details</a>
                          </div>
                          &nbsp  
                          <div class="col-md-4">
                            <a href="{{route('seizuresDetails', $data->seizure_id) }}" class="btn btn-info btn-sm">Seizures Details</a>
                          </div>
                          {{-- &nbsp --}}
                          <div class="col-md-4">
                            <a href="{{route('thirdPartyConsent', $data->seizure_id) }}" class="btn btn-info btn-sm">Third Party Consent</a>
                          </div>
                        </div>
                      @endif
                       
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <div class="col-md-4 justify-content-end">
              <a class="btn btn-info btn-md text-white" onclick="return showform1();">New Request</a>
            </div> 

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
