@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> 
                        {{-- Embassy List --}}
                        <div class="row" style="font-family:Product Sans">
                            <div class="col-sm">
                              Tacktical Request
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add TI Request
                                </button>
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('ip_details.member_navbar')
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>TI Type</th>
                                        <th>Request Type</th>
                                        <th>Suspect Details</th>
                                        <th>In Relation To</th>
                                        <th>Requesting Officer</th>
                                        <th>Request Date</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Recomendation Status</th>
                                        <th>Commission Status</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$tacktical->isNotEmpty())
                                    @foreach(@$tacktical as $att)
                                    <tr>
                                        <td>@if(@$att->type_ti=="IG") Information Gathering @else Surveillance @endif </td>
                                        <td>{{ @$att->request_type_details->name }}</td>
                                        <td>{{ @$att->suspect_details }}</td>
                                        <td>{{ @$att->relation_to }}</td>
                                        <td>{{ @$att->officer_details->name }}</td>
                                        <td>{{ @$att->request_date }}</td>
                                        <td>{{ @$att->start_date }}</td>
                                        <td>{{ @$att->end_date }}</td>
                                        <td>@if($att->recommend_date=="")Awaiting Approval @else Approved @endif</td>
                                        <td>@if($att->com_decision=="")Awaiting Approval @elseif($att->com_decision=="AP") Approved @elseif($att->com_decision=="DF") Deferred @elseif($att->com_decision=="RJ") Rejected @endif</td>
                                        <td>
                                                        
                                               <a class="btn btn-xs btn-warning edit_button" 
                                                                data-id="{{$att->id}}"
                                                                data-type_ti="{{$att->type_ti}}"
                                                                data-request_type="{{$att->request_type}}"
                                                                data-reason="{{$att->reason}}"
                                                                data-suspect_details="{{$att->suspect_details}}"
                                                                data-relation_to="{{$att->relation_to}}"
                                                                data-requesting_officer="{{$att->requesting_officer}}"

                                                                data-request_date="{{$att->request_date}}"

                                                                data-start_date="{{$att->start_date}}"
                                                                data-recom="{{$att->recommend_date}}"
                                                                data-end_date="{{$att->end_date}}"


                                                                data-arrest_type="{{$att->arrest_type}}"
                                                                data-corruption="{{$att->corruption}}"
                                                                data-focal_name="{{$att->focal_name}}"
                                                                data-focal_dept="{{$att->focal_dept}}"
                                                                data-focal_designation="{{$att->focal_designation}}"


                                                                data-activity_nature="{{$att->activity_nature}}"
                                                                data-activity_location="{{$att->activity_location}}"
                                                                data-activity_other="{{$att->activity_other}}"

                                                                data-toggle="modal"


                                               ><i class="fa fa-edit"></i>
                                                </a>

                                                @if($att->recommend_date=="")
                                                <a class="btn btn-xs btn-danger" href="{{route('manage.get.information.report.assignment.tacktical.request.delete',['id'=>$att->id])}}" ><i class="fa fa-trash"></i>
                                                </a>
                                                @endif


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
        </div>


        <!-- Modal -->
