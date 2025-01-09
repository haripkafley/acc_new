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
                    <p><b>EID:</b> {{@$data->eid}}</p>
                    <p><b>Name:</b> {{@$data->user_details->name}}</p>
                    <p><b>Department:</b> {{@$data->user_details->department_name->name}}</p>
                    <p><b>Role:</b> @if(@$data->role=="MS") Member Secretary @elseif(@$data->role=="CP") Chair Person @else Member  @endif</p>
                    <p><b>Remarks:</b> {{@$data->remarks}} </p>
                    <p><b>Availability:</b> @if(@$data->availability=="AA") Awaiting Approval @elseif(@$data->availability=="Y") Available @else Not Available  @endif</p>

                    <p><b>COI Status:</b> @if(@$data->coi_status=="AA") Awaiting Approval @elseif(@$data->availability=="Y") Yes @else No  @endif</p>

                    
                   <p><b>Outcome:</b> {{@$data->outcome_status}}</p> 
                   <p><b>Outcome Remarks:</b> {{@$data->final_remark}} </p>

                   @if(@$data->attachment!="")
                   <p><b>Attachment:</b> <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/cec')}}/{{$data->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> </p>
                   @endif

                   

                    
               </div>
                   
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