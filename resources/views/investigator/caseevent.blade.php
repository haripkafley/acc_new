@extends('layouts.admin')

@section('content')
<br>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@include('investigator/mainheader')
    <!------------------------ end top part ---------------->  
<div class="col-sm-13" style="margin-top:-9px;">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                @include('tabs/investigator_tab')
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                        <button type="button" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" style="float:right" onclick="showtimeline()">
                                <span><i class="fa fa-eye"></i></span>    
                                <span style="font:face:Product Sans">Timeline</span>
                            </button>
                        @if(Auth::user()->role == "Investigator")
                            <button type="button" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" style="float:right" onclick="addnewevent()">
                                <span><i class="fa fa-plus"></i></span>    
                                <span style="font:face:Product Sans">Add Event</span>
                            </button>
                        @endif
                        <br>
                        <br>    
                            <table class="table t2" style="font-family:Product Sans" id="addeventtable">
                                <tr>
                                    <th class="sorting sorting_asc">Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                @if($events->count())
                                @foreach($events as $event)
                                <tr>
                                    <td>{{ $event->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y')}}</td>
                                    @if($event->time != "")
                                <td> {{ date('g:i A', strtotime($event->time)) }}</td>
                                @else
                                <td>Not Available</td>
                                @endif
                                    <td>{!! $event->description !!}</td>
                                    <td>
                                        @if(Auth::user()->role == "Investigator")
                                            <i style="color:gray" onclick="showeditevent('{{ $event->id }}')"  data-toggle="tooltip" data-placement="bottom" title="Edit Summary"  class="fa fa-edit"></i>
                                            <a  href="{{ route('deleteevent', $event->id) }}" style="color:red" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='red';" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                        <tr>
                                            <td colspan="6" style="text-align: center"> No record found </td>
                                        </tr>
                                    @endif
                            </table>
                            <!--timeline -->
                            <div id="timelinediv"style="margin-left:350px; display:none">
                            <i class="fa fa-times" title="Close" onclick="closetimelinediv()" id="closetimeline" name="closetimeline" style="float:right; color:grey" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='grey';"  data-toggle="tooltip" data-placement="bottom">&nbsp;&nbsp;</i><br>
                                <div class="timeline" >
                                    @foreach($eventtimeline as $eventtime)
                                        <div class="timeline-item">
                                            <div class="timeline-date">
                                                <p>{{ \Carbon\Carbon::parse($eventtime->date)->format('d/m/Y')}}</p>
                                            </div>
                                            <div class="timeline-indicator"></div>
                                            <div class="timeline-content">
                                                <h4>{{ $eventtime->name }}</h4>
                                                <p class="timeline-p">{{ $eventtime->description }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!--timeline end -->
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

<!--add modal -->
<form method = "POST" action="{{ route('addevent') }}"  enctype="multipart/form-data" >
      @csrf    
<div class="modal fade" id="addcaseevent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                <h5 class="modal-title" id="exampleModalLabel">Add Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="eventcasenoidadd" id="eventcasenoidadd" value="{{ $casenoid }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event Name&nbsp;<font color='red'>*</font></label>
                                <input type="text" name="eventname"  class="form-control" id="eventname">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event Date&nbsp;<font color='red'>*</font></label>
                                <input type="date" class="form-control" name="eventdate" id="eventdate" />
                            </div>        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event Time (Optional)</label>
                                <input type="time" name="event_time"  id="event_time" class="form-control" >
                            </div> 
                        </div> 
                    </div>  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Event Description&nbsp;<font color='red'>*</font></label>
                                <textarea name="event_desc" id="event_desc" class="form-control" required=""></textarea>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
    </div>
</form>
<!--end add modal -->

<!-- edit modal -->
<form method="POST" action="{{ route('updateevent') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="editcaseevent">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="editeventid" id="editeventid">
                        <div id="editeventshow" style="display:none"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- end edit modal -->


<script>

function addnewevent()
{
        $('#addcaseevent').modal('show');  
}

function showtimeline()
{
    $('#timelinediv').show();
    $('#addeventtable').hide();
    $('#addeventbutton').hide();
    $('#timelinebutton').hide();
    $('#closetimeline').show();
    
}

function closetimelinediv()
{
    $('#timelinediv').hide();
    $('#addeventtable').show();
    $('#addeventbutton').show();
    $('#timelinebutton').show();
    $('#closetimeline').hide();
}

function showeditevent(id)
{
        $('#editcaseevent').modal('show'); 
        $('#editeventid').val(id);

    var url = '{{ route("editevent", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#editeventid').val()},
                success: function(responseText) {
                    
                    $("#editeventshow").html(responseText);
                    $('#editeventshow').show();   
                }
            }); 
}
</script>
<style>
    
    .modal-header {
    background: linear-gradient(to top, grey, #ffffff);
    color: #fff;
    border-radius: 5px 5px 0 0;
    font-family: Product Sans;
}
.t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
}

  .timeline {
    position: relative;
     margin-left: -200px;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
    
}

.timeline-date {
    margin-left: -70px;
    font-family: Product Sans;
}

.timeline-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #fff;
    border: 2px solid red;
    position: absolute;
    left:  33px;
    transform: translateX(-50%);
    top: 2px; /* Adjust the distance from the line */
}

.timeline-content {
    flex-grow: 1;
    margin-left: 42px;
    font-family: Product Sans;
    top: 2px;
}

.timeline h3, .timeline p {
    margin: 0;
}

.timeline-p {
    display: grid;
    grid-template-columns: max-content 1fr;
    align-items: center;
    border-radius: 4px;
    padding: 10px;
    background-color: #ECECEC; 
    font-family: Product Sans;/* Set the background color to grey */
}
</style>

@endsection