<div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">TI Request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                      <form method="post" action="{{route('manage.get.information.report.assignment.tacktical.request.insert')}}" enctype="multipart/form-data">
            @csrf
                <div class="row">

                <input type="hidden" name="ir_id" value="{{@$id}}">    
                
                <div class="col-md-6">
                <div class="form-group">
                    <label>Type Of TI</label>
                    <select class="form-control" required readonly name="type_ti" >
                        <option value="S">Surveillance</option>
                    </select>
                </div>
               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>Request Type</label>
                    <select class="form-control" id="request_type" required name="request_type" >
                        <option value="">Select</option>
                        @foreach(@$request as $val)
                        <option value="{{@$val->id}}">{{@$val->name}}</option>
                        @endforeach
                    </select>
                </div>
               </div> 

               <div class="activity_details row" style="width:100%;display:none" >

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nature of Activity</label>
                                    <input type="text" name="activity_nature"  class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="activity_location"  class="form-control">
                                </div>
                            </div> 

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Other (If applicable)</label>
                                    <input type="text" name="activity_other"  class="form-control">
                                </div>
                            </div> 



                       </div>


               <div class="col-md-6">
                <div class="form-group">
                    <label>In Relation To</label>
                    <input type="text" name="relation_to" value="{{@$ir_form->ir_no}}" readonly required class="form-control">
                </div>
               </div>


               {{-- <div class="col-md-6">
                <div class="form-group">
                    <label>In Relation To</label>
                    <select class="form-control" required name="relation_to">
                        <option value="">Select</option>
                        @foreach(@$relation as $value)
                        <option value="{{@$value->id}}">{{@$value->name}}</option>
                        @endforeach
                    </select>
                </div>
               </div> --}}  


               {{-- <div class="col-md-6">
                <div class="form-group">
                    <label>Reporting Officer</label>
                    <select class="form-control" required name="requesting_officer">
                        <option value="">Select</option>
                        @foreach(@$user as $value)
                        <option value="{{@$value->id}}">{{@$value->name}}</option>
                        @endforeach
                    </select>
                </div>
               </div> --}}
                

               <div class="col-md-6">
                <div class="form-group">
                    <label>Request Date</label>
                    <input type="date" name="request_date" value="{{date('Y-m-d')}}" readonly required class="form-control">
                </div>
               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" required class="form-control">
                </div>
               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" required class="form-control">
                </div>
               </div>

               <div class="arrest_details row" style="width: 100%">
                           <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Arrest Type</label>
                                        <select class="form-control" name="arrest_type" required id="arrest_type">
                                            <option value="">Select</option>
                                            <option value="AW">Arrest Warrant</option>
                                            <option value="AO">Arrest Order</option>
                                            <option value="NA">Not Applicable</option>
                                        </select>
                                    </div>
                            </div>

                            <div class="col-md-6 arrest_attachement_div" style="display:none">
                                    <div class="form-group">
                                        <label>Attachment</label>
                                        <input type="file" name="arrest_attachement"  class="form-control">
                                    </div>
                            </div> 
                            <div class="col-md-6">
                            <div class="form-group">
                                <label>Corruption Offences</label>
                                <select class="form-control" required name="corruption">
                                    <option value="">Select</option>
                                    @foreach(@$offence as $value)
                                    <option value="{{@$value->offence_id}}">{{@$value->offence_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                           </div>
                        </div>

               <div class="col-md-12">
                <div class="form-group">
                    <label>Suspects Details</label>
                    <textarea type="text" name="suspect_details" required class="form-control"></textarea>
                </div>
               </div>

               <div class="col-md-12">
                <div class="form-group">
                    <label>Purpose</label>
                    <textarea type="text" name="reason" required class="form-control"></textarea>
                </div>
               </div>

               <div class="row" style="width: 100%;">
                            <div class="col-md-12 mb-2"><h5 style="font-weight:bold">Focal person (Team Leader)</h5></div>
                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="focal_name" required class="form-control">
                            </div>
                           </div>

                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Designation</label>
                                <input type="text" name="focal_dept" required class="form-control">
                            </div>
                           </div>

                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Department</label>
                                <input type="text" name="focal_designation" required class="form-control">
                            </div>
                           </div>

                        </div>

               



            </div>
                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
            
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
                            <h5 class="modal-title" id="exampleModalLabel">Update Tacktical Request</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           <form method="post" action="{{route('manage.get.information.report.assignment.tacktical.request.update')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                        <div class="row"> 
                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Type Of TI</label>
                                <select class="form-control" readonly required name="type_ti" id="type_ti">
                                    
                                    <option value="S">Surveillance</option>
                                   
                                </select>
                            </div>
                           </div>

                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Request Type</label>
                                <select class="form-control" id="request_type_edit" required name="request_type" >
                                    <option value="">Select</option>
                                    @foreach(@$request as $val)
                                    <option value="{{@$val->id}}">{{@$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                           </div> 


                           
                           

                           {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label>In Relation To</label>
                                <select class="form-control" required name="relation_to" id="relation_to">
                                    <option value="">Select</option>
                                    @foreach(@$relation as $value)
                                    <option value="{{@$value->id}}">{{@$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                           </div> --}}  

                           <div class="col-md-6">
                            <div class="form-group">
                                <label>In Relation To</label>
                                <input type="text" name="relation_to" id="relation_to" value="{{@$ir_form->ir_no}}" readonly required class="form-control">
                            </div>
                           </div>

                           <div class="activity_details_edit row" style="width:100%">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nature of Activity</label>
                                    <input type="text" name="activity_nature" value="{{@$data->activity_nature}}" class="form-control activity_nature">
                                </div>
                            </div>

                            <div class="col-md-12" style="width:100%">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="activity_location" value="{{@$data->activity_location}}" class="form-control activity_location">
                                </div>
                            </div> 

                            <div class="col-md-12" style="width:100%">
                                <div class="form-group">
                                    <label>Other (If applicable)</label>
                                    <input type="text" name="activity_other" value="{{@$data->activity_other}}" class="form-control activity_other">
                                </div>
                            </div> 



                       </div>

                           {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label>Reporting Officer</label>
                                <select class="form-control" required name="requesting_officer" id="requesting_officer">
                                    <option value="">Select</option>
                                    @foreach(@$user as $value)
                                    <option value="{{@$value->id}}">{{@$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                           </div> --}}
                            

                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Request Date</label>
                                <input type="date" name="request_date" readonly class="form-control" id="request_date">
                            </div>
                           </div>

                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" required class="form-control" id="start_date">
                            </div>
                           </div>

                           <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" required class="form-control" id="end_date">
                            </div>
                           </div>

                           <div class="arrest_details row" style="width: 100%">
                           <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Arrest Type</label>
                                        <select class="form-control" name="arrest_type" required id="arrest_type_edit">
                                            <option value="">Select</option>
                                            <option value="AW">Arrest Warrant</option>
                                            <option value="AO">Arrest Order</option>
                                            <option value="NA">Not Applicable</option>
                                        </select>
                                    </div>
                            </div>

                            <div class="col-md-6 arrest_attachement_div_edit" style="display:none">
                                    <div class="form-group">
                                        <label>Attachment</label>
                                        <input type="file" name="arrest_attachement"  class="form-control">
                                    </div>
                            </div> 
                            <div class="col-md-6">
                            <div class="form-group">
                                <label>Corruption Offences</label>
                                <select class="form-control corruption" required name="corruption">
                                    <option value="">Select</option>
                                    @foreach(@$offence as $value)
                                    <option value="{{@$value->offence_id}}">{{@$value->offence_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                           </div>
                        </div>

                           

                           <div class="col-md-12">
                            <div class="form-group">
                                <label>Suspects Details</label>
                                <textarea type="text" name="suspect_details" id="suspect_details" required class="form-control"></textarea>
                            </div>
                           </div>

                           <div class="col-md-12">
                            <div class="form-group">
                                <label>Purpose</label>
                                <textarea type="text" name="reason" id="reason" required class="form-control"></textarea>
                            </div>
                           </div>


                           <div class="row" style="width: 100%;">
                            <div class="col-md-12 mb-2"><h5 style="font-weight:bold">Focal person (Team Leader)</h5></div>
                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="focal_name" required class="form-control name_focal">
                            </div>
                           </div>

                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Designation</label>
                                <input type="text" name="focal_dept" required class="form-control designation">
                            </div>
                           </div>

                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Department</label>
                                <input type="text" name="focal_designation" required class="form-control department">
                            </div>
                           </div>

                        </div>
                           

                           



                        </div>
                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info" id="update_btn">Save</button></div>
            </form>
        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>

    
</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#type_ti').val($(this).data('type_ti')).change();
            $('#request_type_edit').val($(this).data('request_type')).change(); 
            if($(this).data('request_type')=="1")
            {
                $('.activity_details_edit').css('display','block');
            }else{
                $('.activity_details_edit').css('display','none');
            }
            $('#relation_to').val($(this).data('relation_to')).change();
            $('#requesting_officer').val($(this).data('requesting_officer')).change();
            $('#request_date').val($(this).data('request_date'));
            $('#start_date').val($(this).data('start_date'));
            $('#end_date').val($(this).data('end_date'));
            $('#suspect_details').val($(this).data('suspect_details'));
            $('#reason').val($(this).data('reason'));
            $('#id').val($(this).data('id'));
            if($(this).data('recom')!="")
            {
                $('#update_btn').css('display','none');
            }

            if($(this).data('arrest_type')=="NA")
            {
                $('.arrest_attachement_div_edit').css('display','none');
            }else{
                $('.arrest_attachement_div_edit').css('display','block');
            }

            $('.activity_nature').val($(this).data('activity_nature'));
            $('.activity_location').val($(this).data('activity_location'));
            $('.activity_other').val($(this).data('activity_other'));


            $('.name_focal').val($(this).data('focal_name'));
            $('.designation').val($(this).data('focal_designation'));
            $('.department').val($(this).data('focal_dept'));

            $('#arrest_type_edit').val($(this).data('arrest_type')).change(); 
            $('.corruption').val($(this).data('corruption')).change(); 
            $('#exampleModaEdit').modal('show');
        })

   
</script>

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
    $('#request_type').on('change',function(e){
        var request_type = $('#request_type').val();
        if(request_type==1)
        {
            $('.activity_details').show();
        }else{
            $('.activity_details').hide();
        }
    });

        $('#request_type_edit').on('change',function(e){
        var request_type = $('#request_type_edit').val();
        if(request_type==1)
        {
            $('.activity_details_edit').show();
        }else{
            $('.activity_details_edit').hide();
        }
    });


    $('#type_ti').on('change',function(e){
        var type_ti = $('#type_ti').val();
        if(type_ti=="IG")
        {
            $('.purpose_div').hide();
        }else{
            $('.purpose_div').show();
        }
    });

    $('#arrest_type').on('change',function(e){
        var arrest_type = $('#arrest_type').val();
        
        if(arrest_type=="NA")
        {
            $('.arrest_attachement_div').hide();
        }else{
            $('.arrest_attachement_div').show();
        }
    });

    $('#arrest_type_edit').on('change',function(e){
        var arrest_type = $('#arrest_type_edit').val();
        
        if(arrest_type=="NA")
        {
            $('.arrest_attachement_div_edit').hide();
        }else{
            $('.arrest_attachement_div_edit').show();
        }
    });
</script>


@endsection