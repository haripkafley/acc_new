
<!-- MAIN TBALE seizuregenerals -->
  <div class = "container-fluid">
      <h2 class = "card-title text-info"><b>SEARCH DETAILS</b></h2>
      <br>
        @foreach($search as $s)
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
              <form method="POST" action="{{ route('updateSelectedRows') }}">
                @csrf
              <table class="table table-bordered container-fluid" id="table1s">
                        <thead class="bg-info text-center">
                          <tr>
                            <th scope="col"></th>
                            <th scope="col">Items</th>
                            <th scope="col">Manufacturer</th>
                            <th scope="col">Model</th>
                            <th scope="col">Serial No</th>
                            <th scope="col">Condition</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Status</th> 
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($seizuredetailsdigitalitems as $data1)
                          <tr>
                            <td><input type="checkbox" name="selected[]" value="{{ $data1->seizure_id }}"><input type="hidden" id="casenoidseizure" name="casenoidseizure" value="{{ $data1->case_no_id }}"></td>
                            <td>{{ $data1->item }}</td>
                            <td>{{ $data1->manufacturer }}</td>
                            <td>{{ $data1->model }}</td>
                            <td>{{ $data1->serialNo }}</td>
                            <td>{{ $data1->condition }}</td>
                            <td>{{ $data1->remarks }}</td>
                            <td>{{ $data1->status }}</td>
           
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                      <button type="submit">Send selected rows to Forensics</button>
</form>
              <br>
              <table class='table table-bordered'>
                    <col>
                    <colgroup span="2"></colgroup>
                    <tr class="bg-info text-center">
                        <th rowspan="2" scope="col" class="align-middle">Email Address</th>
                        <th rowspan="2" scope="col" class="align-middle">Password</th>
                        <th rowspan="2" scope="col" class="align-middle">Old Password</th>
                        <th rowspan="2" scope="col" class="align-middle">Phone No</th>
                        <th colspan="5" scope="colgroup">No. of mails (standard folders)</th>
                        {{-- <th rowspan="2" class="align-middle">Action</th> --}}
                    </tr>
                    <tr class="bg-info text-center">
                        <th scope="col">Inbox</th>
                        <th scope="col">Sent</th>
                        <th scope="col">Draft</th>
                        <th scope="col">Trash</th>
                        <th scope="col">Spam</th>
                    </tr>
                    {{-- Sub Header 1 Data --}}
                    @foreach ($seizuredetailsemails as $data2)
                    <tr>
                        <td>{{ $data2->email }}</td>
                        <td>{{ $data2->password }}</td>
                        <td>{{ $data2->oldpassword }}</td>
                        <td>{{ $data2->phoneNo }}</td>
                        <td>{{ $data2->inbox }}</td>
                        <td>{{ $data2->sent }}</td>
                        <td>{{ $data2->draft }}</td>
                        <td>{{ $data2->trash }}</td>
                        <td >{{ $data2->spam }}</td>
                        
                        {{-- <td class="text-center">
                            <a class="btn btn-info btn-sm text-white">Browse</a>
                        </td> --}}
                    </tr>
                    @endforeach
                </table>
                <br>
                <table class="table table-bordered container-fluid" id="table1s">
                        <thead class="bg-info text-center">
                          <tr>
                            <th scope="col">Platform</th>
                            <th scope="col">Account Name</th>
                            <th scope="col">Password</th>
                            <th scope="col">Old Password</th>
                            <th scope="col">Remarks</th>
                            {{-- <th scope="col">Action</th> --}}
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($seizuredetailssocialmedia as $data1)
                          <tr>
                            <td>{{ $data1->platform }}</td>
                            <td>{{ $data1->accountform }}</td>
                            <td>{{ $data1->password }}</td>
                            <td>{{ $data1->oldpassword }}</td>
                            <td>{{ $data1->remarks }}</td>
                           
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                      <br>
                <table class="table table-bordered container-fluid" id="table1s">
                        <thead class="bg-info text-center">
                          <tr>
                            <th scope="col">Passport No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Issue Date</th>
                            <th scope="col">Expiry Date</th>
                            <th scope="col">Remarks</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($seizuredetailspassport as $data3)
                          <tr>
                            <td>{{ $data3->passportno }}</td>
                            <td>{{ $data3->name }}</td>
                            <td>{{ $data3->issuedate }}</td>
                            <td>{{ $data3->expirydate }}</td>
                            <td>{{ $data3->remarks }}</td>
                         
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                      <br>
      </div>

  </div>



<script>
      
</script>

