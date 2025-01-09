@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> 
                        {{-- Embassy List --}}
                        <div class="row" style="font-family:Product Sans">
                            <div class="col-sm">
                              Commission Member
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Member
                                </button>
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                           <div class="row"><div class="col-md-12 text-right"><a class=" active btn btn-success text-left"  href="{{route('member.get.information.report.assignment.intel.project.comission.decision.page',@$comdetails->ip_id)}}"> Back</a></div></div>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Member Name</th>
                                        <th>Decision</th>
                                        <th>Remarks / Reason</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->user_details->name}}</td>
                                        <td>@if(@$att->status=="AA") Awaiting Approval @elseif(@$att->status=="A") Accept @else Reject @endif</td>
                                        <td>@if(@$att->remarks=="") -- @else {{@$att->remarks}} @endif</td>
                                        <td>
                                           <a class="btn btn-xs btn-danger" href="{{route('member.get.information.report.assignment.intel.project.comission.decision.page.member.page.delete',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
                                           </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
<div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Commission Decision</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('member.get.information.report.assignment.intel.project.comission.decision.page.member.page.insert')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{@$id}}">
                
                 <div class="form-group mb-3">
                  <label for="select2Multiple">Member</label>
                  <br>
                  <select class="form-control" required name="member">
                      <option value="">Select</option>
                      @foreach(@$users as $val)
                      <option value="{{@$val->id}}">{{@$val->name}}</option>
                      @endforeach
                  </select>
                </div>


                 
        
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>




    </div>
</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


@endsection