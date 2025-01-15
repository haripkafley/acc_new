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
              


                <div class="col-sm-12">
                    <div class="card">
                    <p><b>Complaint No:</b> {{@$data->monitory_details->eve_offence_details->complaint_details->complaintRegNo}}</p>

                    <p><b>Complaint Title:</b> {{@$data->monitory_details->eve_offence_details->complaint_details->complaintTitle}}</p>



                    <p><b>Date Time:</b> {{@$data->monitory_details->eve_offence_details->complaint_details->complaintDateTime}}</p>

                    <p><b>Offence Name :</b> {{@$data->monitory_details->eve_offence_details->allegation_name}}</p>
                    <p><b>Offence Description :</b> {{@$data->monitory_details->eve_offence_details->allegation_description}}</p>
                   

                    
               </div>
                   
            </div>

            <div class="col-sm-12">
                    <div class="card">
                        <p><b>Complaint Details:</b> {{@$data->monitory_details->eve_offence_details->complaint_details->complaintDetails}}</p>
                    </div>
                </div>


                <div class="col-sm-12">
                  <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Monetary Fine </div>
                        <div class = "card-body">
                            <table id  = "maintable" class="table" >
                                  <div class="col-sm">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa3" style="float: right;">
                                        + Add Details
                                    </button>
                                 </div>
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>CID/Permit No.</th>
                                        <th>Name / Agency Name</th>
                                        <th>Amount</th>
                                        <th>Remarks</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$details->isNotEmpty())
                                       @foreach(@$details as $value)
                                       <tr>
                                           <td>@if(@$value->category_id=="IND") Individual @else Agency @endif </td>
                                           <td>{{@$value->cid_permit}}</td>
                                           <td>{{@$value->name}}</td>
                                           <td>{{@$value->amount}}</td>
                                           <td>{{@$value->remarks}}</td>
                                           
                                           <td>
                                            
                                              <a type="button"
                                              class="btn btn-xs btn-primary edit_button_person row-class-{{ @$att->id }}"
                                                        data-row-data='{{ @$value->dzoName }}' data-id="{{@$value->id}}" data-category_id="{{@$value->category_id}}" data-cid_permit="{{@$value->cid_permit}}"
                                                         data-name="{{@$value->name}}" 
                                                        data-amount="{{@$value->amount}}"
                                                        data-department="{{@$value->user_details->department_name->name}}"
                                                        data-remarks = "{{@$value->remarks}}"
                                                        data-toggle="modal"
                                                        >
                                                        Edit
                                                    </a>

                                               <a class="btn btn-xs btn-danger"
                                                        href="{{route('recovery-model.get.official.view.page.delete.fine',@$value->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
                                                    </a>

                                                    <a type="button"
                                                      class="btn btn-xs btn-success edit_button_payment row-class-{{ @$att->id }}"
                                                                data-row-data='{{ @$value->dzoName }}' data-id="{{@$value->id}}" data-category_id="{{@$value->category_id}}" data-cid_permit="{{@$value->cid_permit}}"
                                                                 data-name="{{@$value->name}}" 
                                                                data-amount="{{@$value->amount}}"
                                                                data-department="{{@$value->user_details->department_name->name}}"
                                                                data-remarks = "{{@$value->remarks}}"
                                                                data-receipt_date = "{{@$value->receipt_date}}"
                                                                data-receipt_no = "{{@$value->receipt_no}}"
                                                                data-remarks = "{{@$value->remarks}}"


                                                                data-toggle="modal"
                                                                >
                                                        Payment
                                                    </a>


                                            
                                           </td>

                                       </tr>
                                       @endforeach
                                       @endif            
                                </tbody>
                            </table>
                        </div>
                </div>
                </div>


                <div class="col-sm-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Recovery Report </div>

                        <div class = "card-body">
                            <form action="{{route('recovery-model.get.official.view.page.final.report.submit')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="monetary_id" value="{{@$monetary_id}}">
                                <div class="form-group">
                                    <label>Report Attachment</label>
                                    <input type="file" name="admin_report_attachment" class="form-control">
                                </div>

                                @if(@$monetary_details->admin_report_attachment!="")
                                <div class="form-group">
                                    <a href="{{URL::to('attachment/information_enrichment')}}/{{$monetary_details->admin_report_attachment}}" class="btn btn-xs btn-primary" target="_blank">See Attachment</a>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label>Report Remarks</label>
                                    <textarea type="text" name="admin_report_remarks" class="form-control">{{@$monetary_details->admin_report_remarks}}</textarea>
                                </div>

                                <div class="form-group"><button type="submit" class="btn btn-primary">Submit</button></div>
                            </form>
                        </div>
                    </div>
                </div>



                <div class="modal fade" id="exampleModa3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Add  Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('recovery-model.get.official.view.page.insert.fine') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="monetary_id" value="{{@$monetary_id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Users</label>
                                    <select class="form-control" name="category_id" id="user_change_add_cec" >
                                        <option value="">Select Category</option>
                                        <option value="IND">Individual</option>
                                        <option value="AGC">Agency</option>
                                    </select>
                                </div>

                                <div class="form-group" id="indi_div">
                                    <label for="exampleInputEmail1">CID/Permit No</label>
                                    <input type="text" name="cid_permit" class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1" id="name_label">Name</label>
                                    <input type="text" name="name"  class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Amount</label>
                                    <input type="text" name="amount"  class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea name="remarks" class="form-control"></textarea>
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


            <div class="modal fade" id="exampleModa3_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Edit Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('recovery-model.get.official.view.page.update.fine') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Users</label>
                                    <select class="form-control" name="category_id" id="category_id_edit" disabled>
                                        <option value="">Select Category</option>
                                        <option value="IND">Individual</option>
                                        <option value="AGC">Agency</option>
                                    </select>
                                </div>

                                <div class="form-group" id="indi_div_edit">
                                    <label for="exampleInputEmail1">CID/Permit No</label>
                                    <input type="text" name="cid_permit" id="cid_permit"  class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1" id="name_label_edit">Name</label>
                                    <input type="text" name="name" id="name"  class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Amount</label>
                                    <input type="text" name="amount" id="amount" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea name="remarks" id="remarks" class="form-control"></textarea>
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


            <div class="modal fade" id="exampleModa3_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Payment Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('recovery-model.get.official.view.page.update.fine.payment') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="id" id="id_payment">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Users</label>
                                    <select class="form-control" name="category_id" id="category_id_payment" disabled>
                                        <option value="">Select Category</option>
                                        <option value="IND">Individual</option>
                                        <option value="AGC">Agency</option>
                                    </select>
                                </div>

                                <div class="form-group" id="indi_div_payment">
                                    <label for="exampleInputEmail1">CID/Permit No</label>
                                    <input type="text" name="cid_permit" id="cid_permit_payment" disabled class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1" id="name_label_payment">Name</label>
                                    <input type="text" name="name" id="name_payment"  class="form-control"disabled >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Amount</label>
                                    <input type="text" name="amount" id="amount_payment"disabled class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea name="remarks" id="remarks_payment"disabled class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Receipt Date</label>
                                    <input type="date" name="receipt_date" id="receipt_date" required class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Receipt no</label>
                                    <input type="text" name="receipt_no" id="receipt_no" required class="form-control">
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

    <script type="text/javascript">
        $('.edit_button_person').on('click',function(){
                    $('#category_id_edit').val($(this).data('category_id')).attr("selected", "selected");
                    $('#cid_permit').val($(this).data('cid_permit'));
                    $('#name').val($(this).data('name'));
                    $('#amount').val($(this).data('amount'));
                    $('#remarks').val($(this).data('remarks'));
                    $('#id').val($(this).data('id'));

                    var text = $(this).data('category_id');
                    if(text=="IND")
                    {
                        $('#indi_div_edit').show();
                        $('#name_label_edit').text('Name');
                    }else{
                        $('#indi_div_edit').hide();
                        $('#name_label_edit').text('Agency Name');
                    }


                    $('#exampleModa3_edit').modal('show');
                    
                })

        $('.edit_button_payment').on('click',function(){
                    $('#category_id_payment').val($(this).data('category_id')).attr("selected", "selected");
                    $('#cid_permit_payment').val($(this).data('cid_permit'));
                    $('#name_payment').val($(this).data('name'));
                    $('#amount_payment').val($(this).data('amount'));
                    $('#remarks_payment').val($(this).data('remarks'));
                    $('#id_payment').val($(this).data('id'));

                    $('#receipt_date').val($(this).data('receipt_date'));
                    $('#receipt_no').val($(this).data('receipt_no'));

                    var text = $(this).data('category_id');
                    if(text=="IND")
                    {
                        $('#indi_div_payment').show();
                        $('#name_label_payment').text('Name');
                    }else{
                        $('#indi_div_payment').hide();
                        $('#name_label_payment').text('Agency Name');
                    }


                    $('#exampleModa3_payment').modal('show');
                    
                })

        $('#user_change_add_cec').on('change',function(){
            var text = $('#user_change_add_cec').val();
            if(text=="IND")
            {
                $('#indi_div').show();
                $('#name_label').text('Name');
            }else{
                $('#indi_div').hide();
                $('#name_label').text('Agency Name');
            }
        })
    </script>


@endsection