@foreach ($entitydetailsshow as $showentitydtls)
    <td>
        <div class="entity-details">
    <div class="entity-row">
        <div class="label">Name:</div>
        <div class="value"></div>
    </div>
    <div class="entity-row">
        <div class="label">CID:</div>
        <div class="value"></div>
    </div>
    <div class="entity-row">
        <div class="label">Date of Birth:</div>
        <div class="value"></div>
    </div>
    <div class="entity-row">
        <div class="label">Gender:</div>
        <div class="value"></div>
    </div>
    <div class="entity-row">
        <div class="label">Phone No:</div>
        <div class="value"></div>
    </div>
    <div class="entity-row">
        <div class="label">Dzongkhag:</div>
        <div class="value"></div>
    </div>
    <div class="entity-row">
        <div class="label">Gewog:</div>
        <div class="value"></div>
    </div>
    <div class="entity-row">
        <div class="label">Dzongkhag:</div>
        <div class="value"></div>
    </div>
    <div class="entity-row">
        <div class="label">Email:</div>
        <div class="value"></div>
    </div>
    <div class="entity-row">
        <div class="label">Nationality:</div>
        <div class="value"></div>
    </div>
    <div class="entity-row">
        <div class="label">Address:</div>
        <div class="value"></div>
    </div>
    <div class="entity-row">
        <div class="label">Photo:</div>
        <div class="value">
            <!-- Display your default image here or remove this div altogether -->
        </div>
    </div>
</div>

    </td>
    <td>
        
        @if($showentitydtls->photo_name == "")
            <img src="{{ asset('acc_images/no_image.jpg') }}" class="entity-image rounded-circle header-profile-user" alt="User Image">
        @endif
         
    </td>
@endforeach

<style>
.entity-details {
    display: flex;
    flex-direction: column;
}

.entity-row {
    display: flex;
    align-items: baseline;
    
}

.label {
    font-family: 'Product Sans', sans-serif;
    font-weight: bold;
    width: 120px;
}

.value {
    flex: 1;
}

.entity-image {
    margin-left: 15px;/* Adjust the margin as per your requirement */
    margin-top : -9px;
}

.entity-image img {
    height: 235px;
    width: 235px;
    float: right;
    
}
</style>

