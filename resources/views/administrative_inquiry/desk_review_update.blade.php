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
                    <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Details of Person Contacted </div>

                        <div class = "card-body">
                            <button class="btn btn-primary" data-toggle="modal"
                            data-target="#exampleModa3">+ Add Data</button>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Contact</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$person->isNotEmpty())
                                    @foreach(@$person as $att)
                                    <tr>
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->designation }}</td>
                                        <td>{{ $att->contact }}</td>
                                        <td>
                                                            
                                                            <a class="btn btn-xs btn-success edit_button" 
                                                            data-id="{{$att->id}}"
                                                            data-name="{{$att->name}}"
                                                            data-designation="{{$att->designation}}"
                                                            data-contact="{{$att->contact}}"
                                                            
                                                            ><i class="fa fa-edit"></i>
                                                                
                                                            </a>
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('administrative.inquiry.plan.official.get.list.view.details.review.delete.page.delete.person.contact',['id'=>@$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
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

                </div>



                <div class="col-sm-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Details of Documents Collected </div>

                        <div class = "card-body">
                            <button class="btn btn-primary" data-toggle="modal"
                            data-target="#exampleModa4">+ Add Data</button>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Document Name</th>
                                        <th>Document Description</th>
                                        <th>File</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$document->isNotEmpty())
                                    @foreach(@$document as $att)
                                    <tr>
                                        <td>{{ $att->document_name }}</td>
                                        <td>{{ $att->document_description }}</td>
                                        <td><a target="_blank" href="{{URL::to('attachment/ie_attachment')}}/{{$att->attachment}}" class="btn btn-xs btn-success">View</a></td>
                                        <td>
                                                            
                                                            <a class="btn btn-xs btn-success edit_button2" 
                                                            data-id="{{$att->id}}"
                                                            data-document_name="{{$att->document_name}}"
                                                            data-document_description="{{$att->document_description}}"
                                                            ><i class="fa fa-edit"></i>
                                                                
                                                            </a>
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('administrative.inquiry.plan.official.get.list.view.details.review.delete.page.delete.person.contact',['id'=>@$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
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

                </div>


                <div class="col-sm-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <form method="post" enctype="multipart/form-data" action="{{route('administrative.inquiry.plan.official.get.list.view.details.review.update.page.update.full.page')}}">@csrf

                                <input type="hidden" name="id"  value="{{@$data->id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Activity</label>
                                    <textarea type="text" class="form-control" id="activity" name="activity" aria-describedby="emailHelp" placeholder="Activity" disabled>{{@$data->activity}}</textarea>
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Person to be Contacted</label>
                                    <textarea type="text" class="form-control" id="person_contact" name="person_contact" aria-describedby="emailHelp" disabled placeholder="Person to be Contacted">{{@$data->person_contact}}</textarea>
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Documents to be reviewed or collected</label>
                                    <textarea type="text" class="form-control" id="document_review" name="document_review" aria-describedby="emailHelp" disabled placeholder="Documents to be reviewed or collected">{{@$data->document_review}}</textarea>
                                 </div>


                                 

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" aria-describedby="emailHelp" placeholder="Requested By" value="{{@$data->start_date}}">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="IN" @if(@$data->status=="IN") selected @endif>Initiated</option>
                                        <option value="UP" @if(@$data->status=="UP") selected @endif>Under Process</option>
                                        <option value="COM" @if(@$data->status=="COM") selected @endif>Complete</option>
                                    </select>
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">End Date</label>
                                    <input type="date" class="form-control" value="{{@$data->end_date}}" id="end_date" name="end_date" aria-describedby="emailHelp" placeholder="Requested By">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea type="text" class="form-control" id="remarks" name="remarks" aria-describedby="emailHelp"  >{{@$data->remarks}}</textarea>
                                 </div>


                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                    </div>


        </div>



                <div class="modal fade" id="exampleModa3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Details of Person Contacted</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('administrative.inquiry.plan.official.get.list.view.details.review.update.page.insert.person.contact')}}">@csrf

                                <input type="hidden" name="id" value="{{@$id}}">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp" placeholder="Name">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Designation</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="designation" aria-describedby="emailHelp" placeholder="Designation">
                                 </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Contact</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="contact" aria-describedby="emailHelp" placeholder="Contact">
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


            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Details of Person Contacted</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('administrative.inquiry.plan.official.get.list.view.details.review.update.page.update.person.contact')}}">@csrf

                                <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Name">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Designation</label>
                                    <input type="text" class="form-control" id="designation" name="designation" aria-describedby="emailHelp" placeholder="Designation">
                                 </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Contact</label>
                                    <input type="text" class="form-control" id="contact" name="contact" aria-describedby="emailHelp" placeholder="Contact">
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








            <div class="modal fade" id="exampleModa4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Details of Documents Collected</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('administrative.inquiry.plan.official.get.list.view.details.review.update.page.insert.document.collected')}}">@csrf

                                <input type="hidden" name="id" value="{{@$id}}">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Document Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="document_name" aria-describedby="emailHelp" placeholder="Document Name">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Document Description</label>
                                    <textarea type="text" class="form-control" id="exampleInputEmail1" name="document_description" aria-describedby="emailHelp" placeholder="Document Description"></textarea>
                                 </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">File</label>
                                    <input type="file" class="form-control" id="exampleInputEmail1" name="attachment" aria-describedby="emailHelp" placeholder="Contact">
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



            <div class="modal fade" id="exampleModa4_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Details of Documents Collected</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('administrative.inquiry.plan.official.get.list.view.details.review.update.page.delete.document.collected')}}">@csrf

                                <input type="hidden" id="id_id" name="id" >

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Document Name</label>
                                    <input type="text" class="form-control" id="document_name" name="document_name" aria-describedby="emailHelp" placeholder="Document Name">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Document Description</label>
                                    <textarea type="text" class="form-control" id="document_description" name="document_description" aria-describedby="emailHelp" placeholder="Document Description"></textarea>
                                 </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">File</label>
                                    <input type="file" class="form-control" id="exampleInputEmail1" name="attachment" aria-describedby="emailHelp" placeholder="Contact">
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



</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#name').val($(this).data('name'));
            $('#designation').val($(this).data('designation'));
            $('#contact').val($(this).data('contact'));
            $('#id').val($(this).data('id'));
            $('#exampleModaEdit').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.edit_button2').on('click',function(){
            $('#document_name').val($(this).data('document_name'));
            $('#document_description').val($(this).data('document_description'));
            $('#contact').val($(this).data('contact'));
            $('#id_id').val($(this).data('id'));
            $('#exampleModa4_edit').modal('show');
        })
</script>

@endsection    