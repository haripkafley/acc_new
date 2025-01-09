
<body>
  <div class="container">
    <div class="card-container">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><img src="{{ asset('acc_images/acclogo.png' ) }}"   alt="ACC LOGO" style="height:135px;width:800px;"></h5>
          
          <p><b>Ref No :{FRE05122023/001}</b></p>
          <h2 style="text-align: center;"><b>Case Assignment Order </b></h2>
          <p class="custom-text">In exercise of the power under Section 31 of the Anti-Corruption Act of Bhutan 2011, the Commission has assigned following investigating officers to commence and inquiry or investigation into the allegation/matter  </p>
           @foreach ($casesdtls as $casedetails)
          <br>

          <p><b>Case No:</b> &nbsp; &nbsp;{{ $caseno }}</p>
          <p><b>Case Title: </b>&nbsp; &nbsp;{{ $casedetails->case_title }}</p>
          <p><b>Supervisor: </b>&nbsp; &nbsp;<?php echo $key=DB::table('users')->where('email',$chief)->value('name') ?></p>
          <p><b>Lead Investigator:</b>&nbsp; &nbsp;<?php echo $key=DB::table('users')->where('email',$teamleader)->value('name') ?></p>
          <p><b>Assisting Investigators:</b> 
                @foreach($teammember as $team)    
                    <?php echo $key=DB::table('users')->where('email',$team->assigned_to)->value('name') ?> 
                                @endforeach</p>
          <p><b>Legal Representative:</b>&nbsp; &nbsp;<?php echo $key=DB::table('users')->where('email',$legalrep)->value('name') ?></p>

          <br>
            <p class="custom-text"> By issuing this order, the Commission is deemed to have lawfully authorised the team to exercise all relevant powers and duties under Chapter 6 as well as any other applicable sections under the Anti-Corruption Act of Bhutan 2011 that may be necessary to complete the investigation. The team shall conduct the investigation expeditiously with the highest standard of due diligence, fairness and professionalism in accordance with its established policies and procedures. 

Any person or entities to whom this order has been produced in the course of execution must oblige to assist and/or comply with any lawful demands failing of which may necessitate the Commission to invoke Section 113 (2) of the Anti-Corruption Act of Bhutan 2011. 

Issued under the seal and signature of the Commission on {{ \Carbon\Carbon::parse($casedetails->assignment_order_date)->format('d/m/Y')}}.
@endforeach
            </p>
            <br>
            <br>
            <br>
            
            <br>
            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src="{{ asset('acc_images/Office_Seal.png' ) }}"   alt="ACC LOGO" style="height:135px;width:135px;">&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  (Chairperson)</p>
            <br>
            <br>
            
            <br>
            <p>
            Copied to in confidence:   
            <br>
              (1)	Director, Department of Professional Support Service, ACC<br>
              (2)	Head, Legal Division, ACC
              </p>
        </div>
      </div>
      <br>
      <button style="text-align:center" onclick="printPage()">Print</button>
      &nbsp;
      <button id="backButton" onclick="javascript:history.back()">Back</button>
<br>

    </div>
  </div>
  
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
  height: 100%;
  max-width: 850px; /* Adjust the max-width as needed */
}

.card-container {
  justify-content: center;
  align-items: center;
  
}

.card {
  width: 100%;
  height: 190%;
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



</style>
<script>
function printPage() {
    window.print();
}
function goBack() {
    // Go back in the browser history
    window.history.back();

    // Reload the current page to refresh it
    location.reload();
}


</script>