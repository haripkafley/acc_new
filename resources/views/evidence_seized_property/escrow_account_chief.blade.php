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

                    <p><b>Registration Date:</b> {{@$case_details->creation_date}}</p>

                  </div>
            </div>
              
                    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              ESCROW Account  
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>CID</th>
                                        <th>Amount</th>
                                        <th>Source</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$bailbound->isNotEmpty())
                                    @foreach(@$bailbound as $att)
                                    <tr>
                                        
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->total_amount }}</td>
                                        <td>{{ $att->source }}</td>
                                        
                                        
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


@endsection