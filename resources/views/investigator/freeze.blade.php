@extends('layouts.admin')

@section('content')
<br>
@include('investigator/mainheader')
    <!------------------------ end top part ---------------->

    

	<div class="card  card-tabs">
  		<h6 class="card-header">@include('tabs/investigator_tab')</h6>
  			<div class="card-body">
			  	<div class="row">
                    <div class="col-12 col-sm-12">
                        @include('tabs/searchandseizure_tab')  
                        <br>
                        <div class="header" style="background-color:#D3D3D3;height:40px; border-radius:5px; margin-top:10px;">&nbsp;&nbsp;<font color='#000000' size="5.2" face="Product Sans">Freeze/Unfreeze</font></div>
                        <br>
                            <div id="showfreeze">
                                <table class="table">
                                    <thead >
                                        <tr>
                                            <th>Asset Type</th>
                                            <th>Owner</th>
                                            <th>Status</th>
                                            <th>Freeze Date</th>
                                            <th>Revoke Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($entityasset->count())
                                            @foreach ($entityasset as $asset)
                                            <tr>   
                                                <td>{{ $asset->asset_type }}</td>
                                                <td>{{ $asset->owner }}</td>
                                                <td>
                                                    @if($asset->status == "")
                                                        Not available
                                                    @elseif($asset->status == "Frozen")    
                                                        <label class="text-danger">{{ $asset->status }}</label>
                                                    @else
                                                        <label class="text-success">{{ $asset->status }}</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($asset->freeze_date == "")
                                                        Not available
                                                    @else    
                                                        {{ \Carbon\Carbon::parse($asset->freeze_date)->format('d/m/Y')}}
                                                @endif
                                                </td>
                                                 <td>
                                                    @if($asset->unfreeze_date == "")
                                                        Not available
                                                    @else    
                                                        {{ \Carbon\Carbon::parse($asset->unfreeze_date)->format('d/m/Y')}}
                                                @endif
                                                </td>
                                                <td>
                                                    @if($asset->status == "")
                                                        <button  class="btn btn-primary btn-sm" title="Freeze" onclick="showfreezedetails('{{ $asset->id }}')">Freeze</button>
                                                    @elseif($asset->status == "Frozen")
                                                        <button  class="btn btn-primary btn-sm" title="Freeze" onclick="showunfreezedetails('{{ $asset->id }}')">Revoke</button>
                                                        <button  class="btn btn-primary btn-sm" >Notify Authority</button>
                                                    @else($asset->status == "Revoke")
                                                        <button  class="btn btn-primary btn-sm"  >Notify Authority</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5"> No record found </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    </table>
                            </div> 
                                      
					</div>
				</div>
  			</div>
	</div>
    
<!-- edit modal -->
  <form  method = "POST" action="{{ route('addfreeze') }}" enctype="multipart/form-data">
    @csrf 
<div class="modal fade" id="displayfreezemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Add Freeze</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="assetid" id="assetid">
                    <div id="displayassetdetails" style="display:none"></div>
                    <hr style="height: 1px;  background: teal; margin: 10px 0;   box-shadow: 0px 0px 4px 2px rgba(204,204,204,1);">        
                        <div class="row">
                            
                              <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Date of Freeze </label><br>
                                      <input class="form-control" type="date" name="freezedate" >                              
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Details&nbsp;</label><br>
                                       <textarea class="form-control" name="freezedetails" id="freezedetails" cols="5"></textarea> 
                                </div>
                            </div>
                        </div>
                         
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary"  name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Update" >Print Freeze Order</button> 
                </div>
            </div>
        </div>
    </div>
</form>
<!-- end edit modal -->

<!-- edit modal -->
  <form  method = "POST" action="{{ route('addunfreeze') }}" enctype="multipart/form-data">
    @csrf 
<div class="modal fade" id="displayunfreezemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Revoke Freeze</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="assetidun" id="assetidun">
                    <div id="displayassetdetailsun" style="display:none"></div>
                    <hr style="height: 1px;  background: teal; margin: 10px 0;   box-shadow: 0px 0px 4px 2px rgba(204,204,204,1);">        
                        <div class="row">
                              <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Date of Revoke </label><br>
                                      <input class="form-control" type="date" name="revokedate" >                              
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Details&nbsp;</label><br>
                                       <textarea class="form-control" name="unfreezedetails" id="unfreezedetails" cols="5"></textarea> 
                                </div>
                            </div>
                        </div>
                         
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary"  name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Update" >Print Revoke Order</button> 
                </div>
            </div>
        </div>
    </div>
</form>
<!-- end edit modal -->
</section>
<script>
	function addfreeze()
    {
        $('#addfreezebutt').hide();
        $('#addfreezediv').show();
        $('#showfreeze').hide();
        
    }
     function closeaddfreeze()
     {
        $('#addfreezebutt').show();
        $('#addfreezediv').hide();
        $('#showfreeze').show();
     }

     function showfreezedetails(assetid)
    {
        $('#assetid').val(assetid);
            $('#displayfreezemodal').modal('show');

            var url = '{{ route("displayassetdetailsforfreeze", ":assetid") }}';
                    url = url.replace(':assetid', assetid);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#assetid').val()},
                        success: function(responseText) {
                            
                            $("#displayassetdetails").html(responseText);
                            $("#displayassetdetails").show();
                           
                        }
                    });
     }

     function showunfreezedetails(assetid)
    {
        $('#assetidun').val(assetid);
            $('#displayunfreezemodal').modal('show');

            var url = '{{ route("displayassetdetailsforfreeze", ":assetid") }}';
                    url = url.replace(':assetid', assetid);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#assetid').val()},
                        success: function(responseText) {
                            
                            $("#displayassetdetailsun").html(responseText);
                            $("#displayassetdetailsun").show();
                           
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
@endsection