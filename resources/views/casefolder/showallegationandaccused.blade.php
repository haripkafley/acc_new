                <div class="row">
                        <div class = "col-md-6">
                            <div class = "form-group">
                                <label for = "exampleInputEmail1">Complaint Details</label>
                                    <ol>
                                        @foreach ($offences as $off)
                                            <li> 
                                                {{ $off->offence_type }}<br>
                                            </li>
                                        @endforeach
                                    </ol>                     
                            </div>
                        </div>
                        <!-- <div class = "col-md-6">
                            <div class = "form-group">
                                <label for = "exampleInputEmail1">Alleged Party (ies)</label>
                                
                               <ol>
                                @foreach ($entitieshow as $entityshow)
                                    <li>
                                    {{ $entityshow->entity_name }}<br>
                                    </li>
                                @endforeach 
                                </ol>                            
                            </div>
                        </div> -->
                </div>

                <table id="addmoretable" class="table table-bordered table-hover">
                                            <thead>
                                                    <tr>
                                                        <th>Accused</th>
                                                        <th>CID/Permit No</th>
                                                        <th></th>
                                                        
                                                        
                                                        
                                                       
                                                    </tr>
                                            </thead>
                                                
                                            <tbody id="entity">
                                            
                                                @foreach ($entitieshow as $entityshow)
                                                    <tr >
                                                        <td >
                                                            {{ $entityshow->entity_name }}
                                                            <input type="hidden" value="{{ $entityshow->entity_name }}"  name="entity_name_inv[]" id="entity_name_inv">
                                                        </td>
                                                        <td >
                                                            {{ \Carbon\Carbon::parse($entityshow->entity_cid)->format('d/m/Y')}}
                                                            <input type="hidden" value="{{ $entityshow->entity_cid }}"  name="entity_cid_inv[]" id="entity_cid_inv">
                                                            
                                                        </td>
                                                        <td>
                                                        <button type="button" class="btn btn-primary" onclick="viewentitydetailscoi('{{ $entityshow->id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="View Details">View Details</button> 
                                                        </td>
                                                    </tr>
                                            @endforeach
                                            </tbody>
                                    </table>  

<!-- Show Entity Details -->
<form method = "POST" action="{{ route('declarecoi_investigator') }}"  enctype="multipart/form-data" >
                                    @csrf    

    <div class="modal fade" id="show_entity_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <h5 class="modal-title" >Entity Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   
                <input type="hidden" value=""  name="entityidcoi" id="entityidcoi">
                    <div id="entitydetailsshow" style="display:none;"></div>
                   
                </div>
                    
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- FINISH Declare COI -->

<script>
    
    function viewentitydetailscoi(id){
    
        $('#entityidcoi').val(id);
        $('#show_entity_details').modal('show');
    

   var url = '{{ route("searchentitydetails", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#entityidcoi').val()},
                success: function(result) {
                    
                    $("#entitydetailsshow").html(result);
                    $("#entitydetailsshow").show();
                    
                }
            });


    
}
</script>