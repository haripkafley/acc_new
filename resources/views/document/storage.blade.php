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

            
            @include('document.common')


        
            <div class="row">
              
                




    {{-- table-showing --}}
    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Storage
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>File Name / No</th>
                                        <th>Room No</th>
                                        <th>Rack No</th>
                                        <th>Row No</th>
                                        <th>Column No</th>
                                        <th>Box No.</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$storage->isNotEmpty())
                                    @foreach(@$storage as $att)
                                    <tr>
                                        
                                        <td>{{ @$att->file_details->document_no }}</td>
                                        <td>{{ $att->room_no}}</td>
                                        <td>{{ $att->rack_no}}</td>
                                        <td>{{ $att->row_no  }}</td>
                                        <td>{{ $att->column_no }}</td>
                                        <td>{{ $att->box_no }}</td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-file_id="{{@$att->file_id}}" data-particular="{{@$att->particular}}" data-room_no="{{@$att->room_no}}" data-rack_no="{{@$att->rack_no}}" data-row_no="{{@$att->row_no}}"
                                                data-column_no="{{@$att->column_no}}"
                                                data-box_no="{{@$att->box_no}}"
                                                data-remarks="{{@$att->remarks}}"
                                               
                                                href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                
                                                 </a>


                                                 <a class="btn btn-xs btn-info archive_edit" data-id="{{@$att->id}}" data-file_id="{{@$att->file_id}}" data-particular="{{@$att->particular}}" data-room_no="{{@$att->room_no}}" data-rack_no="{{@$att->rack_no}}" data-row_no="{{@$att->row_no}}"
                                                data-column_no="{{@$att->column_no}}"
                                                data-box_no="{{@$att->box_no}}"
                                                data-remarks="{{@$att->remarks}}"

                                                data-ar_room="{{@$att->ar_room}}"
                                                data-ar_rack="{{@$att->ar_rack}}"
                                                data-ar_row="{{@$att->ar_row}}"
                                                data-ar_column="{{@$att->ar_column}}"
                                                data-ar_box="{{@$att->ar_box}}"
                                               
                                                href="javascript:void(0)" data->
                                                                Archive
                                                 </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('manage.seized.document.get.official.case.storage.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
                                                                
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
                            <h5 class="modal-title" id="exampleModalLabel">New Storage</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.seized.document.get.official.case.storage.insert')}}">@csrf
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}" id="case_id">
                         
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Particular</label>
                          <select class="form-control" name="particular" id="particular">
                            <option value="">Select</option>
                            <option value="F">File</option>
                            <option value="D">Travel Document</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">File/Document No</label>
                          <select class="form-control" name="file_id" id="file_id">
                            <option value="">Select</option>
                           </select>
                         </div>

                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Room No</label>
                          <input type="text" class="form-control" name="room_no" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Rack No</label>
                          <input type="text" class="form-control" name="rack_no" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Row No</label>
                          <input type="text" class="form-control" name="row_no" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Column No</label>
                          <input type="text" class="form-control" name="column_no" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Box No</label>
                          <input type="text" class="form-control" name="box_no" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea type="text" class="form-control" name="remarks" ></textarea>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Storage</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.seized.document.get.official.case.storage.update')}}">@csrf
                        
                         <input type="hidden" name="id"  id="id">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Particular</label>
                          <select class="form-control" name="particular" id="particular_edit" disabled>
                            <option value="">Select</option>
                            <option value="F">File</option>
                            <option value="D">Travel Document</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">File/Document No</label>
                          <select class="form-control" name="file_id" id="file_id_edit" disabled>
                            <option value="">Select</option>
                            @foreach(@$receipt as $value)
                            <option value="{{@$value->id}}">{{@$value->document_no}}</option>
                            @endforeach
                           </select>
                         </div>

                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Room No</label>
                          <input type="text" class="form-control" name="room_no" id="room_no">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Rack No</label>
                          <input type="text" class="form-control" name="rack_no" id="rack_no">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Row No</label>
                          <input type="text" class="form-control" name="row_no" id="row_no">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Column No</label>
                          <input type="text" class="form-control" name="column_no" id="column_no">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Box No</label>
                          <input type="text" class="form-control" name="box_no" id="box_no">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea type="text" class="form-control" name="remarks" id="remarks"></textarea>
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


            {{-- archive --}}
            <div class="modal fade" id="archive_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Archive</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.seized.document.get.official.case.storage.insert.archive.data')}}">@csrf
                        
                         <input type="hidden" name="id"  id="id_ar">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Particular</label>
                          <select class="form-control" name="particular" id="particular_edit_ar" disabled>
                            <option value="">Select</option>
                            <option value="F">File</option>
                            <option value="D">Travel Document</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">File/Document No</label>
                          <select class="form-control" name="file_id" id="file_id_edit_ar" disabled>
                            <option value="">Select</option>
                            @foreach(@$receipt as $value)
                            <option value="{{@$value->id}}">{{@$value->document_no}}</option>
                            @endforeach
                           </select>
                         </div>

                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Room No</label>
                          <input type="text" class="form-control" name="room_no" id="room_no_ar" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Rack No</label>
                          <input type="text" class="form-control" name="rack_no" id="rack_no_ar" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Row No</label>
                          <input type="text" class="form-control" name="row_no" id="row_no_ar" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Column No</label>
                          <input type="text" class="form-control" name="column_no" id="column_no_ar" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Box No</label>
                          <input type="text" class="form-control" name="box_no" id="box_no_ar" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea type="text" class="form-control" name="remarks" id="remarks_ar" disabled></textarea>
                         </div>





                         <div class="form-group">
                          <label for="exampleInputEmail1">Archive Room No</label>
                          <input type="text" class="form-control" name="ar_room" id="room_no_ar_ar" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Archive Rack No</label>
                          <input type="text" class="form-control" name="ar_rack" id="rack_no_ar_ar" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Archive Row No</label>
                          <input type="text" class="form-control" name="ar_row" id="row_no_ar_ar" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Archive Column No</label>
                          <input type="text" class="form-control" name="ar_column" id="column_no_ar_ar" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Archive Box No</label>
                          <input type="text" class="form-control" name="ar_box" id="box_no_ar_ar" >
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
  $(document).ready(function(){
    $('#particular').on('change',function(e){
      
      e.preventDefault();
      var id = $(this).val();
      
      $.ajax({
        url:'{{route('get.receipt.detials.from-particular')}}',
        type:'GET',
        data:{id:id,case:'{{@$case_id}}',type:'custody'},
        success:function(data){
          console.log(data);
          $('#file_id').find('option').remove();
          $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.

                    console.log(value);
                    $('#file_id').append('<option value="' + value.id + '">' + value.document_no +
                        '</option>');
          });
         }
      })
    
   })
  })
