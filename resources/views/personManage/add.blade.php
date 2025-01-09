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
.error{
    color: red;
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
          <a class="nav-link active btn btn-info" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">General Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="#" >Linked Complaint</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="#" >Image Upload</a>
        </li>

        </li>
      </ul>

        <form method="post" action="{{route('manage.person.insert.view')}}" id="frm" enctype="multipart/form-data">
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

               
                </div>



                <div class="row" id="non_bhutanese_div" style="display:none;width: 100%;">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Other Identification No.<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" name="otherIdentification" placeholder="Enter Other Identification Np." id="otherIdentification" type="text" >
                            
                    </div>
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
                        <label>Birth Place</label>
                            <input class="form-control" id="birthPlace" name="birthPlace" type="text" placeholder="Enter Birth Place" >
                            
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nationality</label>
                            <input class="form-control" id="nationality" name="nationality" type="text" placeholder="Enter Nationality" >
                            
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Religion</label>
                            <input class="form-control" id="religion" name="religion" type="text" placeholder="Enter Religion" >
                            
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


                <div class="row" id="bhutanese_div_2" style="width:100%">
                    <div class="col-sm-4">
                    <div class="form-group">
                        <label>Dzongkhag<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="permAddDzongkhag" id="dzongkhag">
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
                            <select class="form-control" name="permAddGewog" id="gewog">
                                <option value="">Select Gewog</option>
                            </select>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Village<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="permAddVillage" id="village">
                                <option value="">Select Village</option>
                            </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Thram Number</label>
                            <input class="form-control" id="permAddThram_no" name="permAddThram_no" type="text" placeholder="Enter Thram Number" >
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>House No</label>
                            <input class="form-control" id="permAddHouse_no" name="permAddHouse_no" type="text" placeholder="Enter House No" >
                    </div>
                </div>


                </div>


                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Blood Group</label>
                            <input class="form-control" id="blood_group" name="blood_group" type="text" placeholder="Enter Blood Group" >
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Height</label>
                            <input class="form-control" id="height" name="height" type="text" placeholder="Enter Height" >
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Weight</label>
                            <input class="form-control" id="weight" name="weight" type="text" placeholder="Enter Weight" >
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Remakrs</label>
                            <textarea class="form-control" id="remarks" name="remarks" type="text" placeholder="Enter Remakrs" ></textarea>
                    </div>
                </div>



                










                






                <div class="col-sm-12"></div>
                <div class="col-sm-6"><button type="submit" id="submit_button" class="btn btn-info">Add Person</button></div>
            </div>
        </form>
    </div>
</section>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    

     <script>
$(document).ready(function(){
    
$('#frm').validate({
rules:{


},
messages:{

},
submitHandler: function(form) { // <- pass 'form' argument in
            var nation = $('input[name="Nationlityradio"]:checked').val();

            if(nation=="1")
            {
               var cid = $('#PIcid').val();
               if(cid=="")
               {
                alert('Please enter cid');
                return false;
               } 
               $.ajax({
                url:'{{route('manage.person.check.cid')}}',
                type:'GET',
                data:{cid:cid},
                success:function(data){
                  if(data=="notfound"){
                    $("#submit_button").attr("disabled", true);
                    form.submit(); // <- use 'form' argument here.
                  }else{
                    alert('CID already added in the system');
                    return false;
                  }
                 
                  
                  
                }
              }) 
            }else{

            var otherIdentification = $('#otherIdentification').val();
               if(otherIdentification=="")
               {
                alert('Please enter otherIdentification');
                return false;
               } 
               $.ajax({
                url:'{{route('manage.person.check.other')}}',
                type:'GET',
                data:{otherIdentification:otherIdentification},
                success:function(data){
                  console.log(data);
                  // return false;  
                  if(data=="notfound"){
                    $("#submit_button").attr("disabled", true);
                    form.submit(); // <- use 'form' argument here.
                  }else{
                    alert('OtherIdentification already added in the system');
                    return false;
                  }
                 
                  
                  
                }
              })






            }
            
            
            
        }
});
});
</script>
    
    

   



     <script type="text/javascript">
    $('input[type=radio][name=Nationlityradio]').change(function() {
       if (this.value == '1') {
           $('#bhutanese_div').show();
           $('#bhutanese_div_2').show();
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
                $('#bhutanese_div_2').hide();
                $('#otherIdentification').prop( "disabled", false );
                $('#PIcid').prop( "disabled", true );
                $('.text_button').text('Save Person');
                $('.category_class').css('display','block');
       }

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




@endsection