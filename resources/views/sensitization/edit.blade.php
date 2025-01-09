@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">


        <div class = "cards">
        <a href="{{route('sensitization.list.action-list',@$data->eve_offence_id)}}" class="btn btn-primary" style="float: right;">
                Back
            </a>
         </div>


        


        <form method="post" action="{{route('sensitization.list.action-list.update.action')}}" enctype="multipart/form-data">
            @csrf
            <h3>Sensitization To Be Done</h3>
            <input type="hidden" name="id" value="{{@$data->id}}">
            <input type="hidden" name="eve_offence_id" value="{{@$data->complaint_id}}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Letter to Agency No.<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" value="{{@$data->letter_no}}"  type="text" name="letter_no" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Letter to Agency Date<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" value="{{@$data->letter_date}}" type="date" name="letter_date" required>
                    </div>
                </div>

                <div class="clearfix"> </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Action To Be Taken Brief<span style="font-weight: bold; color: red;"></span></label>
                            <textarea class="form-control"  type="text" name="description_action"> {{@$data->description_action}} </textarea>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Agency<span style="font-weight: bold; color: red;"></span></label>
                             <select class="select2-multiple form-control" style="width:100%" name="agencyUser[]" multiple="multiple"
                            id="select2Multiple">
                            @foreach(@$agency as $value)
                            <option value="{{@$value->agencyID}}" {{ (in_array($value->agencyID, @$selected)) ? 'selected' : '' }}>{{@$value->agencyName}}</option>
                            @endforeach              
                          </select>
                </div>


               


                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Attach Letter<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" name="attachment" type="file" >
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <a class="btn btn-xs btn-info" href="{{URL::to('attachment/action')}}/{{$data->attachment}}" target="_blank"><i class="fa fa-eye"></i>View  </a>
                    </div>
                </div>
                

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Deadline<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="date" name="deadline" value="{{@$data->deadline}}" required>
                    </div>
                </div>

                <div class="col-sm-12"></div>
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
            </div>
        </form>
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

        });

    </script>


@endsection