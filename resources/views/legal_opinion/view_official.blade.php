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
                    <p><b>Complaint No:</b> {{@$data->legal_opinion_details->eve_offence_details->complaint_details->complaintRegNo}}</p>

                    <p><b>Complaint Title:</b> {{@$data->legal_opinion_details->eve_offence_details->complaint_details->complaintTitle}}</p>



                    <p><b>Date Time:</b> {{@$data->legal_opinion_details->eve_offence_details->complaint_details->complaintDateTime}}</p>

                    <p><b>Offence Name :</b> {{@$data->legal_opinion_details->eve_offence_details->allegation_name}}</p>
                    <p><b>Offence Description :</b> {{@$data->legal_opinion_details->eve_offence_details->allegation_description}}</p>
                   

                    
               </div>
                   
            </div>

            <div class="col-sm-12">
                    <div class="card">
                        <p><b>Complaint Details:</b> {{@$data->legal_opinion_details->eve_offence_details->complaint_details->complaintDetails}}</p>
                    </div>
                </div>


                 <div class="col-sm-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Activity Details </div>

                        <div class = "card-body">
                            <button class="btn btn-primary" data-toggle="modal"
                            data-target="#exampleModa2">+ Add Data</button>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Activity Date</th>
                                        <th>Activity Name</th>
                                        <th>Activity Description</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$activities->isNotEmpty())
                                    @foreach(@$activities as $att)
                                    <tr>
                                        <td>{{ $att->activity_date }}</td>
                                        <td>{{ $att->activity_name }}</td>
                                        <td>{{ $att->activity_description }}</td>
                                       <td>
                                                            
                                                            <a class="btn btn-xs btn-success edit_button" 
                                                            data-id="{{$att->id}}"
                                                            data-activity_date="{{$att->activity_date}}"
                                                            data-activity_name="{{$att->activity_name}}"
                                                            data-activity_description="{{$att->activity_description}}"
                                                            ><i class="fa fa-edit"></i>
                                                                
                                                            </a>
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('legal.opinion.get.official.list.view.details.delete.activity',['id'=>@$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                            </a>
                                            </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Legal Opinion Report </div>

                        <div class = "card-body">
                            <form action="{{route('legal.opinion.get.official.list.view.details.delete.activity.update.legal.report')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="legal_id" value="{{@$legal_id}}">
                                <div class="form-group">
                                    <label>Report Attachment</label>
                                    <input type="file" name="legal_report_attachment" class="form-control">
                                </div>

                                @if(@$legal->legal_report_attachment!="")
                                <div class="form-group">
                                    <a href="{{URL::to('attachment/information_enrichment')}}/{{$legal->legal_report_attachment }}" class="btn btn-xs btn-primary" target="_blank">See Attachment</a>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label>Report Remarks</label>
                                    <textarea type="text" name="legal_report_remarks" class="form-control">{{@$legal->legal_report_remarks}}</textarea>
                                </div>

                                <div class="form-group"><button type="submit" class="btn btn-primary">Submit</button></div>
                            </form>
                        </div>
                    </div>
                </div>



            <div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('legal.opinion.get.official.list.view.details.insert.activity')}}">@csrf

                                <input type="hidden" name="legal_id" value="{{@$legal_id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Activity Date</label>
                                    <input type="date" class="form-control" id="exampleInputEmail1" name="activity_date" aria-describedby="emailHelp" placeholder="Activity">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Activity Title</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="activity_name" aria-describedby="emailHelp" placeholder="Activity Title">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Activity Description</label>
                                    <textarea type="text" class="form-control" id="exampleInputEmail1" name="activity_description" aria-describedby="emailHelp" placeholder="Activity Description"></textarea>
                                 </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>



                <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('legal.opinion.get.official.list.view.details.update.activity')}}">@csrf

                                <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Activity Date</label>
                                    <input type="date" class="form-control" id="activity_date" name="activity_date" aria-describedby="emailHelp" placeholder="Activity">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Activity Title</label>
                                    <input type="text" class="form-control" id="activity_name" name="activity_name" aria-describedby="emailHelp" placeholder="Activity Title">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Activity Description</label>
                                    <textarea type="text" class="form-control" id="activity_description" name="activity_description" aria-describedby="emailHelp" placeholder="Activity Description"></textarea>
                                 </div>


                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
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
                $('#activity_date').val($(this).data('activity_date'));
                $('#activity_name').val($(this).data('activity_name'));
                $('#activity_description').val($(this).data('activity_description'));
                $('#id').val($(this).data('id'));
                $('#exampleModaEdit').modal('show');
            })
    </script>

@endsection