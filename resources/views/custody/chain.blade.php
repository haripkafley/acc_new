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


        @include('custody.common')


    {{-- table-showing --}}
    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Chain of Custody
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Issued To</th>
                                        <th>Issued by</th>
                                        <th>Date & Time of Issueance</th>
                                        <th>Returned by</th>
                                        <th>Returned date & time</th>
                                        <th>Received by</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->item_details->item }}</td>
                                        <td>{{ $att->issued_to }}</td>
                                        <td>{{ $att->issued_by }}</td>
                                        <td>{{ $att->issue_date }} - {{@$att->issue_time}}</td>
                                        <td>@if(@$att->return_by=="") -- @else {{ $att->return_by}} @endif</td>
                                        <td>@if(@$att->return_date=="") -- @else {{ $att->return_date}} - {{$att->return_time}} @endif</td>

                                        <td>@if(@$att->received_by=="") -- @else {{ $att->received_by}} @endif</td>

                                        
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-item="{{@$att->item_id}}" data-item_code="{{@$att->item_details->item_code}}" data-item_description="{{@$att->item_details->item_description}}" data-issued_to="{{@$att->issued_to}}" data-issued_by="{{@$att->issued_by}}" data-issue_date="{{@$att->  issue_date}}" data-issue_time="{{@$att->issue_time}}" data-purpose="{{@$att->purpose}}"  href="javascript:void(0)" data-><i class="fa fa-edit"></i> + <i class="fa fa-eye"></i>
                                                                
                                                 </a>


                                                 <a class="btn btn-xs btn-warning return" data-id="{{@$att->id}}" data-item="{{@$att->item_id}}" data-item_code="{{@$att->item_details->item_code}}" data-item_description="{{@$att->item_details->item_description}}" data-issued_to="{{@$att->issued_to}}" data-issued_by="{{@$att->issued_by}}" data-issue_date="{{@$att->  issue_date}}" data-issue_time="{{@$att->issue_time}}" data-purpose="{{@$att->purpose}}" data-return_by="{{@$att->return_by}}" data-return_date="{{@$att->return_date}}" data-return_time="{{@$att->return_time}}" data-received_by="{{@$att->received_by}}" data-remarks="{{@$att->remarks}}"    href="javascript:void(0)" data->
                                                                Return
                                                 </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('manage.get-assign-official-seized-properties.custody.details.chain.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
                                                                
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
                            <h5 class="modal-title" id="exampleModalLabel">Chain of Custody</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.custody.details.chain.insert')}}">@csrf
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Item</label>
                          <select class="form-control" name="item_id" id="item_id">
                              <option value="">Select</option>
                              @foreach(@$itemsData as $value)
                                <option value="{{@$value->id}}" data-description="{{@$value->item_description}}" data-code={{@$value->item_code}}>{{@$value->item}}</option>
                              @endforeach
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Item Code</label>
                          <input type="text" name="item_code" disabled id="item_code_add" class="form-control">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Item Description</label>
                          <textarea type="text" name="item_description" disabled id="item_description_add" class="form-control"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued To</label>
                          <input type="text" name="issued_to" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued By</label>
                          <input type="text" name="issued_by" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued Date</label>
                          <input type="date" name="issue_date" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued Time</label>
                          <input type="time" name="issue_time" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Purpose</label>
                          <textarea type="text" name="purpose" class="form-control"></textarea>
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


               <div class="modal fade" id="offence_model_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Chain of Custody</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.custody.details.chain.update')}}">@csrf
                        
                         <input type="hidden" name="id"  id="id">
                         <input type="hidden" name="case_id" value="{{@$case_id}}" id="case_id">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Item</label>
                          <select class="form-control" name="item_id" id="item" disabled>
                              <option value="">Select</option>
                              @foreach(@$itemsData as $value)
                                <option value="{{@$value->id}}" data-description="{{@$value->item_description}}" data-code={{@$value->item_code}}>{{@$value->item}}</option>
                              @endforeach
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Item Code</label>
                          <input type="text" name="item_code" id="item_code" disabled class="form-control">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Item Description</label>
                          <textarea type="text" name="item_description" disabled id="item_description" class="form-control"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued To</label>
                          <input type="text" name="issued_to" id="issued_to" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued By</label>
                          <input type="text" name="issued_by" id="issued_by" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued Date</label>
                          <input type="date" name="issue_date" id="issue_date" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued Time</label>
                          <input type="time" name="issue_time" id="issue_time" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Purpose</label>
                          <textarea type="text" name="purpose" id="purpose" class="form-control"></textarea>
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


            {{-- return --}}
                <div class="modal fade" id="return_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Return Chain of Custody</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.custody.details.chain.return')}}">@csrf
                        
                         <input type="hidden" name="id"  id="id_return">
                         <input type="hidden" name="case_id" value="{{@$case_id}}" id="case_id">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Item</label>
                          <select class="form-control" name="item_id" id="item_return" disabled>
                              <option value="">Select</option>
                              @foreach(@$itemsData as $value)
                                <option value="{{@$value->id}}" data-description="{{@$value->item_description}}" data-code={{@$value->item_code}}>{{@$value->item}}</option>
                              @endforeach
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Item Code</label>
                          <input type="text" name="item_code" id="item_code_return" disabled class="form-control">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Item Description</label>
                          <textarea type="text" name="item_description" id="item_description_return" disabled class="form-control"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued To</label>
                          <input type="text" name="issued_to" id="issued_to_return" disabled class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued By</label>
                          <input type="text" name="issued_by" id="issued_by_return" disabled class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued Date</label>
                          <input type="date" name="issue_date" id="issue_date_return" disabled class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued Time</label>
                          <input type="time" name="issue_time" id="issue_time_return" disabled class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Purpose</label>
                          <textarea type="text" name="purpose" id="purpose_return" disabled class="form-control"></textarea>
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1">Return By</label>
                          <input type="text" name="return_by" id="return_by" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Return Date</label>
                          <input type="date" name="return_date" id="return_date" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Return Time</label>
                          <input type="time" name="return_time" id="return_time" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Received By</label>
                          <input type="text" name="received_by" id="received_by" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea type="text" name="remarks" id="remarks"  class="form-control"></textarea>
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


    <script type="text/javascript">
    $('#offences_add').on('click',function(){
            $('#offence_model').modal('show');
        })
</script>
    
    <script type="text/javascript">
    $('.edit_offence').on('click',function(){
            $('#id').val($(this).data('id'));
            $('#item').val($(this).data('item')).change();
            $('#item_code').val($(this).data('item_code'));
            $('#item_description').val($(this).data('item_description'));
            $('#issued_to').val($(this).data('issued_to'));
            $('#issued_by').val($(this).data('issued_by'));
            $('#issue_date').val($(this).data('issue_date'));
            $('#issue_time').val($(this).data('issue_time'));
            $('#purpose').val($(this).data('purpose'));
            $('#offence_model_edit').modal('show');
        })
</script>


    <script type="text/javascript">
    $('.return').on('click',function(){
            $('#id_return').val($(this).data('id'));
            $('#item_return').val($(this).data('item')).change();
            $('#item_code_return').val($(this).data('item_code'));
            $('#item_description_return').val($(this).data('item_description'));
            $('#issued_to_return').val($(this).data('issued_to'));
            $('#issued_by_return').val($(this).data('issued_by'));
            $('#issue_date_return').val($(this).data('issue_date'));
            $('#issue_time_return').val($(this).data('issue_time'));
            $('#purpose_return').val($(this).data('purpose'));



            $('#return_by').val($(this).data('return_by'));
            $('#return_date').val($(this).data('return_date'));
            $('#return_time').val($(this).data('return_time'));
            $('#received_by').val($(this).data('received_by'));
            $('#remarks').val($(this).data('remarks'));
            $('#return_model').modal('show');
        })
</script>


<script type="text/javascript">
    $('#item_id').on('change',function(e){
        $('#item_code_add').val($('#item_id option:selected').data('code'));
        $('#item_description_add').val($('#item_id option:selected').data('description'));
    })
</script>

@endsection