@foreach($casedetails as $dtls)
    <div class="row">
        <div class="col-md-6">
            <label style="font-family:Product Sans">Case No&nbsp;</label><br>
                <input type="text" readonly name="case_id_edit"  class="form-control " id="case_id_edit" value="{{ $dtls->case_no}}">
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label style="font-family:Product Sans">Case ID&nbsp;</label>
                <input type="text"  name="case_id_edit"  class="form-control " id="case_id_edit" value="{{ $dtls->case_id}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label style="font-family:Product Sans">Case Title&nbsp;</label><br>
                <input type="text" readonly name="case_title_edit"  class="form-control " id="case_title_edit" value="{{ $dtls->case_title}}">
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label style="font-family:Product Sans">Date Assigned&nbsp;</label>
                <input type="date"  name="case_date_edit"  class="form-control " id="case_date_edit" value="{{ $dtls->assignment_order_date}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label style="font-family:Product Sans">Sector&nbsp;</label><br>
                <select class="form-control" name="case_sector_edit" id="case_sector_edit" required>
                        @foreach ($sectors as $sect)
                            @if ($dtls->sector == $sect->sector_type)
                                <option selected value="{{ $sect->sector_type }}">{{ $sect->sector_type }}</option>
                            @else
                                <option value="{{ $sect->sector_type }}">{{ $sect->sector_type }}</option>
                            @endif
                        @endforeach
                </select>

        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label style="font-family:Product Sans">Sub Sector&nbsp;</label>
                    <select class="form-control" name="case_sectortype_edit" id="case_sectortype_edit" required>
                            @foreach ($sectortypes as $secttypes)
                                @if ($dtls->sector_type == $secttypes->sector_name)
                                    <option selected value="{{ $secttypes->sector_name }}">{{ $secttypes->sector_name }}</option>
                                @else
                                    <option value="{{ $secttypes->sector_name }}">{{ $secttypes->sector_name }}</option>
                                @endif
                            @endforeach
                    </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label style="font-family:Product Sans">Area&nbsp;</label><br>
                <select class="form-control" name="case_area_edit" id="case_area_edit" required>
                    @foreach ($areas as $areas)
                        @if ($dtls->area == $areas->area_name)
                            <option selected value="{{ $areas->area_name }}">{{ $areas->area_name }}</option>
                        @else
                            <option value="{{ $areas->area_name }}">{{ $areas->area_name }}</option>
                        @endif
                    @endforeach
                </select>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label style="font-family:Product Sans">Institution&nbsp;</label>
                <select class="form-control" name="case_institution_edit" id="case_institution_edit" required>
                    <option value="">Select a sector</option>
                        @foreach ($institutions as $institutiontypes)
                            @if ($dtls->institution_type == $institutiontypes->institution_type)
                                <option selected value="{{ $institutiontypes->institution_type }}">{{ $institutiontypes->institution_type }}</option>
                            @else
                                <option value="{{ $institutiontypes->institution_type }}">{{ $institutiontypes->institution_type }}</option>
                            @endif
                        @endforeach
                </select>
            </div>
        </div>
    </div>
    @endforeach