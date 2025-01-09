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

            



        
            <div class="row">
              
                <div class="col-sm-12">

                    <div class="card">
                    <p><a href="{{route('get.assign.judgement.legal.list')}}" class="btn btn-primary" style="float:right">Back</a></p>
                    <p><b>Case Name:</b> {{@$data->case_withdrawn_details->case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$data->case_withdrawn_details->case_details->case_title}}</p>

                    <p><b>Instruction:</b> {{@$data->instruction}}</p>

                    <p><b>Name of Accused:</b> {{@$data->case_withdrawn_details->accused_name}}</p>
                    <p><b>CID:</b> {{@$data->case_withdrawn_details->cid}}</p>
                    <p><b>Judgment Date:</b> {{@$data->judge_date}}</p>
                    <p><b>Judgment No:</b> {{@$data->judge_no}}</p>
                    <p><b>Court:</b> {{@$data->court_name}} ({{@$data->judge_court}})</p>
                    <p><b>Prosecuting Agency:</b> {{@$data->judge_agency}}</p>
                    <p><b>Judgement Remarks:</b> {{@$data->judge_remarks}}</p>
                    @if(@$data->judge_attachment!="")
                    <p><b>Judgment File:</b> <a class="btn btn-xs btn-info" href="{{URL::to('attachment/legal_prosecution')}}/{{$data->judge_attachment}}" target="_blank">
                                       <i class="fa fa-eye"></i>Attachment </a>
                    </p>
                    @endif
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