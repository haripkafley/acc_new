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
                    <p><b>Complaint No:</b> {{@$data->legal_details->eve_offence_details->complaint_details->complaintRegNo}}</p>

                    <p><b>Complaint Title:</b> {{@$data->legal_details->eve_offence_details->complaint_details->complaintTitle}}</p>



                    <p><b>Date Time:</b> {{@$data->legal_details->eve_offence_details->complaint_details->complaintDateTime}}</p>

                    <p><b>Offence Name :</b> {{@$data->legal_details->eve_offence_details->allegation_name}}</p>
                    <p><b>Offence Description :</b> {{@$data->legal_details->eve_offence_details->allegation_description}}</p>

                    <p><b>IG NO :</b> {{@$data->legal_details->tacktical_details->si_ig_no}}</p>
                   

                    
               </div>
                   
            </div>

            <div class="col-sm-12">
                    <div class="card">
                        <p><b>Complaint Details:</b> {{@$data->legal_details->eve_offence_details->complaint_details->complaintDetails}}</p>
                    </div>
                </div>


                


</div>



</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   

        <script type="text/javascript">
        $('.edit_button').on('click',function(){
                $('#activity').val($(this).data('activity'));
                $('#person_contact').val($(this).data('person_contact'));
                $('#document_review').val($(this).data('document_review'));
                $('#start_date').val($(this).data('start_date'));
                $('#status').val($(this).data('status'));
                $('#id').val($(this).data('id'));
                $('#exampleModaEdit').modal('show');
            })
    </script>

    <script type="text/javascript">
        $('.edit_button2').on('click',function(){
                $('#activity_two').val($(this).data('activity'));
                $('#location').val($(this).data('location'));
                $('#start_date_two').val($(this).data('start_date'));
                $('#status_two').val($(this).data('status'));
                $('#id_two').val($(this).data('id'));
                $('#exampleModaEdit2').modal('show');
            })
    </script>

@endsection