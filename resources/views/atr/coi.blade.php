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
                    <p><b>Complaint No:</b> {{@$complaint->complaintRegNo}}</p>

                    <p><b>Complaint TItle:</b> {{@$complaint->complaintTitle}}</p>

                    <p><b>Complaint Date Time:</b> {{@$complaint->complaintDateTime}}</p>
                    <p><b>Offence Name:</b> {{@$offence_details->offence_name->offence_type}}</p>

                </div>
                   
            </div>


            <div class="col-sm-6">
                    <div class="card">
                    <p><b>Action Letter No:</b> {{@$action_details->letter_no}}</p>

                    <p><b>Action Letter Date:</b> {{@$action_details->letter_date}}</p>

                    <p><b>Action Brief:</b> {{@$action_details->description_action}}</p>

                </div>
                   
            </div>

            <div class="col-sm-12">
                    <div class="card">
                    <p><b>ATR Letter No:</b> {{@$data->letter_no}}</p>

                    <p><b>ATR Letter Date:</b> {{@$data->letter_date}}</p>

                  </div>
                   
            </div>


            

             

                
         <div class="col-sm-12">  
            
        <form method="post" action="{{route('action.review.assign.committee.list.coi.details.update.decision')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{@$id}}">
            <input type="hidden" name="type" value="{{@$type}}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Do you have conflict of interests with the above complaint?<span style="font-weight: bold; color: red;">*</span></label>
                        <br>
                            <div class="form-check form-check-inline">
                              
                              <input class="form-check-input" type="radio" id="evaluation" name="evaluation" checked value="Y">
                              <label class="form-check-label" for="genderInput">Yes</label>
                              
                            </div>

                            <div class="form-check form-check-inline">
                              
                              <input class="form-check-input" type="radio" id="evaluation" name="evaluation" value="N">
                              <label class="form-check-label" for="genderInput">No</label>
                              
                            </div>
                    </div>
                </div>


                


               



                <div class="clearfix"> </div>
                <div class="col-sm-12 describe">
                    <div class="form-group">
                        <label>Describe nature of conflict of interest<span style="font-weight: bold; color: red;">*</span></label>
                            <textarea class="form-control"   type="text" name="describe"> </textarea>
                    </div>
                </div>

                
                <div class="col-sm-12"></div>
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Submit</button> <a type="{{route('action.review.assign.committee.list')}}" class="btn btn-danger">Cancel</a></div>
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