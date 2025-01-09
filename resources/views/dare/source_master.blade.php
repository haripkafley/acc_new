@extends('layouts.admin')

<style type="text/css">
    .select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #80bdff;
    height: 40px !important;
}
</style>
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
                                    Source
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa2">
                                        Add
                                    </button>

                                    <a href="{{route('agency.index')}}" target="_blank" class="btn btn-success">
                                        Add Agency Address
                                    </a>
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
                                        <th>Source Type</th>
                                        <th>Source Name / Source Code</th>
                                        <th>Source Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data->isNotEmpty())
                                        @foreach (@$data as $att)
                                            <tr>
                                               <td>@if(@$att->source_type=="CD") Commission Directives @else {{ @$att->source_type }} @endif</td> 
                                               <td>{{ $att->name }}</td>
                                               @if($att->agency!="")

                                               @php
                                               $agency = DB::table('pl_tblagency')->where('agencyID',$att->agency)->first();
                                               @endphp
                                               <td>{{@$agency->agencyName}}</td>
                                               @else
                                               <td>--</td>
                                               @endif
                                                <td>
                                                   

                                                    <a type="button"
                                                        class="btn btn-xs btn-primary row-class-{{ @$att->id }}"
                                                        data-row-data='{{ @$att->name }}' data-row-type='{{ @$att->source_type }}' data-row-agency='{{ @$att->agency }}' data-toggle="modal"
                                                        onclick="openEditModal({{ @$att->id }})">
                                                        <i
                                                            class="fa fa-edit"></i>
                                                    </a>

                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('manage.ir.source.dare.delete', ['id' => @$att->id]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this dzonkhag ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        
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
                            <h5 class="modal-title" id="exampleModalLabel">Add Source</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        

                        <div class="modal-body">
                            <form method="post" action="{{ route('manage.ir.source.dare.insert') }}">@csrf

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Source Type</label>
                                    <select class="form-control source_type" name="source_type">
                                        <option value="">Select</option>
                                        <option value="OSINT">OSINT</option>
                                        <option value="CD">Commission Directives</option>
                                        <option value="SOCINT">SOCINT</option>
                                        <option value="Humint">Humint</option>
                                        <option value="DS">Data Source</option>
                                    </select>
                                    
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="source_label">Source Name</label>
                                    <input type="text" class="form-control" readonly  value="{{@$source_address}}" id="exampleInputEmail1" name="name"
                                        aria-describedby="emailHelp">
                                    
                                </div>

                                <div class="form-group" id="agency_add_div" style="display:none">
                                    <label for="exampleInputEmail1">Source Address</label>
                                    <select class="js-example-basic-single form-control" name="agency" >
                                        <option value="">Select</option>
                                        @foreach(@$agencys as $value)
                                        <option value="{{@$value->agencyID}}">{{@$value->agencyName}}</option>
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
            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Source</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('manage.ir.source.dare.update')}}">@csrf

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Source Type</label>
                                    <select class="form-control source_type" disabled>
                                        <option value="">Select</option>
                                        <option value="OSINT">OSINT</option>
                                        <option value="CD">Commission Directives</option>
                                        <option value="SOCINT">SOCINT</option>
                                        <option value="Humint">Humint</option>
                                        <option value="DS">Data Source</option>
                                    </select>
                                    
                                </div>

                                <input type="hidden" name="source_type" value="" id="selected_source_type" />

                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="source_label">Source</label>
                                    <input type="text" class="form-control" readonly id="source_id" name="name"
                                        aria-describedby="emailHelp">
                                    <input type="hidden" id="id" name="id">
                                </div>


                                <div class="form-group" id="agency_edit_div">
                                    <label for="exampleInputEmail1">Source Address</label>
                                    <select class="js-example-basic-single2 form-control" name="agency" id="agency_risk">
                                        <option value="">Select</option>
                                        @foreach(@$agencys as $value)
                                        <option value="{{@$value->agencyID}}">{{@$value->agencyName}}</option>
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




    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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

        function openEditModal(id) {
            console.log(7777);
            console.log(id);
            let data = $(`.row-class-${id}`).attr('data-row-data');
            let agency = $(`.row-class-${id}`).attr('data-row-agency');
            let source_type = $(`.row-class-${id}`).attr('data-row-type');
            console.log(source_type);

            $('#exampleModaEdit').modal('show')
            document.getElementById("source_id").value = data;
            document.getElementById("id").value = id;
            $('#agency_risk').val(agency).change();
            $('.source_type').val(source_type).change();
            $('#selected_source_type').val(source_type);
            if(source_type=="Humint")
            {
                $('.source_label').text('Source Code');
            }else{
                $('.source_label').text('Source Name');
            }

            if(source_type=="Humint" || source_type=="DS")
            {
                $('#agency_edit_div').show();
            }else{
                $('#agency_edit_div').hide();
            }
        }
    </script>

    <script type="text/javascript">
        $('.source_type').on('change',function(e){
            var source_type = $('.source_type').val();
            if(source_type=="Humint")
            {
                $('.source_label').text('Source Code');
            }else{
                $('.source_label').text('Source Name');
            }

            if(source_type=="Humint" || source_type=="DS")
            {
                $('#agency_add_div').show();
            }else{
                $('#agency_add_div').hide();
            }


        })
    </script>

    <script>
        $(document).ready(function() {
           $(document).ready(function() {
            $('.js-example-basic-single').select2({
                placeholder: "Select an option",
                allowClear: true,
                dropdownParent: $('#agency_add_div')
            });

            $('.js-example-basic-single2').select2({
                placeholder: "Select an option",
                allowClear: true,
                dropdownParent: $('#agency_edit_div')
            });
        });
        });
    </script>

@endsection
