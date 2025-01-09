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
              
                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                  </div>
            </div>

            <div class="col-md-12"> @include('systemic.common')</div>
    <div class="col-sm-12">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                    + Add Data
                 </button>
    </div>

    {{-- table-showing --}}
    <div class="col-sm-12">

                           <div class="card-body">
                            
                            <table id="maintableEvalDec" class="table">
                                <thead>
                                    <tr>
                                        <th>Date of Receipt</th>
                                        <th>Recommended Systemic Change</th>
                                        <th>Action Taken</th>
                                        <th>Action Taken Date</th>
                                        <th>Reference Document</th>
                                        <th>Appraisal Sheet</th>
                                        <th>Commission's Decision</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data)
                                        {{-- {{$data}} --}}
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->date_receipt }}</td>
                                                <td>{{ $att->systemic_chage }}</td>
                                                <td>{{ $att->action_taken }}</td>
                                                <td>{{ $att->action_date }}</td>
                                                
                                                <td><a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/case_followup')}}/{{$att->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a></td>

                                                <td><a class="btn btn-success appraise_class" href="javascript:void(0)" data-recomendation_cfd="{{@$att->recomendation_cfd}}" data-id="{{@$att->id}}" data-comission_decision="{{@$att->comission_decision}}" data-comission_remark="{{@$att->comission_remark}}" 
                                                    data-receipt="{{ $att->date_receipt }}" 
                                                    data-systemic_chage="{{$att->systemic_chage}}" 
                                                    data-action_taken="{{$att->action_taken}}" 
                                                    data-action_date="{{$att->action_date}}"
                                                    data-case_no = "{{@$case_details->case_no}}"
                                                    data-case_title = "{{@$case_details->case_title}}"    

                                                    > Appraise</a></td>
                                                


                                                <td>
                                                    <p>{{@$att->status}}</p>
                                                    <a class="btn btn-success appraise" href="javascript:void(0)" data-status="{{@$att->status}}" data-id="{{@$att->id}}" data-status_remark="{{@$att->status_remark}}"
                                                    


                                                    >Update Status</a>
                                                </td>
                                                
                                                <td>
                                                    <a class="btn btn-xs btn-info edit_data"
                                                        href="javascript:void(0)" data-receipt="{{ $att->date_receipt }}" data-systemic_chage="{{$att->systemic_chage}}" data-action_taken="{{$att->action_taken}}" data-action_date="{{$att->action_date}}" data-id="{{@$att->id}}"><i class="fa fa-edit"></i>
                                                        + <i class="fa fa-eye"></i>
                                                    </a>


                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('systemic.recommendations.follow.action.taken.agency.delete.data', ['id' => @$att->id]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        
                                                    </a>
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
</div>


            
{{-- add-action --}}
<div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Action Taken Record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" enctype="multipart/form-data" action="{{route('systemic.recommendations.follow.action.taken.agency.inser.data')}}">@csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Date of Receipt</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" required name="date_receipt" aria-describedby="emailHelp">
                 </div>
                 <input type="hidden" name="case_id" value="{{@$case_id}}">
                 <div class="form-group">
                  <label for="exampleInputEmail1">Recommended Systemic Change</label>
                  <select class="form-control" required name="systemic_chage" id="systemic_chage">
                      <option value="">Select</option>
                      <option value="Systemic Change 1">Systemic Change 1</option>
                      <option value="Systemic Change 2">Systemic Change 2</option>
                  </select>
                 </div>

                 


            
                 <div class="form-group">
                  <label for="exampleInputEmail1">Action Taken</label>
                  <textarea class="form-control" name="action_taken"></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Action Taken Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" required name="action_date" aria-describedby="emailHelp">
                 </div>

                 

                 

                 <div class="form-group">
                  <label for="exampleInputEmail1">Reference Document</label>
                  <input type="file" class="form-control" id="exampleInputEmail1" required name="attachment" aria-describedby="emailHelp">
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


  {{-- edit --}}
  <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Action Taken Record</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('systemic.recommendations.follow.action.taken.agency.update.data')}}">@csrf
                        <input type="hidden" name="id" id="id_edit">
                

                <div class="form-group">
                  <label for="exampleInputEmail1">Date of Receipt</label>
                  <input type="date" class="form-control" id="date_receipt" required name="date_receipt" aria-describedby="emailHelp">
                 </div>
                 <input type="hidden" name="case_id" value="{{@$case_id}}">
                 <div class="form-group">
                  <label for="exampleInputEmail1">Recommended Systemic Change</label>
                  <select class="form-control" required name="systemic_chage" id="systemic_chage_id">
                      <option value="">Select</option>
                      <option value="Systemic Change 1">Systemic Change 1</option>
                      <option value="Systemic Change 2">Systemic Change 2</option>
                  </select>
                 </div>

                 


            
                 <div class="form-group">
                  <label for="exampleInputEmail1">Action Taken</label>
                  <textarea class="form-control" name="action_taken" id="action_taken"></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Action Taken Date</label>
                  <input type="date" class="form-control" id="action_date" required name="action_date" aria-describedby="emailHelp">
                 </div>

                 

                 

                 <div class="form-group">
                  <label for="exampleInputEmail1">Reference Document</label>
                  <input type="file" class="form-control" id="exampleInputEmail1"  name="attachment" aria-describedby="emailHelp">
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


            {{-- status --}}
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
                            <form method="post" enctype="multipart/form-data" action="{{route('systemic.recommendations.follow.action.taken.agency.update-status.data')}}">@csrf
                        <input type="hidden" name="id" id="id_appraise">
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <select class="form-control" required name="status" id="status_edit">
                              <option value="">Select</option>
                              <option value="Closed">Closed</option>
                              <option value="Further Action">Further Action</option>
                              <option value="Own Action">Own Action</option>
                          </select>
                         </div>

                         
                        <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="status_remark" id="status_remark"></textarea>
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


                        {{-- Appraise --}}
            <div class="modal fade" id="appraise_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Appraise</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('systemic.recommendations.follow.action.taken.agency.update.appraise')}}">@csrf
                        <input type="hidden" name="id" id="id_status">
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">

                         <div class="form-group">
                          <label for="exampleInputEmail1">Case Title</label>
                          <input class="form-control" readonly name="action_taken" id="case_title_app">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Case No</label>
                          <input type="text" class="form-control" readonly id="case_no_app"  name="action_date" aria-describedby="emailHelp">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Date of Receipt</label>
                          <input type="date" class="form-control" id="date_receipt_app" readonly name="date_receipt" aria-describedby="emailHelp">
                         </div>
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Recommended Systemic Change</label>
                          <select class="form-control" disabled name="systemic_chage" id="systemic_chage_id_app">
                              <option value="">Select</option>
                              <option value="Systemic Change 1">Systemic Change 1</option>
                              <option value="Systemic Change 2">Systemic Change 2</option>
                          </select>
                         </div>

                         


                    
                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Taken</label>
                          <textarea class="form-control" readonly name="action_taken" id="action_taken_app"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Taken Date</label>
                          <input type="date" class="form-control" readonly id="action_date_app" required name="action_date" aria-describedby="emailHelp">
                         </div>



                         <div class="form-group">
                          <label for="exampleInputEmail1">Recommendation by CFD</label>
                          <textarea class="form-control" name="recomendation_cfd" id="recomendation_cfd"></textarea>
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <select class="form-control" required name="comission_decision" id="comission_decision">
                              <option value="">Select</option>
                              <option value="Closed">Closed</option>
                              <option value="Further Action">Further Action</option>
                              <option value="Own Action">Own Action</option>
                          </select>
                         </div>

                         
                        <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="comission_remark" id="comission_remark"></textarea>
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



    <script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],
        responsive: true

    });
});


