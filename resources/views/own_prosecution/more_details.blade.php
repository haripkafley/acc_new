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

        @include('own_prosecution.common')



        
            <div class="row">
              
                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$data->case_withdrawn_details->case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$data->case_withdrawn_details->case_details->case_title}}</p>

                    <p><b>Instruction:</b> {{@$data->instruction}}</p>

                  </div>
            </div>




    {{-- table-showing --}}
    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Offences  
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Remarks</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$offences->isNotEmpty())
                                    @foreach(@$offences as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-offence="{{@$att->offence}}" data-remarks="{{@$att->remarks}}" href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                Edit
                                                            </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('own.prosecution.get.assign.official.case.admitted.offence.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
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


    <div class="modal fade" id="offence_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Offences</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.offence.insert')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="type" value="A">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence" id="offence">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>

                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="remarks" id="remarks"></textarea>
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


                <div class="modal fade" id="offence_model_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Offences</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.offence.update')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="id_offence" value="{{@$id}}" id="id_offence">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence" id="edit_offence">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>

                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="remarks" id="edit_remarks"></textarea>
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




         {{-- offence-count --}}
             <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Offences Count
                              <small><a class="btn btn-warning" style="float:right" id="offences_count_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Count</th>
                                        <th>Remarks</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$offence_count->isNotEmpty())
                                    @foreach(@$offence_count as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->counts }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence_count" data-id="{{@$att->id}}" data-offence="{{@$att->offence}}" data-counts="{{@$att->counts}}" data-remarks="{{@$att->remarks}}" href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                Edit
                                                            </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('own.prosecution.get.assign.official.case.admitted.offence.count.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
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


        <div class="modal fade" id="offence_count_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Offences</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.offence.count.insert')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="type" value="A">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence_name_count" id="offence_name_count">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Offence Count</label>
                          <input type="text" class="form-control" name="offence_count" id="offence_count">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="offence_remark" id="offence_remark"></textarea>
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



                <div class="modal fade" id="offence_count_model_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Offences Count</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.offence.count.update')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="id_offence_edit_id"  id="id_offence_edit_id">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence" id="edit_offence_name">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1">Offence Count</label>
                          <input type="text" class="form-control" name="offence_count" id="edit_offence_count">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="remarks" id="edit_offence_remarks"></textarea>
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


            {{-- sections --}}
                         <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Sections
                              <small><a class="btn btn-warning" style="float:right" id="section_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Section</th>
                                        <th>Remarks</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$sections->isNotEmpty())
                                    @foreach(@$sections as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->section }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_section" data-id="{{@$att->id}}" data-offence="{{@$att->offence}}" data-section="{{@$att->section}}" data-remarks="{{@$att->remarks}}" href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                Edit
                                                            </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('own.prosecution.get.assign.official.case.admitted.section.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
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





            <div class="modal fade" id="section_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Section</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.section.insert')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="type" value="A">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence" id="offence_section">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Section</label>
                          <input type="text" class="form-control" name="section" id="section_section">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="remarks" id="section_remark"></textarea>
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



                <div class="modal fade" id="section_model_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Section</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.section.update')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="id_section"  id="id_section">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence" id="edit_section_offence">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1">Section</label>
                          <input type="text" class="form-control" name="section" id="edit_section">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="remarks" id="edit_section_remark"></textarea>
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




            {{-- restitution --}}
                    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Restitution Prayed
                              <small><a class="btn btn-warning" style="float:right" id="restituion_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Restitution Prayed</th>
                                        <th>Remarks</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$restitution->isNotEmpty())
                                    @foreach(@$restitution as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->restitution_prayed }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_resti" data-id="{{@$att->id}}" data-offence="{{@$att->offence}}" data-restitution_prayed="{{@$att->restitution_prayed}}" data-remarks="{{@$att->remarks}}" href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                Edit
                                                            </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('own.prosecution.get.assign.official.case.admitted.restitution.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
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



            <div class="modal fade" id="restituion_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Restitution Prayed</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.restitution.insert')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="type" value="A">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Restitution Prayed</label>
                          <input type="text" class="form-control" name="restitution_prayed">
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


            <div class="modal fade" id="resti_model_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Restitution Prayed</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.restitution.update')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="id_resti"  id="id_resti">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence" id="edit_resti_offence">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1">Restitution Prayed</label>
                          <input type="text" class="form-control" name="restitution_prayed" id="restitution_prayed">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="remarks" id="edit_resti_remark"></textarea>
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




            {{-- recovery --}}
                    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Confiscation / Recovery Prayed
                              <small><a class="btn btn-warning" style="float:right" id="recovery_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Type</th>
                                        <th>Prayer</th>
                                        <th>Remarks</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$recovery->isNotEmpty())
                                    @foreach(@$recovery as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->type }}</td>
                                        <td>{{ $att->prayer }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_recovery" data-id="{{@$att->id}}" data-offence="{{@$att->offence}}" data-prayer="{{@$att->prayer}}" data-type="{{@$att->type}}" data-remarks="{{@$att->remarks}}" href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                Edit
                                                            </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('own.prosecution.get.assign.official.case.admitted.recovery.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
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



            <div class="modal fade" id="recovery_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confiscation / Recovery Prayed</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.recovery.insert')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="type" value="A">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Type</label>
                          <select class="form-control" required name="type">
                              <option value="">Select Offence</option>
                              <option value="Confiscation">Confiscation</option>
                              <option value="Recovery">Recovery</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Prayer</label>
                          <input type="text" class="form-control" name="prayer">
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



                <div class="modal fade" id="recovery_model_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Confiscation / Recovery Prayed</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.recovery.update')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="id_recovery"  id="id_recovery">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence" id="edit_revovery_offence">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Type</label>
                          <select class="form-control" required name="type" id="type_recovery">
                              <option value="">Select Offence</option>
                              <option value="Confiscation">Confiscation</option>
                              <option value="Recovery">Recovery</option>
                          </select>
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1"> Prayed</label>
                          <input type="text" class="form-control" name="prayer" id="prayer">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="remarks" id="edit_recovery_remark"></textarea>
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



                        {{-- other-prayers --}}
                    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Other Prayed
                              <small><a class="btn btn-warning" style="float:right" id="other_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Offence</th>
                                        <th>Prayer</th>
                                        <th>Remarks</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$other->isNotEmpty())
                                    @foreach(@$other as $att)
                                    <tr>
                                        
                                        <td>{{ $att->offence_name->offence_type }}</td>
                                        <td>{{ $att->prayer }}</td>
                                        <td>{{ $att->remarks }}</td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_other" data-id="{{@$att->id}}" data-offence="{{@$att->offence}}" data-prayer="{{@$att->prayer}}" data-type="{{@$att->type}}" data-remarks="{{@$att->remarks}}" href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                Edit
                                                            </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('own.prosecution.get.assign.official.case.admitted.recovery.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
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





            <div class="modal fade" id="other_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confiscation / Recovery Prayed</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.recovery.insert')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="type_type" value="A">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>

                         <input type="hidden" name="type" value="other">

                         <div class="form-group">
                          <label for="exampleInputEmail1">Prayer</label>
                          <input type="text" class="form-control" name="prayer">
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


            <div class="modal fade" id="other_model_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Other Prayed</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.admitted.recovery.update')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="id_recovery"  id="id_other">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Offences</label>
                          <select class="form-control" required name="offence" id="edit_other_offence">
                              <option value="">Select Offence</option>
                              @foreach(@$off as $val)
                              <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                              @endforeach
                          </select>
                         </div>

                         


                         <div class="form-group">
                          <label for="exampleInputEmail1"> Prayed</label>
                          <input type="text" class="form-control" name="prayer" id="prayer_other">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="remarks" id="edit_other_remark"></textarea>
                         </div>

                         <input type="hidden" name="type" value="other">
                         

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
</div>


            

             

                
         
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   



    <script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});


