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
                              Commission Meeting
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                                @if(@$decision_iprc->decision=="Y")
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Commission Meeting
                                </button>
                               @endif
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('ip_details.member_navbar')
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Commission Meeting No</th>
                                        <th>Meeting Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Created On (Date)</th>
                                        <th>Decision</th>
                                        <th>Attachment</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$decision->isNotEmpty())
                                    @foreach(@$decision as $att)
                                    <tr>
                                        <td>{{ $att->activity}}</td>
                                        <td>{{ $att->activity_date }}</td>
                                        <td>{{ $att->start_time }}</td>
                                        <td>{{ $att->end_time }}</td>
                                        <td>{{ $att->created_on_date }}</td>
                                        <td>{{ $att->status_details->name }}</td>
                                        <td>
                                            @if(@$att->attachment!="")
                                            <a class="btn btn-xs btn-info" href="{{URL::to('attachment/ir')}}/{{$att->attachment}}" target="_blank"><i class="fa fa-eye"></i>View
                                            </a>
                                            @endif
                                        </td>

                                        
                                        <td>
                                                        
                                                            
                                                             <a type="button"
                                                                class="btn btn-xs btn-primary edit_button"
                                                                data-id="{{$att->id}}"
                                                                data-activity="{{$att->activity}}"
                                                                data-activity_date="{{$att->activity_date}}"
                                                                data-start_time="{{$att->start_time}}"
                                                                data-end_time="{{$att->end_time}}"
                                                                data-decision="{{$att->decision}}"
                                                                data-remarks="{{$att->remarks}}"
                                                                data-toggle="modal"
                                                                >
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            
                                                            <a class="btn btn-xs btn-success" href="{{route('member.get.information.report.assignment.intel.project.comission.decision.page.member.page',['id'=>$att->id])}}" ><i class="fa fa-users"></i>
                                                                Commission Member
                                                            </a>
                                                            
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('member.get.information.report.assignment.intel.project.comission.decision.page.delete',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
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
            <form method="post" action="{{route('member.get.information.report.assignment.intel.project.comission.decision.page.insert')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ip_id" value="{{@$id}}">
                <div class="form-group">
                  <label for="exampleInputEmail1">Commission Meeting No</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="activity" aria-describedby="emailHelp" placeholder="Commission Meeting No">
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">Meeting Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="activity_date" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Start Time</label>
                  <input type="time" class="form-control" id="exampleInputEmail1" name="start_time" aria-describedby="emailHelp">
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">End Time</label>
                  <input type="time" class="form-control" id="exampleInputEmail1" name="end_time" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Commission Decision</label>
                  <select class="form-control" name="decision" required>
                      <option value="">Select</option>
                      @foreach(@$status as $value)
                         <option value="{{@$value->id}}">{{@$value->name}}</option>
                      @endforeach
                  </select>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Remarks</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="remarks" aria-describedby="emailHelp"></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Attachment</label>
                  <input type="file" class="form-control" id="exampleInputEmail1" name="attachment" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group mb-3">
                  <label for="select2Multiple">Members</label>
                  <br>
                  <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                    id="select2Multiple">
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


<!--Edit Modal -->
            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Commission Decision</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('member.get.information.report.assignment.intel.project.comission.decision.page.update')}}">@csrf
                                
                               <div class="form-group">
                              <label for="exampleInputEmail1">Commission Meeting No</label>
                              <input type="text" class="form-control" id="activity" name="activity" aria-describedby="emailHelp" placeholder="Commission Meeting No">
                             </div>


                             <div class="form-group">
                              <label for="exampleInputEmail1">Meeting Date</label>
                              <input type="date" class="form-control" id="activity_date" name="activity_date" aria-describedby="emailHelp">
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Start Time</label>
                              <input type="time" class="form-control" id="start_time" name="start_time" aria-describedby="emailHelp">
                             </div>


                             <div class="form-group">
                              <label for="exampleInputEmail1">End Time</label>
                              <input type="time" class="form-control" id="end_time" name="end_time" aria-describedby="emailHelp">
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Commission Decision</label>
                              <select class="form-control" name="decision" id="decision" required>
                                  <option value="">Select</option>
                                  @foreach(@$status as $value)
                                     <option value="{{@$value->id}}">{{@$value->name}}</option>
                                  @endforeach
                              </select>
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Remarks</label>
                              <textarea type="text" class="form-control" id="remarks" name="remarks" aria-describedby="emailHelp"></textarea>
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Attachment</label>
                              <input type="file" class="form-control" id="exampleInputEmail1" name="attachment" aria-describedby="emailHelp">
                             </div>

                                 
                             <input type="hidden" name="id" id="id">
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
<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#activity').val($(this).data('activity'));
            $('#activity_date').val($(this).data('activity_date'));
            $('#start_time').val($(this).data('start_time'));
            $('#end_time').val($(this).data('end_time'));
            $('#remarks').val($(this).data('remarks'));
            $('#decision').val($(this).data('decision')).change();

            $('#id').val($(this).data('id'));
            
            $('#exampleModaEdit').modal('show');
        })
</script>

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