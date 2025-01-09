@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">





        

        {{-- <a href="{{route('action.taken.report',@$action_id)}}" class="btn btn-primary" style="float: right;margin-bottom: 10px;">
                                    Back
        </a> --}}



       <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans">  Evaluation Committee Meeting </div>
                    <div class="card-header" style="font-family:Product Sans"> 

                            <p><b>Complaint Registration No : </b> {{@$complaint->complaintRegNo}}</p>
                            <p><b>Complaint Registration Date : </b> {{@$complaint->complaintDateTime}}</p>
                            <p><b>Complaint Brief : </b> {!!@$complaint->complaintDetails!!}</p>

                            @if(@$data->action_taken=="Y")
                            <div class = "card-body">
                                    <table id  = "maintable" class="table" >
                                        <thead>
                                            <tr>
                                                <th>Entity Type</th>
                                                <th>Name</th>
                                                <th>Action Taken</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                               @if(@$persons->isNotEmpty())
                                               @foreach(@$persons as $value)
                                               <tr>
                                                   <td>{{@$value->type}}</td>
                                                   <td>{{@$value->name}}</td>
                                                   <td>{{@$value->action_taken}}</td>
                                                   
                                                </tr>
                                               @endforeach
                                               @endif            
                                        </tbody>
                                    </table>
                                </div>
                        @endif 

                            <p></p>
                            <p><b>Action Taken ? : </b> @if(@$data->action_taken=="Y") Yes @else No @endif</p>
                            @if(@$data->action_taken=="N")
                            <p><b>Reason : </b> {{@$data->reason}}</p>
                            @endif 

                            <p><b>Letter No : </b> {{@$data->letter_no}}</p>
                            <p><b>Letter Date : </b> {{@$data->letter_date}}</p>

                            <p><b>Attachment : </b> <a class="btn btn-xs btn-info" href="{{URL::to('attachment/action')}}/{{@$data->attach_letter}}" target="_blank"><i class="fa fa-eye"></i>View  </a></p>

                            
                            

                    </div>
             </div>

             <div class="row">
             <div class="col-sm-12">
                    <div class="card">
                            <div class="row" style="font-family:Product Sans">
                                {{-- <div class="col-sm">
                                     Evaluation Committee Meeting
                                </div>
                                <div class="col-sm-12 mt-3">
                                <form method="post" action="{{route('sensitization-report.cec.update.cec.date')}}"> 
                                @csrf
                                <input type="hidden" name="id" value="{{@$id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Date</label>
                                    <input type="date" value="{{@$data->cec_date}}" name="cec_date" id="cec_date" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Time</label>
                                    <input type="time" name="cec_time" value="{{@$data->cec_time}}" id="cec_time" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="cec_venue" value="{{@$data->cec_venue}}" id="cec_venue" class="form-control"  required>
                                </div>
                           

                                <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div> --}}

                                {{-- <div class="col-sm" @if(@$data->cec_create=="Y") style="display:block" @else style="display:none" @endif>
                                    <!-- Button trigger modal -->
                                    
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa3" style="float: right;">
                                        + Add Member
                                    </button>
                                   
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Atr Review CEC Meeting
                                </div>

                               
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    @if(@$data->cec_decision=="")
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa3" style="float: right;">
                                        + Add Member
                                    </button>
                                    @endif
                                   
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
                                        <th>Availability</th>
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

                                                <td>@if(@$att->availability=="AA") Awaiting Approval @elseif(@$att->availability=="Y") Available @else Not Available  @endif</td>


                                                <td>@if(@$att->coi_status=="AA") Awaiting Approval @elseif(@$att->availability=="Y") Yes @else No  @endif</td>

                                                
                                                
                                                <td>
                                                    
                                                    @if(@$att->coi_status!="N")                
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button_person row-class-{{ @$att->id }}"
                                                        data-row-data='{{ @$att->dzoName }}' data-id="{{@$att->id}}" data-eid="{{@$att->user_details->eid}}" data-name="{{@$att->user_details->name}}" 
                                                        data-cid="{{@$att->user_details->cid}}"
                                                        data-department="{{@$att->user_details->department_name->name}}"
                                                        data-role = "{{@$att->role}}"
                                                        data-remarks = "{{@$att->remarks}}"
                                                        data-user_id="{{@$att->user_details->id}}"
                                                        data-toggle="modal"
                                                        >
                                                        <i
                                                            class="fa fa-edit"></i>
                                                    </a>
                                                   

                                                   
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{route('sensitization-report.cec.person.delete.meeting',@$att->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        
                                                    </a>
                                                    @endif

                                                    {{-- <a href="{{route('member.details.on.cases.senstization.details',@$att->id)}}" class="btn btn-xs btn-warning" target="_blank">View More</a> --}}

                                                    
                                                    
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
            <div class="card" style="padding:25px;">
                        <form action="{{route('sensitization-report.cec.update.cec.decision.sensitization')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{@$id}}">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Date</label>
                                    <input type="date" value="{{@$data->cec_date}}" @if(@$members_com_approve>0) disabled @endif name="cec_date" id="cec_date" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Time</label>
                                    <input type="time" name="cec_time" value="{{@$data->cec_time}}" @if(@$members_com_approve>0) disabled @endif id="cec_time" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="cec_venue" value="{{@$data->cec_venue}}" @if(@$members_com_approve>0) disabled @endif id="cec_venue" class="form-control"  required>
                                </div>


                                <div class="form-group">
                                    <label for="label">Decision</label>
                                    <select class="form-control" name="outcome_status" id="outcome_status" @if(@$members_com_approve>0) disabled @endif required>
                                        <option value="">Select</option>
                                        <option value="Accept" @if(@$data->cec_decision=="Accept") selected @endif>Accept</option>
                                        <option value="Defer" @if(@$data->cec_decision=="Defer") selected @endif>Defer</option>
                                        <option value="Need More Information" @if(@$data->cec_decision=="Need More Information") selected @endif>Need More Information</option>
                                        
                                    </select>
                                </div> 


                               


                                <div class="form-group">
                                    <label for="label">Remarks</label>
                                    <textarea type="text" name="cec_remarks" class="form-control"  @if(@$members_com_approve>0) disabled @endif required> {{@$data->cec_remarks}}</textarea>
                                </div>


                                <div class="form-group">
                                    <label for="label">Attachment (Optional)</label>
                                    <input type="file" name="attachment" class="form-control" @if(@$members_com_approve>0) disabled @endif>
                                </div>

                                @if(@$data->cec_attachment!="")
                                    <div class="form-group"> <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/cec')}}/{{$data->cec_attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> </div>
                                @endif

                                @if(@$members_com_approve==0)
                                <div class="form-group"><button class="btn btn-primary" type="submit">Update Decision</button></div>
                                @endif
                             


                             </form>
            </div>
          </div>
          @endif




    

    {{-- commission --}}

{{--     <div class="col-sm-12">
        <div class="card">
                            <div class="col-sm">
                                    Atr Review Comission Meeting
                                </div>
                                <div class="col-sm-12 mt-3">
                                <form method="post" action="{{route('sensitization-report.comission.update.comission.date')}}"> 
                                @csrf
                                <input type="hidden" name="id" value="{{@$id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Comission Date</label>
                                    <input type="date" value="{{@$data->com_date}}" name="com_date" id="com_date" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Comission Time</label>
                                    <input type="time" name="com_time" value="{{@$data->com_time}}" id="com_time" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="com_venue" value="{{@$data->com_venue}}" id="com_venue" class="form-control"  required>
                                </div>
                           

                                <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
    </div> --}}


     @if(@$data->cec_decision!="")
    <div class="col-sm-12">
        <div class="card">

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
                                    @if (@$commision_members->isNotEmpty())
                                        @foreach (@$commision_members as $att)
                                            <tr>
                                                <td>{{ @$att->eid }}</td>
                                                <td>{{ @$att->user_details->name }}</td>
                                                <td>{{ @$att->user_details->department_name->name }}</td>
                                                <td>@if(@$att->role=="MS") Member Secretary @elseif(@$att->role=="CP") Chair Person @else Member  @endif</td>

                                                <td>@if(@$att->availability=="AA") Awaiting Approval @elseif(@$att->availability=="Y") Available @else Not Available  @endif</td>


                                                <td>@if(@$att->coi_status=="AA") Awaiting Approval @elseif(@$att->availability=="Y") Yes @else No  @endif</td>

                                                
                                                
                                                <td>
                                                    
                                                    @if(@$att->coi_status!="N")            
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button_person row-class-{{ @$att->id }}"
                                                        data-row-data='{{ @$att->dzoName }}' data-id="{{@$att->id}}" data-eid="{{@$att->user_details->eid}}" data-name="{{@$att->user_details->name}}" 
                                                        data-cid="{{@$att->user_details->cid}}"
                                                        data-department="{{@$att->user_details->department_name->name}}"
                                                        data-role = "{{@$att->role}}"
                                                        data-remarks = "{{@$att->remarks}}"
                                                        data-user_id="{{@$att->user_details->id}}"
                                                        data-toggle="modal"
                                                        >
                                                        <i
                                                            class="fa fa-edit"></i>
                                                    </a>
                                                   

                                                   
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{route('action-taken-report.cec.person.delete.meeting',@$att->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        
                                                    </a>

                                                    @endif

                                                    <a href="{{route('member.details.on.cases.senstization.details',@$att->id)}}" class="btn btn-xs btn-warning" target="_blank">View More</a>
                                                    
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
            <div class="card" style="padding:25px;">
                        <form action="{{route('sensitization-report.com.update.com.decision.sensitization')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{@$id}}">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commission Date</label>
                                    <input type="date" value="{{@$data->com_date}}"  name="com_date" id="com_date" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commission Time</label>
                                    <input type="time" name="com_time" value="{{@$data->com_time}}"  id="com_time" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="com_venue" value="{{@$data->com_venue}}"  id="com_venue" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="label">Commission Decision</label>
                                    <select class="form-control" name="com_status" id="com_final_decision"  required>
                                        <option value="">Select</option>
                                        <option value="ECD" @if(@$data->com_status=="ECD") selected @endif>Endorse CEC Decision</option>
                                        <option value="ND" @if(@$data->com_status=="ND") selected @endif>New Decision</option>
                                    </select>
                                </div>


                                <div class="new_decision_div" @if(@$data->com_status=="ND") style="display:block;" @else  style="display:none;" @endif>


                                <div class="form-group">
                                    <label for="label">Decision</label>
                                    <select class="form-control" name="com_decision" id="outcome_status" >
                                        <option value="">Select</option>
                                        <option value="Accept" @if(@$data->com_decision=="Accept") selected @endif>Accept</option>
                                        <option value="Defer" @if(@$data->com_decision=="Defer") selected @endif>Defer</option>
                                        <option value="Need More Information" @if(@$data->com_decision=="Need More Information") selected @endif>Need More Information</option>
                                        
                                    </select>
                                </div> 


                               


                                <div class="form-group">
                                    <label for="label">Remarks</label>
                                    <textarea type="text" name="com_remarks" class="form-control"  > {{@$data->com_remarks}}</textarea>
                                </div>


                                <div class="form-group">
                                    <label for="label">Attachment (Optional)</label>
                                    <input type="file" name="com_attachment " class="form-control">
                                </div>

                                @if(@$data->com_attachment  !="")
                                    <div class="form-group"> <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/cec')}}/{{$data->com_attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> </div>
                                @endif
                            </div>

                               
                             <div class="form-group"><button class="btn btn-primary" type="submit">Update Commission Decision</button></div>


                             </form>
            </div>
          </div>
          @endif




    </div>
               
       
</section>



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
                            <form method="post" action="{{ route('sensitization-report.cec.person.add.meeting') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="atr_id" value="{{@$id}}">
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

            {{-- edit --}}

            <div class="modal fade" id="exampleModa3_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Edit Committee Members</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('sensitization-report.cec.person.update.meeting') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="atr_id" value="{{@$id}}">
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
                            <form method="post" action="{{ route('sensitization-report.cec.person.add.meeting') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="atr_id" value="{{@$id}}">
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
                                    <select class="form-control" name="role_commision" required>
                                        <option value="">Select</option>
                                        <option value="MS">Member Secretary</option>
                                        <option value="CP">Chair Person</option>
                                        <option value="M">Member</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea name="remarks_commision" class="form-control"></textarea>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
                    }else{
                        $('.new_decision_div').hide();
                    }
                 })
             </script>

@endsection