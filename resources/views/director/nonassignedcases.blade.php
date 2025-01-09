@extends('layouts.admin')

@section('content')
<br>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="tab-container">
                        <div class="card-header">
                            <div class="tab-header">
                                <div class="tab-item {{ Request::routeIs('directornonassigned') ? 'active' : '' }}">
                                    <a href="{{ route('directornonassigned') }}">Pending Assignment</a>
                                </div>
                                <div class="tab-item {{ Request::routeIs('directorassigned') ? 'active' : '' }}">
                                    <a href="{{ route('directorassigned') }}">Assigned</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <table class="table t2" id="casetablenonassigned">
                                    <thead>
                                        <tr>
                                            <th id="checkboxshow" hidden="hidden"></th>
                                            <th>Complaint No</th>
                                            <th>Complaint Title</th>
                                            <th>Complaint Status</th>
                                            <th>Complaint Date</th>
                                            <th>Action</th>            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($complaints_list->count())
                                        @foreach ($complaints_list as $complaint)  
                                        <tr>
                                            <td>{{ $complaint->complaint_no }}</td>
                                            <td>{{ $complaint->complaint_title }}</td>
                                            <td>@if ($complaint->complaint_status == '0')  Open @endif 
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($complaint->complaint_reg_date)->format('d/m/Y')}}</td>
                                            <td>
                                                <button type="button"  class="btn btn-info btn-sm" onclick="showassigncasenodiv('{{ $complaint->complaint_no }}')">Assign</button>&nbsp;
                                                <button type="button"  class="btn btn-info btn-sm" id="mergetwocomplaint" name="mergetwocomplaint" onclick="showmergecasenodiv('{{ $complaint->complaint_no }}')">Merge</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4"> No record found </td>
                                        </tr>
                                        @endif                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .tab-container {
    padding: 10px;
}

.tab-header {
    display: flex;
    justify-content: left;
    align-items: left;
    font-family : Product Sans;
    
}

.tab-item {
    margin-right: 10px;
    
}

.tab-item a {
    text-decoration: none;
    color: #333;
    padding: 10px;
}

.tab-item.active a {
    color: #000;
    border-bottom: 5px solid blue;
}

.tab-content {
    padding: 10px;
    background-color: #fff;
}
.t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
    
}

.t2 tbody th
{
    vertical-align: middle;
}
.t2 tbody th,
.t2 tbody td {
  padding: 0.35rem; /* Adjust the padding as needed */
  font-size: 0.9rem; /* Adjust the font size as needed */
  vertical-align: middle;
  /* text-align: center; */
}

</style>
@endsection