
<!-- MAIN TBALE seizuregenerals -->
  <div class = "container-fluid">
      <h2 class = "card-title text-info"><b>SEARCH DETAILS</b></h2>
      <br>
        @foreach($searchforseizure as $s)
              <div class="row">
                  <div class="col-sm-6">
                      <div class="form-group">
                          <label>Search Authorization Type&nbsp;</label>
                              <select class="form-control" name="typeofsearch" readonly>
                                  <option selected >{{ $s-> typeofsearch}}</option>
                              </select>
                              
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <div class="form-group">
                          <label>Suspect Name&nbsp;</label>
                              <select class="form-control"   name="searchsuspect" id="searchsuspect" readonly>
                                  <option selected>{{ $s-> suspect}}</option>
                              </select>                                    
                      </div>                                
                  </div>
              </div>
              <div class= "row">                  
                  <div class  = "col-md-6">
                      <div class="form-group">
                          <label>Application Date&nbsp;</label>
                          <input type="date" class="form-control" value="{{ $s-> applicationdate}}" readonly name="searchapplicationdate">
                      </div>
                  </div>
              </div>     
              <div class= "row">                  
                  <div class="col-sm-12">
                          <div class="form-group">
                              <label>Probable Cause:&nbsp;<font color='red'>*</font></label>
                              <textarea type="text" class="form-control" name="searchpcause" id="searchpcause" readonly>{{ $s-> pcause}}</textarea>
                          </div>
                  </div>
              </div>
        @endforeach
              <hr>
          <form action="{{ route('saveGeneral') }}" class="form" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="text" id="casenoidseizureadd" name="casenoidseizureadd" value="{{ $case_no_id }}">
              <input type="text" id="searchidseizureadd" name="searchidseizureadd" value="{{ $search_id }}">
              <div class="row">
                <div class="col-md-6">
                    <label class="text-info"><b>Seized From</b></label>
                </div>
              </div>
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
                  <div class="col-md-2">
                    <label>CID:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" class="form-control" value="" name="seizedCid" >
                  </div> 
                  <div class="col-md-2">
                      <label>Name:</label>
                  </div>
                  <div class="col-md-4 form-group">
                      <input type="text" class="form-control" value="" name="seizedName" >
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
                    <input type="text" class="form-control" value="" name="officerName" >
                </div>

                <div class="col-md-2">
                    <label>Designation:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="" name="officerdesignation" >
                </div>
              </div>
              <br>
              <hr>

              <div class="col-md-2">
                <label class="text-info"><b>Witness:</b></label>
              </div>

              <div class="row">
                <div class="col-md-2">
                    <label>CID:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="" name="witnessCid" >
                </div>

                <div class="col-md-2">
                    <label>Name:</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="text" class="form-control" value="" name="witnessName" >
                </div>
              </div>
             
              <h2 class = "card-title text-info"><b>SEIZURES DETAILS</b></h2>
          <br>
          <br>
          <br>
          <div class="row">
              <div class="col-md-6">
                  <label><b>Seized Item Type:</b></label>
                        <select class="form-control select2" onchange="showTarget()" id="typeofseizure" name="typeofseizure">
                            <option selected>Select an Option</option>
                            @foreach ($typeseizures as $seizuretype)
                            <option value="{{ $seizuretype->seizure_type }}">{{ $seizuretype->seizure_type }}</option>
                            @endforeach
                        </select>
              </div>
          </div>
          <br>
          <div id="digitalshowdiv" style="display:none">
              <table class="table table-bordered container-fluid" id="tableDigital">
                    <thead class="bg-info text-center">
                      <tr>
                        <th scope="col">Items</th>
                        <th scope="col">Manufacturer</th>
                        <th scope="col">Model</th>
                        <th scope="col">Serial No</th>
                        <th scope="col">Condition</th>
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
          <div id="emailshowdiv" style="display:none">
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
          <div id="socialmediashowdiv" style="display:none">
          <hr>
              <div class="col-md-4">
              <label><span class="text-danger"></span>SEIZURES DETAILS SOCIAL MEDIA</label>
              </div>
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
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                      <div class="col-md-4 justify-content-end">
                        <a class="btn-sm bg-info text-white" id="insertRow3">Add new</a>
                      </div>
          </div>
          <div id="passportshowdiv" style="display:none">
              <div class="col-md-4">
                <label><span class="text-danger"></span>SEIZURES DETAILS PASSPORT</label>
              </div>
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
          <div id="currencyshowdiv" style="display:none">
              <div class="col-md-4">
                <label><span class="text-danger"></span>SEIZURES DETAILS CURRENCY</label>
              </div>
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
                <div style="float:right">
                  <button type="submit" class="btn btn-info">Save</button>
                  <button type="reset" class="btn btn-warning">Reset</button>
              </div>
              </form>
      </div>

  </div>



<script>
      function showTarget() {
            var x = document.getElementById("typeofseizure").value;
            if(x == 'Digital Items'){
                $('#digitalshowdiv').show();
                $('#socialmediashowdiv').hide();
                $('#passportshowdiv').hide();
                $('#emailshowdiv').hide();
                $('#currencyshowdiv').hide();
            }
            else if(x == 'Emails'){
                $('#digitalshowdiv').hide();
                $('#socialmediashowdiv').hide();
                $('#passportshowdiv').hide();
                $('#emailshowdiv').show();
                $('#currencyshowdiv').hide();
            }
            else if(x == 'Social Media'){
                $('#digitalshowdiv').hide();
                $('#socialmediashowdiv').show();
                $('#passportshowdiv').hide();
                $('#emailshowdiv').hide();
                $('#currencyshowdiv').hide();
            }
            else if(x == 'Passport'){
                $('#digitalshowdiv').hide();
                $('#socialmediashowdiv').hide();
                $('#passportshowdiv').show();
                $('#emailshowdiv').hide();
                $('#currencyshowdiv').hide();
                
            }
            else if(x == 'Currency'){
                $('#digitalshowdiv').hide();
                $('#socialmediashowdiv').hide();
                $('#passportshowdiv').hide();
                $('#emailshowdiv').hide();
                $('#currencyshowdiv').show();
            }
            else {
                $('#displayperson').hide();
                $('#socialmediashowdiv').hide();
                $('#passportshowdiv').hide();
                $('#emailshowdiv').hide();
                $('#currencyshowdiv').hide();
            }
        }

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



  $($("#tableDigital")).on("click", "#deleteRow", function (event) {
        $(this).closest("tr").remove();
        // counter -= 1
    });
</script>

