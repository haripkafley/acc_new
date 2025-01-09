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
          <a class="nav-link " href="{{route('manage.person.edit.view',@$data->personID)}}">General Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('manage.person.linked.view',@$data->personID)}}" >Linked Complaint</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active btn btn-info"  href="{{route('manage.person.image.upload',@$data->personID)}}" >Image Upload</a>
        </li>




        
      </ul>

        <form method="post" action="{{route('manage.person.image.upload.insert')}}" id="frm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="personID" value="{{@$data->personID }}">
            <div class="row">
                

                
               
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Image Upload</label>
                            <input class="form-control" id="icon" name="image" onchange="fun1()" type="file"  >
                    </div>
                </div>

                 <div class="col-sm-6">
                            <div class="form-group">
                                    <img style="width: 100%;height: 400px" id="img2" src="{{URL::to('storage/app/public/person')}}/{{@$data->userPic}}">
                             </div>
                         </div>

                


                










                






                <div class="col-sm-12"></div>
                <div class="col-sm-6"><button type="submit" id="submit" class="btn btn-info">Update Person</button></div>
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
            $("#submit").attr("disabled", true);

            form.submit(); // <- use 'form' argument here.
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

<script>
        function fun1(){
        var i=document.getElementById('icon').files[0];
        var b=URL.createObjectURL(i);
        $("#img2").attr("src",b);
    }
</script> 


@endsection