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
                    <i class="fa fa-plus" style="float:right; color:grey" onclick="addnewsummonorder()" data-toggle="tooltip" data-placement="bottom" title="Add Person"></i>
                     @endif
                            <br>
                            <table id= "example4" class="table table-bordered table-hover">
                                <thead >
                                    <tr>
                                        <th>Interviewee</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($summonorder as $orders)
                                    <tr>
                                        <td>{{ $orders->interviewee}}</td>
                                        <td>{{ \Carbon\Carbon::parse($orders->summondate)->format('d/m/Y')}}</td>
                                        <td>{{ $orders->summonvenue}}</td>
                                        <td>{{ date('g:i A', strtotime($orders->summontime)) }}</td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
</div>
<!-- add summon order modal -->
  <form  method = "POST" action="{{ route('addsummonorder') }}" enctype="multipart/form-data">
    @csrf 
<div class="modal fade" id="addsummonordermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Summon Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Interviewee<span style="font-weight: bold; color: red;">*</span></label>
                                    <input type="text" name="intervieweename" class="form-control">
                                    <input type="hidden" name="summonordercasenoid" value="{{ $casenoid }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Report To<span style="font-weight: bold; color: red;">*</span></label>
                                    <select class="form-control" name="add_report_to" required>
                                        <option>Select One</option>
                                        @foreach ($interviewers as $intpersons)
                                        <option value="{{ $intpersons->email }}">{{ $intpersons->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Date<span style="font-weight: bold; color: red;">*</span></label>
                                    <input class="form-control" name="summondate" type="date" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Time<span style="font-weight: bold; color: red;">*</span></label>
                                    <input class="form-control" name="summontime" type="time" required>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Venue<span style="font-weight: bold; color: red;">*</span></label>
                                    <textarea class="form-control" name="summonvenue" ></textarea>
                            </div>
                        </div>
                    <div class="col-sm-12">
                            <h6><b>Documents to be produced</b></h6>
                                <table id= "example3" class="table table-bordered table-hover">
                                    <thead >
                                        <tr>
                                            <th scope="col">Sl No</th>
                                            <th scope="col">Description of Document/Article</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Remarks</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>                   
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                       
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary"  name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Update" >Add</button> 
                </div>
            </div>
        </div>
    </div>
</form>
<!-- end edit modal -->
<script>
	
function addnewsummonorder()
{
    $('#addsummonordermodal').modal('show');
}
</script>
@endsection