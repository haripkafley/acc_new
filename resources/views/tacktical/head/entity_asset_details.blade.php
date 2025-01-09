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
                              Asset
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('tacktical.head.navbar')

                                    <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page',@$id)}}">Person</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page.organisation')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page.organisation',@$id)}}"> Organization</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page.asset')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page.asset',@$id)}}"> Asset</a>
                                    </li>
                                </ul>
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Asset Type</th>
                                        <th>Owner</th>
                                        <th>Action</th>          
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($entityasset->count())
                                        @foreach ($entityasset as $asset)
                                        <tr>   
                                            <td>{{ $asset->asset_type }}</td>
                                            <td>{{ $asset->owner }}</td>
                                            <td><i class="fa fa-eye" style="color:gray" onclick="viewassetdetails('{{ $asset->id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="View Details"></i>
                                            &nbsp; </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" style="text-align: center"> No record found </td>
                                        </tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>

<!-- show entity details modal -->
<div class="modal fade" id="show_asset_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Asset Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="assetid" id="assetid">
                        <div id="assetdetailsshow" style="display:none;"></div>
                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
</div>
<!-- end -->
<!--add modal -->


<script>
    function showaddasset()
        {
             $('#addasset').modal('show');
        }
    
    function showlanddiv()
        {
            $('#landdiv').show();
            $('#buildingdiv').hide();
            $('#vehiclediv').hide();
            $('#bankdiv').hide();
        }
    function showbuildingdiv()
        {
            $('#landdiv').hide();
            $('#buildingdiv').show();
            $('#vehiclediv').hide();
            $('#bankdiv').hide();
        }
    function showvehiclediv()
        {
            $('#landdiv').hide();
            $('#buildingdiv').hide();
            $('#vehiclediv').show();
            $('#bankdiv').hide();
        }
    function showbankdiv()
        {
            $('#landdiv').hide();
            $('#buildingdiv').hide();
            $('#vehiclediv').hide();
            $('#bankdiv').show();
        }
    function getLandDetailsByCID()
        {
            $('#getlanddetails').show();
        }
    function getVehicleDetailsByCID()
    {
        $('#getvehicledetails').show();
    }
    function getBankDetailsByCID()
    {
        $('#getbankdetails').show();
    }
    function getBuildingDetailsByCID()
    {
        $('#getbuildingdetails').show();
    }
    
    function gettoken()
       {
         var url = "{{ route('gettoken')}}";
            $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: url,
            success: function (data) {
                console.log(data);
                $('#token').val(data);
            },
            error: function() { 
                console.log('error');
            }
        });

        getVehicleDetailsByCID();
       }

       function getVehicleDetailsByCID(){
        // console.log(_token);
         var cid = $('#assetvehiclecid').val();
         var token = $('#token').val();
         $('#getvehicledetails').show(700);
        // console.log(cid);
        var settings = {
            "url": "https://staging-datahub-apim.dit.gov.bt/rsta_licenseandvehicleinformationapi/1.0.0/vehicledetailsbycid/"+cid,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Authorization": "Bearer " + token,
                // "Cookie": "route=1658042636.829.53.968004"
            },
        };

        $.ajax(settings).done(function (response) {
            console.log(response.vehicleDetails);
            
            if(response.vehicleDetails.vehicleDetail.length >= 0){
                
                
                $("#vehicletype").val(response.vehicleDetails.vehicleDetail[0].Vehicle_Type_Name);
                $("#vehicleregistrationno").val(response.vehicleDetails.vehicleDetail[0].Vehicle_Number); 
                $("#vehicleregistrationdate").val(response.vehicleDetails.vehicleDetail[0].Registration_Date);
                $("#vehicleowner").val(response.vehicleDetails.vehicleDetail[0].ownerName);
                
                 

            } else {
                alert('No details found');
            }
        });
        }

        function viewassetdetails(id){
    
        $('#assetid').val(id);
        $('#show_asset_details').modal('show');
    

        var url = '{{ route("tacktical.inteligence.autorization.individual.ti-entity.information.asset.page.view.details", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#assetid').val()},
                success: function(result) {
                    
                    $("#assetdetailsshow").html(result);
                    $("#assetdetailsshow").show();
                    
                }
            });
        }
</script>
<style>

.t2{
    /*outline: 1px solid #ccc;*/
    font-family:Product Sans;
}
</style>
@endsection