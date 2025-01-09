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
            <h2 class = "card-title text-info"><b>SEIZURES DETAILS FORM EMAIL</b></h2>
            <div class="d-flex justify-content-end">
              
            </div>
            {{-- <div class="d-flex justify-content-end">
              <button type="button" class="btn-close" aria-label="Close" onclick="return hideDetails3();"><b>X</b></button>
            </div> --}}
          </div>
            <!-- content -->
            <div class = "card-body">
              
              <div class="row justify-content-end">
                <a href="{{ route('ViewCheck') }}" class="btn btn-outline-info">Search Checklist</a>
              </div>
              <br>
              
            <form action="{{ route('saveEmail') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @foreach ($MainSeizure as $data)
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
                    <input type="text" class="form-control" value="{{ $data->warrantNo }}" name="searchwarrantNo" readonly>
                </div>

                <div class="col-md-2">
                    <label>Search Warrant Date:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="date" class="form-control" value="{{ $data->warrantDate }}" name="searchwarrantDate" readonly>
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
                    <input type="text" value="{{ $data->location }}" class="form-control" name="place" readonly>
                </div>
              </div>
              @endforeach

              <div class="row">
                <div class="col-md-2">
                    <label>Search Date:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="date" class="form-control" name="searchDate" placeholder="Please Enter Search Date">
                </div>

                <div class="col-md-2">
                    <label>Search Time:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="time" class="form-control" name="searchTime" placeholder="Please Enter Search Time" >
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Article Seized Form:</label>
                </div>
                <div class="col-md-4 form-group">
                    <textarea type="text" class="form-control" name="articleseized" placeholder="Please Enter"></textarea>
                </div>

                <div class="col-md-2">
                    <label>Item Type:</label>
                </div>
                <div class="col-md-4 form-group">
                  <input type="text" value='EMAIL' class="form-control" name="itemtype" readonly>
                </div>
                {{-- <div class="col-md-4 form-group">
                    <select class="form-control select2" Name="itemtype" >
                        <option selected>Select an Option</option>
                        <option value="General Items">General Items</option>
                        <option value="Digital Items">Digital Items</option>
                        <option value="EMail">EMAIL</option>
                    </select>
                </div> --}}
              </div>

              <div class="col-md-4">
                <label><b>Details of Articles Seized:</b></label>
              </div>
              <div class="col-md-4">
                <label><span class="text-danger">*</span> enter data in Table</label>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <table class='table table-bordered'>
                    <col>
                    <colgroup span="2"></colgroup>  
                    <tr class="bg-info text-center">
                        <th rowspan="2" scope="col" class="align-middle">Email Address</th>
                        <th rowspan="2" scope="col" class="align-middle">Password</th>
                        <th rowspan="2" scope="col" class="align-middle">Old Password</th>
                        <th rowspan="2" scope="col" class="align-middle">Phone No</th>
                        <th colspan="5" scope="colgroup">No. of mails (standard folders)</th>
                        <th rowspan="2" class="align-middle">Action</th>
                    </tr>
                    <tr class="bg-info text-center">
                        <th scope="col">Inbox</th>
                        <th scope="col">Sent</th>
                        <th scope="col">Draft</th>
                        <th scope="col">Trash</th>
                        <th scope="col">Spam</th>
                    </tr>
                    {{-- Sub Header 1 Data --}}
                    {{-- <tr>
                        <td>Itech@gmail.com</td>
                        <td>Itech95</td>
                        <td>Dummy123</td>
                        <td>Dummy123</td>
                        <td>Sections 95</td>
                        <td >Dummy123</td>
                        <td>Dummy123</td>
                        <td class="text-center">
                            <a class="btn btn-info btn-sm text-white">Browse</a>
                        </td>
                    </tr> --}}
                </table>
                      <div class="col-md-4 justify-content-end">
                        <a class="btn-sm bg-info text-white" id="insertRow">Add new</a>
                      </div>
                      
                </div> 
              </div>
              <br>
              <input type="hidden" value="{{ $seizure_id }}" name="id" />

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
                    <input type="text" class="form-control" name="seizedName" placeholder="Please Enter Name">
                </div>

                <div class="col-md-2">
                  <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="seizedCid" placeholder="Please Enter CID">
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
                  <input type="text" class="form-control" name="officerName" placeholder="Please Enter Name">
              </div>

                <div class="col-md-2">
                    <label>Designation:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="officerdesignation" placeholder="Please Enter Designation">
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-6">
                  <a class="btn btn-info btn-sm text-white" onclick="return showmember1();">Add more Member</a>
                </div>
              </div>

              <div class="row" id="memberDiv" style='display : none;'>
                <div class="col-md-2">
                  <label>Member Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="teammember1" placeholder="Please Enter Member Name(Optional)">
                </div>

                  <div class="col-md-2">
                      <label>Member Name:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" class="form-control" name="teammember2" placeholder="Please Enter Member Name(Optional)">
                  </div>
                  <div class="col-md-2">
                    <label>Member Name:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" class="form-control" name="teammember3" placeholder="Please Enter Member Name(Optional)">
                  </div>
  
                    <div class="col-md-2">
                        <label>Member Name:</label>
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" name="teammember4" placeholder="Please Enter Member Name(Optional)">
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
                    <input type="text" class="form-control" name="witnessCid1" placeholder="Please Enter Witness CID">
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="witnessName1" placeholder="Please Enter Witness Name">
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="witnessCid2" placeholder="Please Enter Case Witness CID">
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="witnessName2" placeholder="Please Enter Witness Name">
                </div>
              </div>

              {{-- <div class="col-md-6">
                <a href="{{ route('ViewCheck') }}" class="link-info text-info"><h5>Search Checklist</h5></a>
              </div> --}}

              <div class="col-md-6">
                <a href="{{ route('SearchEntryandExit') }}" class="link-info text-info"><h5>Search Entry and Exit Affirmation</h5></a>
              </div>
              <br>

              <div class="row">
                <div class="col-md-2">
                    <label>Attached Document:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="file" id="first-name" class="form-control" name="fileX">
                </div>

                {{-- <div class="col-md-2">
                  <button type="button" class="btn btn-info">Browse</button>
                </div> --}}
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
$(function () {
    // var counter = 1;
    $("#insertRow").on("click", function (event) {
        event.preventDefault();
        var newRow = $("<tr>");
        var cols = '';
        // cols += '<th scrope="row">' + counter + '</th>';
        cols += '<td><input class="form-control rounded-0" type="text" name="email[]" placeholder="Enter Email Address"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="password[]" placeholder="Enter Password"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="oldpassword[]" placeholder="Enter Old Password"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="phoneNo[]" placeholder="Enter Phone No"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="inbox[]" placeholder="Enter Inbox"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="sent[]" placeholder="Enter Sent"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="draft[]" placeholder="Enter Draft"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="trash[]" placeholder="Enter Trash"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="spam[]" placeholder="Enter of Spam"></td>';
        
        cols += '<td><button class="btn btn-outline-danger" id ="deleteRow"><i class="fa fa-trash"></i></button</td>';
        newRow.append(cols);
        $("table").append(newRow);
        counter++;
    });

    $("table").on("click", "#deleteRow", function (event) {
        $(this).closest("tr").remove();
        // counter -= 1
    });
});
</script>

@endsection
