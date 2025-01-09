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
                
                @include('tacktical.indi.navbar')

                <div class="row">
                    <div class="col-sm-12">
                    <div class="card">
                    {{-- <p><b>SL No:</b> {{@$data->ir_no}}</p> --}}
                    @if(@$data->type_ti=="S")
                    <p><b>SI NO:</b> {{@$data->si_ig_no}}</p>
                    @else
                    <p><b>IG NO:</b> {{@$data->si_ig_no}}</p>
                    @endif
                    <p><b>Request Type:</b> {{@$data->request_type_details->name}}</p>
                    <p><b>Reason:</b> {{@$data->reason}}</p>
                    <p><b>Suspect Details:</b> {{@$data->suspect_details}}</p>
                    <p><b>In Relation To:</b> {{@$data->relation_details->name}}</p>
                    <p><b>Requesting Officer:</b> {{@$data->officer_details->name}}</p>

                    <p><b>Request Date:</b> {{@$data->request_date}}</p>
                    <p><b>Start Date:</b> {{@$data->start_date}}</p>
                    <p><b>End Date:</b> {{@$data->end_date}}</p>
                    <p><b>Recommended By:</b> {{@$data->recommend_details->name}}</p>
                    <p><b>Recommended Date:</b> {{@$data->recommend_date}}</p>
                    <p><b>Recommended Remarks:</b> {{@$data->recommend_remarks}}</p>

                    <p><b>Commission Decision:</b> Approved</p>
                    <p><b>Commission Date:</b> {{@$data->com_date}}</p>
                    <p><b>Commission Remarks:</b> {{@$data->com_remarks}}</p>
                    
                    

                  </div>
                </div>
            </div>
    </div>


            

             

                

</section>




@endsection