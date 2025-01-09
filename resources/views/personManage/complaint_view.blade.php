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
        <li class="nav-item">
          <a class="nav-link active btn btn-info" href="{{route('manage.person.view.complaint',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('manage.person.view.complaint.attachment',['id'=>@$id])}}">Attachment Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('manage.person.view.complaint.person',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('manage.person.view.complaint.case-link',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>



        
            <div class="row">
              


                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Processing Type:</b> {{@$data->complaintProcessingTypeRelation->processingTypeName}}</p>

                    <p><b>Complaint TItle:</b> {{@$data->complaintTitle}}</p>

                    <p><b>Date Time:</b> {{@$data->complaintDateTime}}</p>

                    <p><b>Occurrence From:</b> {{@$data->occurrencePeriodFrom}}</p>

                    <p><b>Occurrence Till:</b> {{@$data->occurrencePeriodTill}}</p>

                    <p><b>Complaint Recived By:</b> 
                     @if(@$received_users->isNotEmpty())  
                     @foreach($received_users as $item)
                        {{ @$item->user_details->name }}
                        @if (!@$loop->last)
                        ,
                        @endif
                   @endforeach

                    @else No Users
                    @endif
                </p>

                <p><b>Complaint Mode:</b> {{@$data->complaintmoderelation->modeName}}</p>
               </div>
                   
            </div>


            <div class="col-sm-6">
                    <div class="card">
                    <p><b>Place Of Occurance in Dzongkhag:</b> {{@$data->dzongkhagrelation->dzoName}}</p>

                    <p><b>Place Of Occurance in Gewog:</b> {{@$data->gewogrelation->gewogName}}</p>

                    <p><b>Place Of Occurance in Village:</b> {{@$data->villagerelation->villageName}}</p>

                    <p><b>Occurrence From:</b> {{@$data->occurrencePeriodFrom}}</p>

                    <p><b>Occurrence Till:</b> {{@$data->occurrencePeriodTill}}</p>

                    
               </div>
                   
            </div>

             <div class="col-sm-6">
                    <div class="card">
                        <p><b>Complaint Details:</b> {!!@$data->complaintDetails!!}</p>
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
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

        });

    </script>


    <script type="text/javascript">
        $('#assign_to').on('change',function(){
            var id = $('#assign_to').val();

            if(id=="H"){
                $('#assignUsers_div').css('display','block');
                $('#regional_office_div').css('display','none');
            }else{
                $('#assignUsers_div').css('display','none');
                $('#regional_office_div').css('display','block');
            }
        });
    </script>



@endsection