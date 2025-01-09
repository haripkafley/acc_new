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
                              Renewal of Documents
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>File Name / No</th>
                                        <th>Date of Expiry</th>
                                        <th>Renewal Date</th>
                                        <th>Renewed Till</th>
                                        <th>Renewed By</th>
                                        <th>Expenditure Amount</th>
                                        <th>Document Evidence</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$renewal->isNotEmpty())
                                    @foreach(@$renewal as $att)
                                    <tr>
                                        
                                        <td>{{ @$att->file_details->document_no }}</td>
                                        <td>{{ $att->expiry_date}}</td>
                                        <td>{{ $att->renewal_date}}</td>
                                        <td>{{ $att->renewed_till  }}</td>
                                        <td>{{ $att->renewed_by }}</td>
                                        <td>{{ $att->amount }}</td>
                                        <td>
                                            <a class="btn btn-xs btn-info" href="{{URL::to('document/document')}}/{{$att->document}}" target="_blank">
                                            <i class="fa fa-eye"></i>Attachment </a>
                                        </td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-file_id="{{@$att->file_id}}" data-particular="{{@$att->particular}}" data-expiry_date="{{@$att->expiry_date}}" data-renewal_date="{{@$att->renewal_date}}" data-renewed_till="{{@$att->renewed_till}}"
                                                data-renewed_by="{{@$att->renewed_by}}"
                                                data-amount="{{@$att->amount}}"
                                                data-remarks="{{@$att->remarks}}"
                                               
                                                href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                
                                                 </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('manage.seized.document.get.official.case.renewal.delete.data',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
                                                                
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
                            <h5 class="modal-title" id="exampleModalLabel">
Renewal of Documents</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.seized.document.get.official.case.renewal.insert.data')}}">@csrf
                        
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
                          <label for="exampleInputEmail1">Expiry Date</label>
                          <input type="date" class="form-control" name="expiry_date" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Renewal Date</label>
                          <input type="date" class="form-control" name="renewal_date" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Renewed Till</label>
                          <input type="date" class="form-control" name="renewed_till" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Renewed By</label>
                          <input type="text" class="form-control" name="renewed_by" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Expenditure Amount</label>
                          <input type="text" class="form-control" name="amount" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Document Evidence</label>
                          <input type="file" class="form-control" name="document" >
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
                            <h5 class="modal-title" id="exampleModalLabel">Renewal of Documents</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.seized.document.get.official.case.renewal.update.data')}}">@csrf
                        
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
                          <label for="exampleInputEmail1">Expiry Date</label>
                          <input type="date" class="form-control" name="expiry_date" id="expiry_date">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Renewal Date</label>
                          <input type="date" class="form-control" name="renewal_date" id="renewal_date">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Renewed Till</label>
                          <input type="date" class="form-control" name="renewed_till" id="renewed_till">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Renewed By</label>
                          <input type="text" class="form-control" name="renewed_by" id="renewed_by">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Expenditure Amount</label>
                          <input type="text" class="form-control" name="amount" id="amount">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Document Evidence</label>
                          <input type="file" class="form-control" name="document" >
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


            $('#expiry_date').val($(this).data('expiry_date'));
            $('#renewal_date').val($(this).data('renewal_date'));
            
            $('#renewed_till').val($(this).data('renewed_till'));
            $('#renewed_by').val($(this).data('renewed_by'));
            $('#amount').val($(this).data('amount'));
            
            
           
            $('#offence_model_edit').modal('show');
        })
</script>

@endsection