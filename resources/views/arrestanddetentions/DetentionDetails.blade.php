
<!-- Detention -->
<section id="table1s" class = "content">
  <div class = "container-fluid">
    <div class = "row">
      <div class = "col-12">
        <div class = "card">
          <div class = "card-header">
            <h2 class = "card-title text-info"><b>Detention Details </b></h2>
            <div class="d-flex justify-content-end">
            </div>
            </div>
          </div>
            <!-- content -->
            
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
                           
                

               @endforeach
                
                <hr>

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
                 
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<script>
  function closedetentiondetails()
  {
        $("#displaydetentiondetails").hide();
        $('#arrestanddetentionshow').show();
        $('#addarrestanddetentionbutt').show();
  }
</script>


