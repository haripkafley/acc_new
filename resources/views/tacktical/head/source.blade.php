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
                              Source Form
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Source
                                </button>
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('tacktical.head.navbar')
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>SIR NO</th>
                                        <th>Source Code</th>
                                        <th>SIR Received Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Details</th>
                                        <th>Officers</th>
                                        <th>Action</th>          
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$sir->isNotEmpty())
                                    @foreach(@$sir as $att)
                                    <tr>
                                        <td>{{ $att->sir_no}}</td>
                                        <td>{{ @$att->source_name->name }} (Type - {{@$att->source_type}} )</td>
                                        <td>{{ $att->received_date   }}</td>
                                        <td>{{ $att->start_time }}</td>
                                        <td>{{ $att->end_time }}</td>
                                        <td>{{ $att->details }}</td>
                                        <td>
                                            @php
                                                $explode = explode(',',$att->officers);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}},
                                            @endforeach

                                        </td>
                                        <td>
                                                        
                                                            
                                                             <a type="button"
                                                                class="btn btn-xs btn-primary edit_button"
                                                                data-id="{{$att->id}}"
                                                                data-source_type="{{$att->source_type}}"
                                                                data-source_code="{{$att->source_code}}"
                                                                data-received_date="{{$att->received_date}}"
                                                                data-start_time="{{$att->start_time}}"
                                                                data-end_time="{{$att->end_time}}"
                                                                data-details="{{$att->details}}"
                                                                data-members="{{$att->officers}}"
                                                                data-toggle="modal"
                                                                >
                                                                Edit
                                                            </a>
                                                            
                                                            
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('tacktical.inteligence.autorization.individual.source.information.page.delete.data',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
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

<div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Source Information Report</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('tacktical.inteligence.autorization.individual.source.information.page.insert.data')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ti_id" value="{{@$id}}">
                {{-- <div class="form-group">
                  <label for="exampleInputEmail1">Source</label>
                  <select class="form-control" name="source_code" required>
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
                                            <option value="Humint">Humint</option>
                                       </select>
                                        
                     </div>
                 



               
                <div class="form-group">
                    <label>Source</label>
                    <select class="form-control" required name="source_code" id="source">
                        <option value="">Select</option>
                        <option value="Other">Other</option>
                    </select>
                </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">SIR Received Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="received_date" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Start Time</label>
                  <input type="time" class="form-control" id="exampleInputEmail1" name="start_time" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">End Time</label>
                  <input type="time" class="form-control" id="exampleInputEmail1" name="end_time" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">SIR Details</label>
                  <textarea name="details" class="form-control"></textarea>
                 </div>

                


                  <div class="form-group mb-3">
                  <label for="select2Multiple">Dealing Officers</label>
                  <br>
                  <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                    id="select2Multiple">
                    @foreach(@$users as $val)
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Source Information Report</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('tacktical.inteligence.autorization.individual.source.information.page.update.data')}}">@csrf
                                
                               {{-- <div class="form-group">
                                  <label for="exampleInputEmail1">Source</label>
                                  <select class="form-control" name="source_code" id="source_code" required>
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
                                  <label for="exampleInputEmail1">SIR Received Date</label>
                                  <input type="date" class="form-control" id="received_date" name="received_date" aria-describedby="emailHelp">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Start Time</label>
                                  <input type="time" class="form-control" id="start_time" name="start_time" aria-describedby="emailHelp">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">End Time</label>
                                  <input type="time" class="form-control" id="end_time" name="end_time" aria-describedby="emailHelp">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">SIR Details</label>
                                  <textarea name="details" id="details" class="form-control"></textarea>
                                 </div>


                              <div class="form-group mb-3">
                              <label for="select2Multiple">Dealing Officers</label>
                              <br>
                              <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                                id="leaderMultiSelctdropdown">
                                @foreach(@$users as $val)
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
            $('#source_edit').val($(this).data('source_code')).change();
            $('#received_date').val($(this).data('received_date'));
            $('#end_date').val($(this).data('end_date'));
            $('#start_time').val($(this).data('start_time'));
            $('#end_time').val($(this).data('end_time'));
            $('#details').val($(this).data('details'));
            $('#source_type_edit').val($(this).data('source_type'));
            let string = $(this).data('members');
            $('#id').val($(this).data('id'));
            // let arr = string.split(',');

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