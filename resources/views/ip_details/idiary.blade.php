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
                              Idiary Form
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Idiary
                                </button>
                               
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
                                        <th>Activity</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Created On (Date)</th>
                                        <th>Members Involved</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$decision->isNotEmpty())
                                    @foreach(@$decision as $att)
                                    <tr>
                                        <td>{{ $att->activity}}</td>
                                        <td>{{ $att->start_date }}</td>
                                        <td>{{ $att->end_date }}</td>
                                        <td>{{ $att->created_on }}</td>
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
                                                                data-start_date="{{$att->start_date}}"
                                                                data-end_date="{{$att->end_date}}"
                                                                data-created_on="{{$att->created_on}}"
                                                                data-members="{{$att->members}}"
                                                                data-toggle="modal"
                                                                >
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            
                                                            
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('member.get.information.report.assignment.intel.project.idiary.page.delete.data',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                            </a>
                                                            
                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    @foreach(@$plan as $att)
                                    <tr>
                                        <td>{{ $att->task}}</td>
                                        <td>{{ $att->start_date }}</td>
                                        <td>{{ $att->end_date }}</td>
                                        <td>{{ date('Y-m-d',strtotime($att->created_at))}}</td>
                                        <td>
                                            @php
                                                $explode = explode(',',$att->officer_assign_id);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}},
                                            @endforeach

                                        </td>
                                        <td>
                                       </td>
                                    </tr>
                                    @endforeach

                                    @foreach(@$sir as $att)
                                      <tr>
                                        <td>{{ $att->details}}</td>
                                        <td>{{ $att->received_date }}</td>
                                        <td>--</td>
                                        <td>{{ date('Y-m-d',strtotime($att->created_at))}}</td>
                                        <td>
                                            @php
                                                $explode = explode(',',$att->officers);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}},
                                            @endforeach

                                        </td>
                                        <td>
                                       </td>
                                    </tr>
                                    @endforeach
                                                  
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
          <h5 class="modal-title" id="exampleModalLabel">Add Idiary</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('member.get.information.report.assignment.intel.project.idiary.page.insert.data')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ip_id" value="{{@$id}}">
                <div class="form-group">
                  <label for="exampleInputEmail1">Activity Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="activity" aria-describedby="emailHelp" placeholder="Activity Name">
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">Activity Start Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="start_date" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Activity End Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="end_date" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Created On</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" value="{{date('Y-m-d')}}" name="created_on" aria-describedby="emailHelp">
                 </div>


                  <div class="form-group mb-3">
                  <label for="select2Multiple">Other Member Involved</label>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Idiary</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('member.get.information.report.assignment.intel.project.idiary.page.update.data')}}">@csrf
                                
                               <div class="form-group">
                              <label for="exampleInputEmail1">Activity Name</label>
                              <input type="text" class="form-control" id="activity" name="activity" aria-describedby="emailHelp" placeholder="Activity Name">
                             </div>


                             <div class="form-group">
                              <label for="exampleInputEmail1">Activity Start Date</label>
                              <input type="date" class="form-control" id="start_date" name="start_date" aria-describedby="emailHelp">
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Activity End Date</label>
                              <input type="date" class="form-control" id="end_date" name="end_date" aria-describedby="emailHelp">
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Created On</label>
                              <input type="date" class="form-control" id="created_on" name="created_on" aria-describedby="emailHelp">
                             </div>


                              <div class="form-group mb-3">
                              <label for="select2Multiple">Other Member Involved</label>
                              <br>
                              <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                                id="leaderMultiSelctdropdown">
                                @foreach(@$users as $val)
                                <option value="{{@$val->id}}">{{@$val->name}}</option>
                                @endforeach              
                              </select>
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
            $('#start_date').val($(this).data('start_date'));
            $('#end_date').val($(this).data('end_date'));
            $('#created_on').val($(this).data('created_on'));
            let string = $(this).data('members');
            $('#id').val($(this).data('id'));
            // let arr = string.split(',');

            if (/,/.test(string)) {
                 let arr = string.split(',');
                 $("#leaderMultiSelctdropdown").val(arr);
                 $('#leaderMultiSelctdropdown').val(arr).change();
            }else{
                let arr = [string];
                 $("#leaderMultiSelctdropdown").val(arr);
                $("#leaderMultiSelctdropdown").val(arr);
                $('#leaderMultiSelctdropdown').val(arr).change();
            }
            

            
            
            
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