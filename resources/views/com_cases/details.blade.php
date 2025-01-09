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
          <a class="nav-link active btn btn-info" href="{{route('commission-cases.listing.details',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('commission-cases.listing.details.attachment',['id'=>@$id])}}">Attachment Details</a>
        </li>

         <li class="nav-item">
          <a class="nav-link"  href="{{route('commission-casescase-details.listing.details.financial-implication-details',['id'=>@$id])}}">Financial Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link"  href="{{route('commission-casescase-details.listing.details.social-implication-details',['id'=>@$id])}}">Social Implication</a>
        </li>

        
        <li class="nav-item">
          <a class="nav-link" href="{{route('commission-casescase-details.listing.details.person-involved-details',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('commission-casescase-details.listing.details.case-link-details',['id'=>@$id])}}">Link Case</a>
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


{{--                 <div class="col-sm-6">
                    <div class="card">
                        @php
                        $score = (int)@$score->mode_of_complaint+(int)@$score->identity_of_accused+(int)@$score->location+(int)@$score->witness+(int)@$score->evidense+(int)@$score->finance+(int)@$score->social;
                        @endphp
                        <p><b>System Scoring:</b> {{@$score}}</p>
                        <p>
                            
                            <form method="post" action="{{route('ces.cases.listing.member.score.update')}}">
                                @csrf
                                <input type="hidden" name="complaintID" value="{{@$data->complaintID}}">
                                <div class="form-group">
                                    <label for="label">Update Your Score</label>
                                    <input type="text" name="score" class="form-control" value="{{@$given_score->scoring}}" required>
                                </div>
                                <div class="form-group"><button class="btn btn-primary">Submit</button></div>
                            </form>

                        </p>
                    </div>
                </div> --}}



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
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Complaint Evaluation CEC Members
                                </div>

                                {{-- <div class="col-sm-12 mt-3">
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
                            </div> --}}

                                
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
                                        {{-- <th>Score</th>
                                        <th>Outcome</th>
                                        <th>View</th> --}}
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
                                                {{-- <td>@if(@$att->scoring=="") --  @else {{@$att->scoring}} @endif</td>
                                                <td>@if(@$att->outcome_status!=""){{@$att->outcome_status}} @if(@$att->outcome_status=="Share With Agencies") ({{@$att->agency_outcome}}) @endif @else -- @endif</td>
                                                <td><a href="{{route('case.details.member.view.more',@$att->id)}}" class="btn btn-warning" target="_blank">View More</a></td> --}}
                                                
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


    @if(@$data->outcome_status!="")
              <div class="col-sm-12">
                            <div class="card">
                            <div class="row" style="font-family:Product Sans">
                                        <div class="col-sm">
                                   <h4>CEC Recommendation</h4>
                                </div>
                            </div>

                            <p><b>Recommendation Status :</b> {{@$data->outcome_status}} @if(@$data->outcome_status=="Share With Agencies") ({{@$data->agency_outcome}}) @endif</p>
                            <p><b>Remarks :</b> {{@$data->final_remark}}</p>
                             <p><b>Attachment :</b> 
                                <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/cec')}}/{{$data->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a></p>
                        </div>
                    </div>
                    @endif



        {{-- commision-meeting --}}
                     <div class="col-sm-12">
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Complaint Evaluation Commission Members
                                </div>

                                {{-- <div class="col-sm-12 mt-3">
                                    @if(@$data->com_date=="" && @$data->com_time=="" && @$data->com_venue=="")
                                    <p class="btn btn-warning">Please add  Date, Time,Venue first then add memebers. </p>
                                    @endif
                                <form method="post" action="{{route('add.member.evaluation.update.location.commision')}}"> 
                                    @csrf
                                    <input type="hidden" name="complaintID" value="{{@$id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commision Date</label>
                                    <input type="date" value="{{@$data->com_date}}" name="com_date" id="com_date" class="form-control"  readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Commision Time</label>
                                    <input type="time" name="com_time" value="{{@$data->com_time}}" id="com_time" class="form-control"  readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="com_venue" value="{{@$data->com_venue}}" id="com_venue" class="form-control"  readonly>
                                </div>

                                
                                </form>
                            </div> --}}

                                
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
                                        {{-- <th>Scoring</th> --}}
                                        
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

                                                {{-- <td>@if(@$att->scoring=="") -- @else {{@$att->scoring}} @endif</td> --}}
                                                
                                                
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

@endsection