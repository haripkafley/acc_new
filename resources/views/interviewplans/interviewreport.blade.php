@extends('layouts.admin')

@section('content')
<style>
    .coi_show {
  display: none;
}

.coi_hide {
  display: none;
}
</style>
<br>
      <div class= "container-fluid">
            <div class= "card">
              @if (session('success'))
                        <h6 class="alert alert-success">{{ session('success') }}</h6>
                    @endif
            <div class= "card-header">
                <h3 class= "card-title text-info"><b>Interview Report</b></h3>
                <br>
              </div>
    <div class="card-body table-responsive">
      <div class="card">
        <div class="card-body">
      <form method = "POST"  action="" >
        @csrf
        <h5>Interviewee Details</h5>
        <h5>Personal Details</h5>
      <div class="form-group row">
            <label class="col-sm-2 col-form-label">CID</label>
            <div class="col-sm-3">
              <input class="form-control" name="cid_add" required type="text" placeholder="Enter CID"/>
            </div>
            <label class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-3">
              <input name="name_add" class="form-control" required type="text" placeholder="Enter Name" />
            </div>
        </div>
       <div class="form-group row">
                <label class="col-sm-2 col-form-label">Sex</label>
                <div class="col-sm-3">
                  <input id="sex_add" name="sex_add" class="form-control" type="text" placeholder="Enter Sex" required/>
                </div>
                <label class="col-sm-2 col-form-label">Date of Birth</label>
                <div class="col-sm-3">
                   <input type="date" name="dob_add" class="form-control" required />
                </div>
            </div>
            <br>
            <h5>Employment Details</h5>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">EID No.</label>
  <div class="col-sm-3">
      <input class="form-control" id="eid_add" name="eid_add" rows="3" placeholder="Enter EID No" required />
  </div>
  <label class="col-sm-2 col-form-label">Designation</label>
<div class="col-sm-3">
  <input class="form-control" id="eid_add" name="eid_add" rows="3" placeholder="Enter EID No" required />
</div>
</div>

<div class="form-group row">
  <label class="col-sm-2 col-form-label">Agency Type</label>
  <div class="col-sm-3">
    <input class="form-control" id="eid_add" name="eid_add" rows="3" placeholder="Enter EID No" required />
</div>
  <label class="col-sm-2 col-form-label">Agecy</label>
<div class="col-sm-3">
  <input type="text" class="form-control" name="agency_add" required />
</div>
</div>
<h5>Address</h5>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">House No</label>
  <div class="col-sm-3">
  <input type="text" name="house_add" class="form-control" required />
</div>
  <label class="col-sm-2 col-form-label">Thram No</label>
<div class="col-sm-3">
  <input type="text" class="form-control" name="thram_add" required />
</div>
</div>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Dzongkhag</label>
  <div class="col-sm-3">
    <input class="form-control" id="eid_add" name="eid_add" rows="3" placeholder="Enter EID No" required />
</div>
  <label class="col-sm-2 col-form-label">Gewog</label>
  <div class="col-sm-3">
    <input class="form-control" id="eid_add" name="eid_add" rows="3" placeholder="Enter EID No" required />
</div>
</div>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Email</label>
<div class="col-sm-3">
  <input type="text" class="form-control" name="email_add" required />
</div>
  <label class="col-sm-2 col-form-label">Phone No</label>
<div class="col-sm-3">
  <input type="text" class="form-control" name="phone_add" required />
</div>
</div>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Mobile No</label>
<div class="col-sm-3">
  <input type="text" class="form-control" name="mobile_add" required />
</div>
  <label class="col-sm-2 col-form-label">Contact Address</label>
<div class="col-sm-3">
  <textarea type="text" class="form-control" name="address_add" rows="3" required></textarea>
</div>
</div>
<br><br>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Date<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <input class="form-control" name="date_add" type="date" required />
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Start Time<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <input name="start_time_add" class="form-control" type="time" required />
    </div>
    <label class="col-sm-2 col-form-label">End Time<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <input name="end_time_add" class="form-control" type="time" required />
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Venue<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <select class="form-control" name="venue_add" required>
            <option value="">Select Venue</option>
            @foreach ($locations as $l)
            <option value="{{ $l->location_id }}">{{ $l->location }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Intervieweee<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <textarea name="intervieweee_add" class="form-control" type="text" required></textarea>
    </div>
    <label class="col-sm-2 col-form-label">Category<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <select class="form-control" name="category_add" required>
            <option value="">Select Venue</option>
            @foreach ($category as $c)
            <option value="{{ $c->party_type_id }}">{{ $c->party_type }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Type of Interview<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <select class="form-control" name="interviewtype_add" required>
            <option value="">Select Interview Type</option>
            @foreach ($interviewtype as $it)
            <option value="{{ $it->id }}">{{ $it->interview_type }}</option>
            @endforeach
        </select>
    </div>
    <label class="col-sm-2 col-form-label">Category<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <select class="form-control" name="interviewer_add" required>
            <option value="">Select Interviewer</option>
            @foreach ($interviewer as $i)
            <option value="{{ $i->interviewer_id }}">{{ $i->interviewer }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Interview Summary<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <textarea name="isummary_add" class="form-control" type="text" required></textarea>
    </div>
    <label class="col-sm-2 col-form-label">Observation Summary<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <textarea name="osummary_add" class="form-control" type="text" required></textarea>
    </div>
</div>
<h5><b>Statement and Observations / Additional Notes</b></h5>
<table id="example3" class="table table-bordered table-hover">
    <thead class="bg-info">
        <tr>
            <th scope="col">Statement</th>
            <th scope="col">Observations / Additional Notes</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<a class="btn btn-primary float-right" id="insertRow" href="#">Add new row</a>
<br>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Interview Recorded<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-1">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="interview_record_add" id="flexRadioDefault1" value="Yes">
            <label class="form-check-label" for="flexRadioDefault1">
                Yes
            </label>
        </div>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="interview_record_add" id="flexRadioDefault2" value="No">
        <label class="form-check-label" for="flexRadioDefault2">
            No
        </label>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Interview Recording URL<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <input name="url_add" class="form-control" type="text" required />
    </div>
    <label class="col-sm-2 col-form-label">Upload Recording File<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <input name="file_add" class="form-control" type="file" required />
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Written Statement<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-1">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="written_statement_add" id="flexRadioDefaults1" value="Yes">
            <label class="form-check-label" for="flexRadioDefaults1">
                Yes
            </label>
        </div>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="written_statement_add" id="flexRadioDefaults2" value="No">
        <label class="form-check-label" for="flexRadioDefaults2">
            No
        </label>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label">Statement Written By<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <input name="statement_by_add" class="form-control" type="text" required />
    </div>
    <label class="col-sm-2 col-form-label">Statement Read By<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <input name="statement_read_by_add" class="form-control" type="text" required />
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Attach Statement<span style="font-weight: bold; color: red;">*</span></label>
    <div class="col-sm-3">
        <input name="statement_attached_add" class="form-control" type="file" required />
    </div>
</div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="" class="btn btn-primary">No Interviewee</a></td>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
    </div>


@endsection
