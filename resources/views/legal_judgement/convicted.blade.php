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

            @include('legal_judgement.common_review')



        
{{--             <div class="row">
              
                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$data->case_withdrawn_details->case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$data->case_withdrawn_details->case_details->case_title}}</p>

                    <p><b>Instruction:</b> {{@$data->instruction}}</p>

                  </div>
            </div>
 --}}



    {{-- table-showing --}}
    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Conviction Details  
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Sentence</th>
                                        <th>Restitution</th>
                                        <th>Confiscation / Recovery</th>
                                        <th>Fines and Penalties</th>
                                        <th>Other Orders</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        
                                        <td>{{ $att->sentense }}</td>
                                        <td>{{ $att->restitution }}</td>
                                        <td>{{ $att->recovery }}</td>
                                        <td>{{ $att->fines }}</td>
                                        <td>{{ $att->other }}</td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-sentense="{{@$att->sentense}}" data-restitution="{{@$att->restitution}}" data-recovery="{{@$att->recovery}}" data-fines="{{@$att->fines}}" data-other="{{@$att->other}}" href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                
                                                 </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('get.assign.judgement.legal.review.legal.convicted.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
                                                                
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
                            <h5 class="modal-title" id="exampleModalLabel">New Conviction</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('get.assign.judgement.legal.review.legal.convicted.insert')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Sentence</label>
                          <textarea class="form-control" name="sentense" ></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Restitution</label>
                          <textarea class="form-control" name="restitution" ></textarea>
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Confiscation / Recovery</label>
                          <textarea class="form-control" name="recovery" ></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Fines and Penalties</label>
                          <textarea class="form-control" name="fines" ></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Other Orders</label>
                          <textarea class="form-control" name="other" ></textarea>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Conviction</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('get.assign.judgement.legal.review.legal.convicted.update')}}">@csrf
                        
                         <input type="hidden" name="legal_review_id" value="{{@$id}}" id="legal_review_id">
                         <input type="hidden" name="id_convicted" value="{{@$id}}" id="id_convicted">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Sentence</label>
                          <textarea class="form-control" name="sentense" id="sentense"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Restitution</label>
                          <textarea class="form-control" name="restitution" id="restitution"></textarea>
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Confiscation / Recovery</label>
                          <textarea class="form-control" name="recovery" id="recovery"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Fines and Penalties</label>
                          <textarea class="form-control" name="fines" id="fines"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Other Orders</label>
                          <textarea class="form-control" name="other" id="other"></textarea>
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
    $('#offences_add').on('click',function(){
            $('#offence_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.edit_offence').on('click',function(){
            $('#id_convicted').val($(this).data('id'));
            $('#sentense').val($(this).data('sentense'));
            $('#restitution').val($(this).data('restitution'));
            $('#recovery').val($(this).data('recovery'));
            $('#fines').val($(this).data('fines'));
            $('#other').val($(this).data('other'));
            $('#edit_offence_name').val($(this).data('offence')).change();
            $('#offence_model_edit').modal('show');
        })
</script>

@endsection