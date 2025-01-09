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

            <div class="col-md-12"> @include('admin_refer_follow.common')</div>


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
                                        <th>Date of Action Taken</th>
                                        <th>Action Taken Against</th>
                                        <th>CID/Document No</th>
                                        <th>Name</th>
                                        <th>License No</th>
                                        <th>Agency Name</th>
                                        {{-- <th>Action Taken</th> --}}
                                        <th>Reference</th>
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
                                                <td>{{ $att->action_taken_against }}</td>
                                                <td>{{ $att->cid_document }}</td>
                                                <td>{{ $att->name }}</td>
                                                <td>{{ $att->license_no }}</td>
                                                <td>{{ $att->agency_name }}</td>
                                                {{-- <td>{{ $att->action_taken }}</td> --}}
                                                <td><a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/case_followup')}}/{{$att->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a></td>
                                                <td><a class="btn btn-success appraise_class" href="javascript:void(0)" data-recomendation_cfd="{{@$att->recomendation_cfd}}" data-id="{{@$att->id}}" data-comission_decision="{{@$att->comission_decision}}" data-comission_remark="{{@$att->comission_remark}}" 
                                                data-receipt="{{ $att->date_receipt }}" data-action_taken_against="{{$att->action_taken_against}}" data-cid="{{$att->cid_document}}" data-name="{{$att->name}}" data-license="{{$att->license_no}}" data-agency_name="{{$att->agency_name}}" data-action_type="{{@$att->action_type}}" data-sanction="{{$att->sanction}}" data-action_taken="{{@$att->action_taken}}" data-fine="{{@$att->fines}}" data-action_taken_date="{{@$att->action_taken_date}}"

                                                > Appraise</a></td>
                                                <td>
                                                    <p>@if($att->status=="AA") Awaiting @else {{@$att->status}} @endif</p>
                                                    <a class="btn btn-success appraise" href="javascript:void(0)" data-status="{{@$att->status}}" data-id="{{@$att->id}}" data-status_remark="{{@$att->status_remark}}">Update Status</a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-xs btn-info edit_data"
                                                        href="javascript:void(0)" data-receipt="{{ $att->date_receipt }}" data-action_taken_against="{{$att->action_taken_against}}" data-cid="{{$att->cid_document}}" data-name="{{$att->name}}" data-license="{{$att->license_no}}" data-agency_name="{{$att->agency_name}}" data-action_type="{{@$att->action_type}}" data-sanction="{{$att->sanction}}" data-action_taken="{{@$att->action_taken}}" data-fine="{{@$att->fines}}" data-action_taken_date="{{@$att->action_taken_date}}" data-id="{{@$att->id}}"><i class="fa fa-edit"></i> + <i class="fa fa-eye"></i>
                                                    </a>


                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('case.administrative.referrals.followup.own-action-taken.delete.data', ['id' => @$att->id]) }}"
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
            <form method="post" enctype="multipart/form-data" action="{{route('case.administrative.referrals.followup.own-action-taken.insert.data')}}">@csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Date of Action Taken</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" required name="date_receipt" aria-describedby="emailHelp">
                 </div>
                 <input type="hidden" name="case_id" value="{{@$case_id}}">
                 <div class="form-group">
                  <label for="exampleInputEmail1">Action Taken Against</label>
                  <select class="form-control" required name="action_taken_against" id="action_taken_against">
                      <option value="">Select</option>
                      <option value="Individual">Individual</option>
                      <option value="Organization">Organization</option>
                  </select>
                 </div>

                 <div class="individual_div" style="display:none">
                 <div class="form-group">
                  <label for="exampleInputEmail1">CID / Document No</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="cid_document" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp">
                 </div>
                </div>


                <div class="organization_div" style="display:none">
                 <div class="form-group">
                  <label for="exampleInputEmail1">License No / Registration No</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="license_no" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Agency Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="agency_name" aria-describedby="emailHelp">
                 </div>
                </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Action Type</label>
                  <select class="form-control" name="action_type" required>
                      <option value="">Select</option>
                      <option value="Action1">Action1</option>
                      <option value="Action2">Action2</option>
                  </select>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Action Sanction</label>
                  <select class="form-control" name="sanction" required>
                      <option value="">Select</option>
                      <option value="Sanction1">Sanction1</option>
                      <option value="Sanction2">Sanction2</option>
                  </select>
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">Action Taken</label>
                  <textarea class="form-control" name="action_taken"></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Fines and Penalties</label>
                  <textarea class="form-control" name="fines"></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Action Taken Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" required name="action_taken_date" aria-describedby="emailHelp">
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
                            <form method="post" enctype="multipart/form-data" action="{{route('case.administrative.referrals.followup.own-action-taken.update.data')}}">@csrf
                        <input type="hidden" name="id" id="id_edit">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Date of Action Taken</label>
                          <input type="date" class="form-control" id="date_receipt_edit"  required name="date_receipt" aria-describedby="emailHelp">
                         </div>
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Taken Against</label>
                          <select class="form-control" required name="action_taken_against" id="action_taken_against_edit">
                              <option value="">Select</option>
                              <option value="Individual">Individual</option>
                              <option value="Organization">Organization</option>
                          </select>
                         </div>

                         <div class="individual_div_edit" style="display:none">
                         <div class="form-group">
                          <label for="exampleInputEmail1">CID / Document No</label>
                          <input type="text" class="form-control" id="cid_document_edit" name="cid_document" aria-describedby="emailHelp">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" class="form-control" id="name_edit" name="name" aria-describedby="emailHelp">
                         </div>
                        </div>


                        <div class="organization_div_edit" style="display:none">
                         <div class="form-group">
                          <label for="exampleInputEmail1">License No / Registration No</label>
                          <input type="text" class="form-control" id="license_no_edit" name="license_no" aria-describedby="emailHelp">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Agency Name</label>
                          <input type="text" class="form-control" id="agency_name_edit" name="agency_name" aria-describedby="emailHelp">
                         </div>
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Type</label>
                          <select class="form-control" name="action_type" id="action_type_edit" required>
                              <option value="">Select</option>
                              <option value="Action1">Action1</option>
                              <option value="Action2">Action2</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Sanction</label>
                          <select class="form-control" name="sanction" id="sanction_edit" required>
                              <option value="">Select</option>
                              <option value="Sanction1">Sanction1</option>
                              <option value="Sanction2">Sanction2</option>
                          </select>
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Taken</label>
                          <textarea class="form-control" id="action_taken_edit" name="action_taken"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Fines and Penalties</label>
                          <textarea class="form-control" name="fines" id="fines_edit"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Taken Date</label>
                          <input type="date" class="form-control" id="action_taken_date_edit" required name="action_taken_date" aria-describedby="emailHelp">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Update Reference Document</label>
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
                            <form method="post" enctype="multipart/form-data" action="{{route('case.administrative.referrals.followup.own-action-taken.update.status')}}">@csrf
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
                            <form method="post" enctype="multipart/form-data" action="{{route('case.administrative.referrals.followup.own-action-taken.update.appraise')}}">@csrf
                            <input type="hidden" name="id" id="id_status">
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">

                         <div class="form-group">
                          <label for="exampleInputEmail1">Date of Receipt</label>
                          <input type="date" class="form-control" id="date_receipt_edit_app"  readonly name="date_receipt" aria-describedby="emailHelp">
                         </div>
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Taken Against</label>
                          <select class="form-control" readonly disabled name="action_taken_against" id="action_taken_against_edit_app">
                              <option value="">Select</option>
                              <option value="Individual">Individual</option>
                              <option value="Organization">Organization</option>
                          </select>
                         </div>

                         <div class="individual_div_edit" style="display:none">
                         <div class="form-group">
                          <label for="exampleInputEmail1">CID / Document No</label>
                          <input type="text" class="form-control" readonly id="cid_document_edit_app" name="cid_document" aria-describedby="emailHelp">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" class="form-control" readonly id="name_edit_app" name="name" aria-describedby="emailHelp">
                         </div>
                        </div>


                        <div class="organization_div_edit" style="display:none">
                         <div class="form-group">
                          <label for="exampleInputEmail1">License No / Registration No</label>
                          <input type="text" class="form-control" readonly id="license_no_edit_app" name="license_no" aria-describedby="emailHelp">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Agency Name</label>
                          <input type="text" class="form-control" id="agency_name_edit_app" readonly name="agency_name" aria-describedby="emailHelp">
                         </div>
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Type</label>
                          <select class="form-control" name="action_type" disabled id="action_type_edit_app" required>
                              <option value="">Select</option>
                              <option value="Action1">Action1</option>
                              <option value="Action2">Action2</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Sanction</label>
                          <select class="form-control" name="sanction" id="sanction_edit_app" disabled required>
                              <option value="">Select</option>
                              <option value="Sanction1">Sanction1</option>
                              <option value="Sanction2">Sanction2</option>
                          </select>
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Taken</label>
                          <textarea class="form-control" id="action_taken_edit_app" readonly name="action_taken"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Fines and Penalties</label>
                          <textarea class="form-control" name="fines" id="fines_edit_app" readonly></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Action Taken Date</label>
                          <input type="date" class="form-control" id="action_taken_date_edit_app" readonly required name="action_taken_date" aria-describedby="emailHelp">
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

