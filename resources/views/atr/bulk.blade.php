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
                               Committee Meeting Bulk Member Add
                            </div>
                            
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}

                            <form method="post" action="{{route('action-atr-ces.number.generate.memebers.committee.room',@$id)}}">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date</label>
                                    <input type="date" name="date_search" id="date_search" value="{{request('date_search')}}" class="form-control"  >
                                    
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Meeting Type</label>
                                    <select name="meeting_type" class="form-control">
                                        <option value="cec" @if(request('meeting_type')=="CEC") selected @endif>CEC</option>
                                        <option value="comission" @if(request('meeting_type')=="comission") selected @endif>Comission</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-info mt-3">Search Member</button> 
                                </div>
                            </form>

                            <form method="post" action="{{route('action-atr-ces.number.generate.memebers.committee.room.final-step-update')}}"> 
                                    @csrf
                                    <input type="hidden" name="temp_id" value="{{@$id}}">

                                    <div class="form-group">
                                    <label for="exampleInputEmail1">Meeting Type</label>
                                    <select name="meeting_decide" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="cec">CEC</option>
                                        <option value="com">Comission</option>
                                    </select>
                                </div>



                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date</label>
                                    <input type="date" name="cec_date" id="cec_date" class="form-control"  required >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Time</label>
                                    <input type="time" name="cec_time" id="cec_time" class="form-control"  required >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Venue</label>
                                    <input type="text" name="cec_venue"  id="cec_venue" class="form-control"  required >
                                </div>
                              


                            <table id  = "maintable" class="table" >
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa3" style="float: right;">
                                        + Add Member
                                    </button>
                                <thead>
                                    <tr>
                                        <th>EID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                                
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data)
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                                <td>{{ @$att->user_details->eid }}</td>
                                                <td>{{ @$att->user_details->name }}</td>
                                                <td>{{ @$att->user_details->department_name->name }}</td>
                                                <td>@if(@$att->role=="MS") Member Secretary @elseif(@$att->role=="CP") Chair Person @else Member  @endif</td>

                                               <td>
                                                   <a type="button"
                                                        class="btn btn-xs btn-primary edit_button_person row-class-{{ @$att->id }}"
                                                        data-row-data='{{ @$att->dzoName }}' data-id="{{@$att->id}}" data-eid="{{@$att->user_details->eid}}" data-name="{{@$att->user_details->name}}" 
                                                        data-cid="{{@$att->user_details->cid}}"
                                                        data-department="{{@$att->user_details->department_name->name}}"
                                                        data-role = "{{@$att->role}}"
                                                        data-remarks = "{{@$att->remarks}}"
                                                        data-toggle="modal"
                                                        >
                                                        Edit
                                                    </a>

                                                        <a class="btn btn-xs btn-danger" href="{{route('action-atr-ces.number.generate.memebers.committee.room.delete.temp.member',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
                                                            </a>
                                               </td>
                                                
                                                
                                            </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                    @endif
                                                  
                               </tbody>
                            </table>
                              <button type="submit" class="btn btn-warning mt-3">Assign</button>
                             </form>
                        </div>
                </div>
            </div>
        </div>


            {{-- committe --}}
                <div class="modal fade" id="exampleModa3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Add Committee Members</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('action-atr-ces.number.generate.memebers.committee.room.add.temp.member') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="temp_id" value="{{@$id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">EID</label>
                                    <input class="form-control" id="eid" name="eid" required>
                                    <a href="javascript:void(0)" id="search_eid" class="btn btn-primary mt-2">Search</a>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CID</label>
                                    <input type="text" name="cid" id="cid" class="form-control" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" name="name" id="name_committee" class="form-control" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Deparment</label>
                                    <input type="text" name="department" id="department" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role</label>
                                    <select class="form-control" name="role" required>
                                        <option value="">Select</option>
                                        <option value="MS">Member Secretary</option>
                                        <option value="CP">Chair Person</option>
                                        <option value="M">Member</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea name="remarks" class="form-control"></textarea>
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



                            <div class="modal fade" id="exampleModa3_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Edit Committee Members</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('action-atr-ces.number.generate.memebers.committee.room.update.temp.member') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="temp_id" value="{{@$id}}">
                                <input type="hidden" name="member_id" id="member_id">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">EID</label>
                                    <input class="form-control" id="eid_edit" name="eid" required>
                                    <a href="javascript:void(0)" id="search_eid_edit" class="btn btn-primary mt-2">Search</a>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CID</label>
                                    <input type="text" name="cid" id="cid_edit" class="form-control" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" name="name" id="name_committee_edit" class="form-control" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Deparment</label>
                                    <input type="text" name="department" id="department_edit" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role</label>
                                    <select class="form-control" name="role" id="role_edit" required>
                                        <option value="">Select</option>
                                        <option value="MS">Member Secretary</option>
                                        <option value="CP">Chair Person</option>
                                        <option value="M">Member</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea name="remarks_edit" id="remarks_edit" class="form-control"></textarea>
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
<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#complainttypeName').val($(this).data('name'));
            $('#id').val($(this).data('id'));
            
            $('#exampleModaEdit').modal('show');
        })
</script>

    <script type="text/javascript">
        $('#search_eid').on('click',function(e){
            if($('#eid').val()==""){
                alert('Please enter eid');
                return false;
            }else{
                var eid = $('#eid').val();
                $.ajax({
                url:'{{route('get.person-details.eid')}}',
                type:'GET',
                data:{eid:eid},
                success:function(data){
                  console.log(data);
                  if(data.success==false){
                    alert('User not found . Please try another one');
                    return false;
                  }
                  $('#cid').val(data.cid);
                  $('#department').val(data.department);
                  $('#name_committee').val(data.name);
                }
              })
            }

        });

        $('.edit_button_person').on('click',function(){
            $('#eid_edit').val($(this).data('eid'));
            $('#cid_edit').val($(this).data('cid'));
            $('#name_committee_edit').val($(this).data('name'));
            $('#department_edit').val($(this).data('department'));
            $('#role_edit').val($(this).data('role')).attr("selected", "selected");
            $('#remarks_edit').val($(this).data('remarks'));
            $('#member_id').val($(this).data('id'));
            $('#exampleModa3_edit').modal('show');
            
        })
    </script>


            <script type="text/javascript">
        $('#search_eid_edit').on('click',function(e){
            if($('#eid_edit').val()==""){
                alert('Please enter eid');
                return false;
            }else{
                var eid = $('#eid_edit').val();
                $.ajax({
                url:'{{route('get.person-details.eid')}}',
                type:'GET',
                data:{eid:eid},
                success:function(data){
                  console.log(data);
                  if(data.success==false){
                    alert('User not found . Please try another one');
                    return false;
                  }
                  $('#cid_edit').val(data.cid);
                  $('#department_edit').val(data.department);
                  $('#name_committee_edit').val(data.name);
                  
                }
              })
            }

        });
    </script>

@endsection