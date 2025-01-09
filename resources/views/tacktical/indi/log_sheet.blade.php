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
                              Log Sheet Form
                            </div>
                            @if(@$check->report_status!="A")
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Log Sheet
                                </button>
                               
                            </div>
                            @endif
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('tacktical.indi.navbar')
                            
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Activity</th>
                                        <th>Date Of Event</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Location</th>
                                        <th>Additional officer</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->activity}}</td>
                                        <td>{{ $att->date_event }}</td>
                                        <td>{{ $att->start_time }}</td>
                                        <td>{{ $att->end_time }}</td>
                                        <td>{{ $att->expenditure }}</td>
                                        <td>
                                            @php
                                                $explode = explode(',',$att->members);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}},
                                            @endforeach

                                        </td>
                                        
                                        
                                        <td>
                                                        
                                                            
                                                             <a type="button"
                                                                class="btn btn-xs btn-primary edit_button"
                                                                data-id="{{$att->id}}"
                                                                data-activity="{{$att->activity}}"
                                                                data-date_event="{{$att->date_event}}"
                                                                data-start_time="{{$att->start_time}}"
                                                                data-end_time="{{$att->end_time}}"
                                                                data-expenditure="{{$att->expenditure}}"
                                                                data-expenditure_details="{{$att->expenditure_details}}"
                                                                data-remarks="{{$att->remarks}}"
                                                                data-members="{{$att->members}}"
                                                                data-toggle="modal"
                                                                >
                                                                <i class="fa fa-edit"></i> + <i class="fa fa-eye"></i>
                                                            </a>
                                                            
                                                            
                                                            @if(@$check->report_status!="A")
                                                            <a class="btn btn-xs btn-danger" href="{{route('tacktical.inteligence.autorization.individual.log.sheet.form.page.delete',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                            </a>
                                                            @endif
                                                            
                                                            
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
          <h5 class="modal-title" id="exampleModalLabel">Log Sheet Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('tacktical.inteligence.autorization.individual.log.sheet.form.page.insert')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ti_id" value="{{@$id}}">
                <div class="form-group">
                  <label for="exampleInputEmail1">Activity</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="activity" aria-describedby="emailHelp" placeholder="Activity Name">
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">Date Of Event</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="date_event" aria-describedby="emailHelp">
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
                  <label for="exampleInputEmail1">Location</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="expenditure" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Activity Details</label>
                  <textarea class="form-control" name="expenditure_details"></textarea>
                 </div>


                  <div class="form-group mb-3">
                  <label for="select2Multiple">Additional Officer</label>
                  <br>
                  <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                    id="select2Multiple">
                    @foreach(@$users as $val)
                    <option value="{{@$val->id}}">{{@$val->name}} ({{@$val->department_name->name}})</option>
                    @endforeach              
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Remarks</label>
                  <textarea class="form-control" name="remarks"></textarea>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Log Sheet</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('tacktical.inteligence.autorization.individual.log.sheet.form.page.update')}}">@csrf
                                
                             <div class="form-group">
                              <label for="exampleInputEmail1">Activity</label>
                              <input type="text" class="form-control" id="activity" name="activity" aria-describedby="emailHelp" placeholder="Activity Name">
                             </div>


                             <div class="form-group">
                              <label for="exampleInputEmail1">Date Of Event</label>
                              <input type="date" class="form-control" id="date_event" name="date_event" aria-describedby="emailHelp">
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
                              <label for="exampleInputEmail1">Location</label>
                              <input type="text" class="form-control" id="expenditure" name="expenditure" aria-describedby="emailHelp">
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Activity Details</label>
                              <textarea class="form-control" name="expenditure_details" id="expenditure_details"></textarea>
                             </div>


                              <div class="form-group mb-3">
                              <label for="select2Multiple">Additional Officer</label>
                              <br>
                              <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                                id="leaderMultiSelctdropdown">
                                @foreach(@$users as $val)
                                <option value="{{@$val->id}}">{{@$val->name}}</option>
                                @endforeach              
                              </select>
                            </div>


                            <div class="form-group">
                                  <label for="exampleInputEmail1">Remarks</label>
                                  <textarea class="form-control" name="remarks" id="remarks"></textarea>
                            </div>

                            
                                 
                             <input type="hidden" name="id" id="id">
                             @if(@$check->report_status!="A")
                                <button type="submit" class="btn btn-primary">Submit</button>
                                @endif
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
            $('#date_event').val($(this).data('date_event'));
            $('#start_time').val($(this).data('start_time'));
            $('#end_time').val($(this).data('end_time'));
            $('#expenditure').val($(this).data('expenditure'));
            $('#expenditure_details').val($(this).data('expenditure_details'));
            $('#remarks').val($(this).data('remarks'));
            
            let string = $(this).data('members');
            if (/,/.test(string)) {
                 let arr = string.split(',');
                 $("#leaderMultiSelctdropdown").val(arr);
                 $('#leaderMultiSelctdropdown').val(arr).change();
            }else{
                let arr = [string];
                 $("#leaderMultiSelctdropdown").val(arr);
                 $('#leaderMultiSelctdropdown').val(arr).change();
            }
           
            $('#id').val($(this).data('id'));
            $('#exampleModaEdit').modal('show');
        })
</script>

     <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true,
                           });

        });

    </script>


@endsection