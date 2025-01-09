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
                                    Role Permission Edit
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            <form method="post" action="{{ route('manage.permission.update') }}">@csrf
                                
                                <input type="hidden" name="id" value="{{@$data->id}}">
                                <input type="hidden" name="role_id" value="{{@$data->role_id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Menu</label>
                                    <select class="form-control" name="menu_id" id="menu_id">
                                        <option value="">Select menu</option>
                                        @foreach(@$menu as $value)
                                        <option value="{{@$value->id}}" @if(@$data->menu_id==@$value->id) selected @endif>{{@$value->menu_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">SubMenu</label>
                                    <select class="form-control" name="sub_menu_id" id="submenu">
                                        <option value="">Select sub menu</option>
                                         @foreach(@$submenu as $value)
                                        <option value="{{@$value->id}}" @if(@$data->sub_menu_id==@$value->id) selected @endif>{{@$value->sub_menu_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">View Access</label>
                                    <select class="form-control" name="view_option" id="view_option">
                                        <option value="Y" @if(@$data->view_option=="Y") selected @endif>Yes</option>
                                        <option value="N" @if(@$data->view_option=="N") selected @endif>No</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Add Access</label>
                                    <select class="form-control" name="add_option" id="add_option">
                                        <option value="Y" @if(@$data->add_option=="Y") selected @endif>Yes</option>
                                        <option value="N" @if(@$data->add_option=="N") selected @endif>No</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Edit Access</label>
                                    <select class="form-control" name="edit_option" id="edit_option">
                                        <option value="Y" @if(@$data->edit_option=="Y") selected @endif>Yes</option>
                                        <option value="N" @if(@$data->edit_option=="N") selected @endif>No</option>
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
    $('#menu_id').on('change',function(e){
      
      e.preventDefault();
      var id = $(this).val();
      
      $.ajax({
        url:'{{route('manage.permission.get.submenu')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#submenu').html(data.submenu);
          
        }
      })
    
   })
  })
</script>




@endsection
