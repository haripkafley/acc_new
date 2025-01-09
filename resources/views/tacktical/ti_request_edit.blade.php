@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        




          <form method="post" action="{{route('tacktical.inteligence.autorization.form.update')}}" enctype="multipart/form-data">

            @csrf
                <div class="row">

                <input type="hidden" name="id" value="{{@$data->id}}">
                <div class="col-md-6">
                <div class="form-group">
                    <label>Type Of TI</label>
                    <select class="form-control" required name="type_ti" id="type_ti">
                        <option value="">Select</option>
                        <option value="S" @if(@$data->type_ti=="S") selected @endif>Surveillance</option>
                        <option value="IG" @if(@$data->type_ti=="IG") selected @endif>Information Gathering</option>
                    </select>
                </div>
               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>Request Type</label>
                    <select class="form-control" required name="request_type" id="request_type">
                        <option value="">Select</option>
                        @foreach(@$request as $val)
                        <option value="{{@$val->id}}" @if(@$data->request_type==@$val->id) selected @endif>{{@$val->name}}</option>
                        @endforeach
                    </select>
                </div>
               </div> 


               <div class="activity_details row" @if(@$data->request_type==1) style="width:100%;display:block;" @else style="width:100%;display:none;" @endif >

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nature of Activity</label>
                            <input type="text" name="activity_nature" value="{{@$data->activity_nature}}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12" style="width:100%">
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="activity_location" value="{{@$data->activity_location}}" class="form-control">
                        </div>
                    </div> 

                    <div class="col-md-12" style="width:100%">
                        <div class="form-group">
                            <label>Other (If applicable)</label>
                            <input type="text" name="activity_other" value="{{@$data->activity_other}}" class="form-control">
                        </div>
                    </div> 



               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>In Relation To (Add Case No/Complaint No / IR No)</label>
                    <input type="text" name="relation_to" value="{{@$data->relation_to}}" required class="form-control">
                </div>
               </div>  

                <div class="col-md-6">
                <div class="form-group">
                    <label>Reporting Officer</label>
                    <select class="form-control" required name="requesting_officer">
                        <option value="">Select</option>
                        @foreach(@$user as $value)
                        <option value="{{@$value->id}}" @if(@$data->requesting_officer==@$value->id) selected @endif>{{@$value->name}}</option>
                        @endforeach
                    </select>
                </div>
               </div>

               <div class="col-md-4">
                <div class="form-group">
                    <label>Request Date</label>
                    <input type="date" name="request_date" value="{{@$data->request_date}}" required class="form-control">
                </div>
               </div>

               <div class="col-md-4">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" value="{{@$data->start_date}}" required class="form-control">
                </div>
               </div>

               <div class="col-md-4">
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" value="{{@$data->end_date}}" required class="form-control">
                </div>
               </div>


               <div class="arrest_details row" style="width: 100%">
               <div class="col-md-4">
                        <div class="form-group">
                            <label>Arrest Type</label>
                            <select class="form-control" name="arrest_type" required id="arrest_type">
                                <option value="">Select</option>
                                <option value="AW" @if(@$data->arrest_type=="AW") selected @endif>Arrest Warrant</option>
                                <option value="AO" @if(@$data->arrest_type=="AO") selected @endif>Arrest Order</option>
                                <option value="NA" @if(@$data->arrest_type=="NA") selected @endif>Not Applicable</option>
                            </select>
                        </div>
                </div>

                <div class="col-md-4 arrest_attachement_div" @if(@$data->arrest_type=="NA" ) style="display:none" @else style="display:block" @endif>
                        <div class="form-group">
                            <label>Attachment</label>
                            <input type="file" name="arrest_attachement"  class="form-control">
                        </div>
                        @if(@$data->arrest_type!="NA" )
                        <a class="btn btn-xs btn-warning" href="{{URL::to('attachment/ti')}}/{{$data->arrest_attachement}}" target="_blank"><i class="fa fa-eye"></i>View Attachment
                        </a>
                        @endif
                </div> 
                <div class="col-md-4">
                <div class="form-group">
                    <label>Corruption Offences</label>
                    <select class="form-control" required name="corruption">
                        <option value="">Select</option>
                        @foreach(@$offence as $value)
                        <option value="{{@$value->offence_id}}" @if(@$data->corruption==@$value->offence_id) selected @endif>{{@$value->offence_type}}</option>
                        @endforeach
                    </select>
                </div>
               </div>
            </div>

               <div class="col-md-12">
                <div class="form-group">
                    <label>Suspects Details</label>
                    <textarea type="text" name="suspect_details" required class="form-control">{{@$data->suspect_details}}</textarea>
                </div>
               </div>

               <div class="col-md-12 purpose_div" @if(@$data->type_ti=="IG") style="display:none" @else style="display:block;" @endif>
                <div class="form-group">
                    <label>Purpose</label>
                    <textarea type="text" name="reason" required class="form-control">{{@$data->reason}}</textarea>
                </div>
               </div>


               <div class="row" style="width: 100%;">
                        <div class="col-md-12 mb-2"><h5 style="font-weight:bold">Focal person (Team Leader)</h5></div>
                       <div class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="focal_name" value="{{@$data->focal_name}}" required class="form-control">
                        </div>
                       </div>

                       <div class="col-md-4">
                        <div class="form-group">
                            <label>Designation</label>
                            <input type="text" name="focal_dept" value="{{@$data->focal_dept}}" required class="form-control">
                        </div>
                       </div>

                       <div class="col-md-4">
                        <div class="form-group">
                            <label>Department</label>
                            <input type="text" name="focal_designation" value="{{@$data->focal_designation}}" required class="form-control">
                        </div>
                       </div>

                </div>

               



            </div>
                
                <div class="row">
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button> <a href="{{session()->get('ti_request_add')}}" class="btn btn-success">Back</a></div>
               
                </div>
        </form>
    </div>
</section>

<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>

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

    $('#arrest_type').on('change',function(e){
        var arrest_type = $('#arrest_type').val();
        
        if(arrest_type=="NA")
        {
            $('.arrest_attachement_div').hide();
        }else{
            $('.arrest_attachement_div').show();
        }
    });
</script>

@endsection