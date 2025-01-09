@extends('layouts.admin')

@section('content')

    <br>
    <section class="content">
        <div id="casedetailscard" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header" style="font-family:Product Sans">
                            {{-- Dzonkhag List --}}
                            <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Civil Litigation
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa2">
                                        Add Civil Litigation
                                    </button>
                                    
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        <th>Service Requested</th>
                                        <th>Brief description</th>
                                        <th>Requested by</th>
                                        <th>Requested Date</th>
                                        <th>Attachment</th>
                                        {{-- <th>Assign To</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data->isNotEmpty())
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->service_request }}</td>
                                                <td>{{ substr(@$att->description,0,100)}}..</td>
                                                <td>{{ $att->requested_by }}</td>
                                                <td>{{ $att->request_date }}</td>
                                                <td><a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/legal')}}/{{$att->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a></td>
                                                {{-- <td>@if(@$att->assign_user_id=="") Not Assigned @else Assigned @endif</td>             --}}
                                                <td>
                                                    
                                                            
                                                       
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button"
                                                                data-id="{{$att->id}}"
                                                                data-service_request="{{$att->service_request}}"
                                                                data-description="{{$att->description}}"
                                                                data-requested_by="{{$att->requested_by}}"
                                                                data-request_date="{{$att->request_date}}"
                                                       >
                                                        Edit
                                                    </a>

                                                    {{-- <a class="btn btn-xs btn-warning"
                                                        href=""
                                                        onclick="return confirm('Are you sure , you want to delete this dzonkhag ? ')"><i
                                                            class="fa fa-book"></i>
                                                        Assign
                                                    </a> --}}
                                                     
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{route('civil.litigation.request.delete.data',$att->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this  ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
                                                    </a>
                                                   
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Dzongkhag</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('civil.litigation.request.insert.data')}}">@csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Service Requested</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="service_request" aria-describedby="emailHelp" placeholder="Service Requested">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Brief description of Service Requested</label>
                                    <textarea type="text" class="form-control" id="exampleInputEmail1" name="description" aria-describedby="emailHelp" placeholder="Brief description of Service Requested"></textarea>
                                 </div>


                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Requested By</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="requested_by" aria-describedby="emailHelp" placeholder="Requested By">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Request Date</label>
                                    <input type="date" class="form-control" id="exampleInputEmail1" name="date" aria-describedby="emailHelp" placeholder="Requested By">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Attachment</label>
                                    <input type="file" class="form-control" id="exampleInputEmail1" name="attachment" aria-describedby="emailHelp" placeholder="Requested By">
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


            <!--Edit Modal -->
            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Dzongkhag</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('civil.litigation.request.update.data')}}">@csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Service Requested</label>
                                    <input type="text" class="form-control" id="service_request" name="service_request" aria-describedby="emailHelp" placeholder="Service Requested">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Brief description of Service Requested</label>
                                    <textarea type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp" placeholder="Brief description of Service Requested"></textarea>
                                 </div>


                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Requested By</label>
                                    <input type="text" class="form-control" id="requested_by" name="requested_by" aria-describedby="emailHelp" placeholder="Requested By">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Request Date</label>
                                    <input type="date" class="form-control" id="date" name="date" aria-describedby="emailHelp" placeholder="Requested By">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Attachment</label>
                                    <input type="file" class="form-control" id="attachment" name="attachment" aria-describedby="emailHelp" placeholder="Requested By">
                                 </div>

                                 <input type="hidden" name="id" id="id">

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


    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
    <script>
        // $(function() {
        //     $("#maintableDz").dataTable();
        // });

        $(document).ready(function() {
            $('#maintableDz').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });

        
    </script>

    <script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#service_request').val($(this).data('service_request'));
            $('#description').val($(this).data('description'));
            $('#requested_by').val($(this).data('requested_by'));
            $('#date').val($(this).data('request_date'));
            $('#id').val($(this).data('id'));
            $('#exampleModaEdit').modal('show');
        })
</script>




@endsection
