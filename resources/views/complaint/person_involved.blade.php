@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
         <li class="nav-item">
          <a class="nav-link" href="{{route('complaint.registration.edit.view',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{route('allegation.offence.management',['id'=>@$id])}}">Allegations/Offences</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('attachment.view.complaint',['id'=>@$id])}}">Attachment Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active btn btn-info" href="{{route('person.involved.complaint',['id'=>@$id])}}" >Person Involved</a>
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


        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Person Involved List </div>

                        <div class = "card-body">
                            <h5>
                              <small>List of accused, witness(es) and complainant</small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>CID</th>
                                        <th>Other ID</th>
                                        <th>Category</th>
                                        <th>Designation</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$person->isNotEmpty())
                                    @foreach(@$person as $att)
                                    <tr>
                                        <td>{{ @$att->personID }}</td>
                                        <td>{{ @$att->fname }} {{ @$att->mname }} {{ @$att->lname }}</td>
                                        <td>{{ @$att->cid }}</td>
                                        <td>{{ @$att->otherIdentificationNo }}</td>
                                        <td>{{ @$att->categoryName }}</td>
                                        <td>{{ @$att->designation }}</td>
                                        <td>
                                                        
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('person.involved.complaint.delete.person',['id'=>@$att->personID,'complaint_id'=>@$id])}}" onclick="return confirm('Are you sure , you want to delete this person ? ')"><i class="fa fa-trash"></i>
                                                                Delete Person
                                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Person Involved Againt This Complaint</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <form method="post" action="{{route('postPersonInvolved.person.involved')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="complaintID" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Nationality<span style="font-weight: bold; color: red;">*</span></label>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="Nationlityradio" id="inlineCheckbox1" name="Nationlityradio" value="1" checked>
                              <label class="form-check-label" for="inlineCheckbox1">Bhutanese</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" id="inlineCheckbox2" name="Nationlityradio" value="2">
                              <label class="form-check-label" for="inlineCheckbox2">Non-Bhutanese</label>
                            </div>
                    </div>
                </div>

                <div class="clearfix"> </div>
                
                <div class="row" id="bhutanese_div" style="width:100%">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>CID<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" id="PIcid" name="PIcid" type="text" placeholder="Enter CID" >
                            
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                       
                             <a class="btn btn-default " style="margin-top:30px" onclick="Bhutan({{@$id}});" id="bhutan_search">
                                      Search
                                 </a>
                            
                            
                    </div>
                </div>
                </div>
            


             <div class="row" id="non_bhutanese_div" style="display:none;width: 100%;">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Other Identification No.<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" name="otherIdentification" placeholder="Enter Other Identification Np." id="otherIdentification" type="text" >
                            
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                       
                             <a class="btn btn-default " onclick="NonBhutan({{@$id}});" style="margin-top:30px" id="other_bhutan_search">
                                      Search
                                 </a>
                            
                            
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
            <label>Complaint Registration Number<span style="font-weight: bold; color: red;">*</span></label>
            <input type="text" class="form-control" name="complaint_registration_no" value="{{@$complaintDetails->complaintRegNo}}" readonly>
            </div> 
            <div class="col-sm-6">
                    <div class="form-group category_class" >
                        <label>Category<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="personCategory" >
                                <option value="0">Select Category</option>
                                @foreach(@$category as $value)
                                <option value="{{@$value->personCategoryID}}">{{@$value->categoryName}}</option>
                                @endforeach
                            </select>
                            
                    </div>
            </div>

            <div class="col-sm-6">
                    <div class="form-group">
                        <label>First Name<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" id="fname" name="fname" type="text" placeholder="Enter First Name" required>
                            
                    </div>
                </div>

                 <div class="col-sm-6">
                    <div class="form-group">
                        <label>Middle Name</label>
                            <input class="form-control" id="mname" name="mname" type="text" placeholder="Enter Middle Name" >
                            
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Last Name</label>
                            <input class="form-control" id="lname" name="lname" type="text" placeholder="Enter Last Name" >
                            
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Employee ID</label>
                            <input class="form-control" id="empID" name="empID" type="text" placeholder="Enter Employee ID" >
                            
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>DOB</label>
                            <input class="form-control" id="DOB" name="DOB" type="date" placeholder="Enter Employee ID" >
                            
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Designation</label>
                            <input class="form-control" id="designation" name="designation" type="text" placeholder="Enter Designation" >
                            
                    </div>
                </div>

                 

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Gender</label>


                            @foreach(@$gender as $key=> $value)    
                            <div class="form-check form-check-inline">
                              
                              <input class="form-check-input" type="radio" id="genderInput_{{@$value->id}}" @if($key==0) checked @endif name="gender" value="{{@$value->id}}">
                              <label class="form-check-label" for="genderInput">{{@$value->name}}</label>
                              
                            </div>
                            @endforeach

                              
                            
                           
                            
                    </div>
                </div>



                 <div class="col-sm-6"></div>
               
                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info"><span class="text_button">Save Person</span></button></div>
            </div>
        </form>
    </div>
