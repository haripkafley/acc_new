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
                              SI Plan
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add SI Plan
                                </button>
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                             @include('tacktical.indi.navbar')

                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Collected From</th>
                                        <th>Type Of Source</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Collection Officer</th>
                                        <th>Status</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$plan->isNotEmpty())
                                    @foreach(@$plan as $att)
                                    <tr>
                                        <td>{{ @$att->task}}</td>
                                        <td>{{ @$att->collected_from }}</td>
                                        <td>{{ @$att->source_name->name }} (Type - {{@$att->source_type}} )</td>
                                        <td>{{ @$att->start_date }}</td>
                                        <td>{{ @$att->end_date }}</td>
                                        <td>
                                            @php
                                                $explode = explode(',',$att->officer_assign_id);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}},
                                            @endforeach

                                        </td>
                                        <td>{{ $att->status_details->name }}</td>
                                        
                                        <td>
                                                        
                                                            @if(@$att->status!=2)
                                                             <a type="button"
                                                                class="btn btn-xs btn-primary edit_button"
                                                                data-id="{{$att->id}}"
                                                                data-task="{{$att->task}}"
                                                                data-start_date="{{$att->start_date}}"
                                                                data-end_date="{{$att->end_date}}"
                                                                data-collected_from="{{$att->collected_from}}"
                                                                data-officer_assign_id="{{$att->officer_assign_id}}"
                                                                data-source_type="{{$att->source_type}}"
                                                                data-source="{{$att->source}}"
                                                                data-status="{{$att->status}}"
                                                                data-toggle="modal"
                                                                >
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            
                                                            
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('tacktical.inteligence.autorization.individual.si-plan.information.page.delete.data',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                            </a>
                                                            @endif
                                                            
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
          <h5 class="modal-title" id="exampleModalLabel">Add SI Plan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('tacktical.inteligence.autorization.individual.si-plan.information.page.insert.data')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ti_id" value="{{@$id}}">
                <div class="form-group">
                  <label for="exampleInputEmail1">Task Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="task" aria-describedby="emailHelp" placeholder="Task Name">
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">Collected From</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="collected_from" aria-describedby="emailHelp">
                 </div>

                 {{-- <div class="form-group">
                  <label for="exampleInputEmail1">Source</label>
                  <select class="form-control" name="source" required>
                      <option value="">Select</option>
                      @foreach(@$source as $val)
                      <option value="{{@$val->id}}">{{@$val->name}}</option>
                      @endforeach
                  </select>
                 </div> --}}

                 <div class="form-group">
                                        <label for="exampleInputEmail1">Source Type</label>
                                        <select class="form-control source_type" name="source_type">
                                            <option value="">Select</option>
                                            <option value="OSINT">OSINT</option>
                                            <option value="SOCINT">SOCINT</option>
                                            <option value="Humint">Humint</option>
                                            <option value="DS">Data Source</option>
                                        </select>
                                        
                     </div>
                 



               
                <div class="form-group">
                    <label>Source</label>
                    <select class="form-control" required name="source" id="source">
                        <option value="">Select</option>
                     </select>
                </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Start Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="start_date" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">End Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="end_date" aria-describedby="emailHelp">
                 </div>


                  <div class="form-group mb-3">
                  <label for="select2Multiple">Collection Officer</label>
                  <br>
                  <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                    id="select2Multiple">
                    @foreach(@$users as $val)
                    <option value="{{@$val->id}}">{{@$val->name}}</option>
                    @endforeach              
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Status</label>
                  <select class="form-control" name="status" required>
                      <option value="">Select</option>
                      @foreach(@$status as $val)
                      <option value="{{@$val->id}}">{{@$val->name}}</option>
                      @endforeach
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


<!--Edit Modal -->
            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit SI Plan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('tacktical.inteligence.autorization.individual.si-plan.information.page.update.data')}}">@csrf
                                
                               <div class="form-group">
                              <label for="exampleInputEmail1">Task Name</label>
                              <input type="text" class="form-control" id="task" name="task" aria-describedby="emailHelp" placeholder="Task Name">
                             </div>


                             <div class="form-group">
                              <label for="exampleInputEmail1">Collected From</label>
                              <input type="text" class="form-control" id="collected_from" name="collected_from" aria-describedby="emailHelp">
                             </div>

                             {{-- <div class="form-group">
                              <label for="exampleInputEmail1">Source</label>
                              <select class="form-control" name="source" id="source" required>
                                  <option value="">Select</option>
                                  @foreach(@$source as $val)
                                  <option value="{{@$val->id}}">{{@$val->name}}</option>
                                  @endforeach
                              </select>
                             </div> --}}

                             <div class="form-group">
                                  <label for="exampleInputEmail1">Source Type</label>
                                  <input type="text" class="form-control" disabled id="source_type_edit"  aria-describedby="emailHelp">
                                 </div>

                                     <div class="form-group">
                                      <label for="exampleInputEmail1">Source</label>
                                      <select class="form-control" name="source_code" id="source_edit" disabled required>
                                          <option value="">Select</option>
                                          @foreach(@$source as $val)
                                          <option value="{{@$val->id}}">{{@$val->name}}</option>
                                          @endforeach
                                      </select>
                                     </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Start Date</label>
                              <input type="date" class="form-control" id="start_date" name="start_date" aria-describedby="emailHelp">
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">End Date</label>
                              <input type="date" class="form-control" id="end_date" name="end_date" aria-describedby="emailHelp">
                             </div>


                              <div class="form-group mb-3">
                              <label for="select2Multiple">Other Member Involved</label>
                              <br>
                              <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                                id="leaderMultiSelctdropdown">
                                @foreach(@$users as $val)
                                <option value="{{@$val->id}}">{{@$val->name}}</option>
                                @endforeach              
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputEmail1">Status</label>
                              <select class="form-control" name="status" id="status" required>
                                  <option value="">Select</option>
                                  @foreach(@$status as $val)
                                  <option value="{{@$val->id}}">{{@$val->name}}</option>
                                  @endforeach
                              </select>
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
            $('#task').val($(this).data('task'));
            $('#start_date').val($(this).data('start_date'));
            $('#end_date').val($(this).data('end_date'));
            $('#collected_from').val($(this).data('collected_from'));
            $('#source_edit').val($(this).data('source')).change();
            $('#source_type_edit').val($(this).data('source_type'));
            let string = $(this).data('officer_assign_id');
            if (/,/.test(string)) {
                 let arr = string.split(',');
                 $("#leaderMultiSelctdropdown").val(arr);
                 $('#leaderMultiSelctdropdown').val(arr).change();
            }else{
                let arr = [string];
                 $("#leaderMultiSelctdropdown").val(arr);
                 $('#leaderMultiSelctdropdown').val(arr).change();
            }
           
            $('#id').val($(this).data('id'));
            $('#status').val($(this).data('status')).change();
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


        <script type="text/javascript">
    $('.source_type').on('change',function(e){
        var source = $(this).val();
        var url = '{{ route('get.source.from.source.type', ':id') }}';
        url = url.replace(':id', source);
        $('#source').empty();
            
        $.getJSON(url, function(data) {
                $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    console.log(value);
                    $('#source').append('<option value="' + value.id + '">' + value.name +
                        '</option>');

                });
                
            });
    });
</script>

@endsection