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
            <h2 class = "card-title text-info"><b>SEIZURES DETAILS FORM </b></h2>
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
              
            <form action="{{ route('saveGeneral') }}" class="form" method="POST" enctype="multipart/form-data">
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
                    <label>Seziure Date:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="date" class="form-control" name="seziureDate" >
                </div>

                <div class="col-md-2">
                    <label>Seziure Time:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="time" class="form-control" name="seziureTime"  >
                </div>
              </div>

              <div class="row">
                <!-- <div class="col-md-2">
                    <label>Article Seized Form:</label>
                </div>
                <div class="col-md-4 form-group">
                    <textarea type="text" class="form-control" name="articleseized" placeholder="Please Enter"></textarea>
                </div>
z
                <div class="col-md-2">
                    <label>Item Type:</label>
                </div> -->
                <!-- <div class="col-md-4 form-group">
                  <input type="text" value='General Items' class="form-control" name="itemtype" readonly>
                </div> -->
               
              </div>
              <hr>

              <div class="col-md-4">
                <label><b>Details of Articles Seized:</b></label>
              </div>
              <div class="col-md-4">
                <label><span class="text-danger"></span>SEIZURES DETAILS GENERAL</label>
              </div>

              <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered container-fluid" id="tableGeneral">
                        <thead class="bg-info text-center">
                          <tr>
                            <th scope="col">Description of Articles</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                      <div class="col-md-4 justify-content-end">
                        <a class="btn-sm bg-info text-white" id="insertRow">Add new</a>
                      </div>
                      
                </div> 
              </div>
              <br>
              <input type="hidden" value="{{ $seizure_id }}" name="id" />

              <!-- digital table -->
              <!-- <div class="col-md-4">
                <label><b>Details of Articles Seized:</b></label>
              </div> -->
              <hr>
              <div class="col-md-4">
                <label><span class="text-danger"></span>SEIZURES DETAILS DIGITAL</label>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered container-fluid" id="tableDigital">
                    <thead class="bg-info text-center">
                      <tr>
                        <th scope="col">Items</th>
                        <th scope="col">Manufacturer</th>
                        <th scope="col">Model</th>
                        <th scope="col">Serial No</th>
                        <th scope="col">Condition</th>
                        <th scope="col">Image</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Action</th>
                      </tr>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                      <div class="col-md-4 justify-content-end">
                        <a class="btn-sm bg-info text-white" id="insertRow1">Add new</a>
                      </div>
                      
                </div> 
              </div>
              <br>
              <!-- <input type="hidden" value="{{ $seizure_id }}" name="id" /> -->

              <!-- Email table -->
              <!-- <div class="col-md-4">
                <label><b>Details of Articles Seized:</b></label>
              </div> -->
              <hr>
              <div class="col-md-4">
                <label><span class="text-danger"></span>SEIZURES DETAILS EMAIL</label>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <table class='table table-bordered' id="tableEmail">
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
                    
                </table>
                      <div class="col-md-4 justify-content-end">
                        <a class="btn-sm bg-info text-white" id="insertRow2">Add new</a>
                      </div>
                      
                </div> 
              </div>
              <br>
              <input type="hidden" value="{{ $seizure_id }}" name="id" />

              

              <!-- Social Media Table -->
              <!-- <div class="col-md-4">
                <label><b>Details of Articles Seized:</b></label>
              </div> -->
              <hr>
              <div class="col-md-4">
              <label><span class="text-danger"></span>SEIZURES DETAILS SOCIAL MEDIA</label>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered container-fluid" id="tableSocial">
                    <thead class="bg-info text-center">
                      <tr>
                        <th scope="col">Platform</th>
                        <th scope="col">Account Name</th>
                        <th scope="col">Password</th>
                        <th scope="col">Old Password</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Action</th>
                        
                      </tr>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                      <div class="col-md-4 justify-content-end">
                        <a class="btn-sm bg-info text-white" id="insertRow3">Add new</a>
                      </div>
                      
                </div> 
              </div>
              <br>
              <input type="hidden" value="{{ $seizure_id }}" name="id" />

              <!-- Passport table -->
              <!-- <div class="col-md-4">
                <label><b>Details of Articles Seized:</b></label>
              </div> -->
              <hr>
              <div class="col-md-4">
                <label><span class="text-danger"></span>SEIZURES DETAILS PASSPORT</label>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered container-fluid" id="tablePassport">
                    <thead class="bg-info text-center">
                      <tr>
                        <th scope="col">Passport No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Issue Date</th>
                        <th scope="col">Expiry Date</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Action</th>
                        
                      </tr>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                      <div class="col-md-4 justify-content-end">
                        <a class="btn-sm bg-info text-white" id="insertRow4">Add new</a>
                      </div>
                      
                </div> 
              </div>
              <br>
              <input type="hidden" value="{{ $seizure_id }}" name="id" />

              <!-- Currency Table -->
              <hr>
              <div class="col-md-4">
                <label><span class="text-danger"></span>SEIZURES DETAILS CURRENCY</label>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered container-fluid" id="tableCurrency">
                    <thead class="bg-info text-center">
                      <tr>
                        <th scope="col">Type Of Currency</th>
                        <th scope="col">Denominations</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Action</th>
                        
                      </tr>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                      <div class="col-md-4 justify-content-end">
                        <a class="btn-sm bg-info text-white" id="insertRow5">Add new</a>
                      </div>
                      
                </div> 
              </div>
              <br>
              <input type="hidden" value="{{ $seizure_id }}" name="id" />

              <hr>
              <div class="row">
                <div class="col-md-6">
                    <label class="text-info"><b>Seized Currency Details</b></label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                    <label>Bank Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="bankName" placeholder="Please Enter Bank">
                </div>

                <div class="col-md-2">
                  <label>Branch Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="bankBranch" placeholder="Please Enter Branch Name">
                </div> 
              </div>
              <div class="row">
                <div class="col-md-2">
                    <label>Account Number:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="accNo" placeholder="Please Enter Account Number">
                </div>

                <div class="col-md-2">
                  <label>Date Of Deposit:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="date" class="form-control" name="depositDate" >
                </div> 
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>Attached Bank Reciept:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="file" id="bankReciept" class="form-control" name="DocBR">
                </div>
                    </div>
              <hr>

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
                    <input type="text" class="form-control" name="witnessCid" placeholder="Please Enter Witness CID">
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="witnessName" placeholder="Please Enter Witness Name">
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="witnessCid1" placeholder="Please Enter Case Witness CID">
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="witnessName1" placeholder="Please Enter Witness Name">
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
                    <input type="file" id="first-name" class="form-control" name="seizeddoc">
                </div>

                {{-- <div class="col-md-2">
                  <button type="button" class="btn btn-info">Browse</button>
                </div> --}}
              </div>

              <div class="col-md-4 mb-4">
                  <button type="submit" class="btn btn-info">Save</button>
                  <button type="reset" class="btn btn-warning">Reset</button>
              </div>
            </form>

        </div>
      </div>
    </div>
  </div>
