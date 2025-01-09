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

        @include('followup.common')



        
            <div class="row">
              
                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                  </div>
            </div>


            <div class="col-md-12">
                    <form method="post" action="{{route('get.official.cases.followup.closure.update.decision')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="assign_official_id" value="{{@$id}}">
            <input type="hidden" name="case_id" value="{{@$case_id}}">
            <div class="row">
                

                


            <div class="col-sm-6">
                    <div class="form-group">
                        <label>Judgment Date</label>
                        <input type="date" name="judgement_date" class="form-control" required value="{{@$data->judgement_date}}">
                    </div>
            </div>

            <div class="col-sm-6">
                    <div class="form-group">
                        <label>Judgment No.</label>
                        <input type="text" name="judgement_no" required value="{{@$data->judgement_no}}" class="form-control">
                    </div>
            </div>

            <div class="col-sm-6">
                    <div class="form-group">
                        <label>Court</label>
                        <select class="form-control" name="court" required>
                            <option value="">Select</option>
                            <option value="court 1" @if(@$data->court=="court 1") selected @endif>court 1</option>
                            <option value="court 2" @if(@$data->court=="court 2") selected @endif>court 2</option>
                        </select>
                    </div>
            </div>

            <div class="col-sm-6">
                    <div class="form-group">
                        <label>Court Verdict</label>
                        <input type="file" name="file"  class="form-control">
                    </div>
            </div>

            <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date of Closing</label>
                        <input type="date" name="date_of_closing" value="{{@$data->date_of_closing}}" required class="form-control">
                    </div>
            </div>

            @if(@$data->court_verdict!="")
            <div class="col-sm-6">
                    <div class="form-group">
                        <a class="btn btn-xs btn-info" href="{{URL::to('attachment/case_followup')}}/{{$data->court_verdict}}" target="_blank"><i class="fa fa-eye"></i> Attachment </a>
                    </div>
            </div>
            @endif

           


            <div class="col-sm-12">
                <button type="submit" class="btn btn-info">Submit</button>
            </div>

            </div>
        </form>
    </div>



        <div class="col-sm-12">

                           <div class="card-body">
                            <div class="col-sm">
                                    <!-- Button trigger modal -->
                                     
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa3" style="float:right">
                                        + Add Closure Details
                                    </button>
                                    
                                </div>
                            <table id="maintableGewog" class="table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Name of Accused</th>
                                        <th>CID</th>
                                        <th>License / Registration No</th>
                                        <th>Name of Organization</th>
                                        <th>Sentense</th>
                                        <th>Restitution Ordered</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$details)
                                        {{-- {{$data}} --}}
                                        @foreach (@$details as $att)
                                            <tr>
                                                <td>@if(@$att->type=="Individual") Individual @else Organization @endif</td>
                                                <td>{{ $att->name_of_accused }}</td>
                                                <td>{{ $att->cid_document_no }}</td>
                                                <td>{{ $att->license_no }}</td>
                                                <td>{{ $att->name_organization }}</td>
                                                <td>{{ $att->sentense }}</td>
                                                <td>{{ $att->restitution }}</td>
                                                <td>
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('get.official.cases.followup.closure.delete-data', ['id' => @$att->id]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
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


            
            <div class="modal fade" id="exampleModa3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Closure Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('get.official.cases.followup.closure.insert.details.get.data') }}">@csrf

                                <input type="hidden" name="assign_official_id" value="{{@$id}}">
                                <input type="hidden" name="case_id" value="{{@$case_id}}">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Type</label>
                                    <select class="form-control" name="type" id="type_id" required>
                                        <option value="">Select</option>
                                        <option value="Individual">Individual</option>
                                        <option value="Organization">Organization</option>
                                    </select>
                                 </div>

                                 <div class="indi_div" style="display:none;">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">CID / Document No.</label>
                                    <input type="text" name="cid_document_no" class="form-control">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Name of Accused</label>
                                    <input type="text" name="name_of_accused" class="form-control">
                                 </div>
                                </div>

                                <div class="orga_div" style="display:none;">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">License / Registration No.</label>
                                    <input type="text" name="license_no" class="form-control">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Name of Organization</label>
                                    <input type="text" name="name_organization" class="form-control">
                                 </div>
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Sentence</label>
                                    <select class="form-control" name="sentense" required>
                                        <option value="">Select</option>
                                        <option value="Convicted">Convicted</option>
                                        <option value="Acquited">Acquited</option>
                                    </select>
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Restitution Ordered</label>
                                    <input type="text" name="restitution" class="form-control">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Confiscation / Recovery Ordered</label>
                                    <input type="text" name="recovery_order" class="form-control">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Fines / Penalties Imposed</label>
                                    <input type="text" name="penalty_imposed" class="form-control">
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Others</label>
                                    <textarea class="form-control" name="others"></textarea>
                                 </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea class="form-control" name="remarks"></textarea>
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

    $('#type_id').on('change',function(e){
        var type_details = $('#type_id').val();
        if(type_details=="Individual")
        {
            $('.indi_div').show();
            $('.orga_div').hide();
        }else{
            $('.indi_div').hide();
            $('.orga_div').show();
        }
    });


</script>


@endsection