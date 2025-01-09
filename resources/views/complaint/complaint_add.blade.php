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

        /* nav */
.card {
  max-width: 25rem;
  padding: 0;
  border: none;
  border-radius: 0.5rem;
}

a.active {
  border-bottom: 2px solid #55c57a;
}

.nav-link {
  color: rgb(110, 110, 110);
  font-weight: 500;
}
.nav-link:hover {
  color: #55c57a;
}

.nav-pills .nav-link.active {
  color: black;
  background-color: white;
  border-radius: 0.5rem 0.5rem 0 0;
  font-weight: 600;
}

    </style>
<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active btn btn-info" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Complaint Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Allegations/Offences</a>
        </li>


        <li class="nav-item">
          <a class="nav-link" disabled id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Attachment Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" disabled id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" disabled id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Financial Implication</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" disabled id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Social Implication</a>
        </li>
        

        <li class="nav-item">
          <a class="nav-link" disabled id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Link Case</a>
        </li>
      </ul>

      @if(@$acc_complaint)
      <div class="row">
        <div class="col-md-12">
            <div >
                <p><b>Name:</b> {{@$acc_complaint->name}}</p>
                <p><b>Designation:</b> {{@$acc_complaint->designation}}</p>
                <p><b>Address:</b> {{@$acc_complaint->address}}</p>


                <p><b>Offence:</b> @if(@$acc_complaint->offence_id!=""){{@$acc_complaint->offence_name->offence_type}} @else -- @endif</p>
                <p><b>Area:</b> @if(@$acc_complaint->area_id!=""){{@$acc_complaint->area_name->area}} @else -- @endif</p>
                <p><b>Description:</b> {{@$acc_complaint->complaint}}</p>
                <p><b>Information:</b> {{@$acc_complaint->your_information}}</p>
                <p><b>Source:</b> {{@$acc_complaint->source}}</p>
            </div>
        </div>
      </div>
      @endif

        <form method="post" action="{{route('SaveComplaintRegistration')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="complaintID" value="{{@$acc_complaint->id}}">
            <div class="row">
                {{-- <div class="col-sm-12">
                <div class="form-group">
              <label for="select2Multiple">Multiple Tags</label>
              <select class="select2-multiple form-control" name="tags[]" multiple="multiple"
                id="select2Multiple">
                <option value="tag1">tag1</option>
                <option value="tag2">tag2</option>
                <option value="tag3">tag3</option>               
              </select>
            </div>
        </div> --}}


                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Processing Type<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="compliantProcessingType" >
                                <option value="">Select</option>
                                @foreach(@$processing as $value)
                                <option value="{{$value->complaintProcessingTypeID}}">{{@$value->processingTypeName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Registration No<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" class="form-control" name="complaint_registration_no" value="{{@$complaint_registration_no}}" readonly>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Complaint Title<span style="font-weight: bold; color: red;">*</span></label>
                            <input type="text" class="form-control" name="complaint_title" required>
                    </div>
                </div>



                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Date Time<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" name="complaintDateTime" type="date" required>
                    </div>
                </div>

                 <div class="col-sm-4">
                    <div class="form-group">
                        <label>Occurrence From<span style="font-weight: bold; color: red;"></span></label>
                            <input class="form-control" name="complaintOccurrenceFrom" type="date" >
                    </div>
                </div>


                 <div class="col-sm-4">
                    <div class="form-group">
                        <label>Occurrence Till<span style="font-weight: bold; color: red;"></span></label>
                            <input class="form-control" name="complaintOccurrenceTill" type="date" >
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Received By<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="select2-multiple form-control" name="ComplaintReceivedBy[]" multiple="multiple"
                            id="select2Multiple">
                            @foreach(@$employe as $value)
                            <option value="{{@$value->id}}">{{@$value->name}}</option>
                            @endforeach              
                          </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Complaint Mode<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="complaintMode">
                                <option value="">Select</option>
                                @foreach(@$mode as $value)
                                <option value="{{$value->complaintmodeID}}">{{@$value->modeName}}</option>
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
                                <option value="{{$value->dzoID}}">{{@$value->dzoName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Gewog<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="gewog" id="gewog">
                                <option value="">Select Gewog</option>
                            </select>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Village<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="village" id="village">
                                <option value="">Select Village</option>
                            </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Against Agency Category<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="AgainstAgencyCategory" id="AgainstAgencyCategory">
                                <option value="">Select Agency</option>
                                @foreach(@$agency as $value)
                                <option value="{{@$value->empCategoryID }}">{{@$value->empCategoryName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="others" style="display:none;width:100%;">

                    <div class="col-sm-12">
                    <div class="form-group">
                        <label> Agency<span style="font-weight: bold; color: red;"></span></label>
                       <select class="form-control" name="department_others" id="department_others">
                                <option value="">Select</option>
                       </select>
                    </div>
                    </div>

                </div> 


                <div class="one_and_two" style="display:none; width: 100%;">
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label> Dzongkhag<span style="font-weight: bold; color: red;"></span></label>
                       <select class="form-control" name="Against_agency" id="Against_agency">
                                <option value="">Select</option>
                                @foreach(@$dzongkhag as $value)
                                <option value="{{$value->dzoID}}">{{@$value->dzoName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label> Constituency<span style="font-weight: bold; color: red;"></span></label>
                       <select class="form-control" name="Against_department" id="Against_department">
                                <option value="">Select</option>
                               
                            </select>
                    </div>
                </div>
            </div>

                </div>


                <div class="twenty_two" style="display:none;width: 100%;">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label> Agency<span style="font-weight: bold; color: red;"></span></label>
                       <select class="form-control" name="agency_againt_twenty_two" id="agency_againt_twenty_two">
                                <option value="">Select</option>
                       </select>
                    </div>
                    </div>

                    <div class="col-sm-6" >
                    <div class="form-group Against_department_twenty_two_class" style="display:none">
                        <label> Department<span style="font-weight: bold; color: red;"></span></label>
                       <select class="form-control" name="Against_department_twenty_two" id="Against_department_twenty_two_id">
                                <option value="">Select</option>
                                @foreach(@$dzongkhag as $value)
                                <option value="{{$value->dzoID}}">{{@$value->dzoName}}</option>
                                @endforeach
                       </select>
                    </div>
                    </div>



                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Complainant Type<span style="font-weight: bold; color: red;"></span></label>
                         <select class="form-control" name="complainantType" id="complainantType">
                                <option value="">Select</option>
                                @foreach(@$type as $value)
                                <option value="{{@$value->id}}">{{@$value->complainttypeName}}</option>
                                @endforeach
                       </select>
                    </div>
                </div>

                <div class="know_person row" style="display:none">
                    <div class="col-sm-3">
                    <div class="form-group">
                        <label>Cid</label>
                        <input class="form-control" name="known_cid" type="text" >
                    </div>
                   </div>

                   <div class="col-sm-3">
                    <div class="form-group">
                        <label>First Name</label>
                        <input class="form-control" name="first_name_known" type="text" >
                    </div>
                   </div>


                   <div class="col-sm-3">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input class="form-control" name="last_name_known" type="text" >
                    </div>
                   </div>

                   <div class="col-sm-3">
                    <div class="form-group">
                        <label>Employee Id</label>
                        <input class="form-control" name="employee_id_known" type="text" >
                    </div>
                   </div>

                   <div class="col-sm-3">
                    <div class="form-group">
                        <label>Gender</label>
                        @foreach(@$gender as $key=> $value)    
                            <div class="form-check form-check-inline">
                              
                              <input class="form-check-input" type="radio" id="genderInput_{{@$value->id}}" name="gender_known" value="{{@$value->id}}" @if(@$key==0) checked @endif>
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
                                <option value="{{$value->dzoID}}">{{@$value->dzoName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Gewog</label>
                            <select class="form-control" name="gewog_known" id="gewog_known">
                                <option value="">Select Gewog</option>
                            </select>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Village</label>
                            <select class="form-control" name="village_known" id="village_known">
                                <option value="">Select Village</option>
                            </select>
                    </div>
                </div>


                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input class="form-control" name="phone_number_known" type="number" >
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Address</label>
                        <input class="form-control" name="address_known" type="text" >
                    </div>
                </div>

               



                </div>





                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Complaint Details<span style="font-weight: bold; color: red;"></span></label>
                        <textarea class="form-control" style="height:300px" id="text_complaint" name="complaintDetail"></textarea>
                    </div>
                </div>

                










                






                <div class="col-sm-12"></div>
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Register Complaint</button> <a  class="btn btn-danger" onclick="location.reload()">Cancel</a></div>
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

{{-- <script>
   tinymce.init({
     selector: 'textarea#text_complaint', // Replace this CSS selector to match the placeholder element for TinyMCE
     plugins: 'code table lists',
     toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
   });
 </script> --}}


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
            $('.know_person').show();
        }else{
            $('.know_person').hide();
        }
    });
</script>




@endsection