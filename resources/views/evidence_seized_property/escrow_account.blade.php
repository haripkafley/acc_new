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

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
       
      </ul>



        
            <div class="row">

                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                    <p><b>Registration Date:</b> {{@$case_details->creation_date}}</p>

                  </div>
            </div>
              
                    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              ESCROW Account  
                              <small><a class="btn btn-warning" style="float:right" id="bail_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>CID</th>
                                        <th>Amount</th>
                                        <th>Source</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$bailbound->isNotEmpty())
                                    @foreach(@$bailbound as $att)
                                    <tr>
                                        
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->total_amount }}</td>
                                        <td>{{ $att->source }}</td>
                                        
                                        <td>

                                                <a class="btn btn-xs btn-info edit_bail" data-id="{{@$att->id}}"  href="javascript:void(0)" ><i class="fa fa-edit"></i>
                                                                Edit/View
                                                 </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('manage.get-assign-official-seized-properties-list.escrow.account.delete.data',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
                                                                Delete
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



     <div class="modal fade" id="bail_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New ESCROW Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties-list.escrow.account.insert.data')}}">@csrf
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Source</label>
                          <select class="form-control source" name="source">
                              <option value="">Select</option>
                              <option value="Bail and Bound Cash">Bail and Bound Cash</option>
                              <option value="Auction">Auction</option>
                              <option value="Seized Cash">Seized Cash</option>
                              <option value="Administrative Action">Administrative Action</option>
                              <option value="Fines and Penalties">Fines and Penalties</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">CID of Accused</label>
                          <input type="text" name="cid" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Name of Accused</label>
                          <input type="text" name="name" class="form-control">
                         </div>

                         


                         <div class="auction_div" style="display:none">

                         <div class="form-group">
                          <label for="exampleInputEmail1">Type Of Property</label>
                          <select class="form-control type_of_property " name="type_of_property">
                              <option value="">Select</option>
                              <option value="Land">Land</option>
                              <option value="Vehicle">Vehicle</option>
                              <option value="Other">Other</option>
                          </select>
                         </div>



                         <div class="land_div" style="display:none">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Tham No</label>
                          <input type="text" name="tham_no" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Plot No</label>
                          <input type="text" name="plot_no" class="form-control">
                         </div>

                         </div>


                         <div class="vehicle_div" style="display:none">
                         <div class="form-group">
                              <label for="exampleInputEmail1">Vehicle Registration No</label>
                              <input type="text" name="vehicle_registration_no" class="form-control">
                         </div>
                        </div>

                        </div>



                        <div class="seized_cash_div" style="display:none">

                         <div class="form-group">
                          <label for="exampleInputEmail1">Ngultrum</label>
                          <input type="text" name="ng" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Indian Rupees</label>
                          <input type="text" name="ir" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Other Currency</label>
                          <input type="text" name="oc" class="form-control">
                         </div>

                        </div>
                         


                        <div class="fines_div" style="display:none">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Type Of Fines</label>
                          <select class="form-control type_of_fines " name="type_of_fines">
                              <option value="">Select</option>
                              <option value="Asset Declaration">Asset Declaration</option>
                              <option value="Others">Others</option>
                          </select>
                         </div>
                        </div>
                         





                         <div class="form-group">
                          <label for="exampleInputEmail1">Total Amount</label>
                          <input type="text" name="total_amount" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Receipt Date</label>
                          <input type="date" name="receipt_date" class="form-control">
                         </div>

                         <div class="form-group">
                              <label for="exampleInputEmail1">Remarks</label>
                              <textarea type="text" name="remarks" class="form-control"></textarea>
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





                <div class="modal fade" id="edit_bail_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit ESCROW Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties-list.escrow.account.update.data')}}">@csrf
                        
                         <input type="hidden" name="id" id="id_edit" >
                         
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Source</label>
                          <select class="form-control source" name="source" id="source">
                              <option value="">Select</option>
                              <option value="Bail and Bound Cash">Bail and Bound Cash</option>
                              <option value="Auction">Auction</option>
                              <option value="Seized Cash">Seized Cash</option>
                              <option value="Administrative Action">Administrative Action</option>
                              <option value="Fines and Penalties">Fines and Penalties</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">CID of Accused</label>
                          <input type="text" name="cid" class="form-control" id="cid">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Name of Accused</label>
                          <input type="text" name="name" class="form-control" id="name">
                         </div>

                         


                         <div class="auction_div" style="display:none">

                         <div class="form-group">
                          <label for="exampleInputEmail1">Type Of Property</label>
                          <select class="form-control type_of_property " id="type_of_property" name="type_of_property">
                              <option value="">Select</option>
                              <option value="Land">Land</option>
                              <option value="Vehicle">Vehicle</option>
                              <option value="Other">Other</option>
                          </select>
                         </div>



                         <div class="land_div" style="display:none">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Tham No</label>
                          <input type="text" name="tham_no" id="tham_no" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Plot No</label>
                          <input type="text" name="plot_no" id="plot_no" class="form-control">
                         </div>

                         </div>


                         <div class="vehicle_div" style="display:none">
                         <div class="form-group">
                              <label for="exampleInputEmail1">Vehicle Registration No</label>
                              <input type="text" name="vehicle_registration_no" id="vehicle_registration_no" class="form-control">
                         </div>
                        </div>

                        </div>



                        <div class="seized_cash_div" style="display:none">

                         <div class="form-group">
                          <label for="exampleInputEmail1">Ngultrum</label>
                          <input type="text" name="ng" id="ng" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Indian Rupees</label>
                          <input type="text" name="ir" id="ir" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Other Currency</label>
                          <input type="text" name="oc" id="oc" class="form-control">
                         </div>

                        </div>
                         


                        <div class="fines_div" style="display:none">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Type Of Fines</label>
                          <select class="form-control type_of_fines " id="type_of_fines" name="type_of_fines">
                              <option value="">Select</option>
                              <option value="Asset Declaration">Asset Declaration</option>
                              <option value="Others">Others</option>
                          </select>
                         </div>
                        </div>
                         





                         <div class="form-group">
                          <label for="exampleInputEmail1">Total Amount</label>
                          <input type="text" name="total_amount" id="total_amount" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Receipt Date</label>
                          <input type="date" name="receipt_date" id="receipt_date" class="form-control">
                         </div>

                         <div class="form-group">
                              <label for="exampleInputEmail1">Remarks</label>
                              <textarea type="text" name="remarks" id="remarks" class="form-control"></textarea>
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
    $('#bail_add').on('click',function(){
            $('#bail_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.source').on('change',function(e){
        var source = $(this).val();
        if(source=="Bail and Bound Cash" || source=="Administrative Action")
        {
            $('.auction_div').hide();
            $('.seized_cash_div').hide();
            $('.fines_div').hide();
        }
        else if(source=="Auction")
        {
            $('.auction_div').show();
            $('.seized_cash_div').hide();
            $('.fines_div').hide();
        }

        else if(source=="Seized Cash")
        {
            $('.auction_div').hide();
            $('.seized_cash_div').show();
            $('.fines_div').hide();
        }

        else if(source=="Fines and Penalties")
        {
            $('.auction_div').hide();
            $('.seized_cash_div').hide();
            $('.fines_div').show();
        }
    });

    $('.type_of_property').on('change',function(e){
        var property = $(this).val();
        if(property=="Land")
        {
            $('.land_div').show();
            $('.vehicle_div').hide();
        }

        else if(property=="Vehicle")
        {
            $('.land_div').hide();
            $('.vehicle_div').show();
        }else{
            $('.land_div').hide();
            $('.vehicle_div').hide();
        }
    })



</script>

<script type="text/javascript">
    $('.edit_bail').on('click',function(e){
        var edit_id = $(this).data('id');
        console.log(edit_id);
        $.ajax({
            url:'{{route('manage.get-assign-official-seized-properties-list.escrow.account.details.get.data')}}',
            method:'GET',
            data:{id:edit_id},
            success:function(data){
               console.log(data);
               $('#id_edit').val(data.data.id);
               $('#cid').val(data.data.cid);
               $('#name').val(data.data.name);
               $("#source").val(data.data.source).trigger('change');
               $("#type_of_property").val(data.data.type_of_property).trigger('change');
               $('#tham_no').val(data.data.tham_no);
               $('#plot_no').val(data.data.plot_no);

               $('#total_amount').val(data.data.total_amount);
               $('#receipt_date').val(data.data.receipt_date);
               $('#remarks').val(data.data.remarks);

               $('#vehicle_registration_no').val(data.data.registration_no);
               $('#ng').val(data.data.ng);
               $('#ir').val(data.data.ir);
               $('#oc').val(data.data.oc);
               $('#type_of_fines').val(data.data.type_of_fines);

                if(data.data.source=="Bail and Bound Cash" || data.data.source=="Administrative Action")
                {
                    $('.auction_div').hide();
                    $('.seized_cash_div').hide();
                    $('.fines_div').hide();
                }
                else if(data.data.source=="Auction")
                {
                    $('.auction_div').show();
                    $('.seized_cash_div').hide();
                    $('.fines_div').hide();


                }

                else if(data.data.source=="Seized Cash")
                {
                    $('.auction_div').hide();
                    $('.seized_cash_div').show();
                    $('.fines_div').hide();
                }

                else if(data.data.source=="Fines and Penalties")
                {
                    $('.auction_div').hide();
                    $('.seized_cash_div').hide();
                    $('.fines_div').show();
                }

                if(data.data.type_of_property=="Land")
                    {
                        $('.land_div').show();
                        $('.vehicle_div').hide();
                    }

                    else if(data.data.type_of_property=="Vehicle")
                    {
                        $('.land_div').hide();
                        $('.vehicle_div').show();
                    }else{
                        $('.land_div').hide();
                        $('.vehicle_div').hide();
                    }

               $('#edit_bail_model').modal('show');
            },
        });
    });
</script>


@endsection