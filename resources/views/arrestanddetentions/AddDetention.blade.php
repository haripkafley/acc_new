
            <!-- content -->
            <div class = "card-body"> 
              <form action="{{ route('detentiondetailsadd') }}" method="POST">
                @csrf
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

                
                <div class="row">
                  <div class="col-md-2">
                    <label>Place of custody:</label>
                  </div>
                  <div class="col-md-4 form-group">
                  <textarea type="text" id="detained_from" class="form-control" name="detained_from" placeholder="Please Enter Detained From"></textarea>
                  </div>
  
                  <div class="col-md-2">
                      <label>Detained On:</label>
                  </div>
                  <div class="col-md-4 form-group">
                  <input type="date" id="detained_on" class="form-control" name="detained_on" placeholder="Please Enter Detained On">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label>Detention Facility:</label>
                  </div>
                  <div class="col-md-4 form-group">
                          <select class="form-control select2" name="detained_location" id="detained_location">
                              <option selected>Select an Option</option>
                              <option value="acc">ACC</option>
                              <option value="Without Court Warrant">RBP</option>
                          </select>
                  </div>
  
                  <div class="col-md-2">
                      <label>Detention Time:</label>
                  </div>
                  <div class="col-md-4 form-group">
                  <input type="time" id="detained_time" class="form-control" name="detained_time" placeholder="Please Enter Detained On">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label>Remarks :</label>
                  </div>
                  <div class="col-md-8 form-group">
                  <textarea type="text" id="remarks" class="form-control" name="remarks" placeholder="Please Enter Remarks"></textarea>
                  </div>
                  <div class="col-md-2">
                    <label></label>
                  </div>
                  <div class="col-md-4 form-group">
                  
                  </div>
                 <div>

                

              </form>

<script>

 function closearrestupdatecomission()
 {
      $("#viewarrestdetailsforupdate").hide();
      $('#addarrest').hide();
      $('#arrestanddetentionshow').show();
      $('#addarrestanddetentionbutt').hide();
 }

</script>

