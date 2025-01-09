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
          <a class="nav-link active btn btn-info" href="{{route('ces.cases.listing.details',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('ces.cases.listing.details.attachment',['id'=>@$id])}}">Attachment Details</a>
        </li>

         <li class="nav-item">
          <a class="nav-link"  href="{{route('ces.cases.listing.details.financial-implication-details',['id'=>@$id])}}">Financial Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link"  href="{{route('ces.cases.listing.details.social-implication-details',['id'=>@$id])}}">Social Implication</a>
        </li>

        
        <li class="nav-item">
          <a class="nav-link" href="{{route('ces.cases.listing.details.person-involved-details',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('ces.cases.listing.details.case-link-details',['id'=>@$id])}}">Link Case</a>
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
                        $total_score = (int)@$score->mode_of_complaint+(int)@$score->identity_of_accused+(int)@$score->location+(int)@$score->witness+(int)@$score->evidense+(int)@$score->finance+(int)@$score->social;

                        $complaint_score = (int)@$score->mode_of_complaint+(int)@$score->identity_of_accused+(int)@$score->location+(int)@$score->witness+(int)@$score->evidense;


                        $finance_score = (int)@$score->finance;
                        $social_score =  (int)@$score->social;
                        @endphp
                        <div class="col-sm">
                                    System Scoring Details
                        </div>

                        <p class="mt-3"><b>Complaint Details : {{@$complaint_score}}</b></p>
                        <p><b>Financial Implication : {{@$finance_score}}</b></p>
                        <p><b>Social Implication : {{@$social_score}}</b></p>
                        <p><b>Total System Score : {{@$total_score}}</b></p>

                        <p><b>System Outcome : @if(@$total_score>=1 && @$total_score<=24) Drop @elseif(@$total_score>=25 && @$total_score<=29) Discreet Enquiry or Share with Agencies @elseif(@$total_score>29) Investigate @else No Score No Outcome @endif</b></p>
                        
                 </div>
             </div>



