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
                                    Pursuability Values Range
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    @if(@$add=="Y")
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModaPlValueRange">
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
                                        <th>Start</th>
                                        <th>End</th>
                                        {{-- <th>File Size</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data->isNotEmpty())
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->pValueRangeID }}</td>
                                                <td>{{ $att->created_at }}</td>
                                                <td>{{ $att->startValue }}</td>
                                                <td>{{ $att->endValue }}</td>
                                                <td>
                                                  
                                                    @if(@$edit=="Y")
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary row-class-{{ @$att->pValueRangeID }}"
                                                        data-row-data='{{ @$att->startValue }}' data-toggle="modal"
                                                        onclick="openEditModalCorruptype({{ @$att->pValueRangeID }},`{{ @$att->endValue }}`)">
                                                        Edit
                                                    </a>
                                                    @endif

                                                    @if(@$delete=="Y")
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('value.rangepl.delete', ['id' => @$att->pValueRangeID]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
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
            <div class="modal fade" id="exampleModaPlValueRange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ADD New Pursuability Values</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('pl-value-range.store') }}">@csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Start</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" name="startValue"
                                        aria-describedby="emailHelp" placeholder="Start Value">
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                               
                                <div class="form-group">
                                    <label for="exampleInputEmail1">End</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" name="endValue"
                                        aria-describedby="emailHelp" placeholder="End Value">
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
            <div class="modal fade" id="exampleModaEditValueRange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Pursuability Values</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('plvalues.edit.update') }}">@csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Start</label>
                                    <input type="text" class="form-control" id="startVAlueId" name="startValue"
                                        aria-describedby="emailHelp" placeholder="Name">
                                    <input type="hidden" id="Cid" name="pValueRangeID">
                                </div>
                               
                                <div class="form-group">
                                    <label for="exampleInputEmail1">End</label>
                                    <input type="text" class="form-control" id="endValueId" name="endValue"
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

        function openEditModalCorruptype(id,endValue) {
            console.log(7777);
            console.log(id);
            console.log(endValue);
            let data = $(`.row-class-${id}`).attr('data-row-data');
            console.log(data);
            $('#exampleModaEditValueRange').modal('show')
            document.getElementById("startVAlueId").value = data;
            document.getElementById("endValueId").value = endValue;
            document.getElementById("Cid").value = id;

        }
    </script>




@endsection
