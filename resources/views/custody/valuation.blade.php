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
                              Valuation
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Date of Valuation</th>
                                        <th>Value / Worth</th>
                                        <th>Competent Authorit</th>
                                        <th>Report</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->item_details->item }}</td>
                                        <td>{{ $att->date }}</td>
                                        <td>{{ $att->worth }}</td>
                                        <td>{{ $att->competen }}</td>
                                        <td><a class="btn btn-xs btn-info" href="{{URL::to('custody/report')}}/{{$att->report}}" target="_blank">
                                       <i class="fa fa-eye"></i>Attachment </a></td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-item="{{@$att->item_id}}" data-item_code="{{@$att->item_details->item_code}}" data-item_description="{{@$att->item_details->item_description}}" data-date="{{@$att->date}}" data-worth="{{@$att->worth}}" data-competen="{{@$att->competen}}"  href="javascript:void(0)" data-><i class="fa fa-edit"></i> + <i class="fa fa-eye"></i>
                                                               
                                                 </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('manage.get-assign-official-seized-properties.custody.details.valuation.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
                                                                
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
                            <h5 class="modal-title" id="exampleModalLabel">New Valuation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.custody.details.valuation.insert')}}">@csrf
                        
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
                          <label for="exampleInputEmail1">Date of Valuation</label>
                          <input type="date" name="date" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Value / Worth</label>
                          <input type="text" name="worth" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Competent Authority</label>
                          <input type="text" name="competen" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Report</label>
                          <input type="file" name="report" class="form-control">
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Valuation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.custody.details.valuation.update')}}">@csrf
                        
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
                          <label for="exampleInputEmail1">Date of Valuation</label>
                          <input type="date" name="date" id="date" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Value / Worth</label>
                          <input type="text" name="worth" id="worth" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Competent Authority</label>
                          <input type="text" name="competen" id="competen" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Report</label>
                          <input type="file" name="report" id="report" class="form-control">
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
            $('#date').val($(this).data('date'));
            $('#worth').val($(this).data('worth'));
            $('#competen').val($(this).data('competen'));
            $('#offence_model_edit').modal('show');
        })
</script>

<script type="text/javascript">
    $('#item_id').on('change',function(e){
        $('#item_code_add').val($('#item_id option:selected').data('code'));
        $('#item_description_add').val($('#item_id option:selected').data('description'));
    })
</script>
@endsection