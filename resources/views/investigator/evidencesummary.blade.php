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
                    @include('tabs/evidence_tab')
                    <br>
                    <br>
                        <table class="table t2">
                            <tr>
                                <th>Offence</th>
                                <th>No of person charged</th>
                                <th>No of Counts</th>
                            </tr>
                             @foreach ($evidencesummary as $result)
                                <tr>
                                    <td><?php echo $key = DB::table('tbl_offences_lookup')->where('offence_id', $result->offence_id)->value('offence_type') ?></td>
                                    <td>{{ $result->accused_count }}</td>
                                    <td>{{ $result->last_count }}</td>
                                </tr>
                            @endforeach
                        </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
<script>
	
</script>
<style>
    .t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
}
</style>
@endsection