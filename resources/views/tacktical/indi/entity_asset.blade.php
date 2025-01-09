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
                              @if(@$check->report_status!="A")
                                <button type="button" class="btn btn-default btn-sm" style="float:right; font:face:Product Sans;text-decoration: none; background-color: #007bff; color: #ffffff;" onclick="showaddasset()">
                                <span><i class="fa fa-plus"></i></span>    
                                <span style="font:face:Product Sans">Add Asset</span>
                                </button>
                                @endif
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('tacktical.indi.navbar')

                                    <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.ti-entity.information.page')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.individual.ti-entity.information.page',@$id)}}">Person</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.ti-entity.information.organization.page')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.individual.ti-entity.information.organization.page',@$id)}}"> Organization</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.ti-entity.information.asset.page')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.individual.ti-entity.information.asset.page',@$id)}}"> Asset</a>
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
                                            &nbsp; @if(@$check->report_status!="A")<a style="color:gray" href="{{ route('tacktical.inteligence.autorization.individual.ti-entity.information.asset.page.delete.details',$asset->id) }}" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Are you sure you want to delete this record?') || event.preventDefault();"><i class="fa fa-trash"></i></a> @endif</td>
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
<form method = "POST" action="{{ route('tacktical.inteligence.autorization.individual.ti-entity.information.asset.page.insert.data') }}"  enctype="multipart/form-data" >
@csrf    
<div class="modal fade" id="addasset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">
            <div class="modal-header" style="background-color: #ebeaea">
                    <h5 class="modal-title" id="exampleModalLabel">Add Asset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="assetcasenoid" id="assetcasenoid" value="{{ $id}}">
                <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Asset Type: </label><br> &nbsp;&nbsp;
                                        <input type="radio" name="assettype"  value="Land" onclick="showlanddiv();"> Land &nbsp;
                                        <input type="radio" name="assettype" value="Building" onclick="showbuildingdiv()"> Building  &nbsp;
                                        <input type="radio" name="assettype"  value="Vehicle" onclick="showvehiclediv();"> Vehicle &nbsp;
                                        <input type="radio" name="assettype" value="Bank" onclick="showbankdiv()"> Bank &nbsp;
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div id="landdiv" style="display:none"> 
                                <div class= "row"> 
                                    <div class   = "col-md-6">
                                        <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">CID&nbsp;<font color='red'>*</font></label>
                                                <input name="landcid" id="landcid" onchange="getLandDetailsByCIDAPI()" class="form-control" type="text" />
                                        </div>
                                    </div>
                                </div>

                                <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                                <div id="responseArea"></div>
                                <script>
                                        function getLandDetailsByCIDAPI() {
                                            var landcid = document.getElementById("landcid").value;
                                            var landDetails = []; // Initialize an empty array to store land details
                                            // Send AJAX request to Laravel route
                                            axios.get('/getLandDetailsByCIDAPI/ip-details', {
                                                params: {
                                                    landcid: landcid
                                                }
                                            })
                                            .then(function (response) {
                                                var responseData = response.data;
                                                // Check if the responseData contains landDetails and landDetail array
                                                if (responseData.landDetails && responseData.landDetails.landDetail && responseData.landDetails.landDetail.length > 0) {
                                                    // Iterate through each land detail record
                                                    responseData.landDetails.landDetail.forEach(function(landDetail) {
                                                        var plotId = landDetail.plotId;
                                                        var thramNumber = landDetail.thramNumber;
                                                        var plotNetArea = landDetail.plotNetArea;
                                                        var ownerName = landDetail.ownerName;
                                                        var dzongkhagOrThromde = landDetail.dzongkhagOrThromde;
                                                        var gewogOrThromdeVillage = landDetail.gewogOrThromdeVillage;
                                                        var lapName = landDetail.lapName;

                                                        // Push land detail object to the landDetails array
                                                        landDetails.push({
                                                            plotId: plotId,
                                                            thramNumber: thramNumber,
                                                            plotNetArea: plotNetArea,
                                                            ownerName: ownerName,
                                                            dzongkhagOrThromde: dzongkhagOrThromde,
                                                            gewogOrThromdeVillage: gewogOrThromdeVillage,
                                                            lapName: lapName,
                                                            assettype: "Land", // Adding assettype property with value "Land"
                                                            case_no_id_land: "{{ $id }}" // Adding case_no_id_land property with value from blade
                                                        });

                                                        var businessNameDiv = document.createElement("div");
                                                        businessNameDiv.className = "form-group";
                                                        businessNameDiv.innerHTML = `           
                                                            <div class="row">
                                                            <input type="hidden" name="assettype"  value="Land">
                                                            <input type="hidden" id="case_no_id_land" name="case_no_id_land" value="{{ $id }}">
                                                                <div class="col-md-4"><div class="form-group">
                                                                <label>Plot No&nbsp;<font color='red'>*</font></label>
                                                                <input name="assetplotno2_${plotId}" id="assetplotno2" class="form-control" type="text" value="${plotId}" readonly/>
                                                                </div></div>
                                                                <div class="col-md-4"><div class="form-group">
                                                                <label>Thram No&nbsp;<font color='red'>*</font></label>
                                                                <input name="assetthramno2_${thramNumber}" id="assetthramno2" class="form-control" type="text" value="${thramNumber}" readonly/>
                                                                </div></div>
                                                                <div class="col-md-4"><div class="form-group">
                                                                <label>Area&nbsp;<font color='red'>*</font></label>
                                                                <input name="assetarea2_${plotNetArea}" id="assetarea2" class="form-control" type="text" value="${plotNetArea}" readonly/>
                                                                </div></div>
                                                                <div class="col-md-4"><div class="form-group">
                                                                <label>Owner&nbsp;<font color='red'>*</font></label>
                                                                <input name="landowner2_${ownerName}" id="landowner2" class="form-control" type="text" value="${ownerName}" readonly/>
                                                                </div></div>
                                                                <div class="col-md-4"><div class="form-group">
                                                                <label>Dzongkhag&nbsp;<font color='red'>*</font></label>
                                                                <input name="landdzongkhag2_${dzongkhagOrThromde}" id="landdzongkhag2" class="form-control" type="text" value="${dzongkhagOrThromde}" readonly/>
                                                                </div></div>
                                                                <div class="col-md-4"><div class="form-group">
                                                                <label>Gewog/Thromde&nbsp;<font color='red'>*</font></label>
                                                                <input name="landthromde2_${gewogOrThromdeVillage}" id="landthromde2" class="form-control" type="text" value="${gewogOrThromdeVillage}" readonly/>
                                                                </div></div>
                                                                <div class="col-md-4"><div class="form-group">
                                                                <label>Village/Lap&nbsp;<font color='red'>*</font></label>
                                                                <input name="landvillage2_${lapName}" id="landvillage2" class="form-control" type="text" value="${lapName}" readonly/>
                                                                </div></div>
                                                                <div class="col-md-4"><div class="form-group">
                                                                <label>Address&nbsp;<font color='red'>*</font></label>
                                                                <input name="landaddress2_${dzongkhagOrThromde}" id="landaddress2" class="form-control" type="text" value="${dzongkhagOrThromde}" readonly/>
                                                                </div></div>
                                                            <div>
                                                            `;
                                                    // Append the HTML elements to the response area
                                                    var responseArea = document.getElementById("responseArea");
                                                        responseArea.appendChild(businessNameDiv);
                                                    });

                                                    // Send AJAX POST request with landDetails array to the backend
                                                    axios.post('/savecaseassetAPI', {
                                                        landcid: landcid,
                                                        landDetails: landDetails
                                                    })
                                                    .then(function (response) {
                                                        // Handle response as needed
                                                    })
                                                    .catch(function (error) {
                                                        console.error(error);
                                                    });
                                                } else {
                                                    console.error("No Data Available.");
                                                    alert('Unable to fetch details at the moment. Please insert data manually or try again later');
                                                    $('#getlanddetails').show();
                                                }
                                            })
                                            .catch(function (error) {
                                                console.error(error);
                                            });
                                        }
                                </script>

                            <div id="getlanddetails" style="display:none">
                                    @csrf 
                                    <input type="hidden" id="case_no_id_land" name="case_no_id_land" value="{{ $id }}">
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Plot No&nbsp;<font color='red'>*</font></label>
                                                    <input name="assetplotno" id="assetplotno"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Thram No&nbsp;<font color='red'>*</font></label>
                                                    <input name="assetthramno" id="assetthramno"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Area&nbsp;<font color='red'>*</font></label>
                                                    <input name="assetarea" id="assetarea"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Owner&nbsp;<font color='red'>*</font></label>
                                                    <input name="landowner" id="landowner"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Location</h3>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Dzongkhag&nbsp;<font color='red'>*</font></label>
                                                    <input name="landdzongkhag" id="landdzongkhag"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Gewog/Thromde&nbsp;<font color='red'>*</font></label>
                                                    <input name="landthromde" id="landthromde"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Village/Lap&nbsp;<font color='red'>*</font></label>
                                                    <input name="landvillage" id="landvillage"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Address&nbsp;<font color='red'>*</font></label>
                                                    <textarea name="landaddress" id="landaddress"  class="form-control" type="text"></textarea>
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
                                                <!--<input name="assetvehiclecid" id="assetvehiclecid" onchange="gettoken()" class="form-control" type="text" />
                                                <input type="hidden" name="token" id="token" value="34596348-6abb-382a-b0a0-9d939b1d8d24">-->
                                                <input name="assetvehiclecid" id="assetvehiclecid" onchange="getVehicleDetailsByCIDAPI()" class="form-control" type="text" />

                                            </div>
                                    </div>
                                </div>

                                <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                                <div id="responseAreaVehicle"></div>
                                <script>
                                    function getVehicleDetailsByCIDAPI() {
                                        var assetvehiclecid = document.getElementById("assetvehiclecid").value;
                                        var vehicleDetails = []; // Initialize an empty array to store land details
                                        // Send AJAX request to Laravel route
                                        axios.get('/getVehicleDetailsByCIDAPI/ip-details', {
                                            params: {
                                                assetvehiclecid: assetvehiclecid
                                            }
                                        })
                                        .then(function (response) {
                                            var responseData = response.data;
                                            // Check if the responseData contains vehicleDetails and vehicleDetail array
                                            if (responseData.vehicleDetails && responseData.vehicleDetails.vehicleDetail && responseData.vehicleDetails.vehicleDetail.length > 0) {
                                                responseData.vehicleDetails.vehicleDetail.forEach(function(vehicleDetail) {
                                                    var Vehicle_Type_Name = vehicleDetail.Vehicle_Type_Name;
                                                    var Vehicle_Number = vehicleDetail.Vehicle_Number;
                                                    var Registration_Date = vehicleDetail.Registration_Date;
                                                    var ownerName = vehicleDetail.ownerName;
                                                    
                                                    vehicleDetails.push({
                                                        Vehicle_Type_Name: Vehicle_Type_Name,
                                                        Vehicle_Number: Vehicle_Number,
                                                        Registration_Date: Registration_Date,
                                                        ownerName: ownerName,
                                                        assettype: "Vehicle",
                                                        case_no_id_vehicle: "{{ $id }}"
                                                    });

                                                    var businessNameDiv2 = document.createElement("div");
                                                    businessNameDiv2.className = "form-group";
                                                    businessNameDiv2.innerHTML = `           
                                                        <div class="row">
                                                        <input type="hidden" name="assettype"  value="Vehicle">
                                                        <input type="hidden" id="case_no_id_vehicle" name="case_no_id_vehicle" value="{{ $id }}">
                                                            <div class="col-md-3"><div class="form-group">
                                                            <label>Vehicle Type&nbsp;<font color='red'>*</font></label>
                                                            <input name="vehicletype2_${Vehicle_Type_Name}" id="vehicletype2" class="form-control" type="text" value="${Vehicle_Type_Name}" readonly/>
                                                            </div></div>
                                                            <div class="col-md-3"><div class="form-group">
                                                            <label>Registration/Vehicle No&nbsp;<font color='red'>*</font></label>
                                                            <input name="vehicleregistrationno2_${Vehicle_Number}" id="vehicleregistrationno2" class="form-control" type="text" value="${Vehicle_Number}" readonly/>
                                                            </div></div>
                                                            <div class="col-md-3"><div class="form-group">
                                                            <label>Registration Date&nbsp;<font color='red'>*</font></label>
                                                            <input name="vehicleregistrationdate2_${Registration_Date}" id="vehicleregistrationdate2" class="form-control" type="text" value="${Registration_Date}" readonly/>
                                                            </div></div>
                                                            <div class="col-md-3"><div class="form-group">
                                                            <label>Owner&nbsp;<font color='red'>*</font></label>
                                                            <input name="vehicleowner2_${ownerName}" id="vehicleowner2" class="form-control" type="text" value="${ownerName}" readonly/>
                                                            </div></div>
                                                        <div>
                                                        `;
                                                // Append the HTML elements to the response area
                                                var responseAreaVehicle = document.getElementById("responseAreaVehicle");
                                                responseAreaVehicle.appendChild(businessNameDiv2);
                                                });

                                                // Send AJAX POST request with landDetails array to the backend
                                                axios.post('/savecaseassetVehicleAPI/ip-details', {
                                                    assetvehiclecid: assetvehiclecid,
                                                    vehicleDetails: vehicleDetails
                                                })
                                                .then(function (response) {
                                                    // Handle response as needed
                                                })
                                                .catch(function (error) {
                                                    console.error(error);
                                                });
                                            } else {
                                                console.error("No Data Available.");
                                                alert('Unable to fetch details at the moment. Please insert data manually or try again later');
                                                $('#getvehicledetails').show();
                                            }
                                        })
                                        .catch(function (error) {
                                            console.error(error);
                                        });
                                    }
                                </script>


                                <div id="getvehicledetails" style="display:none">                   
                                    <input type="hidden" id="case_no_id_vehicle" name="case_no_id_vehicle" value="{{ $id }}">
                                    <div class= "row"> 
                                        <div class   = "col-md-3">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Vehicle Type&nbsp;<font color='red'>*</font></label>
                                                    <input type="text" name="vehicletype" id="vehicletype"  class="form-control" >
                                            </div>
                                        </div>
                                        <div class   = "col-md-3">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Registration/Vehicle No&nbsp;<font color='red'>*</font></label>
                                                    <input name="vehicleregistrationno" id="vehicleregistrationno"  class="form-control" type="text"/>
                                            </div>
                                        </div>
 
                                        <div class   = "col-md-3">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Registration Date&nbsp;<font color='red'>*</font></label>
                                                <input name="vehicleregistrationdate" id="vehicleregistrationdate"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-3">
                                            <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">Owner&nbsp;<font color='red'>*</font></label>
                                                <input name="vehicleowner" id="vehicleowner"  class="form-control" type="text"/>
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
                                                    <input name="buildingplotno" id="buildingplotno"  class="form-control" type="text" >
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Thram No&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingthramno" id="buildingthramno"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Land Area/PLR:&nbsp;<font color='red'>*</font></label>
                                                    <input name="landareaplr" id="landareaplr"  class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Building/House/Flat No:&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingno" id="buildingno"  class="form-control" type="text" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">No of Units:&nbsp;<font color='red'>*</font></label>
                                                    <input name="landnoofunits" id="landnoofunits"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Owner&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingowner" id="buildingowner"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Location</h3>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Dzongkhag&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingdzongkhag" id="buildingdzongkhag"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Gewog/Thromde&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingthromde" id="buildingthromde"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Village/Lap&nbsp;<font color='red'>*</font></label>
                                                    <input name="buildingvillage" id="buildingvillage"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-6">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Address&nbsp;<font color='red'>*</font></label>
                                                    <textarea name="buildingaddress" id="buildingaddress"  class="form-control" type="text" ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div id="bankdiv" style="display:none">   
                                    <div class= "row"> 
                                        <div class   = "col-md-3">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Bank Name&nbsp;<font color='red'>*</font></label>
                                                    <input name="bankname" id="bankname"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-3">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Bank Account Type&nbsp;<font color='red'>*</font></label>
                                                    <input name="bankaccounttype" id="bankaccounttype"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-3">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Owner&nbsp;<font color='red'>*</font></label>
                                                    <input name="bankaccountowner" id="bankaccountowner"  class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-3">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Account No&nbsp;<font color='red'>*</font></label>
                                                    <input name="bankaccountno" id="bankaccountno"  class="form-control" type="text"/>
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