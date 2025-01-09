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
                            
                            <form action="{{route('own.prosecution.get.assign.official.case.prosecution.status.page.update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{@$data->id}}">
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Court</label>
                                  <select class="form-control" required name="judge_court" disabled id="judge_court">
                                      <option value="">Select</option>
                                      <option value="Trial" @if(@$data->judge_court=="Trial") selected @endif>Trial</option>
                                      <option value="Appellate" @if(@$data->judge_court=="Appellate") selected @endif>Appellate</option>
                                  </select>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Judgement</label>
                                  <select class="form-control" required name="judge_decision" disabled id="judge_decision">
                                      <option value="">Select</option>
                                      <option value="Yes" @if(@$data->judge_decision=="Yes") selected @endif>Yes</option>
                                      <option value="No" @if(@$data->judge_decision=="No") selected @endif>No</option>
                                  </select>
                                 </div>
                            

                                <div class="judge_yes" @if(@$data->judge_decision=="Yes") style="display:block" @else style="display:none" @endif>
                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Judgement Date</label>
                                  <input type="date" name="judge_date" class="form-control" disabled value="{{@$data->judge_date}}" id="judge_date">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Judgement No</label>
                                  <input type="text" name="judge_no" value="{{@$data->judge_no}}" disabled class="form-control" id="judge_no">
                                 </div>


                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Prosecuting Agency</label>
                                  <select class="form-control" disabled  name="judge_agency">
                                      <option value="">Select</option>
                                      <option value="OAG" @if(@$data->judge_agency=="OAG") selected @endif>OAG</option>
                                      <option value="ACC" @if(@$data->judge_agency=="ACC") selected @endif>ACC</option>
                                      <option value="Others" @if(@$data->judge_agency=="Others") selected @endif>Others</option>
                                  </select>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Judgement Remarks</label>
                                  <textarea class="form-control" disabled name="judge_remarks" id="judge_remarks">{{@$data->judge_remarks}}</textarea>
                                 </div>

                                 @if(@$data->judge_attachment!="")
                                  <div class="form-group">
                                    <a class="btn btn-xs btn-info" href="{{URL::to('attachment/legal_prosecution')}}/{{$data->judge_attachment}}" target="_blank">
                                       <i class="fa fa-eye"></i>Attachment </a>
                                 </div>
                                 @endif
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
    $('#judge_decision').on('change',function(){
        var judge_decision =  $('#judge_decision').val();
        if(judge_decision=="Yes"){
            $('.judge_yes').show();
        }else{
            $('.judge_yes').hide();
        }
    })
</script>


@endsection