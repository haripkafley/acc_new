@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">



                
        <div class="card-body">
            <a href="{{route('action.taken.list.action-list',@$data->eve_offence_id)}}" class="btn btn-primary" style="float: right;">
            Back
        </a>
        </div>

        


        <form method="post" action="{{route('action.taken.list.action-list.extension.action')}}"  enctype="multipart/form-data">


            @csrf
            <input type="hidden" name="id" value="{{@$data->id}}">
            <input type="hidden" name="eve_offence_id" value="{{@$data->eve_offence_id}}">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Letter to Agency No.<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" value="{{@$data->letter_no}}"  readonly  type="text" name="letter_no" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Letter to Agency Date<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" value="{{@$data->letter_date}}"  readonly type="date" name="letter_date" required>
                    </div>
                </div>

                <div class="clearfix"> </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Action To Be Taken Brief<span style="font-weight: bold; color: red;"></span></label>
                            <textarea class="form-control"  type="text" name="description_action" readonly > {{@$data->description_action}} </textarea>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <a class="btn btn-xs btn-info" href="{{URL::to('attachment/action')}}/{{@$data->attachment}}" target="_blank"><i class="fa fa-eye"></i> View Attachment  </a>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Previous Deadline<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="date" name="deadline" value="{{@$data->deadline}}" readonly>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Extented To<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="date" name="extended_to" value="{{@$data->extended_to}}" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Extension Letter No<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="text" name="extension_letter_no" value="{{@$data->extension_letter_no}}" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Reason<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="text" name="reason_extension" value="{{@$data->reason_extension}}" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Request Letter Attachment</label>
                            <input class="form-control"  type="file" name="request_letter_attachment">
                    </div>
                </div>

                @if(@$data->request_letter_attachment!="")
                <div class="form-group">
                        <a class="btn btn-xs btn-info" href="{{URL::to('attachment/action')}}/{{$data->request_letter_attachment}}" target="_blank"><i class="fa fa-eye"></i>View Uploaded Request Letter Attachment</a>
                    </div>
                @endif


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Extension Letter Attachment</label>
                            <input class="form-control"  type="file" name="extension_letter_attachment">
                    </div>
                </div>

                @if(@$data->extension_letter_attachment!="")
                <div class="form-group">
                        <a class="btn btn-xs btn-info" href="{{URL::to('attachment/action')}}/{{$data->extension_letter_attachment}}" target="_blank"><i class="fa fa-eye"></i>View Uploaded Extension Letter Attachment</a>
                    </div>
                @endif

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