  @foreach ($detentions as $data)

    <div class="row">
        <div class="col-md-6">
            <label style="font-family:Product Sans"> Suspect:</label>&nbsp; <?php echo $key=DB::table('tbl_case_entities')->where('id',$data->suspect)->value('name'); ?> [CID: <?php echo $key=DB::table('tbl_case_entities')->where('id',$data->suspect)->value('identification_no'); ?>] &nbsp;  
        </div>
    
        <div class="col-md-6">
            <div class="form-group">
                <label style="font-family:Product Sans">Detained On:</label>&nbsp;  {{ \Carbon\Carbon::parse($data->detained_on)->format('d/m/Y')}}
            </div>
        </div>
            
    </div>
    <div class="row" > 
        <div class="col-md-6">
            <div class="form-group">
                <label style="font-family:Product Sans">Detained From:</label>&nbsp;  {{ $data->detained_from}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label style="font-family:Product Sans">Detained By:</label>&nbsp;  <?php echo $key=DB::table('users')->where('email',$data->detained_by)->value('name'); ?>
            </div>
        </div>
    </div>
     
    <div class="row">
        <div class="col-md-12">
                <label style="font-family:Product Sans"> Probable Cause:</label>
                    <ol>
                        @foreach ($pcauses as $causes)
                            <li> 
                                <?php echo $key=DB::table('tbl_probable_causes')->where('id',$causes->name)->value('name'); ?> <br>
                            </li>
                        @endforeach
                    </ol>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                <label style="font-family:Product Sans"> Status:</label>&nbsp; 
                    @if($data->status=='Detained')
                        <label class="text-danger">Under Custody</label>
                    @elseif($data->status=='Released')
                        <label class="text-success">Released</label>
                    @endif
        </div>
    </div>
    @endforeach
    

   
                
                