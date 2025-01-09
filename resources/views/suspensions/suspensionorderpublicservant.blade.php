
<body>
  <div class="container">
    <div class="card-container">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><img src="{{ asset('acc_images/acclogo.png' ) }}"   alt="ACC LOGO" style="height:135px;width:800px;"></h5>
          
          <p><b>Ref No :{}</b></p>
          <h2 style="text-align: center;"><b>Suspension Order </b></h2>
          <p class="custom-text">The Anti-Corruption Commission, in exercise of the power conferred under Section 167 (1) & (3) of the Anti-Corruption Act of Bhutan 2011 hereby directs the (agency name) to place the following public servant under suspension from his/her service effective from the date of issue of this order or the day of the detention whichever is earlier.  </p>
          <br>
        @foreach($suspensions as $susp)
          <p><b>Name: </b> {{ $susp->name}}</p>
          <p><b>CID No: </b>{{ $susp->identification_no}}</p>
          <p><b>EID No: </b>{{ $susp->employeeno}}</p>
          <p><b>Position Title:</b>{{ $susp->positiontitle}}</p>
          <p><b>Parent Agency:</b>{{ $susp->parentagency}}</p>
          <p><b>Working Agency:</b>{{ $susp->workingagency}}</p>
        

          <br>
            <p class="custom-text"> The above subject has been placed under suspension for the following reasons: <br>	
1. He/she is being currently investigated by the Commission and as been detained since {arrest/detention date} under  the Anti-Corruption Act of Bhutan 2011;  AND/OR
2. The Commission has assessed that his/her regular attendance of his/her office while under investigation is likely to hinder, impede or frustrate the collection of evidence and witness testimonies hampering the investigation. 
<br><br>
The service conditions while under suspension shall be as per BCSR or relevant agency service rules in effect, and a copy of the suspension order issued by the agency shall be submitted to the Commission. The suspension shall remain in force, unless otherwise rescinded by the Commission. 
<br><br>
Kindly note that non-compliance to enforce the Commission’s lawful demand in the course of execution of its functions, constitute an offense under Section 113 (1) (c) of the Anti-Corruption Act of Bhutan 2011. 
<br>
<br>
<br>
Issued under the seal and signature of the Commission on {{ \Carbon\Carbon::parse($susp->suspended_on)->format('d/m/Y')}}.
            </p>
            @endforeach
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
              (1)	Chairperson, RCSC for information<br>
              (2)	Head of concern agency for compliance and necessary action, and
              (3)   Concerned individual for information
              </p>
        </div>
      </div>
      <br>
      <button style="text-align:center" onclick="printPage()">Print</button>
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
  height: 230%;
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

</script>