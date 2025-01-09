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
                                    Pursuability Sub Category List
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    @if(@$add=="Y")
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa2">
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
                                        <th>Parent Category</th>
                                        <th>Subcategory</th>
                                        <th>Maximum Score</th>
                                        <th>Allow Multiple</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data->isNotEmpty())
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->pValueSubCategoryID  }}</td>
                                                <td>{{ $att->category_name->pValueName }}</td>
                                                <td>{{ $att->pValueSubCategoryName }}</td>
                                                <td>{{ $att->maxScore }}</td>

                                                <td>{{ $att->allowMultiple }}</td>
                                                <td>{{ $att->pValueSubCategoryRemarks}}</td>
                                                
                                                <td>
                                                
                                                    @if(@$edit=="Y")
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button row-class-{{ @$att->dzoID }}"
                                                         data-name="{{$att->pValueSubCategoryName}}" data-id="{{$att->pValueSubCategoryID}}" data-parent="{{$att->pValueCategoryID}}" data-max="{{$att->maxScore}}" data-multi="{{$att->allowMultiple}}" data-remark="{{$att->pValueSubCategoryRemarks}}"  data-toggle="modal"
                                                        >
                                                        Edit
                                                    </a>
                                                    @endif

                                                    @if(@$delete=="Y")
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('manage.pursuability-value-sub-category.delete', ['id' => @$att->pValueSubCategoryID]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this  ? ')"><i
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
            <div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add SubCategory</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('manage.pursuability-value-sub-category.insert') }}">@csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category</label>
                                   <select name="pValueCategoryID" class="form-control">
                                    <option>Select Category</option>
                                    @foreach(@$category as $value)
                                    <option value="{{@$value->pValueCategoryID}}">{{$value->pValueName}}</option>
                                    @endforeach    
                                   </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Sub Category Name</label>
                                    <input type="text" class="form-control"  name="pValueSubCategoryName"
                                         placeholder="Sub Category Name" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Max Score</label>
                                    <input type="number" class="form-control"  name="maxScore"
                                         placeholder="Max Score" required>
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Allow Multiple</label>
                                    <input type="number" class="form-control"  name="allowMultiple"
                                         placeholder="Allow Multiple" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <input type="text" class="form-control"  name="pValueSubCategoryRemarks"
                                         placeholder=" Remarks" required>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit SubCategory</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('manage.pursuability-value-sub-category.update') }}">@csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category</label>
                                   <select name="pValueCategoryID" id="pValueCategoryID" class="form-control">
                                    <option>Select Category</option>
                                    @foreach(@$category as $value)
                                    <option value="{{@$value->pValueCategoryID}}">{{$value->pValueName}}</option>
                                    @endforeach    
                                   </select>
                                </div>

                                <input type="hidden" name="id" id="CategoryId">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Sub Category Name</label>
                                    <input type="text" class="form-control"  name="pValueSubCategoryName"
                                         placeholder="Sub Category Name" id="pValueSubCategoryName" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Max Score</label>
                                    <input type="number" class="form-control"  name="maxScore"
                                         placeholder="Max Score" id="maxScore" required>
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Allow Multiple</label>
                                    <input type="number" class="form-control"  name="allowMultiple"
                                         placeholder="Allow Multiple" id="allowMultiple" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <input type="text" class="form-control"  name="pValueSubCategoryRemarks"
                                         placeholder=" Remarks" id="pValueSubCategoryRemarks" required>
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

// ;

        $('.edit_button').on('click',function(){
            $('#pValueSubCategoryName').val($(this).data('name'));
            $('#CategoryId').val($(this).data('id'));
            $('#pValueSubCategoryRemarks').val($(this).data('remark'));
            // $('#genderInput_'+data.person.gender).attr('checked', true);
            var dropdown = $(this).data('parent');
            $('#pValueCategoryID  option[value="'+dropdown+'"]').prop("selected", true);

            $('#maxScore').val($(this).data('max'));
            $('#allowMultiple').val($(this).data('multi'));
            $('#exampleModaEdit').modal('show');
        })
        
    </script>




@endsection
