   
    <label for = "exampleInputEmail1">Supervisor's Declaration</label>
   <br>
   @foreach ($coifiles as $coifiles)
  {{ $coifiles->declared_by }}'s Conflict :
               
    @if($coifiles->nature_of_conflict == "No Conflict")
    Negative
    @else
    {!! $coifiles->nature_of_conflict !!}
    @endif
           <br>
@endforeach