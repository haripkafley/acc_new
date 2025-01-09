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
            <li class="breadcrumb-item active text-info" aria-current="page">Seizure Details View</li>
          </ol>
        </nav>
      </div>
    </div>
  </div> --}}


<section id="table1s" class = "content">
  <div class = "container-fluid">
    <div class = "row">
      <div class = "col-12">
        <div class = "card">
          <div class = "card-header">
            <h2 class = "card-title text-info"><b>SEIZURES DETAILS</b></h2>
            {{-- <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-info btn-sm" onclick="return hideDetails2();"><b>X</b></button>
            </div> --}}
            {{-- <div class="d-flex justify-content-end">
              <button type="button" class="btn-close" aria-label="Close" onclick="return hideDetails3();"><b>X</b></button>
            </div> --}}
          </div>
            <!-- content -->
            <div class = "card-body">
            <form>
              <div class="row">
                <div class="col-md-2">
                    <label>Case No:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="case_no" placeholder="Please Enter Case Number" readonly>
                </div>

                <div class="col-md-2">
                    <label>Place:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="Suspect" placeholder="Please Enter Suspect" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Search Warrant No:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="case_no" placeholder="Please Enter Case Number" readonly>
                </div>

                <div class="col-md-2">
                    <label>Search Warrant Date:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="date" id="first-name" class="form-control" name="Suspect" placeholder="Please Enter Suspect" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Suspect:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="case_no" placeholder="Please Enter Case Number" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Search Date:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="date" id="first-name" class="form-control" name="case_no" placeholder="Please Enter Case Number">
                </div>

                <div class="col-md-2">
                    <label>Search Time:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="time" id="first-name" class="form-control" name="Suspect" placeholder="Please Enter Suspect" >
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Articale Seized Form:</label>
                </div>
                <div class="col-md-4 form-group">
                    <textarea type="text" id="first-name" class="form-control" name="caseBrief" placeholder="Please Enter Case Brief"></textarea>
                </div>

                <div class="col-md-2">
                    <label>Item Type:</label>
                </div>
                <div class="col-md-4 form-group">
                    <select class="form-control select2" Name="Court" >
                        <option selected>Select an Option</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
              </div>

              <div class="col-md-4">
                <label><b>Details of Articles Seized:</b></label>
              </div>

              <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered container-fluid">
                        <thead class="bg-info text-center">
                          <tr>
                            <th scope="col">Sl No</th>
                            <th scope="col">Description of Articles</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Remarks</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th class="align-middle" scope="row">1</th>
                            <td class="align-middle">High way road</td>
                            <td class="align-middle">13</td>
                            <td class="align-middle">Done</td>
                          </tr>
                        </tbody>
                      </table>
                </div> 
              </div>
              <br>

              <div class="row">
                <div class="col-md-6">
                    <label><b>Seized From</b></label>
                </div>

                <div class="col-md-6">
                    <label><b>Officer Conducting Seize</b></label>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="case_no" placeholder="Please Enter Case Number">
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="Suspect" placeholder="Please Enter Suspect">
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="case_no" placeholder="Please Enter Case Number">
                </div>

                <div class="col-md-2">
                    <label>Designation:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="Suspect" placeholder="Please Enter Suspect">
                </div>
              </div>

              <div class="col-md-2">
                <label><b>Witness:</b></label>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="case_no" placeholder="Please Enter Case Number">
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="Suspect" placeholder="Please Enter Suspect">
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="case_no" placeholder="Please Enter Case Number">
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="Suspect" placeholder="Please Enter Suspect">
                </div>
              </div>

              <div class="col-md-6">
                <a href="#" class="link-info text-info"><h5>Search Checklist</h5></a>
              </div>

              <div class="col-md-6">
                <a href="#" class="link-info text-info"><h5>Search Entry and Exit Affirmation</h5></a>
              </div>
              <br>

              <div class="row">
                <div class="col-md-2">
                    <label>Attached Document:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" id="first-name" class="form-control" name="case_no" placeholder="Please Enter Case Number">
                </div>

                <div class="col-md-2">
                  <button type="button" class="btn btn-info">Browse</button>
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
