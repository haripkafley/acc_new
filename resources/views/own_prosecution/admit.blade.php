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

        @include('own_prosecution.common_chief')



        
            <div class="row">
              
                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$data->case_withdrawn_details->case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$data->case_withdrawn_details->case_details->case_title}}</p>

                    <p><b>Instruction:</b> {{@$data->instruction}}</p>

                  </div>
            </div>




    {{-- table-showing --}}
    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Offences  
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Remarks</th>
                                            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$offences->isNotEmpty())
                                    @foreach(@$offences as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>




    </div>







         {{-- offence-count --}}
             <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Offences Count
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Count</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$offence_count->isNotEmpty())
                                    @foreach(@$offence_count as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->counts }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
        </div>





            {{-- sections --}}
                         <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Sections
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Section</th>
                                        <th>Remarks</th>
                                            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$sections->isNotEmpty())
                                    @foreach(@$sections as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->section }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
        </div>





            



            {{-- restitution --}}
                    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Restitution Prayed
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Restitution Prayed</th>
                                        <th>Remarks</th>
                                                 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$restitution->isNotEmpty())
                                    @foreach(@$restitution as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->restitution_prayed }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
        </div>



            




            {{-- recovery --}}
                    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Confiscation / Recovery Prayed
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Type</th>
                                        <th>Prayer</th>
                                        <th>Remarks</th>
                                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$recovery->isNotEmpty())
                                    @foreach(@$recovery as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->type }}</td>
                                        <td>{{ $att->prayer }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
        </div>



            



                        {{-- other-prayers --}}
                    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Other Prayed
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Prayer</th>
                                        <th>Remarks</th>
                                            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$other->isNotEmpty())
                                    @foreach(@$other as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->prayer }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        
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
</div>


            

             

                
         
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   



    <script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});


</script>


@endsection