</section>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
    $('input[type=radio][name=Nationlityradio]').change(function() {
       if (this.value == '1') {
           $('#bhutanese_div').show();
           $('#otherIdentification').prop( "disabled", true );
           $('#PIcid').prop( "disabled", false );
           $('#non_bhutanese_div').hide();
           $('#fname').val('');
                $('#mname').val('');
                $('#lname').val('');
                $('#empID').val('');
                $('#DOB').val('');
                $('.text_button').text('Save Person');
                $('.category_class').css('display','block');
       }else{
           $('#non_bhutanese_div').show();
           $('#bhutanese_div').hide();
           $('#fname').val('');
                $('#mname').val('');
                $('#lname').val('');
                $('#empID').val('');
                $('#DOB').val('');
                $('#otherIdentification').prop( "disabled", false );
                $('#PIcid').prop( "disabled", true );
                $('.text_button').text('Save Person');
                $('.category_class').css('display','block');
       }

    });
</script>

<script type="text/javascript">
    function Bhutan(id)
    {
      var cid = $('#PIcid').val();
      var _token = $('input[name="_token"]').val();
      if(cid!=""){
      $.ajax({
          url:"{{ route('person.involved.bhutanese.details') }}",
          method:"POST",
          data:{cid:cid,complaint_id:id, _token:_token},
          success:function(data){
            
            if(data.success==true)
            {
                if(data.avail=="Y"){
                    // alert('saa');
                    $('.category_class').css('display','none');
                }else{
                    $('.category_class').css('display','block');
                }
                $('#fname').val(data.person.fname);
                $('#mname').val(data.person.mname);
                $('#lname').val(data.person.lname);
                $('#empID').val(data.person.employID);
                $('#DOB').val(data.person.dob);
                $('#genderInput_'+data.person.gender).attr('checked', true);
                $('.text_button').text('Update Person');

            }else{
                $('#fname').val('');
                $('#mname').val('');
                $('#lname').val('');
                $('#empID').val('');
                $('#DOB').val('');
                $('.category_class').css('display','block');
                $('.text_button').text('Save Person');
            }
          }
         });
       }else{
            $('.category_class').css('display','block');
       }
       
    }
</script>

<script type="text/javascript">
    function NonBhutan(id)
    {

      var otherIdentification = $('#otherIdentification').val();
      var _token = $('input[name="_token"]').val();
      // alert(otherIdentification);
      if(otherIdentification!=""){
      $.ajax({
          url:"{{ route('person.involved.non.bhutanese.details') }}",
          method:"POST",
          data:{otherIdentification:otherIdentification,complaint_id:id, _token:_token},
          success:function(data){
            if(data.success==true)
            {
                if(data.avail=="Y"){
                    // alert('saa');
                    $('.category_class').css('display','none');
                }else{
                    $('.category_class').css('display','block');
                }
                $('#fname').val(data.person.fname);
                $('#mname').val(data.person.mname);
                $('#lname').val(data.person.lname);
                $('#empID').val(data.person.employID);
                $('#DOB').val(data.person.dob);
                $('#genderInput_'+data.person.gender).attr('checked', true);
                $('.text_button').text('Update Person');
            }else{
                $('#fname').val('');
                $('#mname').val('');
                $('#lname').val('');
                $('#empID').val('');
                $('#DOB').val('');
                $('.text_button').text('Save Person');
                $('.category_class').css('display','block');
            }
          }
         });
      }else{
            $('.category_class').css('display','block');
       }
       
    }
</script>


@endsection