</div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
        cols += '<td><input class="form-control rounded-0" type="text" name="description[]" placeholder="Description of Article"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="quantity[]" placeholder="Quantity"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="remarks[]" placeholder="Remarks"></td>';
        cols += '<td><button class="btn btn-outline-danger" id ="deleteRow"><i class="fa fa-trash"></i></button</td>';
        newRow.append(cols);
        $("#tableGeneral").append(newRow);
        counter++;
    });
  })

    $(function () {
    // var counter = 1;
    $("#insertRow1").on("click", function (event) {
        event.preventDefault();
        var newRow1 = $("<tr>");
        var cols1 = '';
        // cols += '<th scrope="row">' + counter + '</th>';
        cols1 += '<td><select class="form-control select2" name="item[]" ><option selected>Select an Option</option><option value="Computer">Computer</option><option value="2">Laptop</option><option value="3">Phone</option><option value="3">Others</option></select></td>'
        cols1 += '<td><input type="text" id="manufacturer" class="form-control" name="manufacturer[]"></td>';
        cols1 += '<td><input type="text" id="model" class="form-control" name="model[]"></td>';
        cols1 += '<td><input type="text" id="serial" class="form-control" name="serial[]"></td>';
        cols1 += '<td><input type="text" id="condition" class="form-control" name="condition[]"></td>';
        cols1 += '<td><input type="file" id="image" class="form-control" name="image[]"></td>';
        cols1 += '<td><input type="text" id="Remarks" class="form-control" name="Remarks[]"></td>';
        cols1 += '<td><button class="btn btn-outline-danger" id ="deleteRow"><i class="fa fa-trash"></i></button</td>';
        newRow1.append(cols1);
        $("#tableDigital").append(newRow1);
        counter++;
    });
  })

  $(function () {
    // var counter = 1;
    $("#insertRow2").on("click", function (event) {
        event.preventDefault();
        var newRow2 = $("<tr>");
        var cols2 = '';
        // cols += '<th scrope="row">' + counter + '</th>';
        cols2 += '<td><input class="form-control rounded-0" type="text" name="email[]" placeholder="Enter Email Address"></td>';
        cols2 += '<td><input class="form-control rounded-0" type="text" name="password[]" placeholder="Enter Password"></td>';
        cols2 += '<td><input class="form-control rounded-0" type="text" name="oldpassword[]" placeholder="Enter Old Password"></td>';
        cols2 += '<td><input class="form-control rounded-0" type="text" name="phoneNo[]" placeholder="Enter Phone No"></td>';
        cols2 += '<td><input class="form-control rounded-0" type="text" name="inbox[]" placeholder="Enter Inbox"></td>';
        cols2 += '<td><input class="form-control rounded-0" type="text" name="sent[]" placeholder="Enter Sent"></td>';
        cols2 += '<td><input class="form-control rounded-0" type="text" name="draft[]" placeholder="Enter Draft"></td>';
        cols2 += '<td><input class="form-control rounded-0" type="text" name="trash[]" placeholder="Enter Trash"></td>';
        cols2 += '<td><input class="form-control rounded-0" type="text" name="spam[]" placeholder="Enter of Spam"></td>';
        
        cols2 += '<td><button class="btn btn-outline-danger" id ="deleteRow"><i class="fa fa-trash"></i></button</td>';
        newRow2.append(cols2);
        $("#tableEmail").append(newRow2);
        counter++;
    });
  })
  $(function () {
    // var counter = 1;
    $("#insertRow3").on("click", function (event) {
        event.preventDefault();
        var newRow3 = $("<tr>");
        var cols3 = '';
        // cols += '<th scrope="row">' + counter + '</th>';
        cols3 += '<td><input class="form-control rounded-0" type="text" name="platform[]" placeholder="Enter of Platform"></td>';
        cols3 += '<td><input class="form-control rounded-0" type="text" name="accountform[]" placeholder="Enter Account Name"></td>';
        cols3 += '<td><input class="form-control rounded-0" type="text" name="password[]" placeholder="Enter Password"></td>';
        cols3 += '<td><input class="form-control rounded-0" type="text" name="oldpassword[]" placeholder="Enter Old Password"></td>';
        cols3 += '<td><input class="form-control rounded-0" type="text" name="remarks[]" placeholder="Enter Remarks"></td>';
        cols3 += '<td><button class="btn btn-outline-danger" id ="deleteRow"><i class="fa fa-trash"></i></button</td>';
        newRow3.append(cols3);
        $("#tableSocial").append(newRow3);
        counter++;
    });
  })
  $(function () {
    // var counter = 1;
    $("#insertRow4").on("click", function (event) {
        event.preventDefault();
        var newRow4 = $("<tr>");
        var cols4 = '';
        // cols += '<th scrope="row">' + counter + '</th>';
        cols4 += '<td><input class="form-control rounded-0" type="text" name="passportno[]" placeholder="Enter of Passport No"></td>';
        cols4 += '<td><input class="form-control rounded-0" type="text" name="name[]" placeholder="Enter Account Name"></td>';
        cols4 += '<td><input class="form-control rounded-0" type="text" name="issuedate[]" placeholder="Enter Issue Date"></td>';
        cols4 += '<td><input class="form-control rounded-0" type="text" name="expirydate[]" placeholder="Enter Expiry Date"></td>';
        cols4 += '<td><input class="form-control rounded-0" type="text" name="remarks[]" placeholder="Enter Remarks"></td>';
        cols4 += '<td><button class="btn btn-outline-danger" id ="deleteRow"><i class="fa fa-trash"></i></button</td>';
        newRow4.append(cols4);
        $("#tablePassport").append(newRow4);
        counter++;
    });
  })

  $(function () {
    // var counter = 1;
    $("#insertRow5").on("click", function (event) {
        event.preventDefault();
        var newRow5 = $("<tr>");
        var cols5 = '';
        // cols += '<th scrope="row">' + counter + '</th>';
        cols5 += '<td><input class="form-control rounded-0" type="text" name="typeOfCurrency[]" placeholder="Enter Type of Currency"></td>';
        cols5 += '<td><input class="form-control rounded-0" type="text" name="denominations[]" onInput="calc1()" id ="deno" placeholder="Enter No. of Denominations"></td>';
        cols5 += '<td><input class="form-control rounded-0" type="text" name="frequency[]" onInput="calc2()" id ="freq" placeholder="Enter Quantity"></td>';
        cols5 += '<td><input class="form-control rounded-0" type="text" name="amount[]" placeholder="Enter Amount"></td>';
        cols5 += '<td><input class="form-control rounded-0" type="text" name="remarks[]" placeholder="Enter Remarks"></td>';
        cols5 += '<td><button class="btn btn-outline-danger" id ="deleteRow"><i class="fa fa-trash"></i></button</td>';
        newRow5.append(cols5);
        $("#tableCurrency").append(newRow5);
        counter++;
    });
  })

  function calc1(){
    var denonumber = document.getElementById("deno");
    var denomination = denonumber.value;
    calculateamount(denomination,1);
  }

  function calc2(){
    var freqnumber = document.getElementById("freq");
    var frequency = freqnumber.value;
    calculateamount(frequency,1);
  }

  function calculateamount(denomination, frequency){
    if(frequency == 1){
      var a = denomination;
      var b = 1;
    }
    else{
      var b = frequency;
      var a = 1;
    }

    var total = a * b;
    alert(total);
    // alert(a);
    // alert(b);
    

  }
    $("table").on("click", "#deleteRow", function (event) {
        $(this).closest("tr").remove();
        // counter -= 1
    });

</script>

@endsection
