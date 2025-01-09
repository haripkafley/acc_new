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
                                    Village List
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
                            <table id="maintableVillage" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Dzongkhag</th>
                                        <th>Gewog</th>
                                        <th>Village</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data)
                                        {{-- {{$data}} --}}
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->villageID }}</td>
                                                <td>{{ $att->created_at }}</td>
                                                <td>{{ $att->getDzongkhagDetails->dzoName }}</td>
                                                <td>{{ $att->getGewogDetails->gewogName }}</td>
                                                <td>{{ $att->villageName }}</td>
                                                <td>
                                                    {{-- <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/complaintRegistration')}}/{{$att->AttachmentPath}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a>
                                                             --}}
                                                    @if(@$edit=="Y")         
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary row-class-{{ @$att->villageID }}"
                                                        data-row-data='{{ @$att->villageName }}' data-toggle="modal"
                                                        onclick="openEditModalEditVillage({{ @$att->villageID }},`{{ @$att->getDzongkhagDetails->dzoID }}`, `{{ $att->getGewogDetails->gewogID }}`)">
                                                        Edit
                                                    </a>
                                                    @endif

                                                    @if(@$delete=="Y") 
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('village.delete', ['id' => @$att->villageID]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this village ? ')"><i
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
                            <h5 class="modal-title" id="exampleModalLabel">Add Village</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('village.store') }}">@csrf


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Dzonkhag</label>
                                    <select class="form-control" aria-label="Default select example" name="dzooID"
                                        id="SelectDz">
                                        <option value="">Select Dzonkhag</option>
                                        @foreach (@$processingDz as $value)
                                            <option value="{{ $value->dzoID }}">{{ @$value->dzoName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Gewog</label>
                                    <select class="form-control" aria-label="Default select example" name="gewogID"
                                        id="sel">
                                        <option value="">Select Gewog</option>
                                        {{-- @foreach (@$processing as $value)
                                            <option value="{{ $value->gewogID }}">{{ @$value->gewogName }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Village</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="villageName"
                                        aria-describedby="emailHelp" placeholder="Village Name">
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
            <div class="modal fade" id="exampleModaEditVillage" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Village</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('village.edit.update') }}">@csrf


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Dzonkhag</label>
                                    <select class="form-control" aria-label="Default select example" name="dzooID"
                                        id="DzoNameId">
                                        <option value="">Select Dzonkhag</option>
                                        @foreach (@$processingDz as $value)
                                            <option value="{{ $value->dzoID }}">{{ @$value->dzoName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Gewog</label>
                                    <select class="form-control" aria-label="Default select example" name="gewogID"
                                        id="GewogNameId">
                                        <option value="">Select Gewog</option>
                                        @foreach (@$processing as $value)
                                            <option value="{{ $value->gewogID }}">{{ @$value->gewogName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Village</label>
                                    <input type="text" class="form-control" id="villageNamea"
                                        name="villageNamea" aria-describedby="emailHelp" placeholder="Village Name">
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                    <input type="hidden" id="VillageIDInput" name="villageID">
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
            $('#maintableVillage').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });

        function openEditModalEditVillage(id, selectDz, selectGew) {
            console.log(7777);
            console.log(id);
            console.log(selectDz);
            console.log(selectGew);
            let data = $(`.row-class-${id}`).attr('data-row-data');
            console.log(data);
            $('#exampleModaEditVillage').modal('show')
            document.getElementById("villageNamea").value = data;
            document.getElementById("VillageIDInput").value = id;
            document.getElementById("DzoNameId").value = selectDz;
            document.getElementById("GewogNameId").value = selectGew;

        }

        $('#SelectDz').on('change', function() {
            console.log(333333);
            let selectId = $('#SelectDz').val();
            console.log(selectId);
            var url = '{{ route('gewog.list.dz', ':id') }}';
            url = url.replace(':id', selectId);
            $('#sel').empty();
            
            $.getJSON(url, function(data) {
                $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    console.log(value);
                    $('#sel').append('<option value="' + value.gewogID + '">' + value.gewogName +
                        '</option>');
                });
            });

        });
    </script>



@endsection
