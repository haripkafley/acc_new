
<body>
  <div class="container">
    <div class="card-container">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><img src="{{ asset('acc_images/acclogo.png' ) }}"   alt="ACC LOGO" style="height:135px;width:800px;"></h5>
          
          <p><b>Ref No :{}</b></p>
          <h2 style="text-align: center;"><b>Revocation Order </b></h2>
          <p class="custom-text">In exercise of the power conferred under section 24 (1) (h) of the Anti-Corruption Act of Bhutan 2011, the Commission hereby revokes the following decision with effect from the day following the receipt of this order for reasons stated herein.</p>
          <br>
          <p><b>Cause for revocation:	</b></p>
        @foreach($suspensions as $susp)
          <p><b>Particulars of decision: </b> {{ $susp->revoke_reason}}</p>
          <p><b>Name: </b> {{ $susp->name}}</p>
          <p><b>CID/License No: </b>{{ $susp->identification_no}}</p>

          <br>
            <p class="custom-text"> The agency concerned shall carry out the revocation order and inform the Commission to that effect.
<br><br>
Non-compliance to enforce the Commission’s lawful demand in the course of execution of its functions constitutes an offence under Section 113 (1) (c) of the Anti-Corruption Act of Bhutan 2011.
<br><br>
    <br>
<br>
<br>
Issued under the seal and signature of the Commission on {{ \Carbon\Carbon::parse($susp->revoke_date)->format('d/m/Y')}}.
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
              (1)	Person Concerned<br>
              (2)	Regulatory Agency Concerned, and
              (3)   Public Notification
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