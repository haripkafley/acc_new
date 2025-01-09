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
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Contact</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$person->isNotEmpty())
                                    @foreach(@$person as $att)
                                    <tr>
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->designation }}</td>
                                        <td>{{ $att->contact }}</td>
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
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Document Name</th>
                                        <th>Document Description</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$document->isNotEmpty())
                                    @foreach(@$document as $att)
                                    <tr>
                                        <td>{{ $att->document_name }}</td>
                                        <td>{{ $att->document_description }}</td>
                                        <td><a target="_blank" href="{{URL::to('attachment/ie_attachment')}}/{{$att->attachment}}" class="btn btn-xs btn-success">View</a></td>
                                        
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
                        <form method="post" enctype="multipart/form-data" action="{{route('information.enrichment.get.list.assigned.ie.plan.page.full.update.page.data')}}">@csrf

                                <input type="hidden" name="id" id="id" value="{{@$data->id}}">
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
                                    <input type="date" class="form-control" id="start_date" name="start_date" aria-describedby="emailHelp" disabled placeholder="Requested By" value="{{@$data->start_date}}">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select class="form-control" name="status" id="status" disabled>
                                        <option value="IN" @if(@$data->status=="IN") selected @endif>Initiated</option>
                                        <option value="UP" @if(@$data->status=="UP") selected @endif>Under Process</option>
                                        <option value="COM" @if(@$data->status=="COM") selected @endif>Complete</option>
                                    </select>
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">End Date</label>
                                    <input type="date" class="form-control" value="{{@$data->end_date}}" id="end_date" name="end_date" aria-describedby="emailHelp" disabled placeholder="Requested By">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea type="text" disabled class="form-control" id="remarks" name="remarks" aria-describedby="emailHelp"  >{{@$data->remarks}}</textarea>
                                 </div>
                        </form>
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