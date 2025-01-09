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
                                    Agency List
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    @if(@$add=="Y")
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModaAgency">
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
                            <table id="maintableGewog" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>AgencyName</th>
                                        {{-- <th>Detail</th> --}}
                                        {{-- <th>Agency Category</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data)
                                        {{-- {{$data}} --}}
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->agencyID }}</td>
                                                <td>{{ $att->created_at }}</td>
                                                <td>{{ $att->agencyName }}</td>
                                                {{-- <td>{{ $att->getEmpCatDetails->empCategoryName }}</td> --}}
                                                <td>
                                                    {{-- <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/complaintRegistration')}}/{{$att->AttachmentPath}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a>
                                                             --}}
                                                    @if(@$edit=="Y")         
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary row-class-{{ @$att->agencyID }}"
                                                        data-row-data='{{ @$att->agencyName }}' data-toggle="modal"
                                                        onclick="openEditModalEditAgency({{ @$att->agencyID }},`{{ @$att->getEmpCatDetails->empCategoryID }}`,`{{ @$att->parentAgencyID }}`)">
                                                        Edit
                                                    </a>
                                                    @endif

                                                    @if(@$delete=="Y")
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('agency.delete', ['id' => @$att->agencyID]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this agency ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModaAgency" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Agency</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('agency.store') }}">@csrf

                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Agency Category</label>
                                    <select class="form-control" aria-label="Default select example" name="agencyCategoryID">
                                        <option value="">Select Category</option>
                                        @foreach (@$processing as $value)
                                            <option value="{{ $value->empCategoryID }}">{{ @$value->empCategoryName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">parentAgencyID</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="parentAgencyID"
                                        aria-describedby="emailHelp" placeholder="Parent Agency id">
                                    
                                </div> --}}
                               
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Agency Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="agencyName"
                                        aria-describedby="emailHelp" placeholder="Agency Name">
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
            <div class="modal fade" id="exampleModaEditAGency" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Agency</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('agency.edit.update') }}">@csrf
                                

                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Agency Category</label>
                                    <select class="form-control" aria-label="Default select example" name="emcatId"
                                        id="empCategoryId">
                                        <option value="">Select Category</option>
                                        @foreach (@$processing as $value)
                                            <option value="{{ $value->empCategoryID }}">{{ @$value->empCategoryName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Parent Agency Id</label>
                                    <input type="text" class="form-control" id="parentAgID" name="parentId"
                                        aria-describedby="emailHelp" placeholder="Parent Agency Id">
                                    
                                </div> --}}

                                <div class="form-group">
                                  <label for="exampleInputEmail1">Agency Name</label>
                                  <input type="text" class="form-control" id="agencyNamea" name="agencyName"
                                      aria-describedby="emailHelp" placeholder="Agency Name">
                                  {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                  <input type="hidden" id="agId" name="agencyID">
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
            $('#maintableGewog').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });

        function openEditModalEditAgency(id, empcatId,parentAgencyID) {
            console.log(7777);
            console.log(id);
            console.log(empcatId);
            let data = $(`.row-class-${id}`).attr('data-row-data');
            console.log(data);
            $('#exampleModaEditAGency').modal('show')
            document.getElementById("agencyNamea").value = data;
            document.getElementById("parentAgID").value = parentAgencyID;
            document.getElementById("empCategoryId").value = empcatId;
            document.getElementById("agId").value = id;

        }
    </script>




@endsection
