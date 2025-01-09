
<body>
  <div class="container">
    <div class="card-container">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><img src="{{ asset('acc_images/acclogo.png' ) }}"   alt="ACC LOGO" style="height:135px;width:800px;"></h5>
          
          <p><b>Ref No :{}</b></p>
          <h2 style="text-align: center;"><b>Suspension Order </b></h2>
          <p class="custom-text">In exercise of the power conferred under 24(1) (g) of the Anti- Corruption Act of Bhutan 2011, the Commission hereby suspends the following business operations or activities with immediate effect upon finding a prima facie case of corruption.</p>
          <br>
        @foreach($suspensions as $susp)
          <p><b> Name of business entity: </b> {{ $susp->name}} </p>
          <p><b> License No: </b>              {{ $susp->identification_no}}</p>
          <p><b> Address: </b>                 {{ $susp->business_location}}</p>
          <p><b> Type of Activity:</b>         {{ $susp->business_activity}}</p>

          <br>
            <p class="custom-text"> Consequently, these individuals or business entities are prohibited from conducting any business, directly or indirectly, using the license hereinafter suspended till pending the outcome of the case. However, the entities/ individual is allowed to clear the existing stocks within one months from the date of issuance of this order. 
              <br>
              <br>
              <br>
              This prohibition order shall continue to have effect pending the outcome of the case unless otherwise revoked or rescind by the Commission. Non-compliance of the Commission’s lawful demand constitutes an offence under Section 113(1) (C) of the Anti-Corruption Act of Bhutan 2011.
              <br>
              <br>
              Issued under the seal and signature of the Commission on {{ \Carbon\Carbon::parse($susp->suspended_on)->format('d/m/Y')}}.
            </p>
            <br>
            <br>
            <br>
            @endforeach
            <br>
            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src="{{ asset('acc_images/Office_Seal.png' ) }}"   alt="ACC LOGO" style="height:135px;width:135px;">&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  (Chairperson)</p>
            <br>
            <br>
            
            <br>
            <p>
            Copied to in confidence:   
            <br>
              (1)	Business concerned<br>
              (2)	Regulatory agency concerned
              (3) Kuensel corporation and The Bhutanese for upcoming publication
              (4) Bhutan Broadcasting Service Corporation for broadcase in both Dzongkha and English
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

</script>