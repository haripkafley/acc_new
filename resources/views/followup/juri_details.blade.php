@extends('layouts.admin')

@section('content')
    <style type="text/css">
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
        .tox .tox-notification--warn, .tox .tox-notification--warning {
            display: none;
        }
            
        .card{
            padding: 25px;
        }

            </style>
<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
       
      </ul>



        
            <div class="row">
              


                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Jurisdiction Name:</b> {{@$details->jurisdiction}}</p>
                    <p><b>Date Of Registration:</b> {{@$details->date_registration}}</p>
                    </div>
            </div>


            

             

                
         <div class="col-sm-12">  
            <div class="card">
            <table id = "maintableEvalDec" class="table" >
                <h5 style="color:red">Probable Charge</h5>
                                <thead>
                                    <tr>
                                        
                                        <th>Probable Charge</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$probable_charge->isNotEmpty())
                                    
                                    @foreach(@$probable_charge as $key=> $att)
                                    <tr>
                                       
                                        <td>{{ @$att->probable_charge}}</td>
                                     </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>


                            <table id = "maintableEvalDec" class="table" >
                            <h5 style="color:red">Restitution Prayed</h5>
                                <thead>
                                    <tr>
                                        
                                        <th>Probable Charge</th>
                                        <th>Restitution Prayed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$restitution_prayed->isNotEmpty())
                                    
                                    @foreach(@$restitution_prayed as $key=> $att)
                                    <tr>
                                       
                                        <td>{{ @$att->probable_charge_details->probable_charge}}</td>
                                        <td>{{ @$att->restitution_prayed}}</td>
                                     </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>

                            <table id = "maintableEvalDec" class="table" >
                            <h5 style="color:red">Confiscation / Recovery prayed</h5>
                                <thead>
                                    <tr>
                                        
                                        <th>Probable Charge</th>
                                        <th>Confiscation/Recovery  Prayed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$confiscation_prayed->isNotEmpty())
                                    
                                    @foreach(@$confiscation_prayed as $key=> $att)
                                    <tr>
                                       
                                        <td>{{ @$att->probable_charge_details->probable_charge}}</td>
                                        <td>{{ @$att->confiscation_prayed}}</td>
                                     </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>

                            <table id = "maintableEvalDec" class="table" >
                            <h5 style="color:red">Other Prayed</h5>
                                <thead>
                                    <tr>
                                        
                                        <th>Probable Charge</th>
                                        <th>Other Prayed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$other_prayed->isNotEmpty())
                                    
                                    @foreach(@$other_prayed as $key=> $att)
                                    <tr>
                                       
                                        <td>{{ @$att->probable_charge_details->probable_charge}}</td>
                                        <td>{{ @$att->other_prayers}}</td>
                                     </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>

         </div>
     </div>









                






               
    </div>



</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>  


@endsection