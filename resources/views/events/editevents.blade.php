
 @foreach ($events as $event)
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Event Name&nbsp;<font color='red'>*</font></label>
                <input type="text" name="eventname"  class="form-control" id="eventname" value="{{ $event->name  }}">
                <input type="hidden" name="eventid"  class="form-control" id="eventid" value="{{ $event->id  }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Event Date&nbsp;<font color='red'>*</font></label>
                <input type="date" name="eventdate"  class="form-control" id="eventdate" value="{{ $event->date  }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Event Time&nbsp;<font color='red'>*</font></label>
                <input type="time" name="eventtime"  class="form-control" id="eventtime" value="{{ $event->time  }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Event Description&nbsp;<font color='red'>*</font></label>
                        <textarea name="event_desc" id="event_desc" class="form-control">{{ $event->description  }}</textarea>
            </div>
        </div>
    </div>
        
@endforeach