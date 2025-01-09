@extends('layouts.admin')

@section('content')
    <style type="text/css">
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
        .tox .tox-notification--warn, .tox .tox-notification--warning {
            display: none;
        }
            
        .card{
            padding: 25px;
        }

            </style>
<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

            
        


        
            <div class="row">
              
                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                    <p><b>Instruction:</b> {{@$data->instruction}}</p>

                  </div>
            </div>




    {{-- table-showing --}}
    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Document Disposal
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>File / Document No</th>
                                        <th>Method</th>
                                        <th>Disposed By</th>
                                        <th>Place of Disposal</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$disposal->isNotEmpty())
                                    @foreach(@$disposal as $att)
                                    <tr>
                                        
                                        <td>
                                            @foreach(@$att->files_details as $val)
                                                {{@$val->file_single->document_no}},
                                            @endforeach
                                        </td>
                                        <td>{{ $att->method }}</td>
                                        <td>{{ $att->disposed_by }}</td>
                                        <td>{{ $att->place_of_disposal }}</td>
                                        <td>
                                            <a class="btn btn-xs btn-info edit_offence" 
                                                href="{{route('manage.seized.document.chief.document.disposal.view.complete.details-view',@$att->id)}}" data-><i class="fa fa-eye"></i>
                                                    
                                            </a>

                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>

 </div>




        </div>
    </div>
</section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   



    <script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});


</script>




@endsection