{{--                 <div class="col-sm-12" >
                    <div class="card">
                        
                        <div class="col-sm">
                                    Update Your Score
                        </div>

                       
                        <p>
                            
                            <form method="post" action="{{route('ces.cases.listing.member.score.update')}}">
                                @csrf

                                    <label class="radio-inline">
                                  <input type="radio" name="score_create" class="score_create" value="Y" @if(@$given_score->score_create=="Y")checked @endif>Create Scoring
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="score_create" class="score_create" value="N" @if(@$given_score->score_create=="N")checked @endif>Deffer
                                </label>
                                

                                <input type="hidden" name="complaintID" value="{{@$data->complaintID}}">

                                <div class="scoring_div" @if(@$given_score->score_create=="Y") style="display:block" @else style="display:none" @endif>
                                <div class="form-group">
                                    <label for="label">Complaint Details Score</label>
                                    <input type="number" name="complaint_score" class="form-control" value="{{@$given_score->complaint_score}}" >
                                </div>

                                <div class="form-group">
                                    <label for="label">Financial Implication Score</label>
                                    <input type="number" name="finance_score" class="form-control" value="{{@$given_score->finance_score}}" >
                                </div>

                                <div class="form-group">
                                    <label for="label">Social Implication Score</label>
                                    <input type="number" name="social_score" class="form-control" value="{{@$given_score->social_score}}" >
                                </div>
                              </div>

                              <div class="reason_div" @if(@$given_score->score_create=="Y") style="display:none" @else style="display:block" @endif>
                                <div class="form-group">
                                    <label for="label">Reason</label>
                                    <textarea type="text" name="reason_not_create" class="form-control" > {{@$given_score->reason_not_create}} </textarea>
                                </div>
                              </div>




                                <div class="form-group"><button class="btn btn-primary">Submit</button></div>
                            </form>

                             @if(@$given_score->scoring>0 && @$given_score->score_create=="Y")
                             <p><b>Total Given Score : {{@$given_score->scoring}}</b></p>
                             @endif
                             



                             @if(@$given_score->scoring>0 && @$given_score->score_create=="Y")

                             <form action="{{route('update.outcome.decision.cec.cases')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="complaintID" value="{{@$data->complaintID}}">
                                <div class="form-group">
                                    <label for="label">Outcome Status</label>
                                    <select class="form-control" name="outcome_status" id="outcome_status" required>
                                        <option value="">Select</option>
                                        <option value="Investigate" @if(@$given_score->outcome_status=="Investigate") selected @endif>Investigate</option>
                                        <option value="Discreet Enquiry" @if(@$given_score->outcome_status=="Discreet Enquiry") selected @endif>Discreet Enquiry</option>
                                        <option value="Share With Agencies" @if(@$given_score->outcome_status=="Share With Agencies") selected @endif>Share With Agencies</option>
                                        <option value="Drop" @if(@$given_score->outcome_status=="Drop") selected @endif>Drop</option>
                                    </select>
                                </div> 


                                <div class="form-group agency_outcome_div"  @if(@$given_score->outcome_status=="Share With Agencies") style="display:block" @else  style="display:none" @endif>
                                    <select class="form-control" name="agency_outcome" id="agency_outcome" >
                                        <option value="">Select</option>
                                        <option value="For Action" @if(@$given_score->agency_outcome=="For Action") selected @endif>For Action</option>
                                        <option value="Sensitization" @if(@$given_score->agency_outcome=="Sensitization") selected @endif>Sensitization</option>
                                     </select>
                                </div> 


                                <div class="form-group">
                                    <label for="label">Remarks</label>
                                    <textarea type="text" name="final_remark" class="form-control"  required> {{@$given_score->final_remark}}</textarea>
                                </div>


                                <div class="form-group">
                                    <label for="label">Attachment (Optional)</label>
                                    <input type="file" name="attachment" class="form-control">
                                </div>

                                @if(@$given_score->attachment!="")
                                    <div class="form-group"> <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/cec')}}/{{$given_score->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> </div>
                                @endif

                                <div class="form-group"><button class="btn btn-primary" type="submit">Update Outcome</button></div>
                             


                             </form>

                             

                             @endif

                        </p>
                    </div>
                </div> --}}
                </div>
            </div>
        </div>




                 <div class="col-sm-12">
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Complaint Enrichment
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                    
                                   
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
                    {{-- <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Complaint Evaluation Committee Meeting
                                </div>

                                <div class="col-sm-12 mt-3">
                                    @if(@$data->cec_date=="" && @$data->cec_time=="" && @$data->cec_venue=="")
                                    <p class="btn btn-warning">Please add CEC Date,CEC Time,Venue first then add memebers. </p>
                                    @endif
                                <form method="post" action="{{route('add.member.evaluation.update.location')}}"> 
                                    @csrf
                                    <input type="hidden" name="complaintID" value="{{@$id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Date</label>
                                    <input type="date" value="{{@$data->cec_date}}" name="cec_date" id="cec_date" class="form-control"  required readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEC Time</label>
                                    <input type="time" name="cec_time" value="{{@$data->cec_time}}" id="cec_time" class="form-control"  required readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="cec_venue" value="{{@$data->cec_venue}}" id="cec_venue" class="form-control"  required readonly>
                                </div>
                               </form>
                            </div>

                                
                            </div> --}}
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
                                        {{-- <th>Score</th> --}}
                                        
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


                                                <td>@if(@$att->coi_status=="AA") Awaiting Approval @elseif(@$att->availability=="Y") Yes @else No  @endif</td>
                                                {{-- <td>@if(@$att->scoring=="") --  @else {{@$att->scoring}} @endif</td> --}}
                                                
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
                 $('.score_create').on('change',function(){
                    var change = $(this).val();
                    if(change=="Y")
                    {
                        $('.scoring_div').show();
                        $('.reason_div').hide();
                    }else{
                        $('.scoring_div').hide();
                        $('.reason_div').show();
                    }
                 });
             </script>                
@endsection