</script>

<script type="text/javascript">
    $('#offences_add').on('click',function(){
            $('#offence_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.edit_offence').on('click',function(){
            $('#id_offence').val($(this).data('id'));
            $('#edit_remarks').val($(this).data('remarks'));
            $('#edit_offence').val($(this).data('offence')).change();
            $('#offence_model_edit').modal('show');
        })
</script>


<script type="text/javascript">
    $('#offences_count_add').on('click',function(){
            $('#offence_count_model').modal('show');
        })
</script>


<script type="text/javascript">
    $('.edit_offence_count').on('click',function(){
            $('#id_offence_edit_id').val($(this).data('id'));
            $('#edit_offence_remarks').val($(this).data('remarks'));
            $('#edit_offence_name').val($(this).data('offence')).change();
            $('#edit_offence_count').val($(this).data('counts'));
            $('#offence_count_model_edit').modal('show');
        })
</script>

<script type="text/javascript">
    $('#section_add').on('click',function(){
            $('#section_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.edit_section').on('click',function(){
            $('#id_section').val($(this).data('id'));
            $('#edit_section_remark').val($(this).data('remarks'));
            $('#edit_section_offence').val($(this).data('offence')).change();
            $('#edit_section').val($(this).data('section'));
            $('#section_model_edit').modal('show');
        })
</script>

<script type="text/javascript">
    $('#restituion_add').on('click',function(){
            $('#restituion_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.edit_resti').on('click',function(){
            $('#id_resti').val($(this).data('id'));
            $('#edit_resti_remark').val($(this).data('remarks'));
            $('#edit_resti_offence').val($(this).data('offence')).change();
            $('#restitution_prayed').val($(this).data('restitution_prayed'));
            $('#resti_model_edit').modal('show');
        })
</script>

<script type="text/javascript">
    $('#recovery_add').on('click',function(){
            $('#recovery_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.edit_recovery').on('click',function(){
            $('#id_recovery').val($(this).data('id'));
            $('#edit_recovery_remark').val($(this).data('remarks'));
            $('#edit_revovery_offence').val($(this).data('offence')).change();
            $('#prayer').val($(this).data('prayer'));
            $('#type_recovery').val($(this).data('type'));
            $('#recovery_model_edit').modal('show');
        })
</script>


<script type="text/javascript">
    $('#other_add').on('click',function(){
            $('#other_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.edit_other').on('click',function(){
            $('#id_other').val($(this).data('id'));
            $('#edit_other_remark').val($(this).data('remarks'));
            $('#edit_other_offence').val($(this).data('offence')).change();
            $('#prayer_other').val($(this).data('prayer'));
            $('#other_model_edit').modal('show');
        })
</script>
@endsection