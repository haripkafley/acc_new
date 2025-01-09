@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> 
                        {{-- Embassy List --}}
                        <div class="row" style="font-family:Product Sans">
                            <div class="col-sm">
                              MANAGE CEC MEMBER 
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    Add
                                </button>
                                
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>CID</th>
                                        <th>EID</th>
                                        <th>Department</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->user_details->name  }}</td>
                                        <td>{{ $att->user_details->cid }}</td>
                                        <td>{{ $att->user_details->eid }}</td>
                                        <td>{{ @$att->user_details->department_name->name }}</td>
                                        <td>
                                          <a class="btn btn-xs btn-danger" href="{{route('cec.user.addition.menu.index.delete.user',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i></a>
                                                            

                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
<div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Complaint Mode</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('cec.user.addition.menu.index.insert.user')}}">@csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Department</label>
                  <select class="form-control" name="deparment" id="department_change">
                      <option value="">Select</option>
                      @foreach(@$deparment as $value)
                      <option value="{{@$value->id}}">{{@$value->name}}</option>
                      @endforeach
                  </select>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Users</label>
                  <select name="user_id" class="form-control" id="user_id">
                      <option value="">Select</option>
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
  </div>






            

    </div>
</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#modeName').val($(this).data('name'));
            $('#id').val($(this).data('id'));
            $('#typeofAttachment').val($(this).data('attachment'));
            $('#exampleModaEdit').modal('show');
        })
</script>

<script type="text/javascript">
    $('#department_change').on('change',function(){
            var department = $('#department_change').val();
            var url = '{{ route('cec.user.addition.menu.index.get.department.user', ':id') }}';
            url = url.replace(':id', department);
            $('#user_id').empty();
            
            $.getJSON(url, function(data) {
                $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    console.log(value);
                    $('#user_id').append('<option value="' + value.id + '">' + value.name +'(EID :' + value.eid +
                        ')</option>');
                });
            });
        })
</script>

{{-- <script type="text/javascript">
    $('#department_change').on('change',function(e){
        var department = $('#department_change').val();
        alert(department);
        var url = '{{ route('cec.user.addition.menu.index.get.department.user', ':id') }}';
            url = url.replace(':id', department);
            $('#sel').empty();
            
            $.getJSON(url, function(data) {
                $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    console.log(value);
                    $('#user_id').append('<option value="' + value.id + '">' + value.name +"(EID : "+ value.eid+")"
                        '</option>');
                });
            });
    })
</script> --}}


@endsection