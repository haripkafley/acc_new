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

            
            @include('legal_judgement.common_appraisal')


        
            <div class="row">
              
                <div class="col-sm-6">

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


            <div class="col-sm-6">

                    <div class="card">
                        <form method="post" enctype="multipart/form-data" action="{{ route('get.assign.judgement.legal.appraisal.insert.decision') }}">@csrf
                                
                                
                                
                                <input type="hidden" name="id" value="{{@$data->id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Decision of the Commission</label>
                                    <select name="decision" required id="decision" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Close" @if(@$decision_data->decision=="Close") selected @endif>Close</option>
                                        <option value="Appeal" @if(@$decision_data->decision=="Appeal") selected @endif>Appeal</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Recommendation of LD</label>
                                    <textarea class="form-control" name="recommendation">{{@$decision_data->recommendation}}</textarea>
                                </div>



                                <div class="appeal_div" @if(@$decision_data->decision=="Close" || @$decision_data->decision=="") style="display:none;" @else style="display:block;" @endif>
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Court</label>
                                  <select class="form-control"  name="court" id="court">
                                      <option value="">Select Court</option>
                                      <option value="Bumthang Dzongkhag Court" @if(@$decision_data->court=="Bumthang Dzongkhag Court") selected @endif>Bumthang Dzongkhag Court</option>
                                      <option value="Chukha Dzongkhag Court" @if(@$decision_data->court=="Chukha Dzongkhag Court") selected @endif>Chukha Dzongkhag Court</option>
                                  </select>
                                 </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Registration Date</label>
                                    <input type="date" class="form-control" value="{{@$decision_data->registration_date}}" name="registration_date"> 
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Registration No</label>
                                    <input type="text" class="form-control" value="{{@$decision_data->registration_no}}" name="registration_no"> 
                                </div>


                                <div class="form-group">
                                  <label for="exampleInputEmail1">Attachment</label>
                                  <input type="file" class="form-control"  name="attachment" id="attachment">
                                 </div>

                                 @if(@$decision_data->attachment!="")
                                 <div class="form-group">
                                     <a class="btn btn-xs btn-info" href="{{URL::to('attachment/legal_appraise')}}/{{$decision_data->attachment}}" target="_blank"> <i class="fa fa-eye"></i>View Attachment</a>
                                 </div>
                                 @endif
                                 </div>




                                <button type="submit" class="btn btn-primary">Submit</button>
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
    $('#decision').on('change',function(e){
        var decision = $('#decision').val();
        if(decision=="Close"){
            $('.appeal_div').hide();
        }else{
            $('.appeal_div').show();
        }
    });
</script>


@endsection