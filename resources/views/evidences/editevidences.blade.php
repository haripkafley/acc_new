 @foreach ($evidences as $evid)
    <div class="row"> 
        <div class="col-sm-6">
            <div class="form-group">
                    <label>Evidence Category&nbsp;<font color='red'>*</font></label>
                    <input type="text" readonly class="form-control" name="evidencecat" id="evidencecat" value="{{ $evid->evidence_category}}" />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Exhibit Number&nbsp;<font color='red'>*</font></label>
                    <input type="text" readonly name="evidenceno" value="{{ $evid->evidence_no}} " class="form-control" id="evidenceno">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
                <div class="form-group">
                <label>Exhibit Name&nbsp;<font color='red'>*</font></label>
                    <input type="text" name="evidname" value="{{ $evid->evidence_name}}" class="form-control" id="evidname">   
                </div>
        </div>
    
        <div class="col-sm-6">
            <div class="form-group">
                <label>Collected On&nbsp;<font color='red'>*</font></label>
                <input type="date" name="collected_on" value="{{ $evid->collected_on}}"  class="form-control" id="collected_on">
                
            </div>
        </div>
    </div>   
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                
                <label>Collected Method&nbsp;<font color='red'>*</font></label>
                    <select class="form-control"   name="evidfrom" id="evidfrom" required>
                        <option value="Interview" {{ $evid->collected_from == 'Interview' ? 'selected' : '' }}>Interview</option>
                        <option value="Digital Forensics" {{ $evid->collected_from == 'Digital Forensics' ? 'selected' : '' }}>Digital Forensics</option>
                        <option value="Search and Seizure" {{ $evid->collected_from == 'Search and Seizure' ? 'selected' : '' }}>Search and Seizure</option>
                        <option value="Site Inspection" {{ $evid->collected_from == 'Site Inspection' ? 'selected' : '' }}>Site Inspection</option>
                        <option value="International Cooperation" {{ $evid->collected_from == 'International Cooperation' ? 'selected' : '' }}>International Cooperation</option>
                        <option value="Surveillance" {{ $evid->collected_from == 'Surveillance' ? 'selected' : '' }}>Surveillance</option>
                    </select>    
                       
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Collected By&nbsp;<font color='red'>*</font></label>
                    <select class="form-control"   name="evidcollectedby" id="evidcollectedby" required>
                        <option value="">-- Select Officer --</option>
                                            @foreach ($officers as $off)
                                                <option value="{{ $off->email }}" @if ($off->email === $off->email) selected @endif>{{ $off->name }}</option>
                                            @endforeach   
                    </select>   
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Description&nbsp;<font color='red'>*</font></label>
                    <input type="text" name="evidescription" value="{{$evid->evidence_description}}"  class="form-control" id="evidescription" rows="3">
                    
                </div>
            </div>
    </div>
    <br>
    <div class="row" style="font-family:Product Sans">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Exhibit&nbsp;</label><br>
                    @if(in_array($evid->evidence_file_extension, ['jpg', 'jpeg', 'png', 'gif','bmp']))
                        <img src="{{ asset('Evidences/' .$evid->id.'/' .$evid->evidence_file_name) }}" class="round-image">
                    @elseif (in_array($evid->evidence_file_extension, ['docx', 'doc']))
                        <iframe src="https://docs.google.com/viewer?url={{ asset('Evidences/' . $evid->id . '/' . $evid->evidence_file_name) }}&embedded=true" width="100%" height="600"></iframe>
                    @elseif (in_array($evid->evidence_file_extension, ['pdf']))
                        <embed src="{{ asset('Evidences/' . $evid->id . '/' . $evid->evidence_file_name) }}" type="application/pdf" width="100%" height="300">
                    @else
                        <p>Unsupported file type: {{ $evid->evidence_file_extension }}</p>
                    @endif
            </div>
        </div>
    </div>  
@endforeach