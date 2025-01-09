
<body>
  <div class="container">
    <div class="card-container">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><img src="{{ asset('acc_images/acclogo.png' ) }}"   alt="ACC LOGO" style="height:135px;width:800px;"></h5>
          
          <p><b>Ref No :{FRE05122023/001}</b></p>
          <h2 style="text-align: center;"><b>Interview Summary Report </b></h2>
          
           @foreach ($interviewreportdtls as $details)
          <br>

          
            <div class="col-sm-12">
            
                <table style="width:800px" border="1">
                    <tr>
                        <th>Case No</th>
                        <td><?php echo $key=DB::table('tbl_registered_cases')->where('id',$caseno)->value('case_no') ?></td>
                        <th>Place of Interview</th>
                        <td>{{ $details->actual_location }}</td>
                    </tr>
                    <tr>
                        <th>Interviewee</th>
                        <td><?php echo $key=DB::table('tbl_case_interviewees')->where('identification_no',$interviewee)->value('name') ?></td>
                        <th>CID</th>
                        <td>{{ $interviewee }}</td>
                    </tr>
                    <tr>
                        <th>Interview Date</th>
                        <td>{{ $details->interview_date }}</td>
                        <th>Mode of Interview</th>
                        <td>{{ $details->interview_type }}</td>
                    </tr>
                    <tr>
                        <th>Start Time</th>
                        <td>{{ $details->start_time }}</td>
                        <th>End Time</th>
                        <td>{{ $details->end_time }}</td>
                    </tr>
                    <tr>
                        <th>Statement Taken</th>
                        <td>{{ $details->written_statement }}</td>
                        <th>Interviewers</th>
                        <td>@foreach($interviewers as $views)
                        <?php echo $key=DB::table('users')->where('email',$views->interviewers)->value('name'); ?><br>
                    @endforeach  </td>
                    </tr>
                    
                    <!-- Add more rows as needed -->
                </table>
            </div>
            
            <br>
            <br>
            <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Interview Summary&nbsp;</label><br>
                        {{  $details->interview_summary }}  
                </div>
            </div>
            </div>
            <div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Observation Summary&nbsp;</label><br>
                    {{  $details->observation_summary }} 
                </div>
            </div> 
        
    </div>
            <br>
            <br>

            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Investigator Name: &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  (Date)</p>
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