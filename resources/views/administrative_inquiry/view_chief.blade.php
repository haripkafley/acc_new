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
                                    <select class="form-control" name="admin_approval_status_chief">
                                        <option value="AA" @if(@$appraisal_details->admin_approval_status_chief=="AA") selected @endif>Awaiting</option>
                                        <option value="A" @if(@$appraisal_details->admin_approval_status_chief=="A") selected @endif>Approve</option>
                                        <option value="R" @if(@$appraisal_details->admin_approval_status_chief=="R") selected @endif>Reject</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Chief Remarks</label>
                                    <textarea type="text" name="admin_approval_remarks_chief"  class="form-control">{{@$appraisal_details->admin_approval_remarks_chief}}</textarea>
                                </div>

                                <div class="form-group"><button type="submit" class="btn btn-primary">Submit</button></div>
                            </form>
                        </div>
                    </div>
                </div>



                {{-- cec-member-add --}}
                <div class="col-sm-12">
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Administrative Inquiry Committee
                                </div>

                               
                                <div class="col-sm">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa3" style="float: right;">
                                        + Add Member
                                    </button>
                                 </div>
                            </div>
                    <div class="card-body" >
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}


                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        
                                        <th>EID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>COI Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$members->isNotEmpty())
                                        @foreach (@$members as $att)
                                            <tr>
                                                <td>{{ @$att->eid }}</td>
                                                <td>{{ @$att->user_details->name }}</td>
                                                <td>{{ @$att->user_details->department_name->name }}</td>
                                                <td>@if(@$att->role=="MS") Member Secretary @elseif(@$att->role=="CP") Chair Person @else Member  @endif</td>

                                                <td>@if(@$att->coi_status=="AA") Awaiting Approval @elseif(@$att->coi_status=="Y") Yes @else No  @endif</td>

                                                
                                                
                                                <td>
                                                    
                                                    @if(@$att->coi_status!="N")        
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button_person row-class-{{ @$att->id }}"
                                                        data-row-data='{{ @$att->dzoName }}' data-id="{{@$att->id}}" data-eid="{{@$att->user_details->eid}}" data-name="{{@$att->user_details->name}}"
                                                         data-user_id="{{@$att->user_details->id}}" 
                                                        data-cid="{{@$att->user_details->cid}}"
                                                        data-department="{{@$att->user_details->department_name->name}}"
                                                        data-role = "{{@$att->role}}"
                                                        data-remarks = "{{@$att->remarks}}"
                                                        data-toggle="modal"
                                                        >
                                                        Edit
                                                    </a>
                                                   

                                                   
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{route('administrative.inquiry.plan.chief.list.view.details.chief.delete.inquiry.member',@$att->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    @endif

                                                    {{-- <a href="{{route('member.details.on.cases.action-senstization',@$att->id)}}" class="btn btn-xs btn-warning" target="_blank">View More</a> --}}

                                                    
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                @if(@$member_no_coi>0)
                        <div class="col-sm-12">
                        <div class="card">
                            <form action="{{route('administrative.inquiry.plan.chief.list.view.details.update.inquiry.meeting.decision')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="appraise_id" value="{{@$appraise_id}}">
                                <div class="row">
                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Date</label>
                                    <input type="date" value="{{@$appraisal_details->inquiry_meeting_date}}"  name="inquiry_meeting_date" id="inquiry_meeting_date" class="form-control" required>
                                </div>
                              </div>

                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Time</label>
                                    <input type="time" name="inquiry_meeting_time" value="{{@$appraisal_details->inquiry_meeting_time}}"  id="inquiry_meeting_time" class="form-control" required >
                                </div>
                                </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="inquiry_meeting_venue" value="{{@$appraisal_details->inquiry_meeting_venue}}"  id="inquiry_meeting_venue" class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Recommendation Status</label>
                                    <select class="form-control" name="inquiry_decision">
                                        <option value="">Select</option>
                                        <option value="ADS" @if(@$appraisal_details->inquiry_decision=="ADS") selected @endif>Administration Disciplinery Sanction</option>
                                        <option value="MF" @if(@$appraisal_details->inquiry_decision=="MF") selected @endif>Monetary Fine</option>
                                        <option value="REC" @if(@$appraisal_details->inquiry_decision=="REC") selected @endif>Recoveries</option>
                                        <option value="SC" @if(@$appraisal_details->inquiry_decision=="SC") selected @endif>Systemic Correction</option>
                                        <option value="CI" @if(@$appraisal_details->inquiry_decision=="CI") selected @endif>Criminal Investigation</option>
                                        <option value="SEN" @if(@$appraisal_details->inquiry_decision=="SEN") selected @endif>Sensitive</option>
                                        <option value="REV" @if(@$appraisal_details->inquiry_decision=="REV") selected @endif>Revert</option>
                                        <option value="CLOSE" @if(@$appraisal_details->inquiry_decision=="CLOSE") selected @endif>Close</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea type="text" name="inquiry_remakrs" id="cec_venue" class="form-control" >{{@$appraisal_details->inquiry_remakrs}}</textarea>
                                </div>
                               
                                <div class="form-group"><button type="submit" class="btn btn-primary">Save Decision</button></div>
                               


                                </form>
                                </div> 
                                </div>  

                                @endif



                                                        
                <div class="col-sm-12">
                    <div class="card">
                        <div class="col-sm">
                                                Commission Member List
                                            </div>

                        <div class="card-body">
                           <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa4" style="float: right;">
                                        + Add Member
                                    </button>
                                   
                                </div>


                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        
                                        <th>EID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Availability</th>
                                        <th>COI Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$com_members->isNotEmpty())
                                        @foreach (@$com_members as $att)
                                            <tr>
                                                <td>{{ @$att->eid }}</td>
                                                <td>{{ @$att->user_details->name }}</td>
                                                <td>{{ @$att->user_details->department_name->name }}</td>
                                                <td>@if(@$att->role=="MS") Member Secretary @elseif(@$att->role=="CP") Chair Person @else Member  @endif</td>

                                                <td>@if(@$att->availability=="AA") Awaiting Approval @elseif(@$att->availability=="Y") Available @else Not Available  @endif</td>


                                                <td>@if(@$att->coi_status=="AA") Awaiting Approval @elseif(@$att->coi_status=="Y") Yes @else No  @endif</td>

                                                
                                                
                                                <td>
                                                    
                                                   @if(@$att->coi_status!="N")         
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button_person row-class-{{ @$att->id }}"
                                                        data-row-data='{{ @$att->dzoName }}' data-id="{{@$att->id}}" data-eid="{{@$att->user_details->eid}}" data-name="{{@$att->user_details->name}}"
                                                         data-user_id="{{@$att->user_details->id}}" 
                                                        data-cid="{{@$att->user_details->cid}}"
                                                        data-department="{{@$att->user_details->department_name->name}}"
                                                        data-role = "{{@$att->role}}"
                                                        data-remarks = "{{@$att->remarks}}"
                                                        data-toggle="modal"
                                                        >
                                                        Edit
                                                    </a>
                                                   

                                                   
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{route('administrative.inquiry.plan.chief.list.view.details.chief.delete.inquiry.member',@$att->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    @endif


                                                     {{-- <a href="{{route('member.details.on.cases.action-senstization',@$att->id)}}" class="btn btn-xs btn-warning" target="_blank">View More</a> --}}
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            


                        <div class="col-sm-12">
            <div class="card" style="padding:25px;">
                        <form action="{{route('administrative.inquiry.plan.chief.list.view.details.update.commission.meeting.decision')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="appraise_id" value="{{@$appraise_id}}">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commission Date</label>
                                    <input type="date" value="{{@$appraisal_details->inquiry_com_date}}"  name="inquiry_com_date" id="inquiry_com_date" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commission Time</label>
                                    <input type="time" name="inquiry_com_time" value="{{@$appraisal_details->inquiry_com_time}}"  id="inquiry_com_time" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="inquiry_com_venue" value="{{@$appraisal_details->inquiry_com_venue}}"  id="inquiry_com_venue" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="label">Commission Decision</label>
                                    <select class="form-control" name="inquiry_com_status" id="com_final_decision"  required>
                                        <option value="">Select</option>
                                        <option value="ECD" @if(@$appraisal_details->inquiry_com_status=="ECD") selected @endif>Endorse CEC Decision</option>
                                        <option value="ND" @if(@$appraisal_details->inquiry_com_status=="ND") selected @endif>New Decision</option>
                                    </select>
                                </div>


                                <div class="new_decision_div" @if(@$appraisal_details->inquiry_com_status=="ND") style="display:block;" @else  style="display:none;" @endif>


                                <div class="form-group">
                                    <label for="label">Decision</label>
                                    <select class="form-control" name="inquiry_com_decision" id="outcome_status" >
                                        <option value="ADS" @if(@$appraisal_details->inquiry_com_decision=="ADS") selected @endif>Administration Disciplinery Sanction</option>
                                        <option value="MF" @if(@$appraisal_details->inquiry_com_decision=="MF") selected @endif>Monetary Fine</option>
                                        <option value="REC" @if(@$appraisal_details->inquiry_com_decision=="REC") selected @endif>Recoveries</option>
                                        <option value="SC" @if(@$appraisal_details->inquiry_com_decision=="SC") selected @endif>Systemic Correction</option>
                                        <option value="CI" @if(@$appraisal_details->inquiry_com_decision=="CI") selected @endif>Criminal Investigation</option>
                                        <option value="SEN" @if(@$appraisal_details->inquiry_com_decision=="SEN") selected @endif>Sensitive</option>
                                        <option value="REV" @if(@$appraisal_details->inquiry_com_decision=="REV") selected @endif>Revert</option>
                                        <option value="CLOSE" @if(@$appraisal_details->inquiry_com_decision=="CLOSE") selected @endif>Close</option>
                                        
                                    </select>
                                </div> 
                            </div>


                               


                                <div class="form-group">
                                    <label for="label">Remarks</label>
                                    <textarea type="text" name="inquiry_com_remarks" class="form-control"  > {{@$appraisal_details->inquiry_com_remarks}}</textarea>
                                </div>

                                <div class="form-group"><button class="btn btn-primary" type="submit">Update Commission Decision</button></div>


                             </form>
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


            <div class="modal fade" id="exampleModa3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Add  Member</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('administrative.inquiry.plan.chief.list.view.details.chief.insert.inquiry.member') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="appraise_id" value="{{@$appraise_id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Users</label>
                                    <select class="form-control" name="user_id" id="user_change_add_cec" required>
                                        <option value="">Select User</option>
                                        @foreach(@$committee_dropdown as $value)
                                        <option value="{{@$value->id}}" data-eid="{{@$value->eid}}" data-cid="{{@$value->cid}}" data-department="{{@$value->department_name->name}}">{{@$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden" name="type" value="admin">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CID</label>
                                    <input type="text" name="cid" id="cid" class="form-control" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">EID</label>
                                    <input type="text" name="name" id="eid" class="form-control" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Deparment</label>
                                    <input type="text" name="department" id="department" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role</label>
                                    <select class="form-control" name="role" required>
                                        <option value="">Select</option>
                                        <option value="MS">Member Secretary</option>
                                        <option value="CP">Chair Person</option>
                                        <option value="M">Member</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea name="remarks" class="form-control"></textarea>
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

            {{-- edit --}}

            <div class="modal fade" id="exampleModa3_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Edit Member</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('administrative.inquiry.plan.chief.list.view.details.chief.update.inquiry.member') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="atr_id" value="{{@$id}}">
                                <input type="hidden" name="member_id" id="member_id">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Users</label>
                                    <select class="form-control" name="user_id" disabled id="user_id_edit"  required>
                                        <option value="">Select User</option>
                                        @foreach(@$user_dropdown as $value)
                                        <option value="{{@$value->id}}"  data-eid="{{@$value->eid}}" data-cid="{{@$value->cid}}" data-department="{{@$value->department_name->name}}">{{@$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden" name="user_id" id="user_edit_edit">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">EID</label>
                                    <input class="form-control" id="eid_edit" readonly name="eid" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CID</label>
                                    <input type="text" name="cid" id="cid_edit" class="form-control" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Deparment</label>
                                    <input type="text" name="department" id="department_edit" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role</label>
                                    <select class="form-control" name="role" id="role_edit" required>
                                        <option value="">Select</option>
                                        <option value="MS">Member Secretary</option>
                                        <option value="CP">Chair Person</option>
                                        <option value="M">Member</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea name="remarks_edit" id="remarks_edit" class="form-control"></textarea>
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


            <div class="modal fade" id="exampleModa4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Add  Members</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('administrative.inquiry.plan.chief.list.view.details.chief.insert.inquiry.member') }}" enctype="multipart/form-data">@csrf
                                 <input type="hidden" name="appraise_id" value="{{@$appraise_id}}">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Users</label>
                                    <select class="form-control" name="user_id" id="user_change_add_com" required>
                                        <option value="">Select User</option>
                                        @foreach(@$com_user_dropdown as $value)
                                        <option value="{{@$value->id}}" data-eid="{{@$value->eid}}" data-cid="{{@$value->cid}}" data-department="{{@$value->department_name->name}}">{{@$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <input type="hidden" name="type" value="com">


                                <div class="form-group">
                                    <label for="exampleInputEmail1">CID</label>
                                    <input type="text" name="cid" id="cid_commision" class="form-control" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">EID</label>
                                    <input type="text" name="name" id="eid_commision" class="form-control" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Deparment</label>
                                    <input type="text" name="department_commision" id="department_commision" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role</label>
                                    <select class="form-control" name="role" required>
                                        <option value="">Select</option>
                                        <option value="MS">Member Secretary</option>
                                        <option value="CP">Chair Person</option>
                                        <option value="M">Member</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea name="remarks" class="form-control"></textarea>
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

             <script type="text/javascript">
                 $('#user_change_add_com').on('change',function(){
                    $('#cid_commision').val($("#user_change_add_com option:selected").attr('data-eid'));
                    $('#eid_commision').val($("#user_change_add_com option:selected").attr('data-cid'));
                    $('#department_commision').val($("#user_change_add_com option:selected").attr('data-department'));
                 })

                 $('#com_final_decision').on('change',function(e){
                    var decision = $('#com_final_decision').val();

                    if(decision=="ND")
                    {
                        $('.new_decision_div').show();
                    }else{
                        $('.new_decision_div').hide();
                    }
                 })

                 
             </script>

@endsection