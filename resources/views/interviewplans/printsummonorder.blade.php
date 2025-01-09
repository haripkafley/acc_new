
<body>
  <div class="container">
    <div class="card-container">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><img src="{{ asset('acc_images/acclogo.png' ) }}"   alt="ACC LOGO" style="height:135px;width:800px;"></h5>
          
          <p><b>Ref No :{FRE05122023/001}</b></p>
          <h2 style="text-align: center;"><b>Summon Order </b></h2>
          <p style="text-align: center;">(Order issued in exercise of Section 24 (1)e & 84 of the Anti-Corruption Act of Bhutan 2011)  </p>
           @foreach ($interviewdtls as $details)
          <br>

          <p><b>To:</b> &nbsp; &nbsp;</p>
          
          <p><b>Name: </b>&nbsp; &nbsp;<?php echo $key=DB::table('tbl_case_interviewees')->where('identification_no',$details->accused)->value('name') ?></p>
          <p><b>CID/WP/Passport: </b>&nbsp; &nbsp; {{ $details->accused }}</p>
          <!-- <p><b>Present Address: </b>&nbsp; &nbsp;</p> -->
          

          <br>
            <p class="custom-text"> The Anti-Corruption Commission believes that you are in possession of such knowledge, information or materials that would be relevant to the case {Case no:<b><?php echo $key=DB::table('tbl_registered_cases')->where('id',$details->case_no_id)->value('case_no') ?></b>, Case Title:<b><?php echo $key=DB::table('tbl_registered_cases')->where('id',$details->case_no_id)->value('case_title') ?></b>} that is being investigated under section 83(1) of ACAB 2011. 

Therefore, you are hereby ordered to appear before the investigating team on a date, time and location specified below for the purpose of examination and/or furnishing written statements in connection with any information or materials you may be asked to provide or explain at the time of such examination.


            </p>
            <br>
            <br>
            <p><b>Date: </b>&nbsp; &nbsp;{{ \Carbon\Carbon::parse($details->report_date)->format('d/m/Y')}}</p>
            <p><b>Time: </b>&nbsp; &nbsp;{{ date('g:i A', strtotime($details->report_time)) }}</p>
            <p><b>Location: </b>&nbsp; &nbsp;{{ $details->report_venue }}</p>
            
            <div class="col-sm-12">
            <h4><b>Documents to be produced:</b></h4>
            <table style="width:800px" border="1">
                <thead >
                    <tr>
                        <th scope="col">Description of Document/Article</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Remarks</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $documents)
                    <tr>
                        <td>{{ $documents->documents }}</td>
                        <td>{{ $documents->quantity }}</td>
                        <td>{{ $documents->remarks }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            
            <br>
            <br>
            <br>
            As a proof of service, you must acknowledge the receipt of this order in a manner considered to be proper and acceptable to the undersigned issuing officer.  

Failing to comply with this order without reasonable justifications will be deemed to have offended Section 113 (c ) and (e) the ACAB 2011. 

Issued on<br>

            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src="{{ asset('acc_images/Office_Seal.png' ) }}"   alt="ACC LOGO" style="height:135px;width:135px;">&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  (Name and Signature of Issuing Officer)</p>
            <br>
            <br>
            
            <br>
            
        </div>
      </div>
      <br>
      <button style="text-align:center" onclick="printPage()">Print</button>

    </div>
  </div>
  @endforeach
</body>

<style>
body {
  display: flex;
  justify-content: center;
  align-items: center;
  dth: 850px; /* Adjust the max-width as needed */
  padding: 5px;
}

.container {
  width: 100%;
  height: 105%;
  max-width: 850px; /* Adjust the max-width as needed */
}

.card-container {
  justify-content: center;
  align-items: center;
  
}

.card {
  width: 100%;
  height: 187%;
  border: 1px solid #000;
  

}

/* Add additional styling for card elements */
.card-body {
  padding: 10px;
  font-family : Arial, sans-serif;
  font-size: 14px;
}


.custom-text {
  font-family: Arial, sans-serif;
}

.t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
}

</style>
<script>
function printPage() {
    window.print();
}

</script>