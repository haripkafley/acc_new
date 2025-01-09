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
                              Bail and Bond Properties  
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>CID</th>
                                        <th>Type Of Security</th>
                                        <th>Value</th>
                                        <th>View Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$bailbound->isNotEmpty())
                                    @foreach(@$bailbound as $att)
                                    <tr>
                                        
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->security_type }}</td>
                                        <td>{{ $att->value_property }}</td>
                                        
                                        <td>

                                                <a class="btn btn-xs btn-info edit_bail" data-id="{{@$att->id}}"  href="javascript:void(0)" ><i class="fa fa-eye"></i>
                                                                View
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






<div class="modal fade" id="edit_bail_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit/View Bail and Bond Properties</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties-list.receipt.details.update.bail')}}">@csrf
                        
                         <input type="hidden" name="id" id="edit_id">
                         
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">CID</label>
                          <input type="text" name="cid" class="form-control" id="cid" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" name="name" class="form-control" id="name" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Security Type</label>
                          <select class="form-control security_type" name="security_type" disabled id="security_type">
                              <option value="">Select</option>
                              <option value="Land">Land</option>
                              <option value="Building">Building</option>
                              <option value="Flat">Flat</option>
                              <option value="Vehicle">Vehicle</option>
                              <option value="Other">Other</option>
                          </select>
                         </div>

                         <div class="commom_land_building_flat" style="display:none">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Tham No</label>
                          <input type="text" name="tham_no" class="form-control" id="tham_no" disabled>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Plot No</label>
                          <input type="text" name="plot_no" class="form-control" id="plot_no" disabled>
                         </div>

                         <div class="form-group">
                              <label for="exampleInputEmail1">Dzongkhag</label>
                              <select class="form-control dzongkhag_add" name="dzongkhag" id="dzongkhag" disabled>
                                  <option value="">Select</option>
                                  @foreach(@$dzongkhag as $value)
                                  <option value="{{@$value->dzoID}}">{{@$value->dzoName}}</option>
                                  @endforeach
                               </select>
                          </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Gewog</label>
                          <select class="form-control gewog_add" name="gewog" id="gewog" disabled>
                                  <option value="">Select</option>
                                  @foreach(@$gewog as $vale)
                                  <option value="{{@$vale->gewogID}}">{{@$vale->gewogName}}</option>
                                  @endforeach
                          </select>
                         </div>
                         </div>

                         <div class="building_flat_div" style="display:none">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Building No</label>
                              <input type="text" name="building_no" id="building_no" disabled class="form-control">
                             </div>
                         </div>

                         <div class="flat_div" style="display:none">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Flat No.</label>
                              <input type="text" name="flat_no" id="flat_no" disabled class="form-control">
                             </div>
                         </div>


                         <div class="vehicle_div" style="display:none">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Vehicle Type</label>
                              <select class="form-control" name="vehicle_type" disabled id="vehicle_type">
                                  <option value="">Select</option>
                                  <option value="Vehicle Type 1">Vehicle Type 1</option>
                                  <option value="Vehicle Type 2">Vehicle Type 2</option>
                               </select>
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Vehicle Registration No</label>
                              <input type="text" name="vehicle_registration_no" disabled id="vehicle_registration_no" class="form-control">
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Registered Owner</label>
                              <input type="text" name="registered_owner" disabled id="registered_owner" class="form-control">
                             </div>
                         </div>


                         <div class="form-group">
                              <label for="exampleInputEmail1">Value</label>
                              <input type="text" name="value_property" disabled id="value_property" class="form-control">
                         </div>


                         <div class="form-group">
                              <label for="exampleInputEmail1">Remarks</label>
                              <textarea type="text" name="remarks" id="remarks" disabled class="form-control"></textarea>
                         </div>


                         

                         

                         

                         

        
                        
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
        $('input[type=radio][name=evaluation]').on('change', function() {
          var evaluation =  $(this).val();
           if(evaluation=="Y")
           {
             $('.describe').show();
           }else{
            $('.describe').hide();
           } 
        });
    </script>

    <script type="text/javascript">
    $('#bail_add').on('click',function(){
            $('#bail_model').modal('show');
        })
</script>



<script type="text/javascript">
    $('.dzongkhag_add').on('change',function() {
            
            let selectId = $(this).val();
            
            var url = '{{route('manage.get-assign-official-seized-properties-list.get.gewog',':id') }}';
            url = url.replace(':id', selectId);
            $('.gewog_add').empty();
            
            $.getJSON(url, function(data) {
                $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    console.log(value);
                    $('.gewog_add').append('<option value="' + value.gewogID + '">' + value.gewogName +
                        '</option>');
                });
            });

        });
</script>


<script type="text/javascript">
    $('.edit_bail').on('click',function(e){
        var edit_id = $(this).data('id');
        console.log(edit_id);
        $.ajax({
            url:'{{route('manage.get-assign-official-seized-properties-list.get.edit.data.details')}}',
            method:'GET',
            data:{id:edit_id},
            success:function(data){
               $('#edit_id').val(data.data.id);
               $('#cid').val(data.data.cid);
               $('#name').val(data.data.name);
               $("#security_type").val(data.data.security_type).trigger('change');
               $('#tham_no').val(data.data.tham_no);
               $('#plot_no').val(data.data.plot_no);

               $('#dzongkhag').val(data.data.dzongkhag).trigger('change');
               $('#gewog').val(data.data.gewog).trigger('change');
               $('#building_no').val(data.data.building_no);
               $('#flat_no').val(data.data.flat_no);

               $('#vehicle_type').val(data.data.vehicle_type);
               $('#vehicle_registration_no').val(data.data.vehicle_registration_no);
               $('#registered_owner').val(data.data.registered_owner);
               $('#value_property').val(data.data.value_property);
               $('#remarks').val(data.data.remarks);

                if(data.data.security_type=="Land")
                {
                    $('.commom_land_building_flat').show();
                    $('.building_flat_div').hide();
                    $('.flat_div').hide();
                    $('.vehicle_div').hide();

                }
                else if(data.data.security_type=="Building")
                {
                    $('.commom_land_building_flat').show();
                    $('.building_flat_div').show();
                    $('.flat_div').hide();
                    $('.vehicle_div').hide();
                }

                else if(data.data.security_type=="Flat")
                {
                    
                    $('.commom_land_building_flat').show();
                    $('.building_flat_div').show();
                    $('.flat_div').show();
                    $('.vehicle_div').hide();
                }

                else if(data.data.security_type=="Vehicle")
                {
                    $('.commom_land_building_flat').hide();
                    $('.building_flat_div').hide();
                    $('.flat_div').hide();
                    $('.vehicle_div').show();
                }

                else if(data.data.security_type=="Other")
                {
                    $('.commom_land_building_flat').hide();
                    $('.building_flat_div').hide();
                    $('.flat_div').hide();
                    $('.vehicle_div').hide();
                }

               $('#edit_bail_model').modal('show');
            },
        });
    });
</script>
@endsection