@foreach($interviewplans as $intplans)
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Interviewee </label><br>
                    <?php echo $key=DB::table('tbl_case_interviewees')->where('identification_no',$intplans->accused)->value('name'); ?>
            </div>                          
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Date of Interview&nbsp;</label><br>
                      {{ \Carbon\Carbon::parse($intplans->interview_date)->format('d/m/Y')}}   
            </div>
        </div>
    
        <div class="col-sm-4">
            <div class="form-group">
                <label>Interviewer </label><br>
                    @foreach($interviewers as $views)
                        <?php echo $key=DB::table('users')->where('email',$views->interviewers)->value('name'); ?><br>
                    @endforeach                               
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Location&nbsp;</label><br>
                       {{ $intplans->location}}  
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Defences&nbsp;</label><br>
                {{ $intplans->defences}}
            </div>
        </div> 
        <div class="col-sm-4">
            <div class="form-group">
                <label>Facts Already Established&nbsp;</label><br>
                {{ $intplans->facts_established}}
            </div>
        </div>
    </div>
@foreach($points as $pointstoprove => $facts)
    <table class="table table-bordered" id="addevidencetable">
        <thead>
            <th>Points to Prove</th>
            <th>Facts to Determine</th>
        </thead>
        <tbody>
            <tr>
                <td rowspan="{{ count($facts) }}">{{ $pointstoprove }}</td>
                <td>
                    @foreach($facts as $fact)
                        {{ $fact->interview_fact }}<br>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
    @endforeach
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Status&nbsp;</label><br>
                @if ($intplans->status == 1)
                <label class="text-success">Submitted for Review</label>
                @elseif($intplans->status == 2)
                <label class="text-success">Reviewed</label>
                @elseif($intplans->status == 3)
                <label class="text-success">Summon Order Printed</label>
                @elseif($intplans->status == 4)
                <label class="text-success">Report Printed</label>
                @endif 
        </div>
    </div>
</div>
@endforeach

<style>
    .hrnew {
        border: none;
        border-top: 2px dotted #ccc;
        height: 15px;
        margin: 10px 0;
    }
</style>