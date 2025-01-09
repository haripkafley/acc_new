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

                    <p><b>Instruction:</b> {{@$data->instruction}}</p>

                  </div>
            </div>




    {{-- table-showing --}}
    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Receipt of Document  
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Receipt Date</th>
                                        <th>Receipt Time</th>
                                        <th>Particular</th>
                                        <th>File No</th>
                                        <th>Received From</th>
                                        <th>Received By</th>
                                        <th>Qr Code</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$receipt->isNotEmpty())
                                    @foreach(@$receipt as $att)
                                    <tr>
                                        
                                        <td>{{ $att->date }}</td>
                                        <td>{{ $att->time }}</td>
                                        <td>@if(@$att->particular=="F") File @else Travel Document @endif</td>
                                        <td>{{ $att->document_no }}</td>
                                        <td>{{ $att->received_from }}</td>
                                        <td>{{ $att->received_by }}</td>
                                        <td>
                                            @if(@$att->qr_code!="") <img src="{{URL::to('qr')}}/{{$att->qr_code}}" style="width:100px;height: 100px;"> @else Not generated @endif
                                        </td>
                                        {{-- <td id="{{$att->id}}.my-clas">{!! QrCode::size(256)->generate('http://127.0.0.1:8000/receipt-details/'.$att->id) !!} <br>
                                            <a href="#" class="btn btn-danger download_btn" data-id={{$att->id}}>Download</a>
                                        </td> --}}
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-date="{{@$att->date}}" data-time="{{@$att->time}}" data-particular="{{@$att->particular}}" data-document_no="{{@$att->document_no}}" data-no_pages="{{@$att->no_pages}}"
                                                data-validity_of_document="{{@$att->validity_of_document}}"
                                                data-received_from="{{@$att->received_from}}"
                                                data-received_by="{{@$att->received_by}}"
                                                data-status="{{@$att->status}}"



                                                 href="javascript:void(0)" ><i class="fa fa-edit"></i>
                                                                
                                                 </a>

                                                 @if(@$att->qr_code!="") <a class="btn btn-xs btn-primary"
                                                               href="{{URL::to('qr')}}/{{$att->qr_code}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View Qr
                                                            </a> @endif
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('manage.seized.document.get.official.case.receipt.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
                                                                
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
                            <h5 class="modal-title" id="exampleModalLabel">New Document Received</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.seized.document.get.official.case.receipt.insert')}}">@csrf
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}" id="case_id">
                         
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Date of Receipt</label>
                          <input type="date" class="form-control" name="date" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Time of Receipt</label>
                          <input type="time" class="form-control" name="time" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Particular</label>
                          <select class="form-control" name="particular">
                            <option value="">Select</option>
                            <option value="F">File</option>
                            <option value="D">Travel Document</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">File / Document No.</label>
                          <input type="text" class="form-control" name="document_no" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">No.of Pages</label>
                          <input type="text" class="form-control" name="no_pages" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Validity of Document</label>
                          <input type="text" class="form-control" name="validity_of_document" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Received From</label>
                          <input type="text" class="form-control" name="received_from" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Received By</label>
                          <input type="text" class="form-control" name="received_by" >
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <select class="form-control" name="status">
                            <option value="">Select</option>
                            <option value="Custody">Custody</option>
                            <option value="Disposal">Disposal</option>
                          </select>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Document Received</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.seized.document.get.official.case.receipt.update')}}">@csrf
                        
                         <input type="hidden" name="id"  id="id">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Date of Receipt</label>
                          <input type="date" class="form-control" name="date" id="date">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Time of Receipt</label>
                          <input type="time" class="form-control" name="time" id="time">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Particular</label>
                          <select class="form-control" name="particular" id="particular">
                            <option value="">Select</option>
                            <option value="F">File</option>
                            <option value="D">Travel Document</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">File / Document No.</label>
                          <input type="text" class="form-control" id="document_no" name="document_no" >
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">No.of Pages</label>
                          <input type="text" class="form-control" name="no_pages" id="no_pages">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Validity of Document</label>
                          <input type="text" class="form-control" name="validity_of_document" id="validity_of_document">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Received From</label>
                          <input type="text" class="form-control" name="received_from" id="received_from">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Received By</label>
                          <input type="text" class="form-control" name="received_by" id="received_by">
                         </div>


                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <select class="form-control" name="status" id="status">
                            <option value="">Select</option>
                            <option value="Custody">Custody</option>
                            <option value="Disposal">Disposal</option>
                          </select>
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
            $('#id').val($(this).data('id'));
            $('#date').val($(this).data('date'));
            $('#time').val($(this).data('time'));
            $('#particular').val($(this).data('particular')).change();
            $('#document_no').val($(this).data('document_no'));
            $('#no_pages').val($(this).data('no_pages'));

            $('#validity_of_document').val($(this).data('validity_of_document'));
            $('#received_from').val($(this).data('received_from'));
            $('#received_by').val($(this).data('received_by'));
            $('#status').val($(this).data('status')).change();
           
            $('#offence_model_edit').modal('show');
        })
</script>
{{-- <script type="text/javascript">
    $('.download_btn').on('click',function(e){
        // alert($(this).data('id'));
        var selector = '#' + $(this).data('id') + ' .my-class';
        
        var qrCodeImage = $('selector img');
        var imageURL = qrCodeImage.attr('src');
                
                // Create a temporary anchor element
                var downloadLink = document.createElement('a');
                downloadLink.href = imageURL;
                downloadLink.download = 'qrcode.png';
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
    });
</script> --}}

@endsection