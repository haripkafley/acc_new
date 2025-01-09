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
                            <div class = "cards">
                                <a href="{{route('manage.role')}}" class="btn btn-primary" style="float: right;">
                                                            Back
                                 </a>
                                </div>
                            <div class="row" style="font-family:Product Sans">
                                    <div class="col-sm-6">
                                    <!-- Button trigger modal -->
                                    <form method="post" action="{{route('manage.permission',['id'=>@$id])}}">
                                        @csrf
                                        <div class="form-group">
                                    <label for="exampleInputEmail1">Components</label>
                                    <select class="form-control" name="component" id="component">
                                        <option value="">Select</option>
                                        @foreach(@$components as $value)
                                        <option value="{{@$value->id}}" @if(request('component')==@$value->id) selected @endif>{{@$value->component_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Module</label>
                                    <select class="form-control" name="module" id="module">
                                        <option>Select</option>
                                        @if(request('module'))
                                         @foreach(@$module_data as $value)
                                        <option value="{{@$value->id}}" @if(request('module')==@$value->id) selected @endif>{{@$value->module_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Search Menu</button>
                                

                                </form>
                                </div>
                            </div>

                        </div>






                        <div class="card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <form method="POST" action="{{route('update.role.permission')}}"  >
                            @csrf
                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Menu Name</th>
                                        <th>SubMenu Name</th>
                                        <th>View Access</th>
                                        <th>Edit Access</th>
                                        <th>Add Access</th>
                                        <th>Delete Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data)
                                    @if (@$data->isNotEmpty())
                                        @foreach (@$data as $key=> $att)
                                            <tr>
                                                <td>{{ $att->menu_name->menu_name }}</td>
                                                <td>{{ $att->sub_menu_name }}</td>
                                                <input type="hidden" name="addmore[{{$key}}][module]" value="{{@$module}}">
                                                <input type="hidden" name="addmore[{{$key}}][component]" value="{{@$component}}">

                                                <input type="hidden" name="addmore[{{$key}}][menu_id]" value="{{@$att->menu_id}}">

                                                <input type="hidden" name="addmore[{{$key}}][sub_menu_id]" value="{{@$att->id}}">

                                                <input type="hidden" name="addmore[{{$key}}][role_id]" value="{{@$id}}">
                                                


                                                @if(in_array($att->id,@$selected))

                                                @php
                                                $check = DB::table('tbl_mst_role_permission')->where('sub_menu_id',$att->id)->where('role_id',@$id)->first();
                                                @endphp

                                                <td><input type="checkbox" @if(@$check->view_option=="Y") checked @endif name="addmore[{{$key}}][view_option]" value="Y" class="form-control"></td>

                                                @if($att->type=="NM")

                                                <td><input type="checkbox" @if(@$check->edit_option=="Y") checked @endif  name="addmore[{{$key}}][edit_option]" value="Y" class="form-control"></td>

                                                <td><input type="checkbox" @if(@$check->add_option=="Y") checked @endif  name="addmore[{{$key}}][add_option]" value="Y" class="form-control"></td>

                                                <td><input type="checkbox" @if(@$check->delete_option=="Y") checked @endif  name="addmore[{{$key}}][delete_option]" value="Y" class="form-control"></td>

                                                @endif

                                                @else

                                                <td><input type="checkbox"  name="addmore[{{$key}}][view_option]" value="Y" class="form-control"></td>

                                                @if($att->type=="NM")

                                                <td><input type="checkbox"  name="addmore[{{$key}}][edit_option]" value="Y" class="form-control"></td>

                                                <td><input type="checkbox"  name="addmore[{{$key}}][add_option]" value="Y" class="form-control"></td>

                                                <td><input type="checkbox"  name="addmore[{{$key}}][delete_option]" value="Y" class="form-control"></td>

                                                @endif

                                                @endif
                                                
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif
                                    @endif

                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-warning">Update Permission</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
           {{--  <div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('manage.permission.insert') }}">@csrf
                                
                                <input type="hidden" name="role_id" value="{{@$id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Menu</label>
                                    <select class="form-control" name="menu_id" id="menu_id">
                                        <option value="">Select menu</option>
                                        @foreach(@$menu as $value)
                                        <option value="{{@$value->id}}">{{@$value->menu_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">SubMenu</label>
                                    <select class="form-control" name="sub_menu_id" id="submenu">
                                        <option value="">Select sub menu</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">View Access</label>
                                    <select class="form-control" name="view_option" id="view_option">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Add Access</label>
                                    <select class="form-control" name="add_option" id="add_option">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Edit Access</label>
                                    <select class="form-control" name="edit_option" id="edit_option">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>

                                

                                

                               

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            --}}


          


        </div>
    </section>


    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>


<script type="text/javascript">
  $(document).ready(function(){
    $('#component').on('change',function(e){
      
      e.preventDefault();
      var id = $(this).val();
      // alert(id);
      $.ajax({
        url:'{{route('manage.permission.get.submenu')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
         console.log(data);
          $('#module').html(data.submenu);
          
        }
      })
    
   })
  })
</script>




@endsection
