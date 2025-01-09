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

        


        
            <div class="row">
              
                <div class="col-sm-12">
                    <div class="card">
                    <p><b>Service Requested:</b> {{@$data->service_request}}</p>

                    <p><b>Brief Description of Service:</b> {{@$data->description}}</p>

                    <p><b>Date:</b> {{@$data->date}}</p>

                    <p><b>Duration From:</b> {{@$data->from_duration}}</p>
                    <p><b>Duration To:</b> {{@$data->to_duration}}</p>

                    <p><b>Purpose:</b> {{@$data->purpose}}</p>
                    @if(@$data->attachment=="")
                    <p><a class="btn btn-xs btn-info" href="{{URL::to('attachment/legal_request')}}/{{@$data->attachment}}" target="_blank"><i class="fa fa-eye"></i> Attachment</a></p>
                    @endif

                  </div>
            </div>




    {{-- table-showing --}}
    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Legal Services Activities  
                              <small><a class="btn btn-warning" style="float:right" id="activity_add">+Add Activity</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Activity Brief</th>
                                        <th>Date</th>
                                        <th>Status</th>       
                                        <th>Reference</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$activities->isNotEmpty())
                                    @foreach(@$activities as $att)
                                    <tr>
                                        
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->activity_date }}</td>
                                        <td>{{ $att->status }}</td>
                                        <td>
                                            @if(@$att->attachment=="") No Attachment @else 
                                            <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/legal_request')}}/{{$att->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                Attachment
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                                @if(@$att->status!="Complete")
                                                <a class="btn btn-xs btn-info edit_activity" data-id="{{@$att->id}}" data-description="{{@$att->description}}" data-activity_date="{{@$att->activity_date}}" data-status="{{@$att->status}}" href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                
                                                            </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('get.assigned.legal.services.request.review.delete.activity',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
                                                                
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


    <div class="modal fade" id="activity_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Activity Request</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('get.assigned.legal.services.request.review.insert.activity')}}">@csrf
                        
                         <input type="hidden" name="legal_request_id" value="{{@$id}}" id="legal_request_id">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Activity Date</label>
                          <input type="date" class="form-control" name="activity_date" >
                         </div>

                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Activity Brief</label>
                          <textarea class="form-control" name="description"></textarea>
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <select class="form-control" required name="status">
                              <option value="">Select Status</option>
                              <option value="Ongoing">Ongoing</option>
                              <option value="Deferred">Deferred</option>
                              <option value="Complete">Complete</option>
                           </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Attach File</label>
                          <input type="file" class="form-control" name="attachment" >
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


                <div class="modal fade" id="activity_edit_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                            <form method="post" enctype="multipart/form-data" action="{{route('get.assigned.legal.services.request.review.update.activity')}}">@csrf
                         <input type="hidden" name="id" id="id_id">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Activity Date</label>
                          <input type="date" class="form-control" name="activity_date" id="activity_date">
                         </div>

                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Activity Brief</label>
                          <textarea class="form-control" name="description" id="description"></textarea>
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <select class="form-control" required name="status" id="status">
                              <option value="">Select Status</option>
                              <option value="Ongoing">Ongoing</option>
                              <option value="Deferred">Deferred</option>
                              <option value="Complete">Complete</option>
                           </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Attach File</label>
                          <input type="file" class="form-control" name="attachment" >
                         </div>
                         

                         <button type="submit" class="btn btn-primary">Submit</button>

        
                        
                      </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            
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
    $('#activity_add').on('click',function(){
            $('#activity_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.edit_activity').on('click',function(){
            $('#id_id').val($(this).data('id'));
            $('#activity_date').val($(this).data('activity_date'));
            $('#description').val($(this).data('description'));
            $('#status').val($(this).data('status')).change();
            $('#activity_edit_model').modal('show');
        })
</script>


@endsection