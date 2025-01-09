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
              


                @include('appraise.details_component')


            

             

                
         <div class="col-sm-12">  
            
        <form method="post" id="appraise_form" action="{{route('appraise.comission.review.list.decision.update')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-12">
                    
                  <div class="form-group">
                    <label>Activity Type</label>
                    <select class="form-control" name="comission_activity_type" required>
                        <option value="Appraise Comission" @if(@$data->comission_activity_type=="Appraise Comission") selected @endif>Appraise Comission</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Meeting Date</label>
                    <input type="date" name="meeting_date" value="{{@$data->meeting_date}}" required class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="comission_status" id="comission_status" required>
                        <option value="">Select</option>
                        <option value="For Action" @if(@$data->comission_status=="For Action") selected @endif>For Action</option>
                        <option value="More Review" @if(@$data->comission_status=="More Review") selected @endif>More Review</option>
                        <option value="No Atr" @if(@$data->comission_status=="No ATR") selected @endif>No ATR</option>
                    </select>
                  </div>

                  

                  <div class="form-group">
                    <label>Remarks</label>
                    <textarea class="form-control" required name="comission_remarks">{{@$data->comission_remarks}}</textarea>
                  </div> 

                  

                  <div class="form-group">
                    <label>Attachment</label>
                    <input type="file" name="comission_attachment"  class="form-control">
                  </div>

                  @if(@$data->comission_attachment!="")
                    <div class="form-group"> 
                        <a class="btn btn-xs btn-info"  href="{{URL::to('attachment/review_activity')}}/{{$data->comission_attachment}}" target="_blank"> <i class="fa fa-eye"></i>
                                                                View
                            </a> </div>
                   @endif


                    
                <div class="col-sm-12"></div>
                {{-- <div class="col-sm-6"><button type="submit" class="btn btn-info">Submit</button></div> --}}
                @if(@$data->appraise_com_status=="IN")
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Submit</button></div>
                @elseif(@$data->appraise_com_status!="IN" && @$data->comission_status!="For Action")
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Submit</button></div>
                @endif
                <div class="col-sm-6"></div>

                


            </div>
        </form>

        
    </div>









                






               
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   

    <script type="text/javascript">
        $('input[type=radio][name=evaluation]').on('change', function() {
          var evaluation =  $(this).val();
           if(evaluation=="Y")
           {
             $('.describe').show();
           }else{
            $('.describe').hide();
           } 
        });
    </script>

    <script type="text/javascript">
        $('#appraise_form').on('submit',function(e){
            e.preventDefault();
            var com_status = $('#comission_status').val();
            if(com_status=="More Review")
            {
                var c = confirm('Are you sure you want more review.?');
                if(c==true)
                {
                    $('#appraise_form').submit();
                }else{
                    return false;
                }
            }else{
                $('#appraise_form').submit();
            }
        })
    </script>


@endsection