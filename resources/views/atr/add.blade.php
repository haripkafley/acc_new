@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

         <div class="card-body">
                    <a href="{{route('action.taken.report',@$id)}}" class="btn btn-primary" style="float: right;">
                        Back
                    </a>
                </div>

        <form action="{{route('action.taken.report.action.for.yes.redirect')}}" method="POST" id="action_form">
            @csrf
            <input type="hidden" name="action_id" value="{{@$id}}">
            <div class="col-sm-12">
                    <div class="form-group">
                        <label>Action Taken? <span style="font-weight: bold; color: red;">*</span></label>
                        <br>
                            <div class="form-check form-check-inline">
                              
                              <input class="form-check-input action_taken" type="radio" id="action_taken" name="action_taken"  value="Y">
                              <label class="form-check-label" for="genderInput">Yes</label>
                              
                            </div>

                            <div class="form-check form-check-inline">
                              
                              <input class="form-check-input action_taken" type="radio" id="action_taken" checked name="action_taken" value="N">
                              <label class="form-check-label" for="genderInput">No</label>
                              
                            </div>
                    </div>
            </div>
        </form>
        


        <form method="post" action="{{route('action.taken.report.add.view.action-insert.for.no.action')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="action_id" value="{{@$id}}">
            <div class="row">






                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Letter No<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="text" name="letter_no" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Letter Date<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="date" name="letter_date" required>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Reason<span style="font-weight: bold; color: red;">*</span></label>
                            <textarea class="form-control" style="height: 150px;" name="reason"></textarea>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Attachment<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="file" name="attach_letter" required>
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

<script type="text/javascript">
    $('.action_taken').on('change',function(){
        var action = $(this).val();
        if(action=="Y")
        {
            $('#action_form').submit();
        }
    });
</script>


@endsection