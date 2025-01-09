@foreach($orgdetailsshow as $org)
    @if($org->organization_type == "Business")
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="business_name">Business Name</label>
                        <input type="text" name="business_name" id="business_name" value="{{ $org->organization_name }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="business_location">Location</label>
                        <input type="text" name="business_location" id="business_location" value="{{ $org->business_location }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="business_owner">Owners</label>
                        <input type="text" name="business_owner" id="business_owner" value="{{ $org->business_owner }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="business_name">License Issue Date</label>
                        <input type="text" name="business_issue_date" id="business_issue_date" value="{{ $org->organization_name }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="business_location">License Expiry Date</label>
                        <input type="text" name="business_expiry_date" id="business_expiry_date" value="{{ $org->business_location }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="business_owner">Activity</label>
                        <input type="text" name="business_activity" id="business_activity" value="{{ $org->business_activity }}" class="form-control">
                    </div>
                </div>
            </div>
            <!-- Add submit button for updating data -->
    @endif
    @if($org->organization_type == "Government")
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="parent_agency">Parent Agency</label>
                        <input type="text" name="parent_agency" id="parent_agency" value="{{ $org->parent_agency }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="agency_name">Agency Name</label>
                        <input type="text" name="agency_name" id="agency_name" value="{{ $org->organization_name }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="business_location">Location</label>
                        <input type="text" name="business_location" id="business_location" value="{{ $org->business_location }}" class="form-control">
                    </div>
                </div>
            </div>
    @endif

    @if($org->organization_type == "Corporation")
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="agency_name">Agency Name</label>
                        <input type="text" name="agency_name" id="agency_name" value="{{ $org->organization_name }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="business_location">Location</label>
                        <input type="text" name="business_location" id="business_location" value="{{ $org->business_location }}" class="form-control">
                    </div>
                </div>
            </div>
    @endif

@endforeach
