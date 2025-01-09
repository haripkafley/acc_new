@foreach($seizuredtls as $data)
<div class="row">
    <div class="col-md-4">
        <label style="font-family:Product Sans"> Seziure Date:&nbsp;</label><br>
            {{ \Carbon\Carbon::parse($data->seizure_date)->format('d/m/Y') }}
    </div>
    <div class="col-md-4">
        <label style="font-family:Product Sans"> Seziure Time:&nbsp;</label><br>
            {{ $data->seizure_time }}
    </div>
    <div class="col-md-4">
        <label style="font-family:Product Sans"> Seized From (CID):&nbsp;</label><br>
           {{ $data->seized_from_name }} [CID : {{ $data->seized_from_cid }} ]
    </div> 
</div>
@endforeach
<hr>
    <div class="row">
        <div class="col-md-4">
            <label style="font-family:Product Sans"> <b>Officer Conducting Seize</b>&nbsp;</label><br>
                <ol>
                    @foreach ($officers as $off)
                        <li> 
                            <?php echo $key=DB::table('users')->where('email',$off->officer_email)->value('name'); ?> <br>
                        </li>
                    @endforeach
                </ol> 
        </div>
    
        <div class="col-md-4">
            <label style="font-family:Product Sans"> <b>Witness</b>&nbsp;</label><br>
                <ol>
                    @foreach ($witnesses as $wit)
                        <li> 
                            {{ $wit->witness_name}} [CID : {{ $wit->witness_cid }} ]
                        </li>
                    @endforeach
                </ol> 
        </div>
    </div>
    <hr>

    @foreach($seizeditems as $items)
    @if($items->item_type == "Digital")
    <label style="font-family:Product Sans"> class="text-info"><b>Seized Items</b>&nbsp;</label><br>
    <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Item&nbsp;</label><br>
                                    {{ $items->item_name}}
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Manufacturer&nbsp;</label><br>
                                    {{ $items->item_manufacturer}}
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Model&nbsp;</label><br>
                                    {{ $items->item_model}}
                            </div>
                        </div>
                    </div>
                    <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Serial No&nbsp;</label><br>
                                    {{ $items->serial_no }}
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Condition&nbsp;</label><br>
                                    {{ $items->condition}}
                            </div>
                        </div>
                        
                    </div>
        @endif
        @if($items->item_type == "Email")
        <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Email&nbsp;</label><br>
                                    {{ $items->email_address}}
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Password&nbsp;</label><br>
                                    {{ $items->password}}
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Old Password&nbsp;</label><br>
                                    {{ $items->oldpassword}}
                            </div>
                        </div>
                    </div>
                    <h5>No. of mails (standard folders)</h5>
                    <div class= "row"> 
                        <div class   = "col-md-3">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Inbox&nbsp;</label><br>
                                    {{ $items->inbox}}
                            </div>
                        </div>
                        <div class   = "col-md-3">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Sent&nbsp;</label><br>
                                    {{ $items->sent}}
                            </div>
                        </div>
                        <div class   = "col-md-3">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Draft&nbsp;</label><br>
                                    {{ $items->draft}}
                            </div>
                        </div>
                        <div class   = "col-md-3">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Spam&nbsp;</label><br>
                                    {{ $items->spam}}
                            </div>
                        </div>
                        
                    </div>
            <br>
            @endif
        @if($items->item_type == "Social Media")
        
            <div class= "row"> 
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label style="font-family:Product Sans"> Platform&nbsp;</label><br>
                            {{ $items->platform}}
                    </div>
                </div>
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label style="font-family:Product Sans"> Password&nbsp;</label><br>
                            {{ $items->password}}
                    </div>
                </div>
                <div class   = "col-md-4">
                    <div class  = "form-group">
                        <label style="font-family:Product Sans"> Old Password&nbsp;</label><br>
                            {{ $items->oldpassword}}
                    </div>
                </div>
            </div>
        <br>
       @endif
        @if($items->item_type == "Passport")
        
                <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Passport No&nbsp;</label><br>
                                    {{ $items->passportno}}
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Name&nbsp;</label><br>
                                    {{ $items->passportname}}
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Issue Date&nbsp;</label><br>
                                    {{ \Carbon\Carbon::parse($items->passportissuedate)->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                    <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans"> Expiry Date&nbsp;</label><br>
                                   {{ \Carbon\Carbon::parse($items->passportexpirydate)->format('d/m/Y') }} 
                            </div>
                        </div>
                    </div>
        <br>
        @endif
        @if($items->item_type == "Currency")
        <div class= "row"> 
            <div class   = "col-md-4">
                <div class  = "form-group">
                    <label style="font-family:Product Sans"> Amount&nbsp;</label><br>
                        {{ $items->currencyamt}}
                </div>
            </div>
        </div>
        @endif

        <div class= "row"> 
            <div class   = "col-md-4">
                <div class  = "form-group">
                    <label style="font-family:Product Sans"> Status&nbsp;</label><br>
                        {{ $items->status}}
                </div>
            </div>
        </div>
        @endforeach
        <br><br>
    <style>
    
.t2{
    outline: 2px dotted #ccc;
    font-family:Product Sans;
}
</style>