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
                              Storage - Cash
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Amount</th>
                                        <th>Received On</th>
                                        <th>Time of Receipt</th>
                                        <th>Source</th>
                                        <th>Location of the amount</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->amount }}</td>
                                        <td>{{ $att->date_receipt }}</td>
                                        <td>{{ $att->time_receipt }}</td>
                                        <td>{{ $att->source }}</td>
                                        <td>{{ $att->location_amount}}</td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-amount="{{@$att->amount}}" data-date_receipt="{{@$att->date_receipt}}" data-time_receipt="{{@$att->time_receipt}}" data-source="{{@$att->source}}" data-description="{{@$att->description}}" data-location="{{@$att->location_amount}}" href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                Edit/View
                                                 </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('manage.get-assign-official-seized-properties.custody.details.cash.storage.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
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
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.custody.details.cash.storage.insert')}}">@csrf
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Amount</label>
                          <input type="text" name="amount" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Date of Receipt</label>
                          <input type="date" name="date_receipt" class="form-control">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Time of Receipt</label>
                          <input type="time" name="time_receipt" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Source</label>
                          <input type="text" name="source" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Description</label>
                          <textarea type="text" name="description" class="form-control"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Location of the amount</label>
                          <select class="form-control" name="location_amount">
                            <option value="">Select</option>
                            <option value="Cash In Hand">Cash In Hand</option>
                            <option value="Escrow Account">Escrow Account</option>
                          </select>
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
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.custody.details.cash.storage.update')}}">@csrf
                        
                         <input type="hidden" name="id"  id="id">
                         <input type="hidden" name="case_id" value="{{@$case_id}}" id="case_id">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Amount</label>
                          <input type="text" name="amount" id="amount" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Date of Receipt</label>
                          <input type="date" name="date_receipt" id="date_receipt" class="form-control">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Time of Receipt</label>
                          <input type="time" name="time_receipt" id="time_receipt" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Source</label>
                          <input type="text" name="source" id="source" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Description</label>
                          <textarea type="text" name="description" id="description" class="form-control"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Location of the amount</label>
                          <select class="form-control" id="location_amount" name="location_amount">
                            <option value="">Select</option>
                            <option value="Cash In Hand">Cash In Hand</option>
                            <option value="Escrow Account">Escrow Account</option>
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


    <script type="text/javascript">
    $('#offences_add').on('click',function(){
            $('#offence_model').modal('show');
        })
</script>
    
    <script type="text/javascript">
    $('.edit_offence').on('click',function(){
            $('#id').val($(this).data('id'));
            $('#amount').val($(this).data('amount'));
            $('#source').val($(this).data('source'));
            $('#date_receipt').val($(this).data('date_receipt'));
            $('#time_receipt').val($(this).data('time_receipt'));
            $('#description').val($(this).data('description'));
            $('#location_amount').val($(this).data('location')).change();
            $('#offence_model_edit').modal('show');
        })
</script>

@endsection