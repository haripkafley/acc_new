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
                             Diary Form
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Diary
                                </button>
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">

                            {{-- @include('tacktical.indi.navbar') --}}
                                <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.diary.page.head.details')) active btn btn-info @endif"  href="{{route('tacktical.diary.page.head.details',@$id)}}">Diary Head</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.diary.page.head.details.individuals.details')) active btn btn-info @endif"  href="{{route('tacktical.diary.page.head.details.individuals.details',@$id)}}">Diary Official</a>
                                    </li>
                                </ul>
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Ir/Ti No</th>
                                        <th>Activity</th>
                                        <th>Event</th>
                                        <th>Date Of Event</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Remarks</th>
                                        <th>Type</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        @if(@$att->type_format=="diary")
                                        <td>@if(@$att->type_of_file=="information") {{@$att->ir_details->ir_no}} @else {{@$att->ti_details->si_ig_no}} @endif</td>
                                        <td>{{ $att->activity}}</td>
                                        <td>{{ $att->event }}</td>
                                        <td>{{ $att->date_of_event   }}</td>
                                        <td>{{ $att->start_time }}</td>
                                        <td>{{ $att->end_time }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        <td>Diary</td>
                                        @elseif(@$att->type_format=="intel_plan")
                                        <td>{{@$att->ir_details->ir_no}}</td>
                                        <td>{{ $att->task}}</td>
                                        <td>--</td>
                                        <td>{{ $att->start_date}}</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>Intel Plan</td>
                                        @else
                                        <td>{{@$att->ir_details->ir_no}}</td>
                                        <td>{{ $att->activity}}</td>
                                        <td>--</td>
                                        <td>{{ $att->start_date}}</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>Idiary</td>

                                        @endif
                                        <td>
                                                        
                                                             @if(@$att->type_format=="diary") 
                                                             <a type="button"
                                                                class="btn btn-xs btn-primary edit_button"
                                                                data-id="{{$att->id}}"
                                                                data-activity="{{$att->activity}}"
                                                                data-event="{{$att->event}}"
                                                                data-date_of_event="{{$att->date_of_event}}"
                                                                data-start_time="{{$att->start_time}}"
                                                                data-end_time="{{$att->end_time}}"
                                                                data-remarks="{{$att->remarks}}"
                                                                data-toggle="modal"
                                                                >
                                                                Edit
                                                            </a>
                                                            
                                                            
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('tacktical.inteligence.autorization.individual.diary.information.page.delete',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
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
          <h5 class="modal-title" id="exampleModalLabel">Add Diary</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('tacktical.inteligence.autorization.individual.diary.information.page.insert')}}" enctype="multipart/form-data">
                @csrf
                {{-- <input type="hidden" name="ti_id" value="{{@$id}}"> --}}
                <div class="form-group">
                  <label for="exampleInputEmail1">IR/TI No</label>
                  <select class="form-control ir_ti_id" required name="ti_id">
                      <option value="">Select</option>
                      @foreach(@$tiList as $val)
                      <option value="{{@$val->id}}" data-type="tacktical">{{@$val->si_ig_no}}</option>
                      @endforeach

                      @foreach(@$irList as $val)
                      <option value="{{@$val->id}}" data-type="information">{{@$val->ir_no}}</option>
                      @endforeach
                  </select>
                 </div>

                 <input type="hidden" name="type_of_file" id="type_of_file">

                <div class="form-group">
                  <label for="exampleInputEmail1">Activity Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="activity" aria-describedby="emailHelp" placeholder="Activity Name">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Event Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="event" aria-describedby="emailHelp" placeholder="Event Name">
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">Date Of Event</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="date_of_event" aria-describedby="emailHelp">
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
                  <label for="exampleInputEmail1">Remarks</label>
                  <textarea class="form-control" name="remarks"></textarea>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Idiary</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('tacktical.inteligence.autorization.individual.diary.information.page.update')}}">@csrf
                                
                              <div class="form-group">
                              <label for="exampleInputEmail1">Activity Name</label>
                              <input type="text" class="form-control" id="activity" name="activity" aria-describedby="emailHelp" placeholder="Activity Name">
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Event Name</label>
                              <input type="text" class="form-control" id="event" name="event" aria-describedby="emailHelp" placeholder="Event Name">
                             </div>


                             <div class="form-group">
                              <label for="exampleInputEmail1">Date Of Event</label>
                              <input type="date" class="form-control" id="date_of_event" name="date_of_event" aria-describedby="emailHelp">
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
                              <label for="exampleInputEmail1">Remarks</label>
                              <textarea class="form-control" name="remarks" id="remarks"></textarea>
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
            $('#activity').val($(this).data('activity'));
            $('#event').val($(this).data('event'));
            $('#start_time').val($(this).data('start_time'));
            $('#end_time').val($(this).data('end_time'));
            $('#date_of_event').val($(this).data('date_of_event'));
            $('#remarks').val($(this).data('remarks'));
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
    <script type="text/javascript">
        $('.ir_ti_id').on('change',function(e){
            var type = $('.ir_ti_id option:selected').data('type');
            $('#type_of_file').val(type);
        })
    </script>

@endsection