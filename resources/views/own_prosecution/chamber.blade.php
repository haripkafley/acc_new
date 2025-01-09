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

                           <div class="card-body">
                            
                            <table id="maintableGewog" class="table">
                                <thead>
                                    <tr>
                                        <th>CID</th>
                                        <th>Name</th>
                                        <th>Court Name</th>
                                        <th>Decision of the Court</th>
                                        <th>Decision Date</th>
                                        <th>Decision Attachment</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                        
                                            <tr>
                                                <td>{{ @$data->case_withdrawn_details->cid }}</td>
                                                <td>{{ @$data->case_withdrawn_details->accused_name}}</td>
                                                
                                                <td>
                                                    @if(@$data->court_name=="") Not Updated @else {{@$data->court_name}} @endif
                                                </td>
                                                
                                                <td>
                                                    @if(@$data->own_status=="") Not Updated @else {{@$data->own_status}} @endif
                                                </td>

                                                <td>
                                                    @if(@$data->status_date=="") Not Updated @else {{@$data->status_date}} @endif
                                                </td>

                                                <td>
                                                    @if(@$data->status_attachment=="") Not Updated @else
                                                    <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/legal_prosecution')}}/{{$data->status_attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                Attachment
                                                            </a>
                                                     @endif       
                                                </td>

                                                <td>
                                                    @if(@$data->status_remark=="") Not Updated @else {{@$data->status_remark}} @endif
                                                </td>
                                                
                                                

                                             </tr>


                                       
                                    

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