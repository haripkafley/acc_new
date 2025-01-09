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
                              Chain of Custody
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>File Name / No</th>
                                        <th>Issued To</th>
                                        <th>Date Issuance</th>
                                        <th>Returned By</th>
                                        <th>Returned Date</th>
                                        <th>Received by</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$custody->isNotEmpty())
                                    @foreach(@$custody as $att)
                                    <tr>
                                        
                                        <td>{{ @$att->file_details->document_no }}</td>
                                        <td>{{ $att->issued_to}}</td>
                                        <td>{{ $att->date}}</td>
                                        <td>@if(@$att->return_by!=""){{ $att->return_by  }} @else -- @endif</td>
                                        <td>@if(@$att->return_date!=""){{ $att->return_date  }} @else -- @endif</td>
                                        <td>@if(@$att->return_received_by!=""){{ $att->return_received_by  }} @else -- @endif</td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-file_id="{{@$att->file_id}}" data-particular="{{@$att->particular}}" data-issued_to="{{@$att->issued_to}}" data-issued_by="{{@$att->issued_by}}" data-date="{{@$att->date}}"
                                                data-time="{{@$att->time}}"
                                                data-purpose="{{@$att->purpose}}"
                                               
                                                href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                
                                                 </a>


                                                 <a class="btn btn-xs btn-warning return_offence" data-id="{{@$att->id}}" data-file_id="{{@$att->file_id}}" data-particular="{{@$att->particular}}" data-issued_to="{{@$att->issued_to}}" data-issued_by="{{@$att->issued_by}}" 
                                                data-date="{{@$att->date}}"
                                                data-time="{{@$att->time}}"
                                                data-purpose="{{@$att->purpose}}"
                                                data-return_by="{{@$att->return_by}}"
                                                data-return_date="{{@$att->return_date}}"
                                                data-return_time="{{@$att->return_time}}"
                                                data-return_received_by ="{{@$att->return_received_by }}"
                                                data-remarks ="{{@$att->remarks }}"
                                               
                                                href="javascript:void(0)" data->
                                                                Return
                                                 </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('manage.seized.document.get.official.case.chain-of-custody.delete-data',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
                                                                
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
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.seized.document.get.official.case.chain-of-custody.insert-data')}}">@csrf
                        
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
                          <label for="exampleInputEmail1">Issued To</label>
                          <input type="text" class="form-control" name="issued_to" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued By</label>
                          <input type="text" class="form-control" name="issued_by" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issue Date</label>
                          <input type="date" class="form-control" name="date" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issue Time</label>
                          <input type="time" class="form-control" name="time" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Purpose</label>
                          <textarea type="text" class="form-control" name="purpose" ></textarea>
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
                            <h5 class="modal-title" id="exampleModalLabel">Chain of Custody</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.seized.document.get.official.case.chain-of-custody.update-data')}}">@csrf
                        
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
                          <label for="exampleInputEmail1">Issued To</label>
                          <input type="text" class="form-control" name="issued_to" id="issued_to">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued By</label>
                          <input type="text" class="form-control" name="issued_by" id="issued_by">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issue Date</label>
                          <input type="date" class="form-control" name="date" id="date">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issue Time</label>
                          <input type="time" class="form-control" name="time" id="time">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Purpose</label>
                          <textarea type="text" class="form-control" name="purpose" id="purpose"></textarea>
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
                           <div class="modal fade" id="offence_model_return" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.seized.document.get.official.case.chain-of-custody.return-data')}}">@csrf
                        
                         <input type="hidden" name="id"  id="id_return">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Particular</label>
                          <select class="form-control" name="particular" id="particular_return" disabled>
                            <option value="">Select</option>
                            <option value="F">File</option>
                            <option value="D">Travel Document</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">File/Document No</label>
                          <select class="form-control" name="file_id" id="file_id_return" disabled>
                            <option value="">Select</option>
                            @foreach(@$receipt as $value)
                            <option value="{{@$value->id}}">{{@$value->document_no}}</option>
                            @endforeach
                           </select>
                         </div>

                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued To</label>
                          <input type="text" class="form-control" name="issued_to" id="issued_to_return" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issued By</label>
                          <input type="text" class="form-control" name="issued_by" id="issued_by_return" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issue Date</label>
                          <input type="date" class="form-control" name="date" id="date_return" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Issue Time</label>
                          <input type="time" class="form-control" name="time" id="time_return" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Purpose</label>
                          <textarea type="text" class="form-control" name="purpose" id="purpose_return" disabled></textarea>
                         </div>


                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Returned By</label>
                          <input type="text" class="form-control" name="return_by" id="return_by" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Return Date</label>
                          <input type="date" class="form-control" name="return_date" id="return_date" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Return Time</label>
                          <input type="time" class="form-control" name="return_time" id="return_time" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Return Received By</label>
                          <input type="text" class="form-control" name="return_received_by" id="return_received_by" >
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
          $('#file_id').find('option').remove();  
          console.log(data);
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



            $('#issued_to').val($(this).data('issued_to'));
            $('#issued_by').val($(this).data('issued_by'));
            
            $('#date').val($(this).data('date'));
            $('#time').val($(this).data('time'));
            $('#purpose').val($(this).data('purpose'));
            
            
           
            $('#offence_model_edit').modal('show');
        })
</script>


<script type="text/javascript">
    $('.return_offence').on('click',function(){
            $('#id_return').val($(this).data('id'));
            $('#particular_return').val($(this).data('particular')).change();
            $('#file_id_return').val($(this).data('file_id')).change();



            $('#issued_to_return').val($(this).data('issued_to'));
            $('#issued_by_return').val($(this).data('issued_by'));
            
            $('#date_return').val($(this).data('date'));
            $('#time_return').val($(this).data('time'));
            $('#purpose_return').val($(this).data('purpose'));


            $('#return_by').val($(this).data('return_by'));
            $('#return_date').val($(this).data('return_date'));
            $('#return_time').val($(this).data('return_time'));

            $('#return_received_by').val($(this).data('return_received_by'));
            $('#remarks').val($(this).data('remarks'));
            
            
            
           
            $('#offence_model_return').modal('show');
        })
</script>

@endsection