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
                    <p><b>Complaint No:</b> {{@$appraisal_details->eve_offence_details->complaint_details->complaintRegNo}}</p>

                    <p><b>Complaint Title:</b> {{@$appraisal_details->eve_offence_details->complaint_details->complaintTitle}}</p>



                    <p><b>Date Time:</b> {{@$appraisal_details->eve_offence_details->complaint_details->complaintDateTime}}</p>

                    <p><b>Offence Name :</b> {{@$appraisal_details->eve_offence_details->allegation_name}}</p>
                    <p><b>Offence Description :</b> {{@$appraisal_details->eve_offence_details->allegation_description}}</p>
                   

                    
               </div>
                   
            </div>

            <div class="col-sm-12">
                    <div class="card">
                        <p><b>Complaint Details:</b> {{@$appraisal_details->eve_offence_details->complaint_details->complaintDetails}}</p>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Desk Review </div>

                        <div class = "card-body">
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Start Date</th>
                                        <th>Activity</th>
                                        <th>Person to be contacted</th>
                                        <th>Documents</th>
                                        <th>Status</th>
                                        <th>End Date</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data_one->isNotEmpty())
                                    @foreach(@$data_one as $att)
                                    <tr>
                                        <td>{{ $att->start_date }}</td>
                                        <td>{{ $att->activity }}</td>
                                        <td>{{ $att->person_contact }}</td>
                                        <td>{{ $att->document_review }}</td>
                                        <td>@if(@$att->status=="IN") Initiated @elseif(@$att->status=="UP") UnderProcess @else Complete @endif</td>
                                        <td>{{ $att->end_date }}</td>
                                        <td>
                                                            
                                                            <a class="btn btn-xs btn-success edit_button" 
                                                            data-id="{{$att->id}}"
                                                            data-start_date="{{$att->start_date}}"
                                                            data-activity="{{$att->activity}}"
                                                            data-person_contact="{{$att->person_contact}}"
                                                            data-document_review="{{$att->document_review}}"
                                                            data-status="{{$att->status}}"
                                                            ><i class="fa fa-eye"></i>
                                                                
                                                            </a>
                                                            
                                                           <a class="btn btn-xs btn-warning mt-2" target="_blank" href="{{route('administrative.inquiry.plan.chief.list.view.details.desk.review.view.page.chief',['id'=>@$att->id])}}">Update Details
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
                    <div class="card-header" style="font-family:Product Sans">Field Visits </div>

                        <div class = "card-body">
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Field Visit Date</th>
                                        <th>Visit Location</th>
                                        <th>Activity Description</th>
                                        <th>Status</th>
                                        <th>End Date</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data_two->isNotEmpty())
                                    @foreach(@$data_two as $att)
                                    <tr>
                                        <td>{{ $att->start_date }}</td>
                                        <td>{{ $att->location }}</td>
                                        <td>{{ $att->activity }}</td>
                                        <td>@if(@$att->status=="IN") Initiated @elseif(@$att->status=="UP") UnderProcess @else Complete @endif</td>
                                        <td>{{ $att->end_date }}</td>
                                        <td>
                                                            
                                                            <a class="btn btn-xs btn-success edit_button2" 
                                                            data-id="{{$att->id}}"
                                                            data-start_date="{{$att->start_date}}"
                                                            data-activity="{{$att->activity}}"
                                                            data-location="{{$att->location}}"
                                                            data-status="{{$att->status}}"
                                                            ><i class="fa fa-eye"></i>
                                                                
                                                            </a>
                                                            
                                                           

                                                            <a class="btn btn-xs btn-warning mt-2" target="_blank" href="{{route('administrative.inquiry.plan.chief.list.view.details.feild.visit.view.page.chief',['id'=>@$att->id])}}">Update Details
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
                    <div class="card-header" style="font-family:Product Sans"> Administrative Inquiry Report </div>

                        <div class = "card-body">
                            <form action="{{route('administrative.inquiry.plan.chief.list.view.details.update.report.decision')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="appraise_id" value="{{@$appraise_id}}">
                                @if(@$appraisal_details->admin_report_attachment!="")
                                <div class="form-group">
                                    <a href="{{URL::to('attachment/information_enrichment')}}/{{$appraisal_details->admin_report_attachment}}" class="btn btn-xs btn-primary" target="_blank">See Attachment</a>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label>Report Remarks</label>
                                    <textarea type="text" name="admin_report_remarks" disabled class="form-control">{{@$appraisal_details->admin_report_remarks}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Report Approval Status</label>
                                    <select class="form-control" name="ie_report_status" disabled>
                                        <option value="AA" @if(@$appraisal_details->admin_approval_status_chief=="AA") selected @endif>Awaiting</option>
                                        <option value="A" @if(@$appraisal_details->admin_approval_status_chief=="A") selected @endif>Approve</option>
                                        <option value="R" @if(@$appraisal_details->admin_approval_status_chief=="R") selected @endif>Reject</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Chief Remarks</label>
                                    <textarea type="text" name="admin_approval_remarks_chief" disabled class="form-control">{{@$appraisal_details->admin_approval_remarks_chief}}</textarea>
                                </div>

                             </form>
                        </div>
                    </div>
                </div>



                












            {{-- add-ie-plan --}}
            
            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">View Desk Review</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('administrative.inquiry.plan.official.get.list.view.details.update.desk.review')}}">@csrf

                                <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Activity</label>
                                    <textarea type="text" class="form-control" id="activity" name="activity" aria-describedby="emailHelp" placeholder="Activity"disabled ></textarea>
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Person to be Contacted</label>
                                    <textarea type="text" class="form-control" id="person_contact" name="person_contact" aria-describedby="emailHelp" placeholder="Person to be Contacted"disabled ></textarea>
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Documents to be reviewed or collected</label>
                                    <textarea type="text" class="form-control" id="document_review" name="document_review" aria-describedby="emailHelp"disabled  placeholder="Documents to be reviewed or collected"></textarea>
                                 </div>


                                 

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" aria-describedby="emailHelp"disabled  placeholder="Requested By">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select class="form-control" disabled name="status" id="status">
                                        <option value="IN">Initiated</option>
                                        <option value="UP">Under Process</option>
                                        <option value="COM">Complete</option>
                                    </select>
                                 </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>



            
              



                <div class="modal fade" id="exampleModaEdit2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">View Field Visits</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('administrative.inquiry.plan.official.get.list.view.details.update.felid.visit')}}">@csrf

                                <input type="hidden" name="id" id="id_two">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Field Visit Date</label>
                                    <input type="date" class="form-control" id="start_date_two" name="start_date" aria-describedby="emailHelp" placeholder="Requested By" disabled>
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Visit Location</label>
                                    <textarea type="text" class="form-control" id="location" name="location" aria-describedby="emailHelp" placeholder="Visit Location" disabled></textarea>
                                 </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Activity Description</label>
                                    <textarea type="text" class="form-control" id="activity_two" name="activity" aria-describedby="emailHelp" placeholder="Activity" disabled></textarea>
                                 </div>

                                 
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select class="form-control" name="status" id="status_two" disabled>
                                        <option value="IN">Initiated</option>
                                        <option value="UP">Under Process</option>
                                        <option value="COM">Complete</option>
                                    </select>
                                 </div>
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

        $('.edit_button_person').on('click',function(){
                    $('#user_id_edit').val($(this).data('user_id')).attr("selected", "selected");
                    $('#eid_edit').val($(this).data('eid'));
                    $('#cid_edit').val($(this).data('cid'));
                    $('#name_committee_edit').val($(this).data('name'));
                    $('#department_edit').val($(this).data('department'));
                    $('#role_edit').val($(this).data('role')).attr("selected", "selected");
                    $('#remarks_edit').val($(this).data('remarks'));
                    $('#member_id').val($(this).data('id'));
                    $('#user_edit_edit').val($(this).data('user_id'));
                    $('#exampleModa3_edit').modal('show');
                    
                })
    </script>

    <script type="text/javascript">
                 $('#user_change_add_cec').on('change',function(){
                    $('#eid').val($("#user_change_add_cec option:selected").attr('data-eid'));
                    $('#cid').val($("#user_change_add_cec option:selected").attr('data-cid'));
                    $('#department').val($("#user_change_add_cec option:selected").attr('data-department'));
                 })
             </script>

@endsection