</script>





{{-- appraise --}}
<script type="text/javascript">
    $('.appraise').on('click',function(){
            $('#id_appraise').val($(this).data('id'));
            $('#status_edit').val($(this).data('status')).change();
            $('#status_remark').val($(this).data('status_remark'));
            $('#status_model').modal('show');
        })
</script>


<script type="text/javascript">
    $('.appraise_class').on('click',function(){
            $('#id_status').val($(this).data('id'));
            $('#comission_decision').val($(this).data('comission_decision')).change();
            $('#comission_remark').val($(this).data('comission_remark'));
            $('#recomendation_cfd').val($(this).data('recomendation_cfd'));

            $('#date_receipt_app').val($(this).data('receipt'));
            $('#systemic_chage_id_app').val($(this).data('systemic_chage')).change();
            $('#action_taken_app').val($(this).data('action_taken'));
            $('#action_date_app').val($(this).data('action_date'));
            $('#case_title_app').val($(this).data('case_title'));
            $('#case_no_app').val($(this).data('case_no'));

            $('#appraise_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.edit_data').on('click',function(){
            $('#date_receipt').val($(this).data('receipt'));
            $('#systemic_chage_id').val($(this).data('systemic_chage')).change();
            $('#action_taken').val($(this).data('action_taken'));
            $('#action_date').val($(this).data('action_date'));
            $('#id_edit').val($(this).data('id'));
            $('#exampleModaEdit').modal('show');
        })
</script>



@endsection