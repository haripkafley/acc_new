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
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>
                    <p><b>Name Of Accused:</b> {{@$user_details->name}}</p>
                    @if(@$status!="")
                        <p><b>Status:</b> {{@$status->status}}</p>
                        <p><b>Remarks:</b> {{@$status->remarks}}</p>
                    @endif
                  </div>
            </div>


            

             

                
         <div class="col-sm-12">  
            <div class="card">
            <table id = "maintableEvalDec" class="table" >
                <h5 style="color:red">Probable Charge</h5>
                                <thead>
                                    <tr>
                                        
                                        <th>Administrative Sanction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$probable_charge->isNotEmpty())
                                    
                                    @foreach(@$probable_charge as $key=> $att)
                                    <tr>
                                       
                                        <td>{{ @$att->sanction}}</td>
                                     </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>


                            <table id = "maintableEvalDec" class="table" >
                            <h5 style="color:red">Fines and Penalties</h5>
                                <thead>
                                    <tr>
                                        
                                        <th>Fines and Penalties</th>
                                      </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$fines->isNotEmpty())
                                    
                                    @foreach(@$fines as $key=> $att)
                                    <tr>
                                       
                                        <td>{{ @$att->fines}}</td>
                                     </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>

                            <table id = "maintableEvalDec" class="table" >
                            <h5 style="color:red">Agency Referred</h5>
                                <thead>
                                    <tr>
                                        
                                        <th>Ministry / Organization</th>
                                        <th>Department / Division</th>
                                        <th>Division</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$confiscation_prayed->isNotEmpty())
                                    
                                    @foreach(@$confiscation_prayed as $key=> $att)
                                    <tr>
                                       
                                        <td>{{ @$att->organization}}</td>
                                        <td>{{ @$att->department}}</td>
                                        <td>{{ @$att->division}}</td>
                                        <td>{{ @$att->remarks}}</td>
                                     </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>

                            <table id = "maintableEvalDec" class="table" >
                            <h5 style="color:red">Reference Letter</h5>
                                <thead>
                                    <tr>
                                        
                                        <th>Reference Letter</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$other_prayed->isNotEmpty())
                                    
                                    @foreach(@$other_prayed as $key=> $att)
                                    <tr>
                                       
                                        <td>{{ @$att->description}}</td>
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