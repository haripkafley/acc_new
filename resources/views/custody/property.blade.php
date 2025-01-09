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
                              Storage - Properties
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Item Code</th>
                                        <th>Room No</th>
                                        <th>Rack No</th>
                                        <th>Column No</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->item }}</td>
                                        <td>{{ $att->item_code }}</td>
                                        <td>{{ $att->room_no }}</td>
                                        <td>{{ $att->rack_no }}</td>
                                        <td>{{ $att->column_no }}</td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-item="{{@$att->item}}" data-item_code="{{@$att->item_code}}" data-room_no="{{@$att->room_no}}" data-item_description="{{@$att->item_description}}" data-rack_no="{{@$att->rack_no}}" data-column_no="{{@$att->column_no}}" data-box_no="{{@$att->box_no}}" data-file_no="{{@$att->file_no}}" data-other_location="{{@$att->other_location}}" data-status="{{@$att->status}}" href="javascript:void(0)" data-><i class="fa fa-edit"></i> + <i class="fa fa-eye"></i>
                                                                
                                                 </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('manage.get-assign-official-seized-properties.custody.details.delete.property.data',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
                                                                
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
                            <h5 class="modal-title" id="exampleModalLabel">New Storage - Properties</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.custody.details.insert.property.data')}}">@csrf
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Item</label>
                          <input type="text" name="item" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Item Code</label>
                          <input type="text" name="item_code" class="form-control">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Item Description</label>
                          <textarea class="form-control" name="item_description" ></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Room No</label>
                          <input type="text" name="room_no" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Rack No</label>
                          <input type="text" name="rack_no" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Column No</label>
                          <input type="text" name="column_no" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Box No</label>
                          <input type="text" name="box_no" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">File No</label>
                          <input type="text" name="file_no" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Other Location</label>
                          <textarea class="form-control" name="other_location" ></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <input type="text" name="status" class="form-control">
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Storage - Properties</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.custody.details.update.property.data')}}">@csrf
                        
                         <input type="hidden" name="id"  id="id">
                         <input type="hidden" name="case_id" value="{{@$case_id}}" id="case_id">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Item</label>
                          <input type="text" name="item" class="form-control" id="item">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Item Code</label>
                          <input type="text" name="item_code" class="form-control" id="item_code">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Item Description</label>
                          <textarea class="form-control" name="item_description" id="item_description"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Room No</label>
                          <input type="text" name="room_no" class="form-control" id="room_no">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Rack No</label>
                          <input type="text" name="rack_no" id="rack_no" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Column No</label>
                          <input type="text" name="column_no" id="column_no"  class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Box No</label>
                          <input type="text" name="box_no" id="box_no" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">File No</label>
                          <input type="text" name="file_no" id="file_no" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Other Location</label>
                          <textarea class="form-control" id="other_location" name="other_location" ></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <input type="text" name="status" id="status" class="form-control">
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
            $('#item').val($(this).data('item'));
            $('#item_code').val($(this).data('item_code'));
            $('#item_description').val($(this).data('item_description'));
            $('#room_no').val($(this).data('room_no'));
            $('#rack_no').val($(this).data('rack_no'));

            $('#column_no').val($(this).data('column_no'));
            $('#box_no').val($(this).data('box_no'));
            $('#file_no').val($(this).data('file_no'));
            $('#other_location').val($(this).data('other_location'));
            $('#status').val($(this).data('status'));
            $('#offence_model_edit').modal('show');
        })
</script>

@endsection