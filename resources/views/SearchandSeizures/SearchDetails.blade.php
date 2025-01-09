
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
          
      

  </div>




