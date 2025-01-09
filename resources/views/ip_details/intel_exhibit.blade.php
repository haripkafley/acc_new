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
                              Exhibit
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Exhibit
                                </button>
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('ip_details.member_navbar')
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Exhibit Code</th>
                                        <th>Exhibit Name</th>
                                        <th>Collected Date</th>
                                        {{-- <th>Collected Method</th> --}}
                                        <th>Collected By</th>
                                        <th>Attachment</th>   
                                        <th>Description</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$exhibit->isNotEmpty())
                                    @foreach(@$exhibit as $att)
                                    <tr>
                                        <td>{{ $att->code}}</td>
                                        <td>{{ $att->name}}</td>

                                        <td>{{ $att->created_on }}</td>
                                        {{-- <td>{{ $att->created_method   }}</td> --}}
                                        <td>
                                            @php
                                                $explode = explode(',',$att->collected_by);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}},
                                            @endforeach

                                        </td>
                                        <td>
                                            @if(@$att->attachment!="")
                                            <a class="btn btn-xs btn-info" href="{{URL::to('attachment/ir')}}/{{$att->attachment}}" target="_blank"><i class="fa fa-eye"></i>View
                                            </a>
                                            @endif
                                        </td>
                                        <td>{{ $att->description}}</td>
                                        <td>
                                                        
                                                            
                                                             <a type="button"
                                                                class="btn btn-xs btn-primary edit_button"
                                                                data-id="{{$att->id}}"
                                                                data-code="{{$att->code}}"
                                                                data-name="{{$att->name}}"
                                                                data-created_on="{{$att->created_on}}"
                                                                {{-- data-created_method="{{$att->created_method}}" --}}
                                                                data-members="{{$att->collected_by}}"
                                                                data-description="{{$att->description}}"
                                                                data-toggle="modal"
                                                                >
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            
                                                            
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('manage.get.information.report.assignment.exhibit.plan.delete.data',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                            </a>
                                                            
                                                            
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
          <h5 class="modal-title" id="exampleModalLabel">Add Exhibit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('manage.get.information.report.assignment.exhibit.plan.insert.data')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ip_id" value="{{@$id}}">

                <div class="form-group">
                  <label for="exampleInputEmail1">Exhibit Code</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="code" aria-describedby="emailHelp" placeholder="Exhibit Code" required>
                 </div>


                <div class="form-group">
                  <label for="exampleInputEmail1">Exhibit Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp" placeholder="Exhibit Name" required>
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">Collected On</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="created_on" aria-describedby="emailHelp" required>
                 </div>

                 {{-- <div class="form-group">
                  <label for="exampleInputEmail1">Collected Method</label>
                  <select class="form-control" name="created_method" required>
                      <option value="">Select</option>
                      <option value="Mehtod One">Mehtod One</option>
                      <option value="Method Two">Method Two</option>
                  </select>
                 </div> --}}

                 <div class="form-group">
                  <label for="exampleInputEmail1">Collected By</label>
                  <label for="select2Multiple">Other Member Involved</label>
                  <br>
                  <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                    id="select2Multiple">
                    @foreach(@$users as $val)
                    <option value="{{@$val->id}}">{{@$val->name}}</option>
                    @endforeach              
                  </select>
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="description" aria-describedby="emailHelp" required></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Attachment</label>
                  <input type="file" class="form-control" id="exampleInputEmail1" name="attachment" aria-describedby="emailHelp" required>
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


<!--Edit Modal -->
            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Exhibit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get.information.report.assignment.exhibit.plan.update.data')}}">@csrf
                               
                               <div class="form-group">
                                  <label for="exampleInputEmail1">Exhibit Code</label>
                                  <input type="text" class="form-control" id="code" name="code" aria-describedby="emailHelp" placeholder="Exhibit Code" required>
                                 </div> 
                               <div class="form-group">
                                  <label for="exampleInputEmail1">Exhibit Name</label>
                                  <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Exhibit Name" required>
                                 </div>


                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Collected On</label>
                                  <input type="date" class="form-control" id="created_on" name="created_on" aria-describedby="emailHelp" required>
                                 </div>

                                 {{-- <div class="form-group">
                                  <label for="exampleInputEmail1">Collected Method</label>
                                  <select class="form-control" name="created_method" id="created_method" required>
                                      <option value="">Select</option>
                                      <option value="Mehtod One">Mehtod One</option>
                                      <option value="Method Two">Method Two</option>
                                  </select>
                                 </div> --}}

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Collected By</label>
                                  <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                                    id="leaderMultiSelctdropdown">
                                    @foreach(@$users as $val)
                                    <option value="{{@$val->id}}">{{@$val->name}}</option>
                                    @endforeach              
                                  </select>
                                 </div>


                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Description</label>
                                  <textarea type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp" required></textarea>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Attachment</label>
                                  <input type="file" class="form-control" id="exampleInputEmail1" name="attachment" aria-describedby="emailHelp" >
                                 </div>

                             
                                 
                             <input type="hidden" name="id" id="id">
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#name').val($(this).data('name'));
            $('#created_on').val($(this).data('created_on'));
            $('#code').val($(this).data('code'));
            $('#created_method').val($(this).data('created_method')).change();
            // $('#collected_by').val($(this).data('collected_by')).change();
            let string = $(this).data('members');
            
            
            if (/,/.test(string)) {
                 let arr = string.split(',');
                 $("#leaderMultiSelctdropdown").val(arr);
                 $('#leaderMultiSelctdropdown').val(arr).change();
            }else{
                let arr = [string];
                 $("#leaderMultiSelctdropdown").val(arr);
                $("#leaderMultiSelctdropdown").val(arr);
                $('#leaderMultiSelctdropdown').val(arr).change();
            }
            $('#description').val($(this).data('description'));
            $('#id').val($(this).data('id'));
            $('#exampleModaEdit').modal('show');
        })
</script>

     <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

        });

    </script>



@endsection