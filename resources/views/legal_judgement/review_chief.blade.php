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

            
            @include('legal_judgement.common')


        
            <div class="row">
              
                <div class="col-sm-6">

                    <div class="card">
                    <p><a href="{{route('judgement.chief.list')}}" class="btn btn-primary" style="float:right">Back</a></p>
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


            <div class="col-sm-6">

                    <div class="card">

                        <form method="post" action="{{route('get.assign.judgement.legal.review.legal.update.judgement')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{@$data->id}}">
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Judgment</label>
                                    <select name="review_judgement" disabled id="review_judgement" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Convicted" @if(@$data->review_judgement=="Convicted") selected @endif>Convicted</option>
                                        <option value="Acquitted" @if(@$data->review_judgement=="Acquitted") selected @endif>Acquitted</option>
                                        <option value="Defferred" @if(@$data->review_judgement=="Defferred") selected @endif>Defferred</option>
                                     </select>
                            </div>

                            <div class="form-group" id="review_div" @if(@$data->review_judgement=="Convicted" || @$data->review_judgement=="") style="display:none" @else style="display:block" @endif>
                                <label for="exampleInputEmail1">Reason</label>
                                <textarea class="form-control" disabled style="height:250px;" name="review_reason_def_acq">{{@$data->review_reason_def_acq}}</textarea>
                            </div>   

                            
                        </form>



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

<script type="text/javascript">
    $('#review_judgement').on('change',function(e){
        var review = $('#review_judgement').val();
        if(review!="Convicted")
        {
            $('#review_div').show();
        }else{
            $('#review_div').hide();
        }
    });
</script>


@endsection