</script>

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
            $('#id').val($(this).data('id'));
            $('#particular_edit').val($(this).data('particular')).change();
            $('#file_id_edit').val($(this).data('file_id')).change();


            $('#remarks').val($(this).data('remarks'));
            $('#room_no').val($(this).data('room_no'));
            $('#rack_no').val($(this).data('rack_no'));
            
            $('#row_no').val($(this).data('row_no'));
            $('#column_no').val($(this).data('column_no'));
            $('#box_no').val($(this).data('box_no'));
            
            
           
            $('#offence_model_edit').modal('show');
        })
</script>


<script type="text/javascript">
    $('.archive_edit').on('click',function(){
            $('#id_ar').val($(this).data('id'));
            $('#particular_edit_ar').val($(this).data('particular')).change();
            $('#file_id_edit_ar').val($(this).data('file_id')).change();


            $('#remarks_ar').val($(this).data('remarks'));
            $('#room_no_ar').val($(this).data('room_no'));
            $('#rack_no_ar').val($(this).data('rack_no'));
            
            $('#row_no_ar').val($(this).data('row_no'));
            $('#column_no_ar').val($(this).data('column_no'));
            $('#box_no_ar').val($(this).data('box_no'));

            $('#room_no_ar_ar').val($(this).data('ar_room'));
            $('#rack_no_ar_ar').val($(this).data('ar_rack'));
            
            $('#row_no_ar_ar').val($(this).data('ar_row'));
            $('#column_no_ar_ar').val($(this).data('ar_column'));
            $('#box_no_ar_ar').val($(this).data('ar_box'));
            
            
           
            $('#archive_edit').modal('show');
        })
</script>

@endsection