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
                                        data-target="#exampleModaPlValueScope">
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
                                        {{-- <th>Date</th> --}}
                                        <th>Score Range</th>
                                        <th>Decision to be taken</th>
                                        {{-- <th>File Size</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data->isNotEmpty())
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->lpvalueCompDecisionID }}</td>
                                                {{-- <td>{{ $att->created_at }}</td> --}}
                                                <td>{{ $att->startValue }} - {{ $att->endValue }}</td>
                                                <td>{{ $att->compEvaDecisionName }}</td>
                                                <td>

                                                    @if(@$edit=="Y")
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary row-class-{{ @$att->lpvalueCompDecisionID }}"
                                                        data-row-data='{{ @$att->startValue }}' data-toggle="modal"
                                                        onclick="openEditModalValueScope({{ @$att->lpvalueCompDecisionID }},`{{ @$att->endValue }}`,`{{@$att->compEvaDecisionName}}`)">
                                                        Edit
                                                    </a>
                                                    @endif

                                                    @if(@$delete=="Y")


                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('value.scope.delete', ['id' => @$att->lpvalueCompDecisionID]) }}"
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
            <div class="modal fade" id="exampleModaPlValueScope" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ADD New Pursuability Values</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('pl-value-scope.store') }}">@csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Score Range</label>
                                    <select class="form-control" aria-label="Default select example" name="pValueRangeID">
                                        <option value="">Select</option>
                                        @foreach (@$processing as $value)
                                            <option value="{{ $value->pValueRangeID }}">{{ $value->startValue }} - {{ $value->endValue }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">End</label>
                                    <select class="form-control" aria-label="Default select example" name="compEvaDecisionID">
                                        <option value="">Select</option>
                                        @foreach (@$process as $value)
                                            <option value="{{ $value->compEvaDecisionID }}">{{ $value->compEvaDecisionName }}</option>
                                        @endforeach
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


            <!--Edit Modal -->
            <div class="modal fade" id="exampleModaEditValueScope" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Pursuability Values</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('plvaluesScore.edit.update') }}">@csrf
                              
                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">End</label>
                                    <input type="text" class="form-control" id="endValueId" name="endValue"
                                        aria-describedby="emailHelp" placeholder="Remarks">
                                </div> --}}

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Score Range</label>
                                    <select class="form-control" aria-label="Default select example" name="pValueRangeID" id="startVAlueId">
                                        <option value="">Select</option>
                                        @foreach (@$processing as $value)
                                            <option value="{{ $value->pValueRangeID }}">{{ $value->startValue }} - {{ $value->endValue }}</option>
                                        @endforeach
                                    </select>

                                    <input type="hidden" id="Cid" name="lpvalueCompDecisionID">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">End</label>
                                    <select class="form-control" aria-label="Default select example" id="compEvaDecisionIDname" name="compEvaDecisionID">
                                        <option value="">Select</option>
                                        @foreach (@$process as $value)
                                            <option value="{{ $value->compEvaDecisionID }}">{{ $value->compEvaDecisionName }}</option>
                                        @endforeach
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

        function openEditModalValueScope(id, endValue, compEvaDecisionName) {
            console.log(7777);
            console.log(id);
            console.log(compEvaDecisionName);
            let data = $(`.row-class-${id}`).attr('data-row-data');
            console.log(data+'-'+endValue);
            $('#exampleModaEditValueScope').modal('show')
            // document.getElementById("startVAlueId").value = data+'-'+endValue;

            $("#startVAlueId option").filter(function() {
            return $(this).text() == data+' - '+endValue;
            }).prop('selected', true);
            
            // document.getElementById("compEvaDecisionIDname").value = compEvaDecisionName;
            $("#compEvaDecisionIDname option").filter(function() {
            return $(this).text() == compEvaDecisionName;
            }).prop('selected', true);
            
            document.getElementById("Cid").value = id;

        }
    </script>




@endsection
