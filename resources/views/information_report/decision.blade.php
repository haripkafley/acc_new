@extends('layouts.admin')
<style type="text/css">
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #7c2323 !important;
}
</style>
@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

            <div class="row"><div class="col-md-12"><a href="{{route('manage.information.report.irrc.page.view')}}" style="float: right;" class="btn btn-primary">Back</a></div></div>





          
                
                <div class="row">
                <div class="col-md-3">
                <div class="form-group">
                    <label>Reported By</label>
                    <select class="select2-multiple form-control" disabled name="members[]" multiple="multiple"
                    id="select2Multiple">
                    @foreach(@$user as $val)
                    <option value="{{@$val->id}}" @if(in_array(@$val->id,$user_array)) selected @endif>{{@$val->name}}</option>
                    @endforeach              
                  </select>
                </div>
               </div>

               <div class="col-md-3">
                <div class="form-group">
                    <label>IR Received Date</label>
                    <input type="date" name="received_date" disabled value="{{@$data->received_date}}" required class="form-control">
                </div>
               </div>

               <div class="col-md-3">
               <div class="form-group">
                                    <label for="exampleInputEmail1">Source Type</label>
                                    <select class="form-control source_type" name="source_type" disabled>
                                        <option value="">Select</option>
                                        <option value="OSINT" @if(@$data->source_type=="OSINT") selected @endif>OSINT</option>
                                        <option value="SOCINT" @if(@$data->source_type=="SOCINT") selected @endif>SOCINT</option>
                                        <option value="Humint" @if(@$data->source_type=="Humint") selected @endif>Humint</option>
                                        <option value="DS" @if(@$data->source_type=="DS") selected @endif>Data Source</option>
                                    </select>
                                    
                 </div>
             </div>



               

               <div class="col-md-6">
                <div class="form-group">
                    <label>Source</label>
                    <select class="form-control" required name="source" id="source" disabled>
                        <option value="">Select</option>
                        @foreach(@$sources as $value)
                        <option value="{{@$value->id}}" @if(@$data->source==@$value->id) selected @endif>{{@$value->name}}</option>
                        @endforeach
                        <option value="Other" @if(@$data->source=="Other") selected @endif>Other</option>
                    </select>
                </div>
               </div>

               <div class="col-md-6 other_div" disabled @if(@$data->source=="Other") style="display:block" @else style="display:none" @endif>
                <div class="form-group">
                    <label>Other Source Name</label>
                    <input type="text" name="source_other" value="{{@$data->source_other}}" class="form-control">
                </div>
               </div>




               <div class="col-md-12">
                <div class="form-group">
                    <label>IR Title</label>
                    <input type="text" name="title"  disabled required value="{{@$data->title}}" class="form-control">
                </div>
               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>Occurance From</label>
                    <input type="date" name="occurance_from" disabled value="{{@$data->occurance_from}}" required class="form-control">
                </div>
               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>Occurance Till</label>
                    <input type="date" name="occurance_till" disabled value="{{@$data->occurance_till}}" required class="form-control">
                </div>
               </div>


               <div class="col-sm-4">
                    <div class="form-group">
                        <label>Dzongkhag<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="dzongkhag" disabled id="dzongkhag">
                                <option value="">Select</option>
                                @foreach(@$dzongkhag as $value)
                                <option value="{{$value->dzoID}}" @if(@$data->dzongkhag_id==$value->dzoID) selected @endif>{{@$value->dzoName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Gewog<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="gewog" disabled id="gewog">
                                <option value="">Select Gewog</option>
                                @foreach(@$gewog as $value)
                                <option value="{{$value->gewogID}}" @if(@$data->gewog_id==$value->gewogID) selected @endif>{{@$value->gewogName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Village<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="village" disabled id="village">
                                <option value="">Select Village</option>
                                @foreach(@$village as $value)
                                <option value="{{$value->villageID}}" @if(@$data->village==$value->villageID) selected @endif>{{@$value->villageName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>



               <div class="col-md-12">
                <div class="form-group">
                    <label>IR Details</label>
                    <textarea type="text" name="description" disabled required class="form-control">{{@$data->description}}</textarea>
                </div>
               </div>



               <div class="col-md-4">
                <div class="form-group">
                    <label>Agency</label>
                    <select class="form-control" required disabled name="agency">
                        <option value="">Select</option>
                        @foreach(@$agency as $value)
                        <option value="{{@$value->agencyID}}" @if(@$data->agency==@$value->agencyID) selected @endif>{{@$value->agencyName}}</option>
                        @endforeach
                    </select>
                </div>
               </div>


               <div class="col-md-4">
                <div class="form-group">
                    <label>Corruption Offences</label>
                    <select class="form-control" required disabled name="corruption">
                        <option value="">Select</option>
                        @foreach(@$offence as $value)
                        <option value="{{@$value->offence_id}}" @if(@$data->corruption==@$value->offence_id) selected @endif>{{@$value->offence_type}}</option>
                        @endforeach
                    </select>
                </div>
               </div>

               <div class="col-md-4">
                <div class="form-group">
                    <label>Area Of Corruption</label>
                    <select class="form-control" required disabled name="area">
                        <option value="">Select</option>
                        @foreach(@$area as $value)
                        <option value="{{@$value->id}}" @if(@$data->area==@$value->id) selected @endif>{{@$value->area_name}}</option>
                        @endforeach
                    </select>
                </div>
               </div>


               <div class="col-md-6">
                
                 @if(@$data->attachment)
                    <a class="btn btn-xs btn-warning" href="{{URL::to('attachment/ir')}}/{{$data->attachment}}" target="_blank"><i class="fa fa-eye"></i>View Attachment
                    </a>
                 @endif
               </div>


               
                 
               </div>


                           <div class="row mt-5">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Suspect List </div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Person Type</th>
                                        <th>Nationality</th>
                                        <th>Name Of Suspect</th>
                                        <th>CID</th>
                                        <th>Identification No</th>
                                        <th>Country</th>
                                        <th>Phone</th>
                                        <th>DOB</th>
                                        <th>Address</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$suspects->isNotEmpty())
                                    @foreach(@$suspects as $att)
                                    <tr>
                                        <td>@if(@$att->person_type=='S') Suspect @else Witness @endif</td>
                                        <td>@if(@$att->nationality=="B")National @else Non-National @endif</td>
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->identity }}</td>
                                        <td>{{ $att->country }}</td>
                                        <td>{{ $att->phone_number }}</td>
                                        <td>{{ $att->dob }}</td>
                                        <td>{{ $att->address }}</td>
                                        
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Suspect Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>




               <form method="POST" class="mt-4" action="{{route('manage.information.report.form.decision.page.update.decision')}}">
                    
                    @csrf

                    <input type="hidden" name="id" value="{{@$id}}">

                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Decision</label>
                            <select class="form-control" id="status" required name="status">
                                <option value="AA" @if(@$data->status=="AA") selected @endif>Pending</option>
                                <option value="DP" @if(@$data->status=="DP") selected @endif>Drop</option>
                                <option value="SR" @if(@$data->status=="SR") selected @endif>Share</option>
                                <option value="DR" @if(@$data->status=="DR") selected @endif>Defer</option>
                                <option value="UP" @if(@$data->status=="UP") selected @endif>Upgrade</option>
                            </select>
                        </div>
                       </div>

                       <div class="col-md-6">
                        <div class="form-group mb-3">
                          <label for="select2Multiple">Members</label>
                          <br>
                          <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                            id="select2Multiple">
                            @foreach(@$user as $val)
                            <option value="{{@$val->id}}" @if(in_array(@$val->id,@$explode_member)) selected @endif>{{@$val->name}}</option>
                            @endforeach              
                          </select>
                        </div>
                       </div>


                       <div class="col-md-12 remark_div" @if(@$data->status=="UP") style="display:block" @else style="display:none" @endif>
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea type="text" name="decision_remark"  class="form-control">{{@$data->decision_remark}}</textarea>
                        </div>
                       </div>

                       <div class="col-md-12 reason_div" @if(@$data->status=="DP"||@$data->status=="SR"||@$data->status=="DR") style="display:block" @else style="display:none" @endif>
                        <div class="form-group">
                            <label>Reason</label>
                            <textarea type="text" name="decision_reason"  class="form-control">{{@$data->decision_reason}}</textarea>
                        </div>
                       </div>

                       <div class="col-sm-12 mt-2"><button type="submit" class="btn btn-info">Update</button></div>
                   </div>



               </form>













            </div>
                
                
                
            
      
  

</section>

<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $('#status').on('change',function(e){
        var status = $(this).val();
        if(status=="UP")
        {

            $('.remark_div').show();
            $('.reason_div').hide();
        }else{
            $('.remark_div').hide();
            $('.reason_div').show();
        }    
    });
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

@endsection