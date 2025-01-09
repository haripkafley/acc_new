@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        




          <form method="post" action="{{route('tacktical.inteligence.autorization.form.insert')}}" enctype="multipart/form-data">
            @csrf
                <div class="row">

                
                <div class="col-md-6">
                <div class="form-group">
                    <label>Type Of TI</label>
                    <select class="form-control" required name="type_ti" id="type_ti">
                        <option value="">Select</option>
                        <option value="S">Surveillance</option>
                        <option value="IG">Information Gathering</option>
                    </select>
                </div>
               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>Request Type</label>
                    <select class="form-control" required name="request_type" id="request_type">
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
                    <label>In Relation To (Add Case No/Complaint No / IR No)</label>
                    <input type="text" name="relation_to" required class="form-control">
                </div>
               </div>  

                <div class="col-md-6">
                <div class="form-group">
                    <label>Reporting Officer</label>
                    <select class="form-control" required name="requesting_officer">
                        <option value="">Select</option>
                        @foreach(@$user as $value)
                        <option value="{{@$value->id}}">{{@$value->name}}</option>
                        @endforeach
                    </select>
                </div>
               </div>

               <div class="col-md-4">
                <div class="form-group">
                    <label>Request Date</label>
                    <input type="date" name="request_date" required class="form-control">
                </div>
               </div>

               <div class="col-md-4">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" required class="form-control">
                </div>
               </div>

               <div class="col-md-4">
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" required class="form-control">
                </div>
               </div>


               <div class="arrest_details row" style="width: 100%">
               <div class="col-md-4">
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

                <div class="col-md-4 arrest_attachement_div" style="display:none">
                        <div class="form-group">
                            <label>Attachment</label>
                            <input type="file" name="arrest_attachement"  class="form-control">
                        </div>
                </div> 
                <div class="col-md-4">
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

               <div class="col-md-12 purpose_div">
                <div class="form-group">
                    <label>Purpose</label>
                    <textarea type="text" name="reason" id="purpose" required class="form-control"></textarea>
                </div>
               </div>


                <div class="row" style="width: 100%;">
                        <div class="col-md-12 mb-2"><h5 style="font-weight:bold">Focal person (Team Leader)</h5></div>
                       <div class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="focal_name" required class="form-control">
                        </div>
                       </div>

                       <div class="col-md-4">
                        <div class="form-group">
                            <label>Designation</label>
                            <input type="text" name="focal_dept" required class="form-control">
                        </div>
                       </div>

                       <div class="col-md-4">
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
</script>

@endsection