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

        @include('legal_prosecution.common_dashboard')



        
            <div class="row">
              
                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                  </div>
            </div>




    {{-- table-showing --}}
    <div class="col-sm-12">

                           <div class="card-body">
                            
                            <table id="maintableGewog" class="table">
                                <thead>
                                    <tr>
                                        <th>Case/Accused</th>
                                        <th>CID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Attachment</th>
                                        <th>Reasons Cited by OAG</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$lists)
                                        {{-- {{$data}} --}}
                                        @foreach (@$lists as $att)
                                            <tr>

                                                @php
                                                $check = DB::table('legal_prosecution_status')->where('case_withdrawn_id',$att->id)->first();
                                                @endphp




                                                <td>{{ $att->case_or_accused}}</td>
                                                <td>{{ $att->cid }}</td>
                                                <td>{{ $att->accused_name }}</td>

                                                @if(@$check=="")
                                                <td>{{ $att->type }}</td>
                                                <td>{{ $att->date }}</td>
                                                <td><a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/case_followup')}}/{{$att->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                Attachment
                                                            </a></td>
                                                <td>....</td>

                                                <td>
                                                    <a href="javascript:void(0)"  data-id="{{@$att->id}}"  data-date="{{@$check->date}}" data-attachment="{{URL::to('attachment/legal_prosecution')}}/{{@$check->attachment}}" data-attach="{{@$check->attachment}}" data-status="{{@$check->status}}" data-reason="{{@$check->reason}}" class="btn btn-warning status_button">Update</a>
                                                </td>   
                                                @else


                                                <td>{{ $check->status }}</td>
                                                <td>{{ $check->date }}</td>
                                                <td><a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/legal_prosecution')}}/{{$check->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                Attachment
                                                            </a></td>

                                                <td>{{$check->reason}}</td>
                                                <td>
                                                    <a href="javascript:void(0)"  data-id="{{@$att->id}}"  data-date="{{@$check->date}}" data-attachment="{{URL::to('attachment/legal_prosecution')}}/{{@$check->attachment}}" data-attach="{{@$check->attachment}}" data-status="{{@$check->status}}" data-reason="{{@$check->reason}}" class="btn btn-warning status_button">Update</a>
                                                </td>  



                                                @endif         
                                                
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


    <div class="modal fade" id="status_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('prosecution.legal.list.my-dashboard.view.case-return-dropped-withdrawn.update')}}">@csrf
                        
                         <input type="hidden" name="case_withdrawn_id" id="case_withdrawn_id">
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <select class="form-control" name="status" id="status">
                              <option value="">Select</option>
                              <option value="Withdrawn">Withdrawn</option>
                              <option value="Dropped">Dropped</option>
                              <option value="Return">Return</option>
                          </select>
                         </div>

                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Date</label>
                          <input type="date" class="form-control"  name="date" id="date">
                         </div>

                         
                        <div class="form-group">
                          <label for="exampleInputEmail1">Reason cited by OAG</label>
                          <textarea class="form-control" name="reason" id="reason"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Attachment</label>
                          <input type="file" class="form-control"  name="attachment" id="attachment">
                         </div>

                         <div class="form-group attachment_view" style="display:none">
                          <a href="" class="btn btn-primary" id="attachment_view" target="_blank">View Attachment</a>
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
    $('.status_button').on('click',function(){
            $('#case_withdrawn_id').val($(this).data('id'));
            $('#status').val($(this).data('status')).change();
            $('#date').val($(this).data('date'));
            

            $('#reason').val($(this).data('reason'));

            if($(this).data('attach')!="")
            {
                // alert($(this).data('attachment'));
                $('.attachment_view').show();
                $('#attachment_view').attr('href',$(this).data('attachment')); 
            }
            $('#status_model').modal('show');
        })
</script>

@endsection