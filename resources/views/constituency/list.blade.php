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
                                    Constituency List
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    @if(@$add=="Y")
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa4">
                                        Add
                                    </button>
                                    @endif
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id="maintableConst" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Constituency</th>
                                        {{-- <th>Detail</th> --}}
                                        <th>Dzongkhag</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data)
                                        {{-- {{$data}} --}}
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->constituencyID }}</td>
                                                <td>{{ $att->created_at }}</td>
                                                <td>{{ $att->constituencyName }}</td>
                                                <td>{{ $att->getDzongkhagDetails->dzoName }}</td>
                                                <td>
                                                    {{-- <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/complaintRegistration')}}/{{$att->AttachmentPath}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a>
                                                             --}}
                                                    @if(@$edit=="Y")         
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary row-class-{{ @$att->constituencyID }}"
                                                        data-row-data='{{ @$att->constituencyName }}' data-toggle="modal"
                                                        onclick="openEditModalEditConst({{ @$att->constituencyID }},`{{ @$att->getDzongkhagDetails->dzoID }}`)">
                                                        Edit
                                                    </a>
                                                    @endif

                                                    @if(@$delete=="Y")
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('consti.delete', ['id' => @$att->constituencyID]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this constituency ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Attachment Found Againt This Complaint</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModa4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Constituency</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('constituency.store') }}">@csrf

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Dzonkhag</label>
                                    <select class="form-control" aria-label="Default select example" name="DzoID">
                                        <option value="">Select</option>
                                        @foreach (@$processing as $value)
                                            <option value="{{ $value->dzoID }}">{{ @$value->dzoName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Constituency</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        name="constituencyName" aria-describedby="emailHelp"
                                        placeholder="Constituency Name">
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
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
            <div class="modal fade" id="exampleModaEditConst" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Constituency</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('constituency.edit.update') }}">@csrf


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Dzonkhag</label>
                                    <select class="form-control" aria-label="Default select example" name="DzoID"
                                        id="DzoNameId">
                                        <option value="">Select</option>
                                        @foreach (@$processing as $value)
                                            <option value="{{ $value->dzoID }}">{{ @$value->dzoName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Constituency</label>
                                    <input type="text" class="form-control" id="constituencyNamea"
                                        name="constituencyName" aria-describedby="emailHelp"
                                        placeholder="Constituency Name">
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                    <input type="hidden" id="ConstituencyID" name="constituencyID">
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


    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
    <script>
        // $(function() {
        //     $("#maintableDz").dataTable();
        // });

        $(document).ready(function() {
            $('#maintableConst').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });

        function openEditModalEditConst(id, select) {
            console.log(7777);
            console.log(id);
            console.log(select);
            let data = $(`.row-class-${id}`).attr('data-row-data');
            console.log(data);
            $('#exampleModaEditConst').modal('show')
            document.getElementById("constituencyNamea").value = data;
            document.getElementById("ConstituencyID").value = id;
            document.getElementById("DzoNameId").value = select;

        }
    </script>



@endsection
