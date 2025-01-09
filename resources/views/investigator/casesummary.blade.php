@extends('layouts.admin')

@section('content')
<br>

@include('investigator/mainheader')
    <!------------------------ end top part ---------------->

    <div class="col-sm-13" style="margin-top:-9px;">
        <div class="card card-primary card-outline card-outline-tabs" style="height:350px">
            <div class="card-header p-0 border-bottom-0">
                @include('tabs/investigator_tab')
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
				   <font face="Product Sans"> {{ $casealleationdtls }}</font>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
 <script>
    window.onload = function() {
        var textbox = document.getElementById('textboxvalue').value;
        const accordionItem = document.getElementById('collapseOne');

        if (textbox === '1') {
            // If textbox value is '1', collapse the accordion item
            $(document).ready(function(){
                $('#collapseOne').removeClass('show');
            });
        }
    };

 </script>
@endsection