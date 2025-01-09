@foreach ($assetdtls as $asset)
@if($asset->asset_type == "Land")
            <div class= "row"> 
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Plot No&nbsp;</label>
                        {{ $asset->plotno}}
                    </div>
                </div>
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Thram No&nbsp;</label>
                        {{ $asset->thramno}}
                    </div>
                </div>
            
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Area&nbsp;</label>
                        {{ $asset->area}}
                    </div>
                </div>
                </div>
            <div class= "row"> 
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Owner&nbsp;</label>
                        {{ $asset->owner}}    
                    </div>
                </div>
            
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Dzongkhag&nbsp;</label>
                            {{ $asset->location_dzongkhag}}
                    </div>
                </div>
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Gewog/Thromde&nbsp;</label>
                            {{ $asset->location_gewog}}
                    </div>
                </div> 
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Village/Lap&nbsp;</label>
                            {{ $asset->location_village}}
                    </div>
                </div>
                <div class   = "col-md-8">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Address&nbsp;</label>
                             {{ $asset->location_address}}
                    </div>
                </div>
            </div>
            
        @endif
        @if($asset->asset_type == "Vehicle")
        
            <div class= "row"> 
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Vehicle Type&nbsp;</label>
                           {{ $asset->vehicletype}}
                    </div>
                </div>
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Registration No&nbsp;</label>
                            {{ $asset->vehicle_registrationno}}
                    </div>
                </div>
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Registration Date&nbsp;</label>
                            {{ \Carbon\Carbon::parse($asset->vehicle_registrationdate)->format('d/m/Y')}}
                    </div>
                </div>
                
            </div>
            <div class= "row"> 
                <div class   = "col-md-6">
                    <div class  = "form-group">
                    <label for   = "exampleInputEmail1">Owner&nbsp;</label>
                         {{ $asset->owner}}   
                    </div>
                </div>
            </div>
    @endif
    @if($asset->asset_type == "Building")
            <div class= "row"> 
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Plot No&nbsp;</label>
                           {{ $asset->plotno }} 
                    </div>
                </div>
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Thram No&nbsp;</label>
                           {{ $asset->thramno }} 
                    </div>
                </div>
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Land Area/PLR:&nbsp;</label>
                           {{ $asset->area }} 
                    </div>
                </div>
                
            </div>
            <div class= "row"> 
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Building/House/Flat No:&nbsp;</label>
                            {{ $asset->building_no }} 
                    </div>
                </div>
            
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">No of Units:&nbsp;</label>
                            {{ $asset->noofunits }} 
                    </div>
                </div>
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Owner&nbsp;</label>
                            {{ $asset->owner }} 
                    </div>
                </div>
            </div>
            <div class= "row"> 
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Dzongkhag&nbsp;</label>
                            {{ $asset->location_dzongkhag }} 
                    </div>
                </div>
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Gewog/Thromde&nbsp;</label>
                            {{ $asset->location_gewog }} 
                    </div>
                </div>
            
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Village/Lap&nbsp;</label>
                            {{ $asset->location_village }} 
                    </div>
                </div>
                </div>
            <div class= "row"> 
                <div class   = "col-md-6">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Address&nbsp;</label>
                            {{ $asset->location_address }} 
                    </div>
                </div>
            </div>
    @endif
        @if($asset->asset_type == "Bank")
            <div class= "row"> 
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Bank Name&nbsp;</label>
                            {{ $asset->bank_name }}
                    </div>
                </div>
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Bank Account Type&nbsp;</label>
                            {{ $asset->bank_accounttype }}
                    </div>
                </div>
           
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Owner&nbsp;</label>
                            {{ $asset->owner }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label for   = "exampleInputEmail1">Account No&nbsp;</label>
                            {{ $asset->bank_accountno }}
                    </div>
                </div>
            </div>
        
        @endif
@endforeach