@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Seized Items </div>
                        <div class = "card-body">
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Items Name</th>
                                        <th>Manufacturer</th>
                                        <th>Model</th>
                                        <th>Serial No</th>
                                        <th>Condition</th>
                                        <th>Status</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($seizeditems as $items)
                                        <tr>
                                           <td>{{ $items->item_name }}</td>
                                           <td>{{ $items->manufacturer }}</td>
                                           <td>{{ $items->model }}</td>
                                           <td>{{ $items->serial_no }}</td>
                                           <td>{{ $items->condition }}</td>
                                           <td>
                                            @if($items->status == "Sent to Forensics")
                                                Received
                                            @else
                                                {{ $items->status }}</td>
                                            @endif
                                           <td>
                                            @if($items->status != "Complete")
                                                <i onclick="editstatusforensics('{{ $items->id }}')" style="color:grey"  data-toggle="tooltip" data-placement="bottom" title="Edit"  class="fa fa-edit" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='grey';" ></i> &nbsp; </td>
                                            @endif
                                        </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>

    
<!-- edit modal -->
  <form method="POST" action="{{ route('updatestatusforensic') }}" enctype="multipart/form-data">
                            @csrf
    <div class="modal fade" id="editforensicstatus">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Status</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="itemid" id="itemid">
                    <div id="editforensicshow" style="display:none">
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
        function editstatusforensics(id)
        {
            $('#editforensicstatus').modal('show');     
            $('#itemid').val(id);

    var url = '{{ route("showeditforensic", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#idiaryid').val()},
                success: function(responseText) {
                    
                    $("#editforensicshow").html(responseText);
                    $('#editforensicshow').show();   
                }
            });
        }
    </script>
    <style>
     .modal-header {
    background: linear-gradient(to top, #BFABA2, #ffffff);
    color: Black;
    font-family: Product Sans;
    border-radius: 5px 5px 0 0;
}

</style>
</section>
@endsection