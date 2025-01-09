 @foreach ($evidences as $evid)
 
    <div class="row" style="font-family:Product Sans"> 
        <div class="col-sm-4">
            <div class="form-group">
                    <label>Evidence Category&nbsp;</label><br>
                    {{ $evid->evidence_category}}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Exhibit Number&nbsp;</label><br>
                    {{ $evid->evidence_no}}
            </div>
        </div>
   
        <div class="col-sm-4">
                <div class="form-group">
                <label>Exhibit Name&nbsp;</label><br>
                    {{ $evid->evidence_name}}
                </div>
        </div>
     </div>

    <div class="row" style="font-family:Product Sans">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Collected On&nbsp;</label><br>
                {{ \Carbon\Carbon::parse($evid->collected_on)->format('d/m/Y')}}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Collected Method&nbsp;</label><br>
                        {{ $evid->collected_from }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Collected By&nbsp;</label><br>
                        <?php echo $key=DB::table('users')->where('email', $evid->collected_by)->value('name') ?>  
            </div>
        </div>
    </div>
    <div class="row" style="font-family:Product Sans">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Description&nbsp;</label><br>
                        {{$evid->evidence_description}}
                </div>
            </div>
    </div> 
    <br>
    <div class="row" style="font-family:Product Sans">
        <div class="col-sm-12">
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