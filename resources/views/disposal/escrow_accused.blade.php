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


        @include('disposal.common')


    {{-- table-showing --}}
    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              ESCROW - Accused
                              <small><a class="btn btn-warning" style="float:right" id="offences_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>CID</th>
                                        <th>Name of the Accused</th>
                                        <th>Date & Time of Return</th>
                                        <th>Amount</th>
                                        <th>Reference</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->date }} - {{ $att->time }}</td>
                                        <td>{{ $att->amount }}</td>
                                        <td><a class="btn btn-xs btn-info" href="{{URL::to('disposal/reference')}}/{{$att->reference}}" target="_blank">
                                       <i class="fa fa-eye"></i>Attachment </a></td>
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-cid="{{@$att->cid}}" data-name="{{@$att->name}}" data-date="{{@$att->date}}" data-time="{{@$att->time}}" data-amount="{{@$att->amount}}" data-handed_over_to="{{@$att->handed_over_to}}" data-purpose="{{@$att->purpose}}" data-remarks="{{@$att->remarks}}" href="javascript:void(0)" data-><i class="fa fa-edit"></i>
                                                                Edit/View
                                                 </a>
                                        
                                                 <a class="btn btn-xs btn-danger" href="{{route('manage.get-assign-official-seized-properties.disposal.escrow.accused.details.delete',@$att->id)}}" onclick="return confirm('Are you sure , you want to delete this ? ')"><i class="fa fa-trash"></i>
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
                            <h5 class="modal-title" id="exampleModalLabel">New ESCROW Handover</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.disposal.escrow.accused.details.insert')}}">@csrf
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">CID</label>
                          <input type="text" name="cid" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" name="name" class="form-control">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Date of Return</label>
                          <input type="date" name="date" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Time of Return</label>
                          <input type="time" name="time" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Amount</label>
                          <input type="text" name="amount" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Handed Over To</label>
                          <input type="text" name="handed_over_to" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Purpose</label>
                          <input type="text" name="purpose" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Reference</label>
                          <input type="file" name="reference" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="remarks" ></textarea>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit ESCROW Handover</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.get-assign-official-seized-properties.disposal.escrow.accused.details.update')}}">@csrf
                        
                         <input type="hidden" name="id"  id="id">
                         <input type="hidden" name="case_id" value="{{@$case_id}}" id="case_id">
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">CID</label>
                          <input type="text" name="cid" id="cid" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" name="name" id="name" class="form-control">
                         </div>
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Date of Return</label>
                          <input type="date" name="date" id="date" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Time of Return</label>
                          <input type="time" name="time" id="time" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Amount</label>
                          <input type="text" name="amount" id="amount" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Handed Over To</label>
                          <input type="text" name="handed_over_to" id="handed_over_to" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Purpose</label>
                          <input type="text" name="purpose" id="purpose" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Reference</label>
                          <input type="file" name="reference" class="form-control">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" id="remarks" name="remarks" ></textarea>
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
            $('#cid').val($(this).data('cid'));
            $('#name').val($(this).data('name'));
            $('#date').val($(this).data('date'));
            $('#time').val($(this).data('time'));
            $('#amount').val($(this).data('amount'));

            $('#handed_over_to').val($(this).data('handed_over_to'));
            $('#purpose').val($(this).data('purpose'));
            $('#remarks').val($(this).data('remarks'));
            $('#offence_model_edit').modal('show');
        })
</script>

@endsection