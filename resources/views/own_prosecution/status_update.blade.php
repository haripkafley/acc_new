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

                    @if(@$data->power_of_attorney!="")
                    <p><a class="btn btn-xs btn-info"
                                    href="{{URL::to('attachment/legal')}}/{{$data->power_of_attorney}}" target="_blank"><i class="fa fa-eye"></i> View attachment</a></p>
                    @endif
                  </div>
            </div>




    {{-- table-showing --}}
    <div class="col-sm-12">

                           <div class="card-body">
                            
                            <table id="maintableGewog" class="table">
                                <thead>
                                    <tr>
                                        <th>CID</th>
                                        <th>Name</th>
                                        <th>Probable Charge</th>
                                        <th>Court Name</th>
                                        <th>Decision of the Court</th>
                                        <th>Decision Date</th>
                                        <th>Decision Attachment</th>
                                        {{-- <th>Remarks</th> --}}
                                        {{-- <th>Update</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                        
                                            <tr>
                                                <td>{{ @$data->case_withdrawn_details->cid }}</td>
                                                <td>{{ @$data->case_withdrawn_details->accused_name}}</td>
                                                
                                                <td>
                                                    @if(@$data->court_name=="") Not Updated @else {{@$data->court_name}} @endif
                                                </td>
                                                
                                                <td>
                                                    @if(@$data->own_status=="") Not Updated @else {{@$data->own_status}} @endif
                                                </td>

                                                <td>
                                                    @if(@$data->status_date=="") Not Updated @else {{@$data->status_date}} @endif
                                                </td>

                                                <td>
                                                    @if(@$data->status_attachment=="") Not Updated @else
                                                    <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/legal_prosecution')}}/{{$data->status_attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                Attachment
                                                            </a>
                                                     @endif       
                                                </td>

                                                {{-- <td>
                                                    @if(@$data->status_remark=="") Not Updated @else {{@$data->status_remark}} @endif
                                                </td> --}}
                                                
                                                <td><a href="javascript:void(0)" data-id="{{@$data->id}}" data-status="{{@$data->own_status}}" data-status_date="{{@$data->status_date}}" data-remark="{{@$data->status_remark}}" data-court="{{@$data->court_name}}" class="btn btn-primary status_button">View/ Update Decision</a></td>

                                             </tr>


                                       
                                    

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
                            <form method="post" enctype="multipart/form-data" action="{{route('own.prosecution.get.assign.official.case.status.update')}}">@csrf
                        
                         <input type="hidden" name="id_status" id="id_status">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Court</label>
                          <select class="form-control" required name="court_name" id="court_name">
                              <option value="">Select Status</option>
                              <option value="Bumthang Dzongkhag Court">Bumthang Dzongkhag Court</option>
                              <option value="Chukha Dzongkhag Court">Chukha Dzongkhag Court</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <select class="form-control" required name="own_status" id="own_status">
                              <option value="">Select Status</option>
                              <option value="Admitted">Admitted</option>
                              <option value="Dismissed">Dismissed</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Date</label>
                          <input type="date" name="status_date" class="form-control" id="status_date">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="status_remark" id="status_remark"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Attachment</label>
                          <input type="file" class="form-control"  name="attachment" id="attachment">
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
            $('#id_status').val($(this).data('id'));
            $('#court_name').val($(this).data('court'));
            $('#own_status').val($(this).data('status')).change();
            $('#status_date').val($(this).data('status_date'));
            $('#status_remark').val($(this).data('remark'));
            $('#status_model').modal('show');
        })
</script>


@endsection