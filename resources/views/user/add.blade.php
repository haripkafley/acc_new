@extends('layouts.admin')

@section('content')

    <br>
    <section class="content">
        <div id="casedetailscard" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header" style="font-family:Product Sans">
                            {{-- Dzonkhag List --}}
                            <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Add User
                                </div>
                                <div class = "cards">
                                <a href="{{route('manage.user')}}" class="btn btn-primary" style="float: right;">
                                                            Back
                                 </a>
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            <form method="post" action="{{ route('manage.user.insert') }}">@csrf
                                
                                <input type="hidden" name="id" value="{{@$data->id}}">
                                <input type="hidden" name="role_id" value="{{@$data->role_id}}">
                                

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" name="name"  required class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CID</label>
                                    <input type="text" name="cid" class="form-control" required  maxlength="11" minlength="11">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">EID</label>
                                    <input type="text" name="eid" class="form-control" required  >
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="text" name="email"  required class="form-control">
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Password</label>
                                    <input type="password" name="password"  required class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mobile</label>
                                    <input type="text" name="mobile" required  class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Department</label>
                                    <select name="department" id="department" class="form-control">
                                        <option value="">Select</option>
                                        @foreach(@$department as $value)
                                        <option value="{{@$value->id}}">{{@$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                <label>Office<span style="font-weight: bold; color: red;">*</span></label>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="Nationlityradio" id="inlineCheckbox1" name="Nationlityradio" value="H" checked>
                                      <label class="form-check-label" for="inlineCheckbox1">Head Office</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" id="inlineCheckbox2" name="Nationlityradio" value="R">
                                      <label class="form-check-label" for="inlineCheckbox2">Regional Office</label>
                                    </div>
                            </div>


                                <div class="form-group" id="designation_div">
                                    <label for="exampleInputEmail1">Division</label>
                                    <select class="form-control" name="position" id="designation">
                                        <option value="">Select</option>
                                    </select>
                                </div>

                                <div class="form-group" id="regional_div" style="display: none;">
                                    <label for="exampleInputEmail1">Regional Office</label>
                                    <select name="regional_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach(@$regional as $value)
                                        <option value="{{@$value->id}}">{{@$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group" id="designation_div">
                                    <label for="exampleInputEmail1">Unit</label>
                                    <select class="form-control" name="unit">
                                        <option value="">Select</option>
                                        <option value="u1">u1</option>
                                        <option value="u2">u2</option>
                                        <option value="u3">u3</option>
                                    </select>
                                </div>

                                

                                

                                

                               

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>





          


        </div>
    </section>


    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>


<script type="text/javascript">
  $(document).ready(function(){
    $('#department').on('change',function(e){
      
      e.preventDefault();
      var id = $(this).val();
      
      $.ajax({
        url:'{{route('manage.get.division')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#designation').html(data.division);
          
        }
      })
    
   })
  })
</script>


<script type="text/javascript">
    $('input[type=radio][name=Nationlityradio]').change(function() {
       if (this.value == 'H') {
           $('#designation_div').show();
           $('#regional_div').hide();
       }else{
           $('#designation_div').hide();
           $('#regional_div').show();
           
       }

    });
</script>




@endsection
