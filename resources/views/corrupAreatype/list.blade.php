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
                                    Area of Corruption
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    @if(@$add=="Y")
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModaCorruptarea">
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
                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Corruption Area</th>
                                        <th>Remarks</th>
                                        {{-- <th>File Size</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data->isNotEmpty())
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->corruptionAreaID }}</td>
                                                <td>{{ $att->created_at }}</td>
                                                <td>{{ $att->name }}</td>
                                                <td>{{ $att->remarks }}</td>
                                                <td>
                                                  
                                                    @if(@$edit=="Y")
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary row-class-{{ @$att->corruptionAreaID }}"
                                                        data-row-data='{{ @$att->name }}' data-toggle="modal"
                                                        onclick="openEditModalCorruptype({{ @$att->corruptionAreaID }},`{{ @$att->remarks }}`)">
                                                        Edit
                                                    </a>
                                                    @endif



                                                    @if(@$delete=="Y")
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('corruparea.delete', ['id' => @$att->corruptionAreaID]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this corruption area ? ')"><i
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
            <div class="modal fade" id="exampleModaCorruptarea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Corruption Area</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('corruption-area.store') }}">@csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="name"
                                        aria-describedby="emailHelp" placeholder="Name">
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                               
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="remarks"
                                        aria-describedby="emailHelp" placeholder="Remarks">
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
            <div class="modal fade" id="exampleModaEditCorruptarea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Corruption Area</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('corruparea.edit.update') }}">@csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" id="NameId" name="name"
                                        aria-describedby="emailHelp" placeholder="Name">
                                    <input type="hidden" id="Cid" name="corruptionAreaID">
                                </div>
                               
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <input type="text" class="form-control" id="RemarksId" name="remarks"
                                        aria-describedby="emailHelp" placeholder="Remarks">
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
            $('#maintableDz').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });

        function openEditModalCorruptype(id,remarks) {
            console.log(7777);
            console.log(id);
            console.log(remarks);
            let data = $(`.row-class-${id}`).attr('data-row-data');
            console.log(data);
            $('#exampleModaEditCorruptarea').modal('show')
            document.getElementById("NameId").value = data;
            document.getElementById("RemarksId").value = remarks;
            document.getElementById("Cid").value = id;

        }
    </script>




@endsection
