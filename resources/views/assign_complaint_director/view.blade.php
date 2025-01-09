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
          <a class="nav-link active btn btn-info" href="{{route('complaint.view.details.director',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('complaint.view.details.attachment.details.director',['id'=>@$id])}}">Attachment Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('complaint.view.details.aperson-involved-details.director',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('complaint.view.details.case-link-details.director',['id'=>@$id])}}">Link Case</a>
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

             <div class="col-sm-6">
                    <div class="card">
                        <p><b>Complaint Details:</b> {!!@$data->complaintDetails!!}</p>
                    </div>
                </div>

                
         <div class="col-sm-12">  
        @if(@$data->assign_status=="N")       
        <form method="post" action="{{route('assign.complaint.post.director')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="complaintID" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Assign To<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="assign_to" id="assign_to">
                                <option value="H">Head Quater</option>
                                <option value="R">Regional Office</option>
                            </select>
                    </div>
                </div>


                <div class="col-sm-12" id="assignUsers_div">
                    <div class="form-group">
                        <label>Assign Users<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="headquater_user_id">
                            @foreach(@$user as $value)
                            <option value="{{@$value->id}}">{{@$value->name}}</option>
                            @endforeach 
                            </select>
                            {{-- <select class="select2-multiple form-control" name="assignUsers[]" multiple="multiple"
                            id="select2Multiple">
                            @foreach(@$user as $value)
                            <option value="{{@$value->id}}">{{@$value->name}}</option>
                            @endforeach              
                          </select> --}}
                    </div>
                </div>


                <div class="col-sm-12" id="regional_office_div" style="display:none">
                    <div class="form-group">
                        <label>Regional Office<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="regional_office">
                                @foreach(@$regional_office as $value)
                                <option value="{{@$value->id}}">{{@$value->name}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>



                <div class="clearfix"> </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Instructions<span style="font-weight: bold; color: red;"></span></label>
                            <textarea class="form-control" required  type="text" name="instruction"> </textarea>
                    </div>
                </div>

                
                <div class="col-sm-12"></div>
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
            </div>
        </form>

        @else

            <form method="post" action="{{route('assign.complaint.post.update.director')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="complaintID" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Assign To<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="assign_to" id="assign_to">
                                <option value="H" @if(@$data->assign_to=="H") selected @endif>Head Quater</option>
                                <option value="R" @if(@$data->assign_to=="R") selected @endif>Regional Office</option>
                            </select>
                    </div>
                </div>


                <div class="col-sm-12" id="assignUsers_div"  @if(@$data->assign_to=="H") style="display:block" @else style="display:none" @endif>
                    <div class="form-group">
                        <label>Assign Users<span style="font-weight: bold; color: red;">*</span></label>
                            <br>

                            <select class="form-control" name="headquater_user_id">
                            @foreach(@$user as $value)
                            <option value="{{@$value->id}}" @if(@$data->headquater_user_id==@$value->id) selected @endif>{{@$value->name}}</option>
                            @endforeach 
                            </select>

                            {{-- <select class="select2-multiple form-control" style="width:100%" name="assignUsers[]" multiple="multiple"
                            id="select2Multiple">
                            @foreach(@$user as $value)
                            <option value="{{@$value->id}}" {{ (in_array($value->id, @$assignUsers)) ? 'selected' : '' }}>{{@$value->name}}</option>
                            @endforeach              
                          </select> --}}
                    </div>
                </div>


                <div class="col-sm-12" id="regional_office_div" @if(@$data->assign_to=="R") style="display:block" @else style="display:none" @endif>
                    <div class="form-group">
                        <label>Regional Office<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="regional_office">
                                @foreach(@$regional_office as $value)
                                <option value="{{@$value->id}}" @if(@$data->regional_office==@$value->id) selected @endif>{{@$value->name}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Reason<span style="font-weight: bold; color: red;">*</span></label>
                            <textarea class="form-control" required  type="text" name="reason_change"> {{@$data->reason_change}} </textarea>
                    </div>
                </div>



                <div class="clearfix"> </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Instructions<span style="font-weight: bold; color: red;">*</span></label>
                            <textarea class="form-control" required  type="text" name="instruction"> {{@$data->instruction}} </textarea>
                    </div>
                </div>

                
                <div class="col-sm-12"></div>
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Reassign</button></div>
            </div>
        </form>

        @endif
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



@endsection