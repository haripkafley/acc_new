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
       
      </ul>



        
            <div class="row">
              


                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Complaint No:</b> {{@$complaint->complaintRegNo}}</p>

                    <p><b>Complaint TItle:</b> {{@$complaint->complaintTitle}}</p>

                    <p><b>Complaint Date Time:</b> {{@$complaint->complaintDateTime}}</p>
                    <p><b>Offence Name:</b> {{@$offence_details->offence_name->offence_type}}</p>
                </div>
                   
            </div>


            <div class="col-sm-6">
                    <div class="card">
                    <p><b>Action Letter No:</b> {{@$action_details->letter_no}}</p>

                    <p><b>Action Letter Date:</b> {{@$action_details->letter_date}}</p>

                    <p><b>Action Brief:</b> {{@$action_details->description_action}}</p>

                </div>
                   
            </div>

            <div class="col-sm-12">
                    <div class="card">
                    <p><b>ATR Letter No:</b> {{@$data->letter_no}}</p>

                    <p><b>ATR Letter Date:</b> {{@$data->letter_date}}</p>
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
                           

                           <p><b>Attachment : </b> <a class="btn btn-xs btn-info" href="{{URL::to('attachment/action')}}/{{@$data->attach_letter}}" target="_blank"><i class="fa fa-eye"></i>View  </a></p>
                  </div>
                   
            </div>


            

             

                
         <div class="col-sm-12">  
            <div class="card">
                <div class="col-sm">
                                    CEC Members
                                </div>
                                <div class="card-body" >
                            


                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        
                                        <th>EID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Availability</th>
                                        <th>COI Status</th>
                                        {{-- <th>Action</th> --}}
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
                                                {{-- <td><a href="{{route('member.details.on.cases.action-senstization',@$att->id)}}" class="btn btn-primary" target="_blank">View More</a></td> --}}

                                                
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



          {{-- comission-members --}}
          @if(@$type=="com")
            <div class="col-sm-12">  
            <div class="card">
                <div class="col-sm">
                                    Comission Members
                                </div>
                                <div class="card-body" >
                            


                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        
                                        <th>EID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Availability</th>
                                        <th>COI Status</th>
                                        {{-- <th>Action</th> --}}
                                     </tr>
                                </thead>
                                <tbody>
                                    @if (@$comission->isNotEmpty())
                                        @foreach (@$comission as $att)
                                            <tr>
                                                <td>{{ @$att->eid }}</td>
                                                <td>{{ @$att->user_details->name }}</td>
                                                <td>{{ @$att->user_details->department_name->name }}</td>
                                                <td>@if(@$att->role=="MS") Member Secretary @elseif(@$att->role=="CP") Chair Person @else Member  @endif</td>

                                                <td>@if(@$att->availability=="AA") Awaiting Approval @elseif(@$att->availability=="Y") Available @else Not Available  @endif</td>


                                                <td>@if(@$att->coi_status=="AA") Awaiting Approval @elseif(@$att->availability=="Y") Yes @else No  @endif</td>

                                                {{-- <td><a href="{{route('member.details.on.cases.action-senstization',@$att->id)}}" class="btn btn-primary" target="_blank">View More</a></td>
 --}}
                                                
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



{{--           <div class="col-sm-12">
            <div class="card">
                        <form action="{{route('action.review.assign.committee.list.case.details.update.decision')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{@$id}}">
                                <div class="form-group">
                                    <label for="label">Decision</label>
                                    <select class="form-control" name="outcome_status" id="outcome_status" required>
                                        <option value="">Select</option>
                                        <option value="Accept" @if(@$details->outcome_status=="Accept") selected @endif>Accept</option>
                                        <option value="Defer" @if(@$details->outcome_status=="Defer") selected @endif>Defer</option>
                                        <option value="Need More Information" @if(@$details->outcome_status=="Need More Information") selected @endif>Need More Information</option>
                                        
                                    </select>
                                </div> 


                               


                                <div class="form-group">
                                    <label for="label">Remarks</label>
                                    <textarea type="text" name="final_remark" class="form-control"  required> {{@$details->final_remark}}</textarea>
                                </div>


                                <div class="form-group">
                                    <label for="label">Attachment (Optional)</label>
                                    <input type="file" name="attachment" class="form-control">
                                </div>

                                @if(@$details->attachment!="")
                                    <div class="form-group"> <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/cec')}}/{{$details->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> </div>
                                @endif

                                <div class="form-group"><button class="btn btn-primary" type="submit">Update Decision</button></div>
                             


                             </form>
            </div>
          </div> --}}









                






               
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   

    <script type="text/javascript">
        $('input[type=radio][name=evaluation]').on('change', function() {
          var evaluation =  $(this).val();
           if(evaluation=="Y")
           {
             $('.describe').show();
           }else{
            $('.describe').hide();
           } 
        });
    </script>


@endsection