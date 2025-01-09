@extends('layouts.admin')

@section('content')
<br>
@include('investigator/mainheader')
    <!------------------------ end top part ---------------->  
<div class="col-sm-13" style="margin-top:-9px;">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                @include('tabs/investigator_tab')
            </div>
            <div class="card-body">
                @include('tabs/interviewplan_tab')
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <br>
                    @if(Auth::user()->role == "Investigator")
                    <i class="fa fa-plus" style="float:right; color:grey" onclick="addnewinterviewplan()" data-toggle="tooltip" data-placement="bottom" title="Add Person"></i>
                        @endif
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

<script>
	

</script>
@endsection