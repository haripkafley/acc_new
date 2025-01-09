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
        /*.select2-container--default .select2-selection--multiple .select2-selection__rendered li{
            background: #606060;
        }*/
    </style>
<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active btn btn-info" href="{{route('complaint.registration.edit.view',['id'=>@$id])}}">Complaint Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('allegation.offence.management',['id'=>@$id])}}">Allegations/Offences</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('attachment.view.complaint',['id'=>@$id])}}">Attachment Details</a>
        </li>


        



        <li class="nav-item">
          <a class="nav-link" href="{{route('person.involved.complaint',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.financial-implication-details.page',['id'=>@$id])}}">Financial Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.social.implication',['id'=>@$id])}}">Social Implication</a>
        </li>

        

        <li class="nav-item">
          <a class="nav-link" href="{{route('link.case.complaint',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>



        <form method="post" action="{{route('complaint.registration.edit.update')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="complaintID" value="{{@$data->complaintID}}">
            <div class="row">
              


                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Processing Type<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="compliantProcessingType">
                                <option value="">Select</option>
                                @foreach(@$processing as $value)
                                <option value="{{$value->complaintProcessingTypeID}}" @if(@$data->complaintProcessingTypeID==$value->complaintProcessingTypeID) selected @endif>{{@$value->processingTypeName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Registration No<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" class="form-control" name="complaint_registration_no" value="{{@$data->complaintRegNo}}" readonly>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Complaint Title<span style="font-weight: bold; color: red;">*</span></label>
                            <input type="text" class="form-control" name="complaint_title" value="{{@$data->complaintTitle}}">
                    </div>
                </div>



                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Date Time<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" name="complaintDateTime" type="date" value="{{@$data->complaintDateTime}}" required>
                    </div>
                </div>

                 <div class="col-sm-4">
                    <div class="form-group">
                        <label>Occurrence From<span style="font-weight: bold; color: red;"></span></label>
                            <input class="form-control" name="complaintOccurrenceFrom"  value="{{@$data->occurrencePeriodFrom}}" type="date" >
                    </div>
                </div>


                 <div class="col-sm-4">
                    <div class="form-group">
                        <label>Occurrence Till<span style="font-weight: bold; color: red;"></span></label>
                            <input class="form-control" name="complaintOccurrenceTill"  value="{{@$data->occurrencePeriodTill}}" type="date" >
                    </div>
                </div>


               

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Received By<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="select2-multiple form-control" name="ComplaintReceivedBy[]" multiple="multiple"
                            id="select2Multiple">
                            @foreach(@$employe as $value)
                            <option value="{{@$value->id}}" {{ (in_array($value->id, $received_users)) ? 'selected' : '' }}>{{@$value->name}}</option>
                            @endforeach              
                          </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Complaint Mode<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="complaintMode">
                                <option value="">Select</option>
                                @foreach(@$mode as $value)
                                <option value="{{$value->complaintmodeID}}" @if(@$data->modeID==$value->complaintmodeID) selected @endif>{{@$value->modeName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-sm-12"><label>Place Of Occurance :-</label></div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Dzongkhag<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="dzongkhag" id="dzongkhag">
                                <option value="">Select</option>
                                @foreach(@$dzongkhag as $value)
                                <option value="{{$value->dzoID}}" @if(@$data->placeOfOccurrenceDzongkhagID==$value->dzoID) selected @endif>{{@$value->dzoName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Gewog<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="gewog" id="gewog">
                                <option value="">Select Gewog</option>
                                @foreach(@$gewog as $value)
                                <option value="{{$value->gewogID}}" @if(@$data->placeOfOccurrenceGewogID==$value->gewogID) selected @endif>{{@$value->gewogName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Village<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="village" id="village">
                                <option value="">Select Village</option>
                                @foreach(@$village as $value)
                                <option value="{{$value->villageID}}" @if(@$data->placeOfOccurrenceVillageID==$value->villageID) selected @endif>{{@$value->villageName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Against Agency Category<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="AgainstAgencyCategory" id="AgainstAgencyCategory">
                                <option value="">Select Agency</option>
                                @foreach(@$agencyCategory as $value)
                                <option value="{{@$value->empCategoryID}}" @if(@$data->AgainstAgencyCategory==@$value->empCategoryID) selected @endif>{{@$value->empCategoryName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="others" @if(@$data->AgainstAgencyCategory=="1" || @$data->AgainstAgencyCategory=="2" || @$data->AgainstAgencyCategory=="22")style="display:none" @else style="display: block;width: 100%;" @endif>
                    <div class="row">
                    <div class="col-sm-12">
                    <div class="form-group">
                        <label>Select Agency<span style="font-weight: bold; color: red;"></span></label>
                       <select class="form-control" name="department_others" id="department_others">
                                <option value="">Select</option>
                                @foreach(@$deparment as $value)
                                <option value="{{@$value->agencyID}}" @if(@$data->AgainstDepartment==@$value->agencyID) selected @endif>{{@$value->agencyName}}</option>
                                @endforeach
                       </select>
                    </div>
                    </div>
                </div>
                </div> 


                <div class="one_and_two" @if(@$data->AgainstAgencyCategory=="1" || @$data->AgainstAgencyCategory=="2") style="display:block" @else  style="display:none;width: 100%;" @endif>
                    <div class="row">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label>Select Dzongkhag<span style="font-weight: bold; color: red;"></span></label>
                       <select class="form-control" name="Against_agency" id="Against_agency">
                                <option value="">Select</option>
                                @foreach(@$dzongkhag as $value)
                                <option value="{{$value->dzoID}}" @if(@$data->AgainstAgencyCategory=="1" || @$data->AgainstAgencyCategory=="2") @if(@$data->AgainstAgency==$value->dzoID) selected @endif @endif>{{@$value->dzoName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Select Constituency<span style="font-weight: bold; color: red;"></span></label>
                       <select class="form-control" name="Against_department" id="Against_department">
                                <option value="">Select</option>
                                @foreach(@$constituency as $value)
                                <option value="{{$value->constituencyID}}" @if(@$data->AgainstAgencyCategory=="1" || @$data->AgainstAgencyCategory=="2") @if(@$data->AgainstDepartment==$value->constituencyID) selected @endif @endif>{{@$value->constituencyName}}</option>
                                @endforeach
                               
                            </select>
                    </div>
                </div>

            </div>
                </div>


                <div class="twenty_two" @if(@$data->AgainstAgencyCategory!="22")style="display:none" @else style="display:block;width: 100%;" @endif>
                    <div class="row">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label>Select Agency<span style="font-weight: bold; color: red;"></span></label>
                       <select class="form-control" name="agency_againt_twenty_two" id="agency_againt_twenty_two">
                                <option value="">Select</option>
                                @foreach(@$agency as $value)
                                <option value="{{$value->agencyID}}" @if(@$data->AgainstAgencyCategory=="22") @if(@$data->AgainstAgency==$value->agencyID) selected @endif @endif>{{@$value->agencyName}}</option>
                                @endforeach
                       </select>
                    </div>
                    </div>

                    <div class="col-sm-6" >
                    <div class="form-group Against_department_twenty_two_class" style="display:none">
                        <label>Select Department<span style="font-weight: bold; color: red;"></span></label>
                       <select class="form-control" name="Against_department_twenty_two" id="Against_department_twenty_two_id">
                                <option value="">Select</option>
                                @foreach(@$dzongkhag as $value)
                                <option value="{{$value->dzoID}}" @if(@$data->AgainstAgencyCategory=="22") @if(@$data->AgainstDepartment==$value->dzoID) selected @endif @endif>{{@$value->dzoName}}</option>
                                @endforeach
                       </select>
                    </div>
                    </div>
                </div>


                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Complainant Type<span style="font-weight: bold; color: red;"></span></label>
                         <select class="form-control" name="complainantType" id="complainantType">
                                <option value="">Select</option>
                                @foreach(@$type as $value)
                                <option value="{{@$value->id}}" @if(@$data->complainantType==@$value->id) selected @endif>{{@$value->complainttypeName}}</option>
                                @endforeach
                       </select>
                    </div>
                </div>


                <div class="row know_person " @if(@$data->complainantType==1) style="display:block;width:100%" @else style="display:none;width:100%" @endif>
                    <div class="row">
                    <div class="col-sm-3">
                    <div class="form-group">
                        <label>Cid<span style="font-weight: bold; color: red;"></span></label>
                        <input class="form-control" name="known_cid" type="text" value="{{@$data->known_cid}}" >
                    </div>
                   </div>

                   <div class="col-sm-3">
                    <div class="form-group">
                        <label>First Name<span style="font-weight: bold; color: red;"></span></label>
                        <input class="form-control" name="first_name_known" type="text" value="{{@$data->first_name_known}}">
                    </div>
                   </div>


                   <div class="col-sm-3">
                    <div class="form-group">
                        <label>Last Name<span style="font-weight: bold; color: red;"></span></label>
                        <input class="form-control" name="last_name_known" type="text" value="{{@$data->last_name_known}}">
                    </div>
                   </div>

                   <div class="col-sm-3">
                    <div class="form-group">
                        <label>Employee Id<span style="font-weight: bold; color: red;"></span></label>
                        <input class="form-control" name="employee_id_known" type="text" value="{{@$data->employee_id_known}}">
                    </div>
                   </div>

                   <div class="col-sm-3">
                    <div class="form-group">
                        <label>Gender<span style="font-weight: bold; color: red;"></span></label>
                        @foreach(@$gender as $key=> $value)    
                            <div class="form-check form-check-inline">
                              
                              <input class="form-check-input" type="radio" id="genderInput_{{@$value->id}}" name="gender_known" value="{{@$value->id}}" @if(@$data->gender_known==@$value->id) checked @endif>
                              <label class="form-check-label" for="genderInput">{{@$value->name}}</label>
                              
                            </div>
                            @endforeach
                    </div>
                   </div>



                   <div class="col-sm-4">
                    <div class="form-group">
                        <label>Dzongkhag</label>
                            <select class="form-control" name="dzongkhag_known" id="dzongkhag_known">
                                <option value="">Select</option>
                                @foreach(@$dzongkhag as $value)
                                <option value="{{$value->dzoID}}" @if(@$data->dzongkhag_known==$value->dzoID) selected @endif>{{@$value->dzoName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Gewog</label>
                            <select class="form-control" name="gewog_known" id="gewog_known">
                                <option value="">Select Gewog</option>
                                @foreach(@$gewog as $value)
                                <option value="{{$value->gewogID}}" @if(@$data->gewog_known==$value->gewogID) selected @endif>{{@$value->gewogName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Village</label>
                            <select class="form-control" name="village_known" id="village_known">
                                <option value="">Select Village</option>
                                @foreach(@$village as $value)
                                <option value="{{$value->villageID}}" @if(@$data->village_known==$value->villageID) selected @endif>{{@$value->villageName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>


                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input class="form-control" name="phone_number_known" value="{{@$data->phone_number_known}}" type="number" >
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Address</label>
                        <input class="form-control" name="address_known" value="{{@$data->address_known}}" type="text" >
                    </div>
                </div>


            </div>


                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Complaint Details<span style="font-weight: bold; color: red;"></span></label>
                        <textarea class="form-control" style="height:300px" name="complaintDetail">{{strip_tags(@$data->complaintDetails)}}</textarea>
                    </div>
                </div>

                










                






                <div class="col-sm-12"></div>
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Update Complaint</button></div>
            </div>
        </form>
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

<script>
   tinymce.init({
     selector: 'textarea#text_complaint', // Replace this CSS selector to match the placeholder element for TinyMCE
     plugins: 'code table lists',
     toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
   });
 </script>


 <script type="text/javascript">
  $(document).ready(function(){
    $('#dzongkhag').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('get.gewog.onchange.dzongkhag')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#gewog').html(data.gewog);
          
        }
      })
    })
  })
</script>


 <script type="text/javascript">
  $(document).ready(function(){
    $('#dzongkhag_known').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('get.gewog.onchange.dzongkhag')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#gewog_known').html(data.gewog);
          
        }
      })
    })
  })
</script>





 <script type="text/javascript">
  $(document).ready(function(){
    $('#gewog_known').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('get.village.onchange.gewog')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#village_known').html(data.village);
          
        }
      })
    })
  })
</script>


 <script type="text/javascript">
  $(document).ready(function(){
    $('#gewog').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('get.village.onchange.gewog')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#village').html(data.village);
          
        }
      })
    })
  })
