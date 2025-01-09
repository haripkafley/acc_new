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
            
        <form method="post" id="agency_form" action="{{route('appraise.director.review.list.decision.update')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-12">
                    
                  <div class="form-group">
                    <label>Activity Type</label>
                    <select class="form-control" name="director_acitivity_type" required>
                        <option value="">Select</option>
                        <option value="Appraise Director"  @if(@$data->appraise_direcor_status!="IN")@if(@$data->director_acitivity_type=="Appraise Director") selected @endif @endif>Appraise Director</option>
                        <option value="Brief Agency" @if(@$data->appraise_direcor_status!="IN") @if(@$data->director_acitivity_type=="Brief Agency") selected @endif @endif>Brief Agency</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Activity Date</label>
                    <input type="date" name="director_acitivity_date" value="{{@$data->director_acitivity_date}}" required class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Activity Description</label>
                    <textarea class="form-control" required name="director_acitivity_description">{{@$data->director_acitivity_description}}</textarea>
                  </div> 

                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="director_acitivity_status" required>
                        <option value="Continue Review" @if(@$data->appraise_direcor_status!="IN")@if(@$data->director_acitivity_status=="Continue Review") selected @endif @endif>Continue Review</option>
                        <option value="Brief Agency" @if(@$data->appraise_direcor_status!="IN")@if(@$data->director_acitivity_status=="Brief Agency") selected @endif @endif>Brief Agency</option>
                    </select>
                  </div> 

                  <div class="form-group">
                    <label>Attachment</label>
                    <input type="file" name="director_attachment"  class="form-control">
                  </div>

                  @if(@$data->director_attachment!="")
                    <div class="form-group"> 
                        <a class="btn btn-xs btn-info"  href="{{URL::to('attachment/review_activity')}}/{{$data->director_attachment}}" target="_blank"> <i class="fa fa-eye"></i>
                                                                View
                            </a> </div>
                   @endif


                    
                <div class="col-sm-12"></div>
                @if(@$data->review_crud!="N")
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

   


@endsection