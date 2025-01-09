   
  @foreach ($coifiles as $coifiles)
  <label>{{ $coifiles->declared_by }}'s Conflict</label> 
  &nbsp;
               
    @if($coifiles->nature_of_conflict == "No Conflict")
    Negative
    @else
    {!! $coifiles->nature_of_conflict !!}
    @endif
      <br>     
@endforeach
