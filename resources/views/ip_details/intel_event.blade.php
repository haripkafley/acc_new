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
                              Intel Event
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Intel Event
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
                                        <th>Event Name</th>
                                        <th>Event Date</th>
                                        <th>Event Description</th>
                                        <th>Event Time</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$event->isNotEmpty())
                                    @foreach(@$event as $att)
                                    <tr>
                                        <td>{{ $att->name}}</td>
                                        <td>{{ $att->event_date }}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->event_time }}</td>
                                        <td>
                                                        
                                                            
                                                             <a type="button"
                                                                class="btn btn-xs btn-primary edit_button"
                                                                data-id="{{$att->id}}"
                                                                data-name="{{$att->name}}"
                                                                data-event_date="{{$att->event_date}}"
                                                                data-event_time="{{$att->event_time}}"
                                                                data-description="{{$att->description}}"
                                                                data-toggle="modal"
                                                                >
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            
                                                            
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('manage.get.information.report.assignment.intel.event.plan.delete.data',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
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
          <h5 class="modal-title" id="exampleModalLabel">Add Intel Event</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('manage.get.information.report.assignment.intel.event.plan.insert.data')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ip_id" value="{{@$id}}">
                <div class="form-group">
                  <label for="exampleInputEmail1">Event Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp" placeholder="Event Name" required>
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">Event Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="event_date" aria-describedby="emailHelp" required>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Event Time</label>
                  <input type="time" class="form-control" id="exampleInputEmail1" name="event_time" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Event Description</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="description" aria-describedby="emailHelp" required></textarea>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Intel Event</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get.information.report.assignment.intel.event.plan.update.data')}}">@csrf
                                
                               <div class="form-group">
                                  <label for="exampleInputEmail1">Event Name</label>
                                  <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Event Name" required>
                                 </div>


                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Event Date</label>
                                  <input type="date" class="form-control" id="event_date" name="event_date" aria-describedby="emailHelp" required>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Event Time</label>
                                  <input type="time" class="form-control" id="event_time" name="event_time" aria-describedby="emailHelp">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Event Description</label>
                                  <textarea type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp" required></textarea>
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
            $('#event_date').val($(this).data('event_date'));
            $('#event_time').val($(this).data('event_time'));
            $('#description').val($(this).data('description'));
            $('#id').val($(this).data('id'));
            $('#exampleModaEdit').modal('show');
        })
</script>




@endsection