@extends('layouts.admin')

@section('content')
    <style type="text/css">
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
        .tox .tox-notification--warn, .tox .tox-notification--warning {
            display: none;
        }
            
        .card{
            padding: 25px;
        }

            </style>
<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
       
      </ul>



        
            <div class="row">
              


                <div class="col-sm-12">
                    <div class="card">
                    <p><b>Complaint No:</b> {{@$data->complaintRegNo}}</p>

                    <p><b>Complaint TItle:</b> {{@$data->complaintTitle}}</p>

                    <p><b>Date Time:</b> {{@$data->complaintDateTime}}</p>

                    <p><b>Complaint Brief:</b> {!!@$data->complaintDetails!!}</p>

                    <p><b>Offence Name:</b> {{@$offence_details->offence_name->offence_type}}</p>

                   

                    
               </div>
                   
            </div>




                             <div class="col-sm-12">
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Assign Review Team
                                </div>

                                

                                <div class="col-sm" >
                                    <!-- Button trigger modal -->
                                    @if(@$appaise  && @$appaise->review_crud=="Y" || !@$appaise)
                                    
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa3" style="float: right;">
                                        + Add Member
                                    </button>
                                    
                                    @endif
                                   
                                </div>
                            </div>
                    <div class="card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}


                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        
                                        <th>EID</th>
                                        <th>Name</th>
                                        <th>COI Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$members->isNotEmpty())
                                        @foreach (@$members as $att)
                                            <tr>
                                                <td>{{@$att->user_details->eid}}</td>
                                                <td>{{@$att->user_details->name}}</td>


                                                <td>@if(@$att->coi_status=="AA") Awaiting Approval @elseif(@$att->coi_status=="Y") Yes @else No  @endif</td>

                                                
                                                
                                                <td>
                                                    
                                                            
                                                     
                                                   

                                                    @if(@$appaise  && @$appaise->review_crud=="Y" || !@$appaise)
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{route('asssign.review.team.evaluation.delete.team',@$att->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    @endif

                                                    
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
    </div>


            

             

                









                <div class="modal fade" id="exampleModa3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Add  Members</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('assign.review.team.evaluation.insert.member') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="complaint_id" value="{{@$id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">EID</label>
                                    <input class="form-control" id="eid" name="eid" required>
                                    <a href="javascript:void(0)" id="search_eid" class="btn btn-primary mt-2">Search</a>
                                </div>

                                <input type="hidden" name="type" value="cec">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CID</label>
                                    <input type="text" name="cid" id="cid" class="form-control" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" name="name" id="name_committee" class="form-control" readonly required>
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   




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
    </script>

@endsection