<script type="text/javascript">
    $('#action_taken_against').on('change',function(e){
        var action_val = $('#action_taken_against').val();
        if(action_val=="Individual")
        {
             $('.individual_div').show();
             $('.organization_div').hide();
        }else{
             $('.individual_div').hide();
             $('.organization_div').show();
        }   
    });
</script>

<script type="text/javascript">
    $('#action_taken_against_edit').on('change',function(e){
        var action_val = $('#action_taken_against_edit').val();
        if(action_val=="Individual")
        {
             $('.individual_div_edit').show();
             $('.organization_div_edit').hide();
        }else{
             $('.individual_div_edit').hide();
             $('.organization_div_edit').show();
        }   
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

            $('#date_receipt_edit_app').val($(this).data('receipt'));
            $('#action_taken_against_edit_app').val($(this).data('action_taken_against')).change();
            if($(this).data('action_taken_against')=="Individual")
            {
                $('.individual_div_edit').show();
                $('.organization_div_edit').hide();
            }else{
                 $('.individual_div_edit').hide();
                 $('.organization_div_edit').show();
            }



            $('#cid_document_edit_app').val($(this).data('cid'));
            $('#name_edit_app').val($(this).data('name'));

            $('#license_no_edit_app').val($(this).data('license'));
            $('#agency_name_edit_app').val($(this).data('agency_name'));
            $('#action_type_edit_app').val($(this).data('action_type')).change();
            $('#sanction_edit_app').val($(this).data('sanction')).change();

            $('#action_taken_edit_app').val($(this).data('action_taken'));
            $('#fines_edit_app').val($(this).data('fine'));
            $('#action_taken_date_edit_app').val($(this).data('action_taken_date'));
            $('#appraise_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.edit_data').on('click',function(){
            $('#date_receipt_edit').val($(this).data('receipt'));
            $('#action_taken_against_edit').val($(this).data('action_taken_against')).change();
            if($(this).data('action_taken_against')=="Individual")
            {
                $('.individual_div_edit').show();
                $('.organization_div_edit').hide();
            }else{
                 $('.individual_div_edit').hide();
                 $('.organization_div_edit').show();
            }



            $('#cid_document_edit').val($(this).data('cid'));
            $('#name_edit').val($(this).data('name'));

            $('#license_no_edit').val($(this).data('license'));
            $('#agency_name_edit').val($(this).data('agency_name'));
            $('#action_type_edit').val($(this).data('action_type')).change();
            $('#sanction_edit').val($(this).data('sanction')).change();

            $('#action_taken_edit').val($(this).data('action_taken'));
            $('#fines_edit').val($(this).data('fine'));
            $('#action_taken_date_edit').val($(this).data('action_taken_date'));
            $('#id_edit').val($(this).data('id'));

            $('#exampleModaEdit').modal('show');
        })
</script>

@endsection