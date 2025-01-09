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
                        <img src="{{ asset('dist/img/accnew.gif') }}" class="img-fluid" alt="Responsive image" srcset=""
                            width="100%">
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="" method="">
                                @csrf
                                @foreach ($Searchconsentdetail as $data)
                                <div class="form-body container">
                                    <div>
                                        <div style="float:left">
                                            <label><b>{{ $data->case_no }}</b></label>
                                        </div>
                                        <div style="float:right">
                                            <label><b>Date: <span id="dateID"></span></b></label>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p style="text-align: justify;">I,
                                                _______________________________________________________,
                                                in accordance with section 179 of the Civil and Criminal Procedure Code
                                                of Bhutan 2001,
                                                hereby authorize the Investigation Officer _____________________________
                                                and his/her team members
                                                of the Anti-Corruption Commission to search work areas/room/apartment of
                                                my ________________________________,
                                                Mr./Ms.___________________________ for items related to him/her at the
                                                premises located at _________________________________.
                                                These Investigation Officers are authorized by me as per section 180 &
                                                181 to take from him/her any letters, papers, materials or other
                                                property which may be of evidentiary value to the case being
                                                investigated. I understand that this evidence may be used against
                                                my ___________________________________in
                                                a court of law or other proceedings.
                                            </p>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p style="text-align: justify;">This written permission is being given by
                                                the undersigned voluntarily and without threats,
                                                duress or promises of any kind. I understand that I or my
                                                _______________________________________ may ask for and receive
                                                a receipt for all things taken.
                                            </p>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>

                                    <div >
                                      <p>Name and Signature(with Legal Stamp):  <b>{{ $data->consent_name }}</b></p>
                                    </div>

                                    

                                    <div>
                                      <p>Agency/Organization/Others:  <b>{{ $data->consent_agency }}</b></p>
                                    </div>

                                   

                                    <div>
                                      <lpbel>CID No:  <b>{{ $data->consent_cid }}</b></p>
                                    </div>

                                    <br>
                                    <br>
                                   

                                    <div >
                                      <p>Name & Signature of Witness: <b>{{ $data->witness_name }}</b></p>
                                    </div>

                                    

                                    <div>
                                      <p>CID No: <b>{{ $data->witness_cid }}</b></p>
                                    </div>

                                  

                                    <div>
                                      <p>Contact No: <b>{{ $data->witness_contactno }}</b></p>
                                    </div>
                                </div>
                                @endforeach
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <button type="button" class="btn btn-info me-1 mb-1" onclick="return printPage();">Print</button>
                    {{-- <a href="mailto:jigmenamgyal@itechnologies.bt?subject=Test Subject!&body=Summon Order"
                        class="btn btn-info me-1 mb-1 text-white">Send Mail</a> --}}
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
