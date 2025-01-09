
<div class = "card-body"> 
      @foreach ($Mainarrest as $data)
        <input type="hidden" name="arrestid" id="arrestid" value="{{ $arrest_id}}">
        <input type="hidden" name="arrestcasenoidadd" id="arrestcasenoidadd" value="{{ $data->case_no_id}}">
      <div class="row">
        <div class="col-md-4">
            <label class="text-info"><b>Application Details:</b></label>
        </div>
      </div>
      <div class="row">
          <div class="col-sm-5">
              <div class="form-group">
                  <label style="font-family:Product Sans">Type of Arrest & Detention Requested&nbsp;</label><br>
                      {{ $data->typeofArrest }}
              </div>
          </div>
          <div class="col-sm-3">
              <div class="form-group">
                  <label style="font-family:Product Sans">Application Date&nbsp;</label><br>
                      {{ \Carbon\Carbon::parse($data->applicationdate)->format('d/m/Y') }}
                                                
              </div>                                
          </div>
          <div class  = "col-md-2">
              <div class="form-group">
                <label style="font-family:Product Sans">Suspect Name&nbsp;</label> 
                     <?php echo $key=DB::table('tbl_case_entities')->where('id',$data->suspect)->value('name'); ?>  
              </div>
          </div>
        </div>
      <div class="row">
                      
          <div class="col-sm-12">
                  <div class="form-group">
                      <label style="font-family:Product Sans">Probable Cause:&nbsp;</label>
                      <ol>
                        @foreach ($pcauses as $causes)
                            <li> 
                                <?php echo $key=DB::table('tbl_probable_causes')->where('id',$causes->name)->value('name'); ?> <br>
                            </li>
                        @endforeach
                    </ol>   
                  </div>
          </div>
      </div>
               @endforeach
                
                <hr>

                <div class="row">
                  <div class="col-md-4">
                      <label class="text-info"><b>Commission’s Recommendation</b></label>
                  </div>
                </div>

                
                <div class="row">
                  <div class="col-md-6">
                    <label style="font-family:Product Sans">Recommendation Status:</label>
                  
                    <select class="form-control select2" Name="commissionStatus">
                      <option selected>Select an Option</option>
                      @foreach ($Recommendationstatus as $getData1)
                        <option value="{{ $getData1->recommendationstatus_type }}">{{ $getData1->recommendationstatus_type }}</option>
                      @endforeach
                    </select>
                  </div>
  
                  <div class="col-md-12">
                      <label style="font-family:Product Sans">Instructions/Remarks:</label>
                  
                      <textarea  type="text" class="form-control" name="commissionReview" placeholder="Please Enter Remarks" ></textarea>
                  </div>
                </div>

               

              

          


<script>

 function closearrestupdatecomission()
 {
      $("#viewarrestdetailsforupdate").hide();
      $('#addarrest').hide();
      $('#arrestanddetentionshow').show();
      $('#addarrestanddetentionbutt').hide();
 }

</script>

