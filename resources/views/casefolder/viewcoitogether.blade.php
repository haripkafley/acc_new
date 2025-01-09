   
<table  class="table t2">
    <thead>
        <tr>
            <th>Conflict Declarant:</th>
            <th>Nature of Conflict</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($coifiles as $coifiles)
        <tr>
            <td>{{ $coifiles->name }}</td>
            <td>
                <br>
                @if ($coifiles->nature_of_conflict == "No Conflict") 
                  Negative   
                @else
                    {{ $coifiles->nature_of_conflict }}
                @endif
            </td>
            <td>
                @if($coifiles->declared_by == "Investigator" && $coifiles->nature_of_conflict != "No Conflict")
                      <button type="button" class="btn btn-danger btn-sm" onclick="showmodalreplaceinvestigator('{{ $coifiles->email }}','{{ $coifiles->id }}','{{ $coifiles->name }}', '{{ $coifiles->role}}' , '{{ $coifiles->department}}')" >REPLACE</button>
                @endif
            </td>
            
        </tr>
      @endforeach
    </tbody>
</table>
<form method = "POST" action="{{ route('replaceinvestigator') }}" enctype="multipart/form-data" >
    @csrf      

    <div class="modal fade" id="show_modal_replace_investigator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-large modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <h5 class="modal-title" >Change Team Members</h5>
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Current Member:&nbsp;</label>
                                        <input type="text" readonly name="existinginv"  class="form-control" id="existinginv">
                                        <input type="hidden" name="existinginvemail"  class="form-control" id="existinginvemail">
                                        <input type="hidden"  name="id"  class="form-control" id="id">
                                        <input id = "casenoidreplace" class="form-control"  type="hidden" name="casenoidreplace" value="{{ $casenoid }}"  >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Replace By:&nbsp;</label>
                                            <select class="form-control" id="newmember" name="newmember">
                                                <option value="">Please Select One</option>
                                                    @foreach ($users as $user)
                                                        <option value = "{{ $user->email }}">{{ $user->name }}</option>
                                                    @endforeach
                                            </select>
                                    </div>
                                </div>
                            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</form>
<script>
    function showmodalreplaceinvestigator(email,id,name,role,department)
        {
            
             $('#existinginv').val(name);
             $('#existinginvemail').val(email);
             $('#id').val(id);
            // $('#case_title_coi').val(casetitle);
            // $('#case_regdate_coi').val(caseregdate);

            $('#show_modal_replace_investigator').modal('show');
        
        }
</script>
<style>
    .t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
    align:center;
}
</style>
