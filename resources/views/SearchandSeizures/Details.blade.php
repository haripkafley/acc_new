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


<!-- Details Form -->
<section id="table2s" class = "content">
  <div class = "container-fluid">
    <div class = "row">
      <div class = "col-12">
        <div class = "card">
          <div class = "card-header">
            <h2 class = "card-title text-info"><b>Details</b></h2>
            <div class="d-flex justify-content-end">
              
            </div>
          </div>

            <!-- content -->
            <div class = "card-body"> 
              <form>
                @csrf
                @foreach ($MainSeizure as $data)
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
                      <input type="text" value="{{ $data->case_no }}" class="form-control" name="case_no" readonly>
                  </div>
  
                  <div class="col-md-2">
                      <label>Case Title:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" value="{{ $data->case_title }}" class="form-control" name="case_title" readonly>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                      <label>Name:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" value="{{ $data->name }}" class="form-control" name="name" readonly>
                  </div>
  
                  <div class="col-md-2">
                      <label>Branch/Department:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" value="{{ $data->branch }}" class="form-control" name="branch" readonly>
                  </div>
                </div>

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
                    <select class="form-control select2" name="typeofseizure" readonly>
                      <option>{{ $data->typeofseizure }}</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                    <label>Suspect:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <select class="form-control select2" Name="suspect" readonly>
                      <option>{{ $data->suspect }}</option>
                    </select>
                  </div>
  
                  <div class="col-md-2">
                      <label>Location:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" value="{{ $data->location }}" class="form-control" name="location" readonly>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                      <label>Probable Cause:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <textarea type="text" class="form-control" name="pcause" readonly>{{ $data->pcause }}</textarea>
                  </div>

                  <div class="col-md-2">
                    <label>Applicant’s Signature:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <img src="..." alt="..." class="img-thumbnail" readonly> 
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                      <label>Application Date:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="date" value="{{ $data->applicationdate }}" class="form-control" name="applicationdate" readonly>
                  </div>
  
                  <div class="col-md-2">
                      <label>Attached Document:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <input type="file" id="first-name" class="form-control" name="x" readonly>
                  </div>
                </div>
                <hr>

                <div class="row">
                  <div class="col-md-4">
                      <label class="text-info"><b>Warrant Details</b></label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                    <label>Warrant No:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <input type="text" value="{{ $data->warrantNo }}" class="form-control" name="warrantNo" readonly>
                  </div>
  
                  <div class="col-md-2">
                      <label>Warrant Date:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="date" value="{{ $data->warrantDate }}" class="form-control" name="warrantDate" readonly>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-2">
                    <label>Warrant Remark:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <textarea type="text" class="form-control" name="pcause" readonly>{{ $data->warrantRemark }}</textarea>
                  </div>
                </div>
                <hr>

                

                <div class="row">
                  <div class="col-md-4">
                      <label class="text-info"><b>Commission’s Recommendation</b></label>
                  </div>
                </div>
                @if($data->commissionStatus=='Recommended')
                <div class="row">
                  <div class="col-md-2">
                    <label class="text-success"><b>&#x1F6C8; Recommended<b></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label>Recommendation Status:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <select class="form-control select2" Name="commissionStatus" readonly>
                      <<option>{{ $data->commissionStatus }}</option>
                    </select>
                  </div>
  
                  <div class="col-md-2">
                      <label>Instructions/Remarks:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <textarea  type="text" class="form-control" name="commissionReview" readonly>{{ $data->commissionReview }}</textarea>
                  </div>
                </div>

                @elseif($data->commissionStatus=='Reject')
                <div class="row">
                  <div class="col-md-2">
                    <label class="text-success"><b>&#x1F6C8; Rejected<b></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label>Recommendation Status:</label>
                  </div>
                  <div class="col-md-4 form-group">
                    <select class="form-control select2" Name="commissionStatus" readonly>
                      <<option>{{ $data->commissionStatus }}</option>
                    </select>
                  </div>
  
                  <div class="col-md-2">
                      <label>Instructions/Remarks:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <textarea  type="text" class="form-control" name="commissionReview" readonly>{{ $data->commissionReview }}</textarea>
                  </div>
                </div>
                @elseif($data->commissionStatus==0)
                <div class="row">
                  <div class="col-md-2">
                    <h5 class="text-warning">&#x1F6C8; Not Reviewed</h5>
                  </div>
                </div>
                @endif
                @endforeach
                <input type="hidden" value="{{ $Showcases }}" name='case_no1'>
                <br>
              </form>

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
