
<div class="container">
    <div class="row">
        @foreach($uniqueOffences as $offenceName => $firstDetail)
            <div class="col-md-12">
                <div class="card" style="font-family:Product Sans">
                    <div class="card-header">
                       <b> <?php echo $key=DB::table('tbl_offences_lookup')->where('offence_id',$offenceName)->value('offence_type') ?></b>
                    </div>
                    <div class="card-body" >
                        <ul>
                            <!-- Replace 'textdetails' and 'id' with the actual property names in your objects -->
                            @foreach($offenceDetails->where('offence_name', $offenceName) as $detail)
                                <li>
                                    <?php echo $key=DB::table('tbl_elements_lookup')->where('id', $detail->element_id)->value('element_name') ?><br>
                                    <b>Evidence:</b><?php echo $key=DB::table('tbl_case_evidences')->where('id', $detail->evidence_id)->value('evidence_name') ?>{{ $detail->evidence_id }}<br>
                                    <b>Evidence Desciption</b> {{ $detail->textdetails }}<br>
                                    <b> 
                                                @if($detail->substantiate == "")
                                                    Not Substantiated 
                                                @else
                                                    Substantiated
                                                @endif
                                    </b>
                                </li>
                                <br>
                            @endforeach
                            <br>
                        </ul>
                        
                    </div>
                </div>
            </div>
            
        @endforeach
      
    </div>
</div>

