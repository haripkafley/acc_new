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
                              Lease & Hiring
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Action Type</th>
                                        <th>Leased To</th>
                                        <th>Name</th>
                                        <th>CID/License No</th>
                                        <th>Date Range</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->item_details->item }}</td>
                                        <td>@if(@$att->action_type=="L") Lease @else Hiring @endif</td>
                                        <td>@if(@$att->leased_to=="B") Business @else Individual @endif</td>
                                        <td>{{ $att->name }}</td>
                                        <td>@if(@$att->leased_to=="B") {{@$att->license}} @else {{@$att->cid}} @endif</td>
                                        <td>{{@$att->start_date}} - {{@$att->end_date}}</td>
                                        
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-item="{{@$att->item_id}}" data-item_code="{{@$att->item_details->item_code}}" data-item_description="{{@$att->item_details->item_description}}" data-action_type="{{@$att->action_type}}" data-leased_to="{{@$att->leased_to}}" data-cid="{{@$att->cid}}"
                                                data-name="{{@$att->name}}"
                                                data-start_date="{{@$att->start_date}}"
                                                data-end_date="{{@$att->end_date}}"
                                                data-license="{{@$att->license}}"
                                                data-remarks="{{@$att->remarks}}"    
                                                href="javascript:void(0)" data-><i class="fa fa-edit"></i> + <i class="fa fa-eye"></i>
                                                               
                                                 </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('manage.get-assign-official-seized-properties.custody.details.lease.hiring.delete.data',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
                                                                
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
                            <h5 class="modal-title" id="exampleModalLabel">New Lease & Hiring</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.custody.details.lease.hiring.insert.data')}}">@csrf
                        
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
                          <label for="exampleInputEmail1">Action Type</label>
                          <select class="form-control" name="action_type">
                              <option value="">Select</option>
                              <option value="L">Lease</option>
                              <option value="H">Hiring</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Lease To</label>
                          <select class="form-control" name="leased_to" id="leased_to">
                              <option value="">Select</option>
                              <option value="B">Business</option>
                              <option value="I">Individual</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" name="name" class="form-control">
                         </div>

                         <div class="form-group cid_div" style="display:none">
                          <label for="exampleInputEmail1">CID</label>
                          <input type="text" name="cid" class="form-control">
                         </div>

                         <div class="form-group business_license" style="display:none">
                          <label for="exampleInputEmail1">License</label>
                          <input type="text" name="license" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Start Date</label>
                          <input type="date" name="start_date" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">End Date</label>
                          <input type="date" name="end_date" class="form-control">
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
                            
                        </div>
                    </div>
                </div>
            </div>


               <div class="modal fade" id="offence_model_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Lease & Hiring</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.custody.details.lease.hiring.update.data')}}">@csrf
                        
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
                          <label for="exampleInputEmail1">Action Type</label>
                          <select class="form-control" name="action_type" id="action_type_id">
                              <option value="">Select</option>
                              <option value="L">Lease</option>
                              <option value="H">Hiring</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Lease To</label>
                          <select class="form-control" name="leased_to" id="leased_to_id" disabled>
                              <option value="">Select</option>
                              <option value="B">Business</option>
                              <option value="I">Individual</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" name="name" class="form-control" id="name">
                         </div>

                         <div class="form-group cid_div" id="cid_div">
                          <label for="exampleInputEmail1">CID</label>
                          <input type="text" name="cid" class="form-control" id="cid">
                         </div>

                         <div class="form-group business_license" id="business_license">
                          <label for="exampleInputEmail1">License</label>
                          <input type="text" name="license" class="form-control" id="license">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Start Date</label>
                          <input type="date" name="start_date" class="form-control" id="start_date">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">End Date</label>
                          <input type="date" name="end_date" class="form-control" id="end_date">
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
            $('#action_type_id').val($(this).data('action_type'));
            $('#leased_to_id').val($(this).data('leased_to'));
            $('#name').val($(this).data('name'));
            $('#start_date').val($(this).data('start_date'));
            $('#end_date').val($(this).data('end_date'));
            $('#remarks').val($(this).data('remarks'));

            $('#cid').val($(this).data('cid'));
            $('#license').val($(this).data('license'));

            if($(this).data('leased_to')=="B")
            {
                $('#cid_div').hide();
                $('#business_license').show();
            }else{
                $('#cid_div').show();
                $('#business_license').hide();
            }
            $('#offence_model_edit').modal('show');
        })
</script>

<script type="text/javascript">
    $('#item_id').on('change',function(e){
        $('#item_code_add').val($('#item_id option:selected').data('code'));
        $('#item_description_add').val($('#item_id option:selected').data('description'));
    })
</script>

<script type="text/javascript">
    $('#leased_to').on('change',function(e){
        var leased_to = $('#leased_to').val();
        if(leased_to=="I")
        {
            $('.cid_div').show();
            $('.business_license').hide();

        }else{
            $('.cid_div').hide();
            $('.business_license').show();
        }
    });
</script>
@endsection