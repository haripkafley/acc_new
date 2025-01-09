@foreach ($idiarydetails as $idetails)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="casetitle">Date of Event:<font color='red'>*</font></label>
                            <input type="date" name="idiary_date"  id="idiary_date" class="form-control" value="{{ $idetails->date }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="casetitle">Task Type:<font color='red'>*</font></label>
                            <select class="form-control"   name="idiarytasktype" id="idiarytasktype" value="{{ $idetails->activity_category }}">
                               
                                    @foreach ($tasktypes as $tasktype)
                                        <option >{{ $tasktype->task_name }}</option>
                                    @endforeach    
                            </select>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group"> 
                        <label for="casetitle">Task Details:<font color='red'>*</font></label>
                                <textarea name="idiarytaskdetailsedit" id="idiarytaskdetailsedit" class="form-control">{{ $idetails->task_to_be_done }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
        <div class="col-sm-6">
            <div class="form-group"> 
                <label>Start Time&nbsp;<font color='red'>*</font></label>
                <input type="time" name="idiary_starttime"  id="idiary_starttime" class="form-control" value="{{ $idetails->start_time }}">
            </div> 
        </div>
        <div class="col-sm-6">
            <div class="form-group"> 
                <label>End Time&nbsp;<font color='red'>*</font></label>
                <input type="time" name="idiary_endtime"  id="idiary_endtime" class="form-control" value="{{ $idetails->end_time }}">
            </div> 
        </div> 
    </div> 
@endforeach
