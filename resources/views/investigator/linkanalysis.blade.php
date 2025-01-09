@extends('layouts.admin')

@section('content')
<br>

<section class = "content">   
    @include('investigator/mainheader')
    <!------------------------ end top part ---------------->  
<div class="col-sm-13" style="margin-top:-9px;">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                @include('tabs/investigator_tab')
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    gg
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
<script>
	
</script>
@endsection