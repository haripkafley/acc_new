@extends('layouts.admin')

@section('content')
<style>
  .coi_show {
    display : none;
  }

  .coi_hide {
    display : none;
  }
</style>

<br>

<div class="main-content container-fluid">
<section id="itemPrint">
  <div class="row match-height">
      <div class="col-md-12 col-12">
      <div class="card" id="dvPrintp">
          <div class="card-header bg-white">
              <img src="{{ asset('dist/img/accnew.gif') }}" class="img-fluid" alt="Responsive image" srcset="" width="100%">
          </div>
          <div class="card-content">
          <div class="card-body">

            <form class="form form-horizontal" action="" method="">
              @csrf
              @foreach ($searchwarrantapplications as $data)
              <div class="form-body container">
                  <div>
                      <div style="float:left">
                          <label><b>{{ $data->case_no }}</b></label>
                      </div>
                      <div style="float:right">
                          <label ><b>Date: <span id="dateID"></span></b></label>
                      </div>
                  </div>
                  <br>

                  <div>
                      <div style="text-align: center;">
                          <label><h5><b>IN THE HON’BLE {{ $data->court_type }},</b></h5></label>
                      </div>
                      <div style="text-align: center;">
                        <label><h5><b>ROYAL COURT OF JUSTICE, {{ $data->court_type }}</b></h5></label>
                    </div>
                  </div>
                 <br>

                  <div class="row">
                    <div class="col-md-12 d-flex justify-content-start">
                      <p><b>Hon’ble Chief Judge</b></p>
                    </div>
                    <div class="col-md-12 d-flex justify-content-start">
                      <p><b>Sub: Application for Arrest Warrant</b></p>
                    </div>
                  </div>

                  <div class="row">
                      <div class="col-md-12">
                          <p class="text-justify">The undersigned hereby applies for a warrant for the arrest of the accused named below on the basis of the facts
                          set forth hereunder.
                          </p>
                      </div>
                  </div>
                 

                  <div>
                    {{-- <div class="col-md-12"> --}}
                        <table style="border: 1px solid;" with="100%">
                          <thead style="border: 1px solid;">
                            <tr>
                              <th style="border: 1px solid;">Case Number</th>
                              <th style="border: 1px solid;">Suspect Name</th>
                              <th style="border: 1px solid;">Suspect CID</th>
                              <th style="border: 1px solid;">Suspect Address</th>
                            </tr>
                          </thead>
            
                          <tbody>
                            {{-- @foreach ( $searchwarrantapplications as $data ) --}}
                            <tr>
                                <td style="border: 1px solid;">{{ $data->case_no }}</td>
                                <td style="border: 1px solid;">{{ $data->suspect }}</td>
                                <td style="border: 1px solid;">{{ $data->cid }}</td>
                                <td style="border: 1px solid;">{{ $data->location }}</td>
                            </tr>
                            {{-- @endforeach --}}
                          </tbody>
                        </table>
                    {{-- </div>   --}}
                  </div>
                  <br>

                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-justify">The Anti-Corruption Commission, in relation to its investigation into the alleged/suspected corrupt practices in the
                        <b>{{ $data->case_brief }}</b>
                      </p>
                  </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-justify">1. has reasonable grounds to believe that the suspect is in possession of a document, material or other thing which is
                        relevant is likely to be relevant to the investigation; and
                      </p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-justify">2. the Commission has reasonable cause to believe that there is on the suspect’s permises document, material or other
                        thing which is or contains evidence of the commission of an offence under the Anti-Corruption Act of Bhutan 2011.
                      </p>
                    </div>
                  </div>

                  <div class="row">
                      <div class="col-md-12">
                          <p class="text-justify">
                            Wherefore, this Hon’ble Court is pleased to issue an search warrant to the Anticorruption Commission as prayed for
                            under section 168 of the Civil and Criminal Procedure Code of Bhutan 2001 read with section 95 of the Anti-
                            Corruption Act of Bhutan 2011
                          </p>
                      </div>
                  </div>
                  <br>
                  <br>
                  <br>
                  <br><br>
                  <br>

                  <div class="row">
                      <div class="col-md-9 d-flex justify-content-end">
                          <label><b>Signature with Legal Stamp</b></label>
                      </div>
                  </div>
                  <br>
                  <br>
                  <br>
                 
                  <div class="row">
                    <div class="col-md-9 d-flex justify-content-end">
                        <label><b>Name & Designation</b></label>
                    </div>
                </div>
                  
              </div>

              {{-- <div class="col-sm-12 d-flex justify-content-start">
                  <button type="button" class="btn btn-warning me-1 mb-1" onclick="return printPage();">Print</button>
                  <button type="cancel" class="btn btn-light-secondary me-1 mb-1 border-dark">Cancel</button>
              </div> --}}
              @endforeach
            </form>

          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
          <button type="button" class="btn btn-info me-1 mb-1" onclick="return printPage();">Print</button>
          <a href="mailto:jigmenamgyal@itechnologies.bt?subject=Test Subject!&body=Summon Order" 
            class="btn btn-info me-1 mb-1 text-white">Send Mail</a>
      </div>
    </div>
      
  </div>
</section>
</div>




<script>

function printPage() {
        var dataToPrint = document.getElementById("dvPrintp");
        var a = document.write(dataToPrint.innerHTML);
        window.print(a);
    }

  // function printPage() {
  //       var dataToPrint = document.getElementById("dvPrintp");
  //       newWin = window.open("");
  //       newWin.document.write(dataToPrint.outerHTML);
  //       newWin.print();
  //       newWin.close();
  // }

    $(document).ready(function(){
    $("#open").click(function(){
    $(".coi_show").animate({height: "toggle"}, 500);
    $(".coi_hide").hide();
  });
  $("#close").click(function(){
    $(".coi_show").hide();

  });
});

var today = new Date();
    var date = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
    $('#dateID').html(date);
</script>

@endsection
