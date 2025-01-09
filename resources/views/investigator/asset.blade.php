@extends('layouts.admin')
@section('content')
<br>
@include('investigator/mainheader')
    <!------------------------ end top part ---------------->  
<div class="col-sm-13" style="margin-top:-9px;">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                @include('tabs/investigator_tab')
            </div>
            <div class="card-body">
                @include('tabs/entity_tab')
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <br>
                        @if(Auth::user()->role == "Investigator")
                            <button type="button" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" style="float:right" onclick="showaddasset()">
                                <span><i class="fa fa-plus"></i></span>    
                                <span style="font:face:Product Sans">Add Asset</span>
                            </button>
                        @endif
                        <br>
                        <div class="header" style="height:40px; border-radius:5px; margin-top:10px;">&nbsp;&nbsp;<font color='#000000' size="5.2" face="Product Sans">Asset</font></div>
                        
                            <table class="table t2">
                                <thead >
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
                                            &nbsp; <a style="color:gray" href="{{ route('deleteasset',$asset->id) }}" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Are you sure you want to delete this record?') || event.preventDefault();"><i class="fa fa-trash"></i></a></td>
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
<form method = "POST" action="{{ route('savecaseasset') }}"  enctype="multipart/form-data" >
      @csrf    
<div class="modal fade" id="addasset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add iDiary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><input type="hidden" name="assetcasenoid" id="assetcasenoid" value="{{ $casenoid}}">
                <div class="modal-body">
                    <div class="row">
                                <div class="col-md-6">
                                    <label>Asset Type: </label><br> &nbsp;&nbsp;
                                        <input type="radio" name="assettype"  value="Land" onclick="showlanddiv();"> Land &nbsp;
                                        <input type="radio" name="assettype" value="Building" onclick="showbuildingdiv()"> Building  </label>
                                        <input type="radio" name="assettype"  value="Vehicle" onclick="showvehiclediv();"> Vehicle &nbsp;
                                        <input type="radio" name="assettype" value="Bank" onclick="showbankdiv()"> Bank  </label>
                                </div>
                            </div>
                            <br>
                            <div id="landdiv" style="display:none"> 
                                <div class= "row"> 
                                    <div class   = "col-md-6">
                                        <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">CID&nbsp;<font color='red'>*</font></label>
                                                <input name="landcid" id="landcid" onchange="getLandDetailsByCID()" class="form-control" type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div id="getlanddetails" style="display:none">
                                <form action="" method="POST">
                                    @csrf 
                                    <input type="hidden" id="case_no_id_land" name="case_no_id_land" value="{{ $casenoid }}">
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Plot No&nbsp;<font color='red'>*</font></label>
                                                    <input name="assetplotno" id="assetplotno"  class="form-control" type="text" readonly value="xyz" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Thram No&nbsp;<font color='red'>*</font></label>
                                                    <input name="assetthramno" id="assetthramno"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Area&nbsp;<font color='red'>*</font></label>
                                                    <input name="assetarea" id="assetarea"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Owner&nbsp;<font color='red'>*</font></label>
                                                    <input name="landowner" id="landowner"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Location</h3>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Dzongkhag&nbsp;<font color='red'>*</font></label>
                                                    <input name="landdzongkhag" id="landdzongkhag"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Gewog/Thromde&nbsp;<font color='red'>*</font></label>
                                                    <input name="landthromde" id="landthromde"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Village/Lap&nbsp;<font color='red'>*</font></label>
                                                    <input name="landvillage" id="landvillage"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Address&nbsp;<font color='red'>*</font></label>
                                                    <textarea name="landaddress" id="landaddress"  class="form-control" type="text" readonly value="xyz"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div id="vehiclediv" style="display:none"> 
                                <div class= "row"> 
                                    <div class   = "col-md-6">
                                        <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">CID&nbsp;<font color='red'>*</font></label>
                                                <input name="assetvehiclecid" id="assetvehiclecid" onchange="gettoken()" class="form-control" type="text" />
                                                <input type="hidden" name="token" id="token" value="34596348-6abb-382a-b0a0-9d939b1d8d24">
                                        </div>
                                    </div>
                                </div>
                                <div id="getvehicledetails" style="display:none">
                               
                                    <input type="hidden" id="case_no_id_vehicle" name="case_no_id_vehicle" value="{{ $casenoid }}">
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Vehicle Type&nbsp;<font color='red'>*</font></label>
                                                    <input type="text" name="vehicletype" id="vehicletype"  class="form-control" readonly >
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Registration No&nbsp;<font color='red'>*</font></label>
                                                    <input name="vehicleregistrationno" id="vehicleregistrationno"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Registration Date&nbsp;<font color='red'>*</font></label>
                                                <input name="vehicleregistrationdate" id="vehicleregistrationdate"  class="form-control" type="text" readonly value="2023-04-02"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">Owner&nbsp;<font color='red'>*</font></label>
                                                <input name="vehicleowner" id="vehicleowner"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <div id="buildingdiv" style="display:none"> 
                                <div class= "row"> 
                                    <div class   = "col-md-6">
                                        <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">CID&nbsp;<font color='red'>*</font></label>
                                                <input name="assetbuildingcid" id="assetbuildingcid" onchange="getBuildingDetailsByCID()" class="form-control" type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div id="getbuildingdetails" style="display:none"> 
                               
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Plot No&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingplotno" id="buildingplotno"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Thram No&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingthramno" id="buildingthramno"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Land Area/PLR:&nbsp;<font color='red'>*</font></label>
                                                    <input name="landareaplr" id="landareaplr"  class="form-control" type="text" /readonly value="xyz">
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Building/House/Flat No:&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingno" id="buildingno"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">No of Units:&nbsp;<font color='red'>*</font></label>
                                                    <input name="landnoofunits" id="landnoofunits"  class="form-control" type="text" readonly value="2"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Owner&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingowner" id="buildingowner"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Location</h3>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Dzongkhag&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingdzongkhag" id="buildingdzongkhag"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Gewog/Thromde&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingthromde" id="buildingthromde"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Village/Lap&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingvillage" id="buildingvillage"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Address&nbsp;<font color='red'>*</font></label>
                                                    <textarea name="buildingaddress" id="buildingaddress"  class="form-control" type="text" readonly>xyz</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div id="bankdiv" style="display:none"> 
                                
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Bank Name&nbsp;<font color='red'>*</font></label>
                                                    <input name="bankname" id="bankname"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Bank Account Type&nbsp;<font color='red'>*</font></label>
                                                    <input name="bankaccounttype" id="bankaccounttype"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Owner&nbsp;<font color='red'>*</font></label>
                                                    <input name="bankaccountowner" id="bankaccountowner"  class="form-control" type="text" readonly value="xyz"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Account No&nbsp;<font color='red'>*</font></label>
                                                    <input name="bankaccountno" id="bankaccountno"  class="form-control" type="text" readonly value="xyz"/>
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
    

        var url = '{{ route("showassetdetails", ":id") }}';
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
</style>
@endsection