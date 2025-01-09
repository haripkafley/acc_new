@foreach ($casedetails as $dtls)
<div class="row">
    <div class   = "col-md-6">
        <div class    = "form-group">
            <label style="font-family:Product Sans" for = "exampleInputEmail1">Current Branch</label>   
            <input type="text" name="branch_reassign" readonly id="branch_reassign" class="form-control" value="{{ $dtls->branch}}">
                                            
        </div>
    </div>

    <div class   = "col-md-6">
        <div class    = "form-group">
            <label style="font-family:Product Sans" for = "exampleInputEmail1">New Branch&nbsp;<font color='red'>*</font></label>   
                <select class = "form-control" name="new_branch" id="new_branch" required>
                    <option value="">Select Branch</option>
                        @foreach ($branches as $branch)
                            @if ($branch->branch_name != $dtls->branch)
                                <option value="{{ $branch->branch_name }}">{{ $branch->branch_name }}</option>
                            @endif
                        @endforeach 
                </select>
                                            
        </div>
    </div>
</div>
                        
<div class="row">

        <div class  = "col-md-12">
            <div class = "form-group">
                <label style="font-family:Product Sans" for  = "ccoi" required>Reason&nbsp;<font color='red'>*</font></label>
                    <input type = "text" class="form-control" name="reason_reassign" id="reason_reassign">    
            </div>
        </div>

</div>
@endforeach