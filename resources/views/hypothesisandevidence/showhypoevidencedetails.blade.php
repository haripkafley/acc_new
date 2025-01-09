
 <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <select name="assessmentstatus" id="assessmentstatus" class="form-control" required>
                <option value="">Select Status</option>
                    @foreach ($assessmenttypes as $assessmenttypes)
                        <option value="{{ $assessmenttypes->id }}">{{ $assessmenttypes->name }}</option>
                    @endforeach    
            </select> 
        </div>
    </div>
</div> 