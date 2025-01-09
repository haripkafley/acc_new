@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">





        


        <form method="post" action="{{route('action.taken.list.action-list.delete.action')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Reason<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="text" name="reason" required>
                    </div>
                </div>



                <div class="col-sm-12"></div>
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Delete</button></div>
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