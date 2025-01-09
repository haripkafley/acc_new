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
            <h2 class = "card-title text-info"><b>SEIZURES DETAILS FOR GENERAL</b></h2>
            <div class="d-flex justify-content-end">
              
            </div>
            {{-- <div class="d-flex justify-content-end">
              <button type="button" class="btn-close" aria-label="Close" onclick="return hideDetails3();"><b>X</b></button>
            </div> --}}
          </div>
            <!-- content -->
            <div class = "card-body">
              
            <form action="" method="POST" enctype="multipart/form-data">
              @csrf
              @foreach ($Seizuregeneral as $data)
              <div class="row">
                <div class="col-md-2">
                    <label>Case No:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" value="{{ $data->case_no }}" class="form-control" name="case_no"  readonly>
                </div>

                <div class="col-md-2">
                    <label>Case Tittle:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" value="{{ $data->case_title }}" class="form-control" name="case_title" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Search Warrant No:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="{{ $data->searchwarrantNo }}" name="searchwarrantNo" readonly>
                </div>

                <div class="col-md-2">
                    <label>Search Warrant Date:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="date" class="form-control" value="{{ $data->searchwarrantDate }}" name="searchwarrantDate" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Suspect:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" value="{{ $data->suspect }}" class="form-control" name="suspect" readonly>
                </div>

                <div class="col-md-2">
                  <label>Place:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" value="{{ $data->place }}" class="form-control" name="place" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Search Date:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="date" class="form-control" value="{{ $data->searchDate }}" name="searchDate" readonly>
                </div>

                <div class="col-md-2">
                    <label>Search Time:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="{{ $data->searchTime }}" name="searchTime" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Article Seized Form:</label>
                </div>
                <div class="col-md-4 form-group">
                    <textarea type="text" class="form-control" name="articleseized" readonly>{{ $data->articleseized }}</textarea>
                </div>

                <div class="col-md-2">
                    <label>Item Type:</label>
                </div>
                <div class="col-md-4 form-group">
                  <input type="text" class="form-control" value="{{ $data->itemtype }}" name="itemtype" readonly>
                </div>
              </div>

              <div class="col-md-4">
                <label><b>Details of Articles Seized:</b></label>
              </div>
              <div class="col-md-4">
                <label><span class="text-danger">*</span> enter data in Table</label>
              </div>

              <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered container-fluid" id="table1s">
                        <thead class="bg-info text-center">
                          <tr>
                            <th scope="col">Description of Articles</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Remarks</th>
                            {{-- <th scope="col">Action</th> --}}
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($Articleseizedgeneral as $data1)
                          <tr>
                            <td>{{ $data1->description }}</td>
                            <td>{{ $data1->quantity }}</td>
                            <td>{{ $data1->remarks }}</td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                      {{-- <div class="col-md-4 justify-content-end">
                        <a class="btn-sm bg-info text-white" id="insertRow">Add new</a>
                      </div> --}}
                      
                </div> 
              </div>
              <br>
              {{-- <input type="hidden" value="{{ $seizure_id }}" name="id" /> --}}

              <div class="row">
                <div class="col-md-6">
                    <label class="text-info"><b>Seized From</b></label>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="{{ $data->seizedName }}" name="seizedName" readonly>
                </div>

                <div class="col-md-2">
                  <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="{{ $data->seizedCid }}" name="seizedCid" readonly>
                </div> 
              </div>
              <hr>

              <div class="row">
                <div class="col-md-6">
                    <label class="text-info"><b>Officer Conducting Seize</b></label>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                  <label>Name:</label>
              </div>
              <div class="col-md-4 form-group">
                  <input type="text" class="form-control" value="{{ $data->officerName }}" name="officerName" readonly>
              </div>

                <div class="col-md-2">
                    <label>Designation:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="{{ $data->officerdesignation }}" name="officerdesignation" readonly>
                </div>
              </div>
              <br>

              {{-- <div class="row">
                <div class="col-md-6">
                  <a class="btn btn-info btn-sm text-white" onclick="return showmember1();">Add more Member</a>
                </div>
              </div> --}}

              <div class="row" id="memberDiv" >
                <div class="col-md-2">
                  <label>Member Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="{{ $data->teammember1 }}" name="teammember1" readonly>
                </div>

                  <div class="col-md-2">
                      <label>Member Name:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" class="form-control" value="{{ $data->teammember2 }}" name="teammember2" readonly>
                  </div>
                  <div class="col-md-2">
                    <label>Member Name:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" class="form-control" value="{{ $data->teammember3 }}" name="teammember3" readonly>
                  </div>
  
                    <div class="col-md-2">
                        <label>Member Name:</label>
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" value="{{ $data->teammember4 }}" name="teammember4" readonly>
                    </div>
              </div>
              <hr>

              <div class="col-md-2">
                <label><b>Witness:</b></label>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="{{ $data->witnessCid1 }}" name="witnessCid1" readonly>
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="{{ $data->witnessName1 }}" name="witnessName1" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="{{ $data->witnessCid2 }}" name="witnessCid2" readonly>
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="{{ $data->witnessName2 }}" name="witnessName2" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Attached Document:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="file" id="first-name" class="form-control" value="{{ $data->witnessName2 }}">
                </div>
              </div>
              @endforeach
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

//Add new Data in Table
// $(function () {
//     // var counter = 1;
//     $("#insertRow").on("click", function (event) {
//         event.preventDefault();
//         var newRow = $("<tr>");
//         var cols = '';
//         // cols += '<th scrope="row">' + counter + '</th>';
//         cols += '<td><input class="form-control rounded-0" type="text" name="description[]" placeholder="Description of Article"></td>';
//         cols += '<td><input class="form-control rounded-0" type="text" name="quantity[]" placeholder="Quantity"></td>';
//         cols += '<td><input class="form-control rounded-0" type="text" name="remarks[]" placeholder="Remarks"></td>';
//         cols += '<td><button class="btn btn-outline-danger" id ="deleteRow"><i class="fa fa-trash"></i></button</td>';
//         newRow.append(cols);
//         $("table").append(newRow);
//         counter++;
//     });

//     $("table").on("click", "#deleteRow", function (event) {
//         $(this).closest("tr").remove();
//         // counter -= 1
//     });
// });
</script>

@endsection
