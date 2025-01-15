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
                    <p><b>Complaint No:</b> {{@$monetary_details->eve_offence_details->complaint_details->complaintRegNo}}</p>

                    <p><b>Complaint Title:</b> {{@$monetary_details->eve_offence_details->complaint_details->complaintTitle}}</p>



                    <p><b>Date Time:</b> {{@$monetary_details->eve_offence_details->complaint_details->complaintDateTime}}</p>

                    <p><b>Offence Name :</b> {{@$monetary_details->eve_offence_details->allegation_name}}</p>
                    <p><b>Offence Description :</b> {{@$monetary_details->eve_offence_details->allegation_description}}</p>
                   

                    
               </div>
                   
            </div>

            <div class="col-sm-12">
                    <div class="card">
                        <p><b>Complaint Details:</b> {{@$monetary_details->eve_offence_details->complaint_details->complaintDetails}}</p>
                    </div>
                </div>


                <div class="col-sm-12">
                  <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Monetary Fine </div>
                        <div class = "card-body">
                            <table id  = "maintable" class="table" >
                               <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>CID/Permit No.</th>
                                        <th>Name / Agency Name</th>
                                        <th>Amount</th>
                                        <th>Remarks</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$details->isNotEmpty())
                                       @foreach(@$details as $value)
                                       <tr>
                                           <td>@if(@$value->category_id=="IND") Individual @else Agency @endif </td>
                                           <td>{{@$value->cid_permit}}</td>
                                           <td>{{@$value->name}}</td>
                                           <td>{{@$value->amount}}</td>
                                           <td>{{@$value->remarks}}</td>
                                           
                                           <td>
                                            
                                              <a type="button"
                                              class="btn btn-xs btn-primary edit_button_person row-class-{{ @$att->id }}"
                                                        data-row-data='{{ @$value->dzoName }}' data-id="{{@$value->id}}" data-category_id="{{@$value->category_id}}" data-cid_permit="{{@$value->cid_permit}}"
                                                         data-name="{{@$value->name}}" 
                                                        data-amount="{{@$value->amount}}"
                                                        data-department="{{@$value->user_details->department_name->name}}"
                                                        data-remarks = "{{@$value->remarks}}"
                                                        data-toggle="modal"
                                                        >
                                                        View
                                                    </a>
                                                    <a type="button"
                                                      class="btn btn-xs btn-success edit_button_payment row-class-{{ @$att->id }}"
                                                                data-row-data='{{ @$value->dzoName }}' data-id="{{@$value->id}}" data-category_id="{{@$value->category_id}}" data-cid_permit="{{@$value->cid_permit}}"
                                                                 data-name="{{@$value->name}}" 
                                                                data-amount="{{@$value->amount}}"
                                                                data-department="{{@$value->user_details->department_name->name}}"
                                                                data-remarks = "{{@$value->remarks}}"
                                                                data-receipt_date = "{{@$value->receipt_date}}"
                                                                data-receipt_no = "{{@$value->receipt_no}}"
                                                                data-remarks = "{{@$value->remarks}}"


                                                                data-toggle="modal"
                                                                >
                                                        Payment
                                                    </a>


                                            
                                           </td>

                                       </tr>
                                       @endforeach
                                       @endif            
                                </tbody>
                            </table>
                        </div>
                </div>
                </div>

                <div class="col-sm-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Monitory Fine Report </div>

                        <div class = "card-body">
                            <form action="{{route('monetary.fine.view.details.page.chief.update.monitory.fine.decision')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="monetary_id" value="{{@$monetary_id}}">
                                @if(@$monetary_details->admin_report_attachment!="")
                                <div class="form-group">
                                    <a href="{{URL::to('attachment/information_enrichment')}}/{{$monetary_details->admin_report_attachment}}" class="btn btn-xs btn-primary" target="_blank">See Attachment</a>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label>Report Remarks</label>
                                    <textarea type="text" name="admin_report_remarks" disabled class="form-control">{{@$monetary_details->admin_report_remarks}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Report Approval Status</label>
                                    <select class="form-control" name="admin_approval_status_chief">
                                        <option value="AA" @if(@$monetary_details->admin_approval_status_chief=="AA") selected @endif>Awaiting</option>
                                        <option value="A" @if(@$monetary_details->admin_approval_status_chief=="A") selected @endif>Approve</option>
                                        <option value="R" @if(@$monetary_details->admin_approval_status_chief=="R") selected @endif>Reject</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Chief Remarks</label>
                                    <textarea type="text" name="admin_approval_remarks_chief"  class="form-control">{{@$monetary_details->admin_approval_remarks_chief}}</textarea>
                                </div>

                                <div class="form-group"><button type="submit" class="btn btn-primary">Submit</button></div>
                            </form>
                        </div>
                    </div>
                </div>




                <div class="col-sm-12">
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    CEC Committee
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
                                    @if (@$cec_members->isNotEmpty())
                                        @foreach (@$cec_members as $att)
                                            <tr>
                                                <td>{{ @$att->eid }}</td>
                                                <td>{{ @$att->user_details->name }}</td>
                                                <td>{{ @$att->user_details->department_name->name }}</td>
                                                <td>@if(@$att->role=="MS") Member Secretary @elseif(@$att->role=="CP") Chair Person @else Member  @endif</td>

                                                <td>@if(@$att->coi_status=="AA") Awaiting Approval @elseif(@$att->coi_status=="Y") Yes @else No  @endif</td>

                                                
                                                
                                                <td>
                                                    
                                                    @if(@$att->coi_status!="N")        
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button_cec row-class-{{ @$att->id }}"
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
                                                        href="{{route('monetary.fine.view.details.page.chief.delete.cec.member.data',@$att->id)}}"
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


                

                <div class="col-sm-12">
                        <div class="card">
                            <form action="{{route('monetary.fine.view.details.page.chief.insert.cec.member.update.decision')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{@$id}}">
                                <div class="row">
                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC  Date</label>
                                    <input type="date" value="{{@$data->cec_date}}"  name="cec_date" id="cec_date" class="form-control" required>
                                </div>
                              </div>

                                <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC  Time</label>
                                    <input type="time" name="cec_time" value="{{@$data->cec_time}}"  id="cec_time" class="form-control" required >
                                </div>
                                </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Venue</label>
                                    <input type="text" name="cec_venue" value="{{@$data->cec_venue}}"  id="cec_venue" class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Recommendation Status</label>
                                    <select class="form-control" name="cec_decision">
                                        <option value="">Select</option>
                                        <option value="ADS" @if(@$data->cec_decision=="ADS") selected @endif>Administration Disciplinery Sanction</option>
                                        <option value="MF" @if(@$data->cec_decision=="MF") selected @endif>Monetary Fine</option>
                                        <option value="REC" @if(@$data->cec_decision=="REC") selected @endif>Recoveries</option>
                                        <option value="SC" @if(@$data->cec_decision=="SC") selected @endif>Systemic Correction</option>
                                        <option value="CI" @if(@$data->cec_decision=="CI") selected @endif>Criminal Investigation</option>
                                        <option value="SEN" @if(@$data->cec_decision=="SEN") selected @endif>Sensitive</option>
                                        <option value="REV" @if(@$data->cec_decision=="REV") selected @endif>Revert</option>
                                        <option value="CLOSE" @if(@$data->cec_decision=="CLOSE") selected @endif>Close</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Remarks</label>
                                    <textarea type="text" name="cec_remarks" id="cec_venue" class="form-control" >{{@$data->cec_remarks}}</textarea>
                                </div>
                               
                                <div class="form-group"><button type="submit" class="btn btn-primary">Save Decision</button></div>
                               


                                </form>
                                </div> 
                    </div>




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
                                                        class="btn btn-xs btn-primary edit_button_cec row-class-{{ @$att->id }}"
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
                                                        href="{{route('monetary.fine.view.details.page.chief.delete.cec.member.data',@$att->id)}}"
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


            
                <div class="col-sm-12">
            <div class="card" style="padding:25px;">
                        <form action="{{route('monetary.fine.view.details.page.chief.insert.commission.member.update.decision')}}" enctype="multipart/form-data" method="POST">
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
                                        <option value="ADS" @if(@$data->com_decision=="ADS") selected @endif>Administration Disciplinery Sanction</option>
                                        <option value="MF" @if(@$data->com_decision=="MF") selected @endif>Monetary Fine</option>
                                        <option value="REC" @if(@$data->com_decision=="REC") selected @endif>Recoveries</option>
                                        <option value="SC" @if(@$data->com_decision=="SC") selected @endif>Systemic Correction</option>
                                        <option value="CI" @if(@$data->com_decision=="CI") selected @endif>Criminal Investigation</option>
                                        <option value="SEN" @if(@$data->com_decision=="SEN") selected @endif>Sensitive</option>
                                        <option value="REV" @if(@$data->com_decision=="REV") selected @endif>Revert</option>
                                        <option value="CLOSE" @if(@$data->com_decision=="CLOSE") selected @endif>Close</option>
                                        
                                    </select>
                                </div> 
                            </div>


                               


                                <div class="form-group">
                                    <label for="label">Remarks</label>
                                    <textarea type="text" name="com_remarks" class="form-control"  > {{@$data->com_remarks}}</textarea>
                                </div>

                                <div class="form-group"><button class="btn btn-primary" type="submit">Update Commission Decision</button></div>


                             </form>
            </div>
          </div>

            




































            <div class="modal fade" id="exampleModa3_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">View Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="#" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Users</label>
                                    <select class="form-control" name="category_id" id="category_id_edit" disabled>
                                        <option value="">Select Category</option>
                                        <option value="IND">Individual</option>
                                        <option value="AGC">Agency</option>
                                    </select>
                                </div>

                                <div class="form-group" id="indi_div_edit">
                                    <label for="exampleInputEmail1">CID/Permit No</label>
                                    <input type="text" name="cid_permit" id="cid_permit"  disabled class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1" id="name_label_edit">Name</label>
                                    <input type="text" name="name" id="name"  disabled class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Amount</label>
                                    <input type="text" name="amount" id="amount" disabled class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea name="remarks" id="remarks" disabled class="form-control"></textarea>
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


            <div class="modal fade" id="exampleModa3_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Payment Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="#" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="id" id="id_payment">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Users</label>
                                    <select class="form-control" name="category_id" id="category_id_payment" disabled>
                                        <option value="">Select Category</option>
                                        <option value="IND">Individual</option>
                                        <option value="AGC">Agency</option>
                                    </select>
                                </div>

                                <div class="form-group" id="indi_div_payment">
                                    <label for="exampleInputEmail1">CID/Permit No</label>
                                    <input type="text" name="cid_permit" id="cid_permit_payment" disabled class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1" id="name_label_payment">Name</label>
                                    <input type="text" name="name" id="name_payment"  class="form-control"disabled >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Amount</label>
                                    <input type="text" name="amount" id="amount_payment"disabled class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea name="remarks" id="remarks_payment"disabled class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Receipt Date</label>
                                    <input type="date" name="receipt_date" id="receipt_date" disabled required class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Receipt no</label>
                                    <input type="text" name="receipt_no" id="receipt_no" disabled required class="form-control">
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
                            <form method="post" action="{{ route('monetary.fine.view.details.page.chief.insert.cec.member') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="monetory_id" value="{{@$id}}">
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

            <div class="modal fade" id="exampleModa3_edit_cec" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
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
                            <form method="post" action="{{ route('monetary.fine.view.details.page.chief.update.cec.member') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="monetory_id" value="{{@$id}}">
                                <input type="hidden" name="member_id" id="member_id">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Users</label>
                                    <select class="form-control" name="user_id" disabled id="user_id_edit"  required>
                                        <option value="">Select User</option>
                                        @foreach(@$all_users as $value)
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
                            <form method="post" action="{{ route('monetary.fine.view.details.page.chief.insert.cec.member') }}" enctype="multipart/form-data">@csrf
                                 <input type="hidden" name="monetory_id" value="{{@$monetary_id}}">
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
        $('.edit_button_person').on('click',function(){
                    $('#category_id_edit').val($(this).data('category_id')).attr("selected", "selected");
                    $('#cid_permit').val($(this).data('cid_permit'));
                    $('#name').val($(this).data('name'));
                    $('#amount').val($(this).data('amount'));
                    $('#remarks').val($(this).data('remarks'));
                    $('#id').val($(this).data('id'));

                    var text = $(this).data('category_id');
                    if(text=="IND")
                    {
                        $('#indi_div_edit').show();
                        $('#name_label_edit').text('Name');
                    }else{
                        $('#indi_div_edit').hide();
                        $('#name_label_edit').text('Agency Name');
                    }


                    $('#exampleModa3_edit').modal('show');
                    
                })

        $('.edit_button_payment').on('click',function(){
                    $('#category_id_payment').val($(this).data('category_id')).attr("selected", "selected");
                    $('#cid_permit_payment').val($(this).data('cid_permit'));
                    $('#name_payment').val($(this).data('name'));
                    $('#amount_payment').val($(this).data('amount'));
                    $('#remarks_payment').val($(this).data('remarks'));
                    $('#id_payment').val($(this).data('id'));

                    $('#receipt_date').val($(this).data('receipt_date'));
                    $('#receipt_no').val($(this).data('receipt_no'));

                    var text = $(this).data('category_id');
                    if(text=="IND")
                    {
                        $('#indi_div_payment').show();
                        $('#name_label_payment').text('Name');
                    }else{
                        $('#indi_div_payment').hide();
                        $('#name_label_payment').text('Agency Name');
                    }


                    $('#exampleModa3_payment').modal('show');
                    
                })


        $('.edit_button_cec').on('click',function(){
                    $('#user_id_edit').val($(this).data('user_id')).attr("selected", "selected");
                    $('#eid_edit').val($(this).data('eid'));
                    $('#cid_edit').val($(this).data('cid'));
                    $('#department_edit').val($(this).data('department'));
                    $('#role_edit').val($(this).data('role')).attr("selected", "selected");
                    $('#remarks_edit').val($(this).data('remarks'));
                    $('#member_id').val($(this).data('id'));
                    $('#user_edit_edit').val($(this).data('user_id'));
                    $('#exampleModa3_edit_cec').modal('show');
                    
                })

        $('#user_change_add_cec').on('change',function(){
            var text = $('#user_change_add_cec').val();
            if(text=="IND")
            {
                $('#indi_div').show();
                $('#name_label').text('Name');
            }else{
                $('#indi_div').hide();
                $('#name_label').text('Agency Name');
            }
        })

        $('#user_change_add_com').on('change',function(){
                    $('#cid_commision').val($("#user_change_add_com option:selected").attr('data-eid'));
                    $('#eid_commision').val($("#user_change_add_com option:selected").attr('data-cid'));
                    $('#department_commision').val($("#user_change_add_com option:selected").attr('data-department'));
                 })

        $('#user_change_add_cec').on('change',function(){
                    $('#eid').val($("#user_change_add_cec option:selected").attr('data-eid'));
                    $('#cid').val($("#user_change_add_cec option:selected").attr('data-cid'));
                    $('#department').val($("#user_change_add_cec option:selected").attr('data-department'));
                 })
    </script>


@endsection