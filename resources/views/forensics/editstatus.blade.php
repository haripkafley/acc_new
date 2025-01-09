@foreach ($forensicdetails as $details)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="casetitle">Case No:</label>
                            <br>
                          {{ $details->case_no}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="casetitle">Case Title:</label>
                            <br>
                            {{ $details->case_no}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label for="casetitle">Status:</label>
                            <select class="form-control"   name="forensicstatus" id="forensicstatus">
                                    @foreach ($status as $status)
                                        <option value="{{ $status->name }}">{{ $status->name }}</option>
                                    @endforeach    
                            </select>
                    </div>
                </div>
            </div>
@endforeach
