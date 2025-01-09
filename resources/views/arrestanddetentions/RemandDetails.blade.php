
         
            <div class = "card-body">
                @foreach ($Mainarrest as $data)

                <div class="row">
                  <div class="col-md-2">
                      <label class="text-info"><b>Arrest Details:</b></label>
                  </div>
                </div>
                <br>
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label>Type of Arrest & Detention Requested&nbsp;</label><br>
                                      {{ $data->typeofArrest }}
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label>Application Date&nbsp;</label><br>
                                      {{ \Carbon\Carbon::parse($data->applicationdate)->format('d/m/Y') }}
                                                                
                              </div>                                
                          </div>
                      </div>
                      <div class= "row">                  
                          <div class  = "col-md-6">
                              <div class="form-group">
                                <label>Suspect Name&nbsp;</label> <br>
                                     <?php echo $key=DB::table('tbl_case_entities')->where('id',$data->suspect)->value('name'); ?>  
                                  
                              </div>
                          </div>
                          <div class  = "col-md-6">
                              <div class="form-group">
                              <label>Location&nbsp;</label><br>
                                      {{ $data->location }} 
                              </div>
                          </div>
                      </div>     
                      <div class= "row">                  
                          <div class="col-sm-12">
                                  <div class="form-group">
                                      <label>Probable Cause:&nbsp;</label>
                                      {!! $data->pcause !!} 
                                  </div>
                          </div>
                      </div>
                           
                <hr>

               @endforeach
                

                <div class="row">
                  <div class="col-md-4">
                      <label class="text-info"><b>Detention Details</b></label>
                  </div>
                </div>

                @foreach ($detentions as $detention)
                <div class="row">
                    <div class="col-md-2">
                      <label>Place of custody:</label>
                    </div>
                    <div class="col-md-4 form-group">
                    {{ $detention->detained_from }}
                    </div>
    
                    <div class="col-md-2">
                        <label>Detained On:</label>
                    </div>
                    <div class="col-md-4 form-group">
                    {{ $detention->detained_on }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                      <label>Detention Facility:</label>
                    </div>
                    <div class="col-md-4 form-group">
                    {{ $detention->detained_location }}
                    </div>
    
                    <div class="col-md-2">
                        <label>Detention Time:</label>
                    </div>
                    <div class="col-md-4 form-group">
                    {{ $detention->detained_time }}
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label>Remarks :</label>
                  </div>
                  <div class="col-md-8 form-group">
                  {{ $detention->remarks }}
                  </div>
                  
                 <div>
</div>
</div>
                 <hr>

            @endforeach

              <div class="row">
                  <div class="col-md-4">
                      <label class="text-info"><b>Remand Details</b></label>
                  </div>
              </div>
              <div class="row">
                    <div class="col-md-2">
                        <label>Application Date:</label>
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="date" id="remandapplicationdate" class="form-control" name="remandapplicationdate" >
                    </div>
              
                      <div class="col-md-2">
                       
                          <label>Arrest Warrant Reference No:</label>
                      </div>
                      <div class="col-md-4 form-group">
                          <input type="text" id="first-name" class="form-control" name="warrant_rNo" placeholder="Please Enter Arrest Warrant Reference No">
                      </div>
                      </div>
              <div class="row">
                      <div class="col-md-2">
                          <label>Court Order Reference No:</label>
                      </div>
                      <div class="col-md-4 form-group">
                          <input type="text" id="first-name" class="form-control" name="court_rNo" placeholder="Please Enter Court Order Reference No">
                      </div>
                    

                    <div class="col-md-2">
                        <label>Court:</label>
                      </div>
                      <div class="col-md-4 form-group">
                        <select class="form-control select2" Name="court" >
                          <option selected>Select an Option</option>
                          @foreach ($courts as $getData)
                            <option value="{{ $getData->court_type }}">{{ $getData->court_type }}</option>
                          @endforeach
                        </select>
                      </div>
                      </div>
              </div>
             
           
          </div>
          <button type="button" style="float:right"  class="btn btn-outline-primary" onclick="closeremanddetails()" name="add" data-toggle="tooltip" data-placement="bottom" title="Go Back"><i class="fa fa-times"></i></button>
              <button type="submit" style="float:right" class="btn btn-outline-primary"  name="add" data-toggle="tooltip" data-placement="bottom" title="Save"><i class="fa fa-save"></i></button> 

        
       





