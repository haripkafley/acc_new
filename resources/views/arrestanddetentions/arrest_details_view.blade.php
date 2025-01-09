  @foreach ($Mainarrest as $data)

   <div class="row" > 
        <div class="col-md-10">
            <div class="form-group">
                <label style="font-family:Product Sans">Type of Arrest & Detention Requested:</label>&nbsp;  {{ $data->typeofArrest }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <label style="font-family:Product Sans"> Suspect:</label>&nbsp; <?php echo $key=DB::table('tbl_case_entities')->where('id',$data->suspect)->value('name'); ?> [CID: <?php echo $key=DB::table('tbl_case_entities')->where('id',$data->suspect)->value('identification_no'); ?>] &nbsp;  
        </div>
        
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
                <label style="font-family:Product Sans"> Probable Offence:</label>
                    <ol>
                        @foreach ($pcauses as $causes)
                            <li> 
                                <?php echo $key=DB::table('tbl_probable_causes')->where('id',$causes->name)->value('name'); ?> <br>
                            </li>
                        @endforeach
                    </ol>   
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
                <label style="font-family:Product Sans"> Status:</label>&nbsp; 
                  @if($data->commissionStatus=='Approved')
                        <label class="text-success">Approved</label>
                    @elseif($data->commissionStatus=='Reject')
                        <label class="text-danger">Rejected</label>
                    @elseif($data->commissionStatus=='Arrested')
                        <label class="text-danger">Arrested</label>
                    @elseif($data->commissionStatus==0)
                        <label class="text-warning">Pending</label>
                    @endif
        </div>
    </div>
    <div class="row" > 
        <div class="col-md-10">
            <div class="form-group">
                <label style="font-family:Product Sans">Commission's Recommendations:</label>&nbsp;  
                @if($data->commissionReview == "" )
                <label class="text-warning">Pending</label>
                @else
                {{ $data->commissionReview }}
                @endif
            </div>
        </div>
    </div>
                        
    @endforeach
                
                