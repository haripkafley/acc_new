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

{{-- For General --}}
<section id="table1s" class = "content">
  <div class = "container-fluid">
    <div class = "row">
      <div class = "col-12">
        <div class = "card">
          <div class = "card-header">
            <h2 class = "card-title text-info"><b>Approval Details</b></h2>
            <div class="d-flex justify-content-end">
              
            </div>
            {{-- <div class="d-flex justify-content-end">
              <button type="button" class="btn-close" aria-label="Close" onclick="return hideDetails3();"><b>X</b></button>
            </div> --}}
          </div>
            <!-- content -->
            <div class = "card-body">
              
            <form action="{{ route('UpdateUpdateWarrantApprovels',$seizure_id) }}" method="Post">
              @csrf
              @foreach ($MainSeizure as $data)
              <div class="row">
                <div class="col-md-2">
                    <label>Application No:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="" value="{{ $data->case_no }}" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Application Date:</label>
                </div>
                <div class="col-md-4 form-group">
                  <input type="text" class="form-control" name="" value="{{ $data->applicationdate }}" readonly>
                </div>
              </div>

              <div class="col-md-4">
                <label><b>Case and Suspect Details</b></label>
              </div>

              <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered container-fluid" id="table1s">
                        <thead class="bg-info text-center">
                          <tr>
                            <th scope="col">ACC Case No</th>
                            <th scope="col">Suspect’s Name/CID No.</th>
                            <th scope="col">Suspect’s address/location</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="align-middle">{{ $data->case_no }}</td>
                            <td class="align-middle">{{ $data->suspect }}</td>
                            <td class="align-middle">{{ $data->location }}</td>
                          </tr>
                        </tbody>
                      </table>
                </div> 
              </div>
              <br>

              <div class="row">
                <div class="col-md-6">
                    <label><i>Case Brief</i></label>
                </div>
              </div>
              @endforeach
                <input type="hidden" value="{{ $Showcases }}" name='case_no1'>
                <hr>

              <div class="row">
                <div class="col-md-6">
                    <label><b>Approval Details</b></label>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                  <label>Warrant No:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="warrantNo" placeholder="Please Enter Warrant No">
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                  <label>Warrant Date:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="date" class="form-control" name="warrantDate" placeholder="Please Enter Warrant Date">
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                  <label>Remarks:</label>
                </div>
                <div class="col-md-4 form-group">
                    <textarea type="text" class="form-control" name="warrantRemark" placeholder="Please Enter Remarks"></textarea>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Attached Warrant:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="file" id="first-name" class="form-control" name="">
                </div>
              </div>

              <div class="col-md-4 mb-4">
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




<script>

function showmember1() {
    $('#memberDiv').show(1000);
}

$(document).ready(function () {
        $("#open").click(function () {
            $(".coi_show").animate({
                height: "toggle"
            }, 500);
            $(".coi_hide").hide();
        });
        $("#close").click(function () {
            $(".coi_show").hide();

        });
});

</script>

@endsection
