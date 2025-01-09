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

<!-- THIRD PARTY CONSENT -->
<br>


<section id="table1s" class = "content">
  <div class = "container-fluid">
    <div class = "row">
      <div class = "col-12">
        @if (session('status'))
                <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif
        <div class = "card">
          <div class = "card-header">
            <h2 class = "card-title text-info"><b>THIRD PARTY CONSENT FORM</b></h2>
            <div class="d-flex justify-content-end">
              {{-- <button type="button" class="btn btn-info btn-sm" onclick="return hideDetails2();"><b>X</b></button> --}}
            </div>
            {{-- <div class="d-flex justify-content-end">
              <button type="button" class="btn-close" aria-label="Close" onclick="return hideDetails3();"><b>X</b></button>
            </div> --}}
          </div>
            <!-- content -->
            <div class = "card-body">
            <h4>Search Consent Details</h4>
            <form action="{{ route('saveForm1') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-md-2">
                    <label>Case No:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" value="{{ $caseNo }}" class="form-control" name="case_no" readonly>
                </div>

                <div class="col-md-2">
                    <label>Consent Provided On:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="date" value="{{ $ConsentProvided }}" class="form-control" name="consent_provided_on" readonly>
                </div>
              </div>

                <input type="hidden" value="{{ $caseID }}" name="sid" />

              <div class="col-md-3">
                <label class="text-info"><b>Consent Provided By:</b></label>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="consent_cid" placeholder="Please Enter CID">
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="consent_name" placeholder="Please Enter Name">
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Designation:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="consent_designation" placeholder="Please Enter Designation">
                </div>

                <div class="col-md-2">
                    <label>Agency:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="consent_agency" placeholder="Please Enter Agency">
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Mobile No:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="consent_mobileno" placeholder="Please Enter Mobile Number">
                </div>

                <div class="col-md-2">
                    <label>Email:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="consent_email" placeholder="Please Enter Email">
                </div>
              </div>
              
              <div class="col-md-2">
                <label class="text-info"><b>Witness:</b></label>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="witness_cid" placeholder="Please Enter CID">
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="witness_name" placeholder="Please Enter Name">
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Contact No:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="witness_contactno" placeholder="Please Enter Contact Number">
                </div>

                <div class="col-md-2">
                  <label>Attach Document:</label>
              </div>
              <div class="col-md-4 form-group">
                  <input type="file" id="first-name" class="form-control" name="fileX">
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
