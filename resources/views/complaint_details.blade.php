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
          <a class="nav-link active btn btn-info" href="{{route('complaint.complete.details.full',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.complete.details.full.attachment',['id'=>@$id])}}">Attachment Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.complete.details.full.finance',['id'=>@$id])}}">Financial Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.complete.details.full.social',['id'=>@$id])}}">Social Implication</a>
        </li>



        <li class="nav-item">
          <a class="nav-link " href="{{route('complaint.complete.details.full.person',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="{{route('complaint.complete.details.full.link.case',['id'=>@$id])}}">Link Case</a>
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

             <div class="col-sm-12">
                    <div class="card">
                        <p><b>Complaint Details:</b> {!!@$data->complaintDetails!!}</p>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="row">
                    <div class="col-sm-12">
                    <div class="card">
                        @php
                        $score = (int)@$score->mode_of_complaint+(int)@$score->identity_of_accused+(int)@$score->location+(int)@$score->witness+(int)@$score->evidense+(int)@$score->finance+(int)@$score->social;
                        $complaint_score = (int)@$score->mode_of_complaint+(int)@$score->identity_of_accused+(int)@$score->location+(int)@$score->witness+(int)@$score->evidense;

                        $finance_score = (int)@$score->finance;
                        $social_score =  (int)@$score->social;
                        @endphp
                        <p><b>System Scoring:</b> {{@$score}}</p>
                        <p class="mt-3"><b>Complaint Details : {{@$complaint_score}}</b></p>
                        <p><b>Financial Implication : {{@$finance_score}}</b></p>
                        <p><b>Social Implication : {{@$social_score}}</b></p>
                        <p><b>Total System Score : {{@$score}}</b></p>

                        <p><b>System Outcome : @if(@$score>=1 && @$score<=24) Drop @elseif(@$score>=25 && @$score<=29) Discreet Enquiry or Share with Agencies @elseif(@$score>29) Investigate @else No Score No Outcome @endif</b></p>
                    </div>
                    </div>



                    
                  </div>
                </div>
               


                 <div class="col-md-12">
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Information Enrichment
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    @if(@$members_cec_approve==0)
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa2">
                                        Add
                                    </button>
                                    @endif
                                   
                                </div>
                            </div>
                    <div class="card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}


                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descrption</th>
                                        <th>Date</th>
                                        <th>Attached Document</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$information->isNotEmpty())
                                        @foreach (@$information as $att)
                                            <tr>
                                                <td>{{ $att->id }}</td>
                                                <td>{{ $att->description }}</td>
                                                <td>{{ $att->date }}</td>
                                                <td>@if($att->attachment!="") <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/information')}}/{{$att->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> @else -- @endif</td>
                                                
                                                <td>
                                                    
                                                    @if(@$members_cec_approve==0)        
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button row-class-{{ @$att->id }}"
                                                        data-row-data='{{ @$att->dzoName }}' data-id="{{@$att->id}}" data-description="{{@$att->description}}" data-date="{{@$att->date}}" data-attachment="{{URL::to('attachment/information')}}/{{@$att->attachment}}" @if(@$att->attachment=="") data-attachmentType="N" @else data-attachmentType="Y" @endif  data-toggle="modal"
                                                        >
                                                        Edit
                                                    </a>
                                                   

                                                   
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('dzonkhag.delete', ['id' => @$att->id]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this dzonkhag ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    @endif
                                                    
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
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Complaint Evaluation Committee Meeting
                                </div>
                                @if(@$data->outcome_status=="")
                                <div class="col-sm-12 mt-3">
                                    {{-- @if(@$data->cec_date=="" && @$data->cec_time=="" && @$data->cec_venue=="")
                                    <p class="btn btn-warning">Please add CEC Date,CEC Time,Venue first then add memebers. </p>
                                    @endif --}}
                                <form method="post" id="cec_form_update" action="{{route('add.member.evaluation.update.location')}}"> 
                                    @csrf
                                    <input type="hidden" name="complaintID" value="{{@$id}}">
                                
                                    <label class="radio-inline">
                                  <input type="radio" name="cec_create" class="cec_create" value="Y" @if(@$data->cec_create=="Y")checked @endif>Create Scoring
                                </label>
                                

                                <label class="radio-inline">
                                  <input type="radio" name="cec_create" class="cec_create" value="N" @if(@$data->cec_create=="N")checked @endif>Deffer
                                </label>

                                {{-- <div class="cec_create_div" @if(@$data->cec_create=="Y") style="display:block" @else style="display:none" @endif>

                                <div class="row">
                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Date</label>
                                    <input type="date" value="{{@$data->cec_date}}" name="cec_date" id="cec_date" class="form-control" >
                                </div>
                              </div>

                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Time</label>
                                    <input type="time" name="cec_time" value="{{@$data->cec_time}}" id="cec_time" class="form-control" >
                                </div>
                                </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="cec_venue" value="{{@$data->cec_venue}}" id="cec_venue" class="form-control" >
                                </div>
                            </div> --}} 


                             <div class="reason_div" @if(@$data->cec_create=="Y") style="display:none" @else style="display:block" @endif>
                                <div class="form-group">
                                    <label for="label">Reason</label>
                                    <textarea type="text" name="reason_not_create" class="form-control" > {{@$data->reason_not_create}} </textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>

                                {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
                                {{-- please remove top one --}}
                                </form>
                            </div>
                            @endif


                                @if(@$data->outcome_status=="")
                                <div class="col-sm" id="cec_add_button" @if(@$data->cec_create=="Y") style="display:block" @else style="display:none" @endif>
                                    <!-- Button trigger modal -->
                                    
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa3" style="float: right;">
                                        + Add Member
                                    </button>
                                   
                                </div>
                                @endif
                            </div>
                    <div class="card-body" id="cec_member_add" @if(@$data->cec_create=="Y") style="display:block" @else style="display:none" @endif>
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
                                        {{-- <th>Availability</th> --}}
                                        <th>COI Status</th>
                                        {{-- <th>Scoring</th> --}}
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

                                                {{-- <td>@if(@$att->availability=="AA") Awaiting Approval @elseif(@$att->availability=="Y") Available @else Not Available  @endif</td> --}}


                                                <td>@if(@$att->coi_status=="AA") Awaiting Approval @elseif(@$att->coi_status=="Y") Yes @else No  @endif</td>

                                                {{-- <td>@if(@$att->scoring=="") -- @else {{@$att->scoring}} @endif</td> --}}
                                                
                                                <td>
                                                    
                                                    @if(@$att->coi_status!="N")        
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button_person row-class-{{ @$att->id }}"
                                                        data-row-data='{{ @$att->dzoName }}' data-id="{{@$att->id}}" data-eid="{{@$att->user_details->eid}}" data-user_id="{{@$att->user_details->id}}" data-name="{{@$att->user_details->name}}" 
                                                        data-cid="{{@$att->user_details->cid}}"
                                                        data-department="{{@$att->user_details->department_name->name}}"
                                                        data-role = "{{@$att->role}}"
                                                        data-remarks = "{{@$att->remarks}}"
                                                        data-toggle="modal"
                                                        >
                                                        Edit
                                                    </a>
                                                   

                                                   
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{route('delete.member.evaluation',@$att->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    @endif

                                                    {{-- <a href="{{route('case.details.member.view.more',@$att->id)}}" class="btn btn-xs btn-warning" target="_blank">View Score Details</a> --}}
                                                    
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



                    @if(@$members_cec_approve>0)
                    <div class="col-sm-12">
                        <div class="card">
                            {{-- @php @$avg = @$sum/ @$count_member @endphp
                            <p><b>Total Score Of Cec Member:</b> {{@$sum}}</p>
                            <p><b>Average Score Of Cec Member:</b> {{@$avg}}</p> --}}

                              <form action="{{route('complaint.evaluate.outcome-final-update')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="complaintID" value="{{@$data->complaintID}}">


                                <div class="row">
                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Date</label>
                                    <input type="date" value="{{@$data->cec_date}}" @if(@$members_com_approve>0) disabled @endif name="cec_date" id="cec_date" class="form-control" >
                                </div>
                              </div>

                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Time</label>
                                    <input type="time" name="cec_time" value="{{@$data->cec_time}}" @if(@$members_com_approve>0) disabled @endif id="cec_time" class="form-control" >
                                </div>
                                </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="cec_venue" value="{{@$data->cec_venue}}" @if(@$members_com_approve>0) disabled @endif id="cec_venue" class="form-control" >
                                </div>
                            

                                <div class="form-group">
                                    <label for="label">CEC Recommendation</label>
                                    <select class="form-control" name="outcome_status" id="outcome_status" @if(@$members_com_approve>0) disabled @endif required>
                                        <option value="">Select</option>
                                        <option value="Investigate" @if(@$data->outcome_status=="Investigate") selected @endif>Investigate</option>
                                        <option value="Information Enrichment" @if(@$data->outcome_status=="Information Enrichment") selected @endif>Information Enrichment</option>
                                        <option value="Share With Agencies" @if(@$data->outcome_status=="Share With Agencies") selected @endif>Share With Agencies</option>
                                        <option value="Drop" @if(@$data->outcome_status=="Drop") selected @endif>Drop</option>
                                    </select>
                                </div> 


                                <div class="form-group agency_outcome_div"   @if(@$data->outcome_status=="Share With Agencies") style="display:block" @else  style="display:none" @endif>
                                    <select class="form-control" @if(@$members_com_approve>0) disabled @endif name="agency_outcome" id="agency_outcome" >
                                        <option value="">Select</option>
                                        <option value="For Action" @if(@$data->agency_outcome=="For Action") selected @endif>For Action</option>
                                        <option value="Sensitization" @if(@$data->agency_outcome=="Sensitization") selected @endif>Sensitization</option>
                                     </select>
                                </div> 


                                <div class="form-group">
                                    <label for="label">Remarks</label>
                                    <textarea type="text" name="final_remark" @if(@$members_com_approve>0) disabled @endif class="form-control"  required> {{@$data->final_remark}}</textarea>
                                </div>


                                <div class="form-group">
                                    <label for="label">Attachment (Optional)</label>
                                    <input type="file" name="attachment" @if(@$members_com_approve>0) disabled @endif class="form-control">
                                </div>

                                @if(@$data->attachment!="")
                                    <div class="form-group"> <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/cec')}}/{{$data->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> </div>
                                @endif
                                @if(@$members_com_approve==0)
                                <div class="form-group"><button class="btn btn-primary" type="submit">Update Final Outcome</button></div>
                                @endif
                             


                             </form>
                        </div>
                    </div>
                    @endif


    {{-- commision-meeting --}}
    @if(@$data->outcome_status!="")
                     <div class="col-sm-12">
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Complaint Evaluation Commision Meeting
                                </div>

                                {{-- <div class="col-sm-12 mt-3">
                                    @if(@$data->com_date=="" && @$data->com_time=="" && @$data->com_venue=="")
                                    <p class="btn btn-warning">Please add  Date, Time,Venue first then add memebers. </p>
                                    @endif
                                <form method="post" action="{{route('add.member.evaluation.update.location.commision')}}"> 
                                    @csrf
                                    <input type="hidden" name="complaintID" value="{{@$id}}">
                                <div class="row">
                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commision Date</label>
                                    <input type="date" value="{{@$data->com_date}}" name="com_date" id="com_date" class="form-control"  required>
                                </div>
                                </div>

                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commision Time</label>
                                    <input type="time" name="com_time" value="{{@$data->com_time}}" id="com_time" class="form-control"  required>
                                </div>
                                </div>
                            </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="com_venue" value="{{@$data->com_venue}}" id="com_venue" class="form-control"  required>
                                </div>

                                <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div> --}}

                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    @if(@$data->com_final_decision=="")
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa4" style="float: right;">
                                        + Add Member
                                    </button>
                                    @endif
                                   
                                </div>
                            </div>
                    <div class="card-body">
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
                                        {{-- <th>Availability</th> --}}
                                        <th>COI Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$commision_members->isNotEmpty())
                                        @foreach (@$commision_members as $att)
                                            <tr>
                                                <td>{{ @$att->eid }}</td>
                                                <td>{{ @$att->user_details->name }}</td>
                                                <td>{{ @$att->user_details->department_name->name }}</td>
                                                <td>@if(@$att->role=="MS") Member Secretary @elseif(@$att->role=="CP") Chair Person @else Member  @endif</td>

                                                {{-- <td>@if(@$att->availability=="AA") Awaiting Approval @elseif(@$att->availability=="Y") Available @else Not Available  @endif</td> --}}


                                                <td>@if(@$att->coi_status=="AA") Awaiting Approval @elseif(@$att->availability=="Y") Yes @else No  @endif</td>

                                                
                                                
                                                <td>
                                                    
                                                    @if(@$att->coi_status!="N")            
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button_person row-class-{{ @$att->id }}" data-user_id="{{@$att->user_details->id}}"
                                                        data-row-data='{{ @$att->dzoName }}' data-id="{{@$att->id}}" data-eid="{{@$att->user_details->eid}}" data-name="{{@$att->user_details->name}}" 
                                                        data-cid="{{@$att->user_details->cid}}"
                                                        data-department="{{@$att->user_details->department_name->name}}"
                                                        data-role = "{{@$att->role}}"
                                                        data-remarks = "{{@$att->remarks}}"
                                                        data-toggle="modal"
                                                        >
                                                        Edit
                                                    </a>
                                                   

                                                   
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{route('delete.member.evaluation',@$att->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    @endif
                                                    
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


@endif


@if(@$members_com_approve>0)
                    <div class="col-sm-12">
                        <div class="card">
                            {{-- @php @$avg = @$sum/ @$count_member @endphp
                            <p><b>Total Score Of Cec Member:</b> {{@$sum}}</p>
                            <p><b>Average Score Of Cec Member:</b> {{@$avg}}</p> --}}

                              <form action="{{route('complaint.evaluate.outcome-final-update.commission')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="complaintID" value="{{@$data->complaintID}}">


                                <div class="row">

                                    <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commission Meeting No</label>
                                    <input type="text" value="{{@$data->com_meeting_no}}" disabled  name="com_meeting_no" id="cec_date" class="form-control" >
                                </div>
                              </div>
                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commission Date</label>
                                    <input type="date" value="{{@$data->com_date}}" disabled  name="com_date" id="cec_date" class="form-control" >
                                </div>
                              </div>

                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commission Time</label>
                                    <input type="time" name="com_time" disabled value="{{@$data->com_time}}"  id="com_time" class="form-control" >
                                </div>
                                </div>
                                

                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="com_venue" disabled value="{{@$data->com_venue}}"  id="com_venue" class="form-control" >
                                </div>
                            </div>
                            </div>


                            <div class="form-group">
                                    <label for="label">Commission Decision</label>
                                    <select class="form-control" disabled name="com_final_decision" id="com_final_decision"  required>
                                        <option value="">Select</option>
                                        <option value="ECD" @if(@$data->com_final_decision=="ECD") selected @endif>Endorse CEC Decision</option>
                                        <option value="ND" @if(@$data->com_final_decision=="ND") selected @endif>New Decision</option>
                                    </select>
                                </div>
                            
                                <div class="new_decision_div" @if(@$data->com_final_decision=="ND") style="display:block;" @else  style="display:none;" @endif>
                                <div class="form-group">
                                    <label for="label">Commission Recommendation</label>
                                    <select class="form-control" disabled name="com_outcome_status" id="com_outcome_status"  >
                                        <option value="">Select</option>
                                        <option value="Investigate" @if(@$data->com_outcome_status=="Investigate") selected @endif>Investigate</option>
                                        <option value="Information Enrichment" @if(@$data->com_outcome_status=="Information Enrichment") selected @endif>Information Enrichment</option>
                                        <option value="Share With Agencies" @if(@$data->com_outcome_status=="Share With Agencies") selected @endif>Share With Agencies</option>
                                        <option value="Drop" @if(@$data->com_outcome_status=="Drop") selected @endif>Drop</option>
                                    </select>
                                </div> 


                                <div class="form-group agency_outcome_div_com"   @if(@$data->com_outcome_status=="Share With Agencies") style="display:block" @else  style="display:none" @endif>
                                    <select class="form-control" disabled  name="com_agency_outcome" id="com_agency_outcome" >
                                        <option value="">Select</option>
                                        <option value="For Action" @if(@$data->com_agency_outcome=="For Action") selected @endif>For Action</option>
                                        <option value="Sensitization" @if(@$data->com_agency_outcome=="Sensitization") selected @endif>Sensitization</option>
                                     </select>
                                </div> 


                                <div class="form-group">
                                    <label for="label">Commission Remarks</label>
                                    <textarea type="text" disabled name="com_agency_final_remark"  class="form-control"  > {{@$data->com_agency_final_remark}}</textarea>
                                </div>


                                

                                @if(@$data->com_final_attachement!="")
                                    <div class="form-group"> <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/cec')}}/{{$data->com_final_attachement}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> </div>
                                @endif
                            </div>
                                
                                
                                
                             


                             </form>
                        </div>
                    </div>
                    @endif
             








            








    </div>












                






               
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   

@endsection