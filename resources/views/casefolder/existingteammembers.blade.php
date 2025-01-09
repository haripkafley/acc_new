<table  class="table">
    <thead>
        <tr>
            <th>Name:</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($existingteammembers as $extteams)
        <tr>
            <td>{{ $extteams->assigned_to }}</td>
            <td>{{ $extteams->role }}</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="showmodalreplaceinvestigator('{{ $extteams->assigned_to }}')" >REPLACE</button></td>
        </tr>
      @endforeach
    </tbody>
</table>
<!-- VIEW REPLACE MODAL-->

        <div class="modal fade" id="show_modal_replace_investigator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-scrollable" >
                <div class="modal-content">
                    <form action="{{ route('reassignmembers') }}" method="POST">
                        @csrf
                    <div class="modal-header alert-info">
                        <h5 class="modal-title" id="exampleModalLabel">REPLACE</h5>
                        <button type="button" class="close"  >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >REPLACE</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
</form>

<!-- END VIEW REPLACE MODAL -->
<script>
    function showmodalreplaceinvestigator(email)
        {
             $('#existinginvemail').val(email);
             $('#show_modal_replace_investigator').modal('show');
        
        }
</script>