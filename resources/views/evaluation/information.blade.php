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
                                    Additional Information List
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa2">
                                        Add
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
                                        <th>#</th>
                                        <th>Descrption</th>
                                        <th>Date</th>
                                        <th>Attached Document</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data->isNotEmpty())
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->id }}</td>
                                                <td>{{ $att->description }}</td>
                                                <td>{{ $att->date }}</td>
                                                <td>@if($att->attachment!="") <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/information')}}/{{$att->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a> @else -- @endif</td>
                                                
                                                <td>
                                                    
                                                            
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button row-class-{{ @$att->id }}"
                                                        data-row-data='{{ @$att->dzoName }}' data-id="{{@$att->id}}" data-description="{{@$att->description}}" data-date="{{@$att->date}}" data-attachment="{{URL::to('attachment/information')}}/{{@$att->attachment}}" @if(@$att->attachment=="") data-attachmentType="N" @else data-attachmentType="Y" @endif  data-toggle="modal"
                                                        >
                                                        Edit
                                                    </a>
                                                   

                                                   
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('dzonkhag.delete', ['id' => @$att->id]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this dzonkhag ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    
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
            <div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('complaint.evaluation.additional.information.insert') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="id" value="{{@$id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Information Brief</label>
                                    <textarea class="form-control" name="description" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Attachment</label>
                                    <input type="file" name="attachment" class="form-control" >
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('complaint.evaluation.additional.information.update') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="info_id" id="info_id">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Information Brief</label>
                                    <textarea class="form-control" name="description" id="description" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date</label>
                                    <input type="date" name="date" id="date" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Attachment</label>
                                    <input type="file" name="attachment"  class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1" id="past"></label>
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

        $('.edit_button').on('click',function(){
            $('#description').val($(this).data('description'));
            $('#date').val($(this).data('date'));
            $('#info_id').val($(this).data('id'));
            if($(this).data('attachmenttype')=="Y")
            {
                $('#past').html('<a class="btn btn-xs btn-info" href="'+$(this).data('attachment')+'"" target="_blank"><i class="fa fa-eye"></i> View </a>');
            }
            $('#exampleModaEdit').modal('show');
            

         })
    </script>




@endsection
