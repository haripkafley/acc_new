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
          <a class="nav-link active btn btn-info" href="{{route('complaint.evaluate.list.view.details',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.evaluate.list.attachment.details.regional',['id'=>@$id])}}">Attachment Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.evaluate.list.financial-implication-details.regional',['id'=>@$id])}}">Financial Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.evaluate.list.social-implication-details.regional',['id'=>@$id])}}">Social Implication</a>
        </li>



        <li class="nav-item">
          <a class="nav-link " href="{{route('complaint.evaluate.list.aperson-involved-details.regional',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="{{route('complaint.evaluate.list.case-link-details.regional',['id'=>@$id])}}">Link Case</a>
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


                {{-- allegation --}}
                <div class="col-sm-12">
                    <div class="card">
                        <div class="col-sm">
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa_all" style="margin-bottom: 15px;">
                                    + Add Allegation
                                </button>
                        </div>
                        
                    
                    <table  class="table">
                        <thead>
                            <th>Allegation</th>
                            <th>Allegation Details</th>
                            <th>Action</th>   
                        </thead>
                        <tbody>
                            @php $count = 1 @endphp
                            @foreach(@$evalution_allegation_list as $att)
                            <tr>
                                        <td>{{ $att->allegation_name }}</td>
                                        <td>{{ $att->allegation_description }}</td>
                                        <td>
                                                        <a class="btn btn-xs btn-info edit_button_all"
                                                            data-id="{{$att->id}}"
                                                            data-allegation_name="{{$att->allegation_name}}"
                                                            data-allegation_description="{{$att->allegation_description}}"   
                                                        >
                                                                <i class="fa fa-edit"></i>
                                                                
                                                            </a>
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('allegation.offence.management.delete.allegation',['id'=>@$att->id])}}" onclick="return confirm('Are you sure , you want to delete this attachment ? ')"><i class="fa fa-trash"></i>
                                                                
                                                            </a>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card">
                        <form method="post" action="{{route('complaint.evaluate.list.view.details.add.offence.post')}}">
                            @csrf
                            <input type="hidden" name="complaint_id" value="{{@$id}}">
                            <div class="row">
                            <div class="col-md-9 mb-2">
                            <div class="form-group">
                                <label>Offence</label>
                                <select class="form-control" name="offence">
                                    <option value="">Select</option>
                                    @foreach(@$offence_list as $val)
                                    <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mt-4"><button class="btn btn-primary">Save</button></div>
                        </div>
                        </form>
                    
                    <table  class="table">
                        <thead>
                            <th>S.no</th>
                            <th>Offence</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @php $count = 1 @endphp
                            @foreach(@$evalution_offence_list as $value)
                            <tr>
                                <th>{{@$count++}}</th>
                                <td>{{@$value->offence_name->offence_type}}</td> 
                                <td><a href="{{route('complaint.evaluate.list.view.details.delete.offence',@$value->id)}}" class="btn btn-xs btn-danger" onclick="return confirm('Are sure want to delete this?')"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="row">
                    <div class="col-sm-6">
                    <div class="card">
                        @php
                        $score_details = (int)@$score->mode_of_complaint+(int)@$score->identity_of_accused+(int)@$score->location+(int)@$score->witness+(int)@$score->evidense+(int)@$score->finance+(int)@$score->social;


                        $complaint_score = (int)@$score->mode_of_complaint+(int)@$score->identity_of_accused+(int)@$score->location+(int)@$score->witness+(int)@$score->evidense;

                        $finance_score = (int)@$score->finance;
                        $social_score =  (int)@$score->social;
                        @endphp
                        <p><b>System Scoring:</b> {{@$score_details}}</p>
                        <p class="mt-3"><b>Complaint Details : {{@$complaint_score}}</b></p>
                        <p><b>Financial Implication : {{@$finance_score}}</b></p>
                        <p><b>Social Implication : {{@$social_score}}</b></p>
                        <p><b>Total System Score : {{@$score_details}}</b></p>

                        <p><b>System Outcome : @if(@$score_details>=1 && @$score_details<=24) Drop @elseif(@$score_details>=25 && @$score_details<=29) Discreet Enquiry or Share with Agencies @elseif(@$score_details>29) Investigate @else No Score No Outcome @endif</b></p>
                    </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="card">
                            <form action="{{route('complaint.evaluate.pursuable.update')}}" method="POST">
                                @csrf
                                <input type="hidden" name="complaint_id" value="{{@$id}}">
                                <div class="form-group">
                                    <label>Is Complaint Pursuable?</label>
                                    <select class="form-control" name="pursuable">
                                        <option value="">Select</option>
                                        <option value="Y" @if(@$data->pursuable_decision=="Y") selected @endif>Yes</option>
                                        <option value="N" @if(@$data->pursuable_decision=="N") selected @endif>No</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="pursuable_remark">{{@$data->pursuable_remarks}}</textarea>
                                </div>
                                <div class="col-md-12"><button type="submit" class="btn btn-primary">Save</button></div>
                            </form>
                        </div>
                    </div>


                    
                  </div>
                </div>
               


                 <div class="col-md-12">
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Complaint Enrichment
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
                                                        <i class="fa fa-edit"></i></a>
                                                    </a>
                                                   

                                                   
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('complaint.evaluation.additional.information.delete', ['id' => @$att->id]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this  ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        
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
                                    Complaint Evaluation CEC Members
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
                                                        <i
                                                            class="fa fa-edit"></i>
                                                    </a>
                                                   

                                                   
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{route('delete.member.evaluation',@$att->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        

                                                    </a>
                                                    @endif

                                                    {{-- <a href="{{route('case.details.member.view.more',@$att->id)}}" class="btn btn-xs btn-warning" target="_blank">View Score Details</a> --}}
                                                    
                                                </td>
                                            </tr>

                                            
                                        @endforeach
                                   <tr>
                                                <td>@if(@$data->assign_to=="H") {{ @$data->user_details_head->eid }} @else {{ @$data->user_details_regional->eid }} @endif</td>
                                                <td>@if(@$data->assign_to=="H") {{ @$data->user_details_head->name }} @else {{ @$data->user_details_regional->name }} @endif</td>
                                                <td> @if(@$data->assign_to=="H") {{ @$data->user_details_head->department_name->name }} @else {{ @$data->user_details_regional->department_name->name }} @endif</td>
                                                <td>Member Secretary</td>
                                                
                                            </tr>

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
                            {{-- complaint.evaluate.outcome-final-update --}}
                              <form action="{{route('complaint.evaluate.list.view.details.cec.recommendation.update.new')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="complaintID" value="{{@$data->complaintID}}">


                                <div class="row">
                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Date</label>
                                    <input type="date" @if(@$data->cec_date!="")value="{{@$data->cec_date}}" @else value="{{date('Y-m-d')}}" @endif @if(@$members_com_approve>0) disabled @endif name="cec_date" id="cec_date" class="form-control" required>
                                </div>
                              </div>

                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Time</label>
                                    <input type="time" name="cec_time" value="{{@$data->cec_time}}" @if(@$members_com_approve>0) disabled @endif id="cec_time" class="form-control" required >
                                </div>
                                </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="cec_venue" value="{{@$data->cec_venue}}" @if(@$members_com_approve>0) disabled @endif id="cec_venue" class="form-control" >
                                </div>
                                
                                <table class="table">
                                    <thead>
                                        <th>S.No</th>
                                        <th>Allgeation Name</th>
                                        <th>Allgeation Details</th>
                                        <th>CEC Recommendation</th>
                                        <th>Remarks</th>
                                    </thead>
                                    <tbody>

                                        @php $count = 1 @endphp
                                        @foreach(@$evalution_allegation_list as $key=> $value)
                                        <tr>
                                             <td>{{@$count++}}</td>
                                             <td>{{@$value->allegation_name}}</td> 
                                             <td>{{@$value->allegation_description}}</td> 
                                             <td>
                                                <input type="hidden"    name="addmore[{{$key}}][id]" class="form-control name" value="{{@$value->id}}">
                                                 <select class="form-control cec_decision" data-id="{{@$value->id}}" name="addmore[{{$key}}][decision]">
                                                     <option value="">Select</option>
                                                     <option value="CL" @if(@$value->decision=="CL") selected @endif>Close ( No further Action)</option>
                                                     <option value="DD" @if(@$value->decision=="DD") selected @endif>Deferred Decision</option>
                                                     <option value="SEN" @if(@$value->decision=="SEN") selected @endif>Sensitization</option>
                                                     <option value="AI" @if(@$value->decision=="AI") selected @endif>Administrative Inquiry</option>
                                                     <option value="IVS" @if(@$value->decision=="IVS") selected @endif>Investigation</option>
                                                 </select>

                                                 <select class="form-control cec_sub_decision mt-2" id="cec_sub_decision{{@$value->id}}" name="addmore[{{$key}}][sub_decision]" @if(@$value->decision=="DD") style="display: block;" @else style="display: none;" @endif>
                                                    <option value="IE" @if(@$value->sub_decision=="IE") selected @endif>Information Enrichment</option> 
                                                    <option value="LO" @if(@$value->sub_decision=="LO") selected @endif>Legal Opinion</option> 
                                                    <option value="IG" @if(@$value->sub_decision=="IG") selected @endif>Information Gathering (Complaint)</option> 
                                                    <option value="IGI" @if(@$value->sub_decision=="IGI") selected @endif>Information Gathering (Intel) </option> 
                                                 </select>
                                             </td>
                                             <td><textarea class="form-control" name="addmore[{{$key}}][remarks]">{{@$value->remarks}}</textarea></td>
                                        </tr>
                                        @endforeach
                                       
                                    </tbody>
                                </table>

                                {{-- <div class="form-group">
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

                                @if(@$members_com_approve<0)
                                <div class="form-group">
                                    <label for="label">Attachment (Optional)</label>
                                    <input type="file" name="attachment"  class="form-control">
                                </div>
                                @endif

                                @if(@$data->attachment!="")
                                    <div class="form-group"> <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/cec')}}/{{$data->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> </div>
                                @endif --}}
                                @if(@$members_com_approve==0)
                                <div class="form-group"><button class="btn btn-primary" type="submit">Update Final Outcome</button></div>
                                @endif
                             


                             </form>
                        </div>
                    </div>
                    @endif


    {{-- commision-meeting --}}
    @if(@$data->cec_date!="")
                     <div class="col-sm-12">
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Complaint Evaluation Commision Members
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
                                                         <i
                                                            class="fa fa-edit"></i>
                                                    </a>
                                                   

                                                   
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{route('delete.member.evaluation',@$att->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        
                                                    </a>
                                                    @endif
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                        <tr>
                                                <td>@if(@$data->assign_to=="H") {{ @$data->user_details_head->eid }} @else {{ @$data->user_details_regional->eid }} @endif</td>
                                                <td>@if(@$data->assign_to=="H") {{ @$data->user_details_head->name }} @else {{ @$data->user_details_regional->name }} @endif</td>
                                                <td> @if(@$data->assign_to=="H") {{ @$data->user_details_head->department_name->name }} @else {{ @$data->user_details_regional->department_name->name }} @endif</td>
                                                <td>Member Secretary</td>
                                                
                                            </tr>

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

                                    {{-- <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commission Meeting No</label>
                                    <input type="text" value="{{@$data->com_meeting_no}}"  name="com_meeting_no" id="cec_date" class="form-control" >
                                </div>
                              </div> --}}
                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commission Date</label>
                                    <input type="date"  @if(@$data->com_date!="")value="{{@$data->com_date}}" @else value="{{date('Y-m-d')}}" @endif  name="com_date" id="cec_date" class="form-control" >
                                </div>
                              </div>

                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commission Time</label>
                                    <input type="time" name="com_time" value="{{@$data->com_time}}"  id="com_time" class="form-control" >
                                </div>
                                </div>
                                

                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="com_venue" value="{{@$data->com_venue}}"  id="com_venue" class="form-control" >
                                </div>
                            </div>
                            </div>


                                                            <table class="table">
                                    <thead>
                                        <th>S.No</th>
                                        <th>Allgeation Name</th>
                                        <th>Allgeation Details</th>
                                        <th>CEC Recommendation</th>
                                        <th>Remarks</th>
                                        <th>Commission Recommendation</th>
                                        <th>Commission Remarks</th>
                                    </thead>
                                    <tbody>

                                        @php $count = 1 @endphp
                                        @foreach(@$evalution_allegation_list as $key=> $value)
                                        <tr>
                                             <td>{{@$count++}}</td>
                                             <td>{{@$value->allegation_name}}</td> 
                                             <td>{{@$value->allegation_description}}</td> 
                                             <td>
                                                <input type="hidden"    name="addmore[{{$key}}][id]" class="form-control name" value="{{@$value->id}}">
                                                 <select class="form-control cec_decision" disabled>
                                                     <option value="">Select</option>
                                                     <option value="CL" @if(@$value->decision=="CL") selected @endif>Close ( No further Action)</option>
                                                     <option value="DD" @if(@$value->decision=="DD") selected @endif>Deferred Decision</option>
                                                     <option value="SEN" @if(@$value->decision=="SEN") selected @endif>Sensitization</option>
                                                     <option value="AI" @if(@$value->decision=="AI") selected @endif>Administrative Inquiry</option>
                                                     <option value="IVS" @if(@$value->decision=="IVS") selected @endif>Investigation</option>
                                                 </select>

                                                 <select class="form-control cec_sub_decision mt-2" disabled @if(@$value->decision=="DD") style="display: block;" @else style="display: none;" @endif>
                                                    <option value="IE">Information Enrichment</option> 
                                                    <option value="LO">Legal Opinion</option> 
                                                    <option value="IG">Information Gathering</option> 
                                                 </select>
                                             </td>
                                             <td><textarea class="form-control" disabled name="addmore[{{$key}}][remarks]">{{@$value->remarks}}</textarea></td>


                                             <td>
                                                
                                                 <select class="form-control com_decision" data-id="{{@$value->id}}" name="addmore[{{$key}}][com_decision]">
                                                     <option value="">Select</option>
                                                     <option value="CL" @if(@$value->com_decision=="CL") selected @endif>Close ( No further Action)</option>
                                                     <option value="DD" @if(@$value->com_decision=="DD") selected @endif>Deferred Decision</option>
                                                     <option value="SEN" @if(@$value->com_decision=="SEN") selected @endif>Sensitization</option>
                                                     <option value="AI" @if(@$value->com_decision=="AI") selected @endif>Administrative Inquiry</option>
                                                     <option value="IVS" @if(@$value->com_decision=="IVS") selected @endif>Investigation</option>
                                                 </select>

                                                 <select class="form-control com_sub_decision mt-2" id="com_sub_decision{{@$value->id}}" name="addmore[{{$key}}][com_sub_decision]" @if(@$value->com_decision=="DD") style="display: block;" @else style="display: none;" @endif>
                                                    <option value="IE" @if(@$value->com_sub_decision=="IE") selected @endif>Information Enrichment</option> 
                                                    <option value="LO" @if(@$value->com_sub_decision=="LO") selected @endif>Legal Opinion</option> 
                                                    <option value="IG" @if(@$value->com_sub_decision=="IG") selected @endif>Information Gathering (Complaint)</option> 
                                                    <option value="IGI" @if(@$value->com_sub_decision=="IGI") selected @endif>Information Gathering (Intel) </option> 
                                                 </select>
                                             </td>

                                             <td><textarea class="form-control"  name="addmore[{{$key}}][com_remarks]">{{@$value->com_remarks}}</textarea></td>



                                        </tr>
                                        @endforeach
                                       
                                    </tbody>
                                </table>


{{--                             <div class="form-group">
                                    <label for="label">Commission Decision</label>
                                    <select class="form-control" name="com_final_decision" id="com_final_decision"  required>
                                        <option value="">Select</option>
                                        <option value="ECD" @if(@$data->com_final_decision=="ECD") selected @endif>Endorse CEC Decision</option>
                                        <option value="ND" @if(@$data->com_final_decision=="ND") selected @endif>New Decision</option>
                                    </select>
                                </div>


                                <div class="cec_decision_old" @if(@$data->com_final_decision=="ND") style="display:none;" @else  style="display:block;" @endif>

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

                                @if(@$data->attachment!="")
                                    <div class="form-group"> <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/cec')}}/{{$data->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> </div>
                                @endif


                                </div>
                            
                                <div class="new_decision_div" @if(@$data->com_final_decision=="ND") style="display:block;" @else  style="display:none;" @endif>
                                <div class="form-group">
                                    <label for="label">Commission Recommendation</label>
                                    <select class="form-control" name="com_outcome_status" id="com_outcome_status"  >
                                        <option value="">Select</option>
                                        <option value="Investigate" @if(@$data->com_outcome_status=="Investigate") selected @endif>Investigate</option>
                                        <option value="Information Enrichment" @if(@$data->com_outcome_status=="Information Enrichment") selected @endif>Information Enrichment</option>
                                        <option value="Share With Agencies" @if(@$data->com_outcome_status=="Share With Agencies") selected @endif>Share With Agencies</option>
                                        <option value="Drop" @if(@$data->com_outcome_status=="Drop") selected @endif>Drop</option>
                                    </select>
                                </div> 


                                <div class="form-group agency_outcome_div_com"   @if(@$data->com_outcome_status=="Share With Agencies") style="display:block" @else  style="display:none" @endif>
                                    <select class="form-control"  name="com_agency_outcome" id="com_agency_outcome" >
                                        <option value="">Select</option>
                                        <option value="For Action" @if(@$data->com_agency_outcome=="For Action") selected @endif>For Action</option>
                                        <option value="Sensitization" @if(@$data->com_agency_outcome=="Sensitization") selected @endif>Sensitization</option>
                                     </select>
                                </div> 


                                <div class="form-group">
                                    <label for="label">Commission Remarks</label>
                                    <textarea type="text" name="com_agency_final_remark"  class="form-control"  > {{@$data->com_agency_final_remark}}</textarea>
                                </div>


                                <div class="form-group">
                                    <label for="label">Commission Attachment (Optional)</label>
                                    <input type="file" name="com_final_attachement"  class="form-control">
                                </div>

                                @if(@$data->com_final_attachement!="")
                                    <div class="form-group"> <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/cec')}}/{{$data->com_final_attachement}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> </div>
                                @endif
                            </div> --}}
                                
                                <div class="form-group"><button class="btn btn-primary" type="submit">Update Commission Decision</button></div>
                                
                             


                             </form>
                        </div>
                    </div>
                    @endif
             







                {{-- <div class="col-sm-6">
                    <div class="card">
                        <p><a href="{{route('complaint.evaluation.additional.information',@$data->complaintID)}}" target="_blank" class="btn btn-warning">Additional Information</a></p>
                    </div>
                </div> --}}

                            <!-- Modal -->
            <div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('complaint.evaluation.additional.information.insert') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="id" value="{{@$id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Information Brief</label>
                                    <textarea class="form-control" name="description" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Attachment</label>
                                    <input type="file" name="attachment" class="form-control" >
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


            <!--Edit Modal -->
            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('complaint.evaluation.additional.information.update') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="info_id" id="info_id">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Information Brief</label>
                                    <textarea class="form-control" name="description" id="description" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date</label>
                                    <input type="date" name="date" id="date" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Attachment</label>
                                    <input type="file" name="attachment"  class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1" id="past"></label>
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


            {{-- committe --}}
                <div class="modal fade" id="exampleModa3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Add  Members</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('add.member.evaluation') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="complaint_id" value="{{@$id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Users</label>
                                    <select class="form-control" name="user_id" id="user_change_add_cec" required>
                                        <option value="">Select User</option>
                                        @foreach(@$cec_user_dropdown as $value)
                                        <option value="{{@$value->id}}" data-eid="{{@$value->eid}}" data-cid="{{@$value->cid}}" data-department="{{@$value->department_name->name}}">{{@$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden" name="type" value="cec">

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
    

            {{-- commision --}}

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
                            <form method="post" action="{{ route('add.member.evaluation') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="complaint_id" value="{{@$id}}">
                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">EID</label>
                                    <input class="form-control" id="eid_commision" name="eid" required>
                                    <a href="javascript:void(0)" id="search_eid_commision" class="btn btn-primary mt-2">Search</a>
                                </div> --}}

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
                            <form method="post" action="{{ route('update.member.evaluation') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="complaint_id" value="{{@$id}}">
                                <input type="hidden" name="member_id" id="member_id">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Users</label>
                                    <select class="form-control" name="user_id" id="user_id_edit" disabled required>
                                        <option value="">Select User</option>
                                        @foreach(@$user as $value)
                                        <option value="{{@$value->id}}" data-eid="{{@$value->eid}}" data-cid="{{@$value->cid}}" data-department="{{@$value->department_name->name}}">{{@$value->name}}</option>
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








    </div>







    <div class="modal fade" id="exampleModa_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Allegation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('allegation.offence.management.insert.allegation')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="complaint_id" value="{{@$id}}">

                <div class="form-group">
                  <label for="exampleInputEmail1">Allegation Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="allegation_name" aria-describedby="emailHelp" placeholder="Allegation Name" required>
                 </div>


                <div class="form-group">
                  <label for="exampleInputEmail1">Allegation Description</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="allegation_description" aria-describedby="emailHelp" placeholder="Allegation Description" required></textarea>
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
              <div class="modal fade" id="exampleModaEdit_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Exhibit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('allegation.offence.management.update.allegation')}}">@csrf
                                
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Allegation Name</label>
                                  <input type="text" class="form-control" id="allegation_name" name="allegation_name" aria-describedby="emailHelp" placeholder="Allegation Name" required>
                                 </div>


                                <div class="form-group">
                                  <label for="exampleInputEmail1">Allegation Description</label>
                                  <textarea type="text" class="form-control" id="allegation_description" name="allegation_description" aria-describedby="emailHelp" placeholder="Allegation Description" required></textarea>
                                 </div>

                             
                                 
                             <input type="hidden" name="id" id="id_all">
                             
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

<script>
        // $(function() {
        //     $("#maintableDz").dataTable();
        // });

        $(document).ready(function() {
            $('#maintableDz').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });

        $('.edit_button').on('click',function(){
            $('#description').val($(this).data('description'));
            $('#date').val($(this).data('date'));
            $('#info_id').val($(this).data('id'));
            if($(this).data('attachmenttype')=="Y")
            {
                $('#past').html('<a class="btn btn-xs btn-info" href="'+$(this).data('attachment')+'"" target="_blank"><i class="fa fa-eye"></i> View </a>');
            }
            $('#exampleModaEdit').modal('show');
            

         })

        $('.edit_button_person').on('click',function(){
            $('#user_id_edit').val($(this).data('user_id')).attr("selected", "selected");

            $('#user_edit_edit').val($(this).data('user_id'));
            $('#eid_edit').val($(this).data('eid'));
            $('#cid_edit').val($(this).data('cid'));
            $('#name_committee_edit').val($(this).data('name'));
            $('#department_edit').val($(this).data('department'));
            $('#role_edit').val($(this).data('role')).attr("selected", "selected");
            $('#remarks_edit').val($(this).data('remarks'));
            $('#member_id').val($(this).data('id'));
            $('#exampleModa3_edit').modal('show');
            
            
        })
    </script>

    <script type="text/javascript">
        $('#search_eid').on('click',function(e){
            if($('#eid').val()==""){
                alert('Please enter eid');
                return false;
            }else{
                var eid = $('#eid').val();
                $.ajax({
                url:'{{route('get.person-details.eid')}}',
                type:'GET',
                data:{eid:eid},
                success:function(data){
                  console.log(data);
                  if(data.success==false){
                    alert('User not found . Please try another one');
                    return false;
                  }
                  $('#cid').val(data.cid);
                  $('#department').val(data.department);
                  $('#name_committee').val(data.name);
                  
                }
              })
            }

        });
    </script>



    <script type="text/javascript">
        $('#search_eid_commision').on('click',function(e){
            if($('#eid_commision').val()==""){
                alert('Please enter eid');
                return false;
            }else{
                var eid = $('#eid_commision').val();
                $.ajax({
                url:'{{route('get.person-details.eid')}}',
                type:'GET',
                data:{eid:eid},
                success:function(data){
                  console.log(data);
                  if(data.success==false){
                    alert('User not found . Please try another one');
                    return false;
                  }
                  $('#cid_commision').val(data.cid);
                  $('#department_commision').val(data.department);
                  $('#name_committee_commision').val(data.name);
                  
                }
              })
            }

        });
    </script>



        <script type="text/javascript">
        $('#search_eid_edit').on('click',function(e){
            if($('#eid_edit').val()==""){
                alert('Please enter eid');
                return false;
            }else{
                var eid = $('#eid_edit').val();
                $.ajax({
                url:'{{route('get.person-details.eid')}}',
                type:'GET',
                data:{eid:eid},
                success:function(data){
                  console.log(data);
                  if(data.success==false){
                    alert('User not found . Please try another one');
                    return false;
                  }
                  $('#cid_edit').val(data.cid);
                  $('#department_edit').val(data.department);
                  $('#name_committee_edit').val(data.name);
                  
                }
              })
            }

        });
    </script>


        <script type="text/javascript">
                                 $('#outcome_status').on('change',function(){
                                    var outcome = $('#outcome_status').val();
                                    
                                    if(outcome=="Share With Agencies")
                                    {
                                        $('.agency_outcome_div').show();
                                    }else{
                                        $('.agency_outcome_div').hide();
                                    }
                                 });
                             </script>


                             <script type="text/javascript">
                                 $('#com_outcome_status').on('change',function(){
                                    var outcome = $('#com_outcome_status').val();
                                    
                                    if(outcome=="Share With Agencies")
                                    {
                                        $('.agency_outcome_div_com').show();
                                    }else{
                                        $('.agency_outcome_div_com').hide();
                                    }
                                 });
                             </script>


               <script type="text/javascript">
                 $('.cec_create').on('change',function(){
                    $('#cec_form_update').submit();
                    var change = $(this).val();
                    if(change=="Y")
                    {
                        $('.cec_create_div').show();
                        $('.reason_div').hide();
                        $('#cec_member_add').show();
                        $('#cec_add_button').show();
                        
                    }else{
                        $('.cec_create_div').hide();
                        $('.reason_div').show();
                        $('#cec_member_add').hide();
                        $('#cec_add_button').hide();
                    }
                 });
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
             </script>

             <script type="text/javascript">
                 $('#com_final_decision').on('change',function(e){
                    var decision = $('#com_final_decision').val();
                    if(decision=="ND")
                    {
                        $('.new_decision_div').show();
                        $('.cec_decision_old').hide();
                    }else{
                        $('.new_decision_div').hide();
                        $('.cec_decision_old').show();
                    }
                 })

                 $('.cec_decision').on('change',function(e){
                    var cec_id = $(this).data('id');
                    var selectedValue = $(this).val();
                    if(selectedValue=="DD")
                    {
                        $('#cec_sub_decision'+cec_id).show();
                    }else{
                        $('#cec_sub_decision'+cec_id).hide();
                    }
                    
                })

                 $('.com_decision').on('change',function(e){
                    var com_id = $(this).data('id');
                    var selectedValue = $(this).val();
                    if(selectedValue=="DD")
                    {
                        $('#com_sub_decision'+com_id).show();
                    }else{
                        $('#com_sub_decision'+com_id).hide();
                    }
                    
                })
             </script>

             <script type="text/javascript">
                $('.edit_button_all').on('click',function(){
                        $('#allegation_name').val($(this).data('allegation_name'));
                        $('#allegation_description').val($(this).data('allegation_description'));
                        $('#id_all').val($(this).data('id'));
                        $('#exampleModaEdit_all').modal('show');
                    })
            </script>

@endsection