
<!-- MAIN TBALE seizuregenerals -->
  @foreach ($searchdetails as $data)
              <input type="hidden" name="searchidupdate" id="searchidupdate" value="{{  $search_id}}">                
                <div class="row">
                  <div class="col-md-4">
                      <label class="text-info"><b>Application Details:</b></label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <label style="font-family:Product Sans">Type of Search Requested:</label>
                  <br>
                  {{ $data->typeofsearch }}
                  </div>
                  <div class="col-md-4">
                    <label style="font-family:Product Sans">Suspect:</label>
                  <br>
                  <?php echo $key=DB::table('tbl_case_entities')->where('id',$data->suspect)->value('name'); ?>
                  </div>
  
                  <div class="col-md-4">
                      <label style="font-family:Product Sans">Application Date:</label>
                  <br>
                      {{ \Carbon\Carbon::parse($data->applicationdate)->format('d/m/Y') }}
                  </div>
  
                  
                </div>
                <br>
                

               <div class="row">
                      
          <div class="col-sm-4">
                  <div class="form-group">
                      <label style="font-family:Product Sans">Probable Cause:&nbsp;</label>
                      <br>
                                <?php echo $key=DB::table('tbl_search_probable_causes_lookup')->where('id',$data->pcause)->value('name'); ?> <br>
                  </div>
          </div>
          <div class="col-sm-4">
                  <div class="form-group">
                      <label style="font-family:Product Sans">Ownership Type:&nbsp;</label>
                      <br>
                      {{ $data->ownership_type }}
                  </div>
          </div>
          <div class="col-sm-4">
                  <div class="form-group">
                      <label style="font-family:Product Sans">Target Location:&nbsp;</label>
                      <br>
                      {{ $data->searchtarget }}
                  </div>
          </div>
      </div>
                
    <!-- @if($data->searchtarget == 'movable')
      
        <div class="row">
            <div class="col-md-4">                   
                <label style="font-family:Product Sans">Identification No:</label>
            <br>
                {{ $data->identification_no}}
            </div>

            <div class="col-md-4">
                <label style="font-family:Product Sans">Owner Name:</label>
           <br>
                {{ $data->owner_name}}
            </div>
        </div>

    @elseif($data->searchtarget == 'publicPremise')
        <div class="row">
            <div class="col-md-4">
                <label style="font-family:Product Sans">Office Name:</label>
            <br>
                {{ $data->public_premise_name}}
            </div>
            <div class="col-md-4">
                <label style="font-family:Product Sans">Location:</label>
            <br>
                {{ $data->public_premise_location}}
            </div>
        </div>

    @elseif($data->searchtarget == 'privatePremise')
        <div class="row">
            <div class="col-md-4">
                <label style="font-family:Product Sans">Location:</label>
           <br>
                {{ $data->private_premise_location}}
            </div>
        </div>
    @endif 
    <hr>
    <div class="row">
        <div class="col-md-4">
            <label class="text-info"><b>Commission's Approval:</b></label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
        <label style="font-family:Product Sans">Status:</label>
        <br>
            @if($data->commissionStatus=='Approved')
                <label class="text-success">Approved</label>
                    @elseif($data->commissionStatus=='Rejected')
                <label class="text-danger">Rejected</label>
                    @elseif($data->commissionStatus==0)
                <label class="text-warning">Pending</label>
            @endif
        </div>
        <div class="col-md-4">
        <label style="font-family:Product Sans">Commission's Recommendation:</label>
        <br>
         @if( $data->commissionReview == '')
         Not Reviewed
         @else
         {{ $data->commissionReview}}
         @endif
        </div>
    </div> -->
@endforeach