</script>


 <script type="text/javascript">
  $(document).ready(function(){
    $('#AgainstAgencyCategory').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();
      // alert(id);
      if(id==1 || id==2){
       $('.one_and_two').show();
       $('.twenty_two').hide();
        $('.others').hide();
      }else if(id==22){


        $.ajax({
        url:'{{route('get.fetchAgency')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#agency_againt_twenty_two').html(data.agency);
          
        }
      })

        $('.one_and_two').hide();
        $('.twenty_two').show();
        $('.others').hide();
      }else{

        $.ajax({
        url:'{{route('get.departmentFetch')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#department_others').html(data.department);
          
        }
      })
         $('.others').show();
         $('.one_and_two').hide();
         $('.twenty_two').hide();
      }
    })
  })
</script>

<script type="text/javascript">
      $(document).ready(function(){
    $('#agency_againt_twenty_two').on('change',function(e){
        // alert('sayan');
      e.preventDefault();
      var id = $(this).val();
      // alert(id);
      if(id==139||id==141||id==333){
        // alert(id);
        $('.Against_department_twenty_two_class').css('display','block');
     }else{
        $('.Against_department_twenty_two_class').css('display','none');
     }
    
   })
  })
</script>


 <script type="text/javascript">
  $(document).ready(function(){
    $('#Against_agency').on('change',function(e){
        // alert('sayan');
      e.preventDefault();
      var id = $(this).val();
      
      $.ajax({
        url:'{{route('get.fetchConstituency')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#Against_department').html(data.constituency);
          
        }
      })
    
   })
  })
</script>

<script type="text/javascript">
    $('#complainantType').on('change',function(){
        var id = $(this).val();
        if(id==1){
            $('.know_person').css('display','block');
        }else{
            $('.know_person').css('display','none');
        }
    });
</script>



@endsection