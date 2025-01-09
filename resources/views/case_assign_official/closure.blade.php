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

        @include('case_assign_official.common')



        
            <div class="row">
              
                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                  </div>
            </div>


            <div class="col-md-12">
                   
            <div class="row">
                

                


            <div class="col-sm-6">
                    <div class="form-group">
                        <label>Judgment Date</label>
                        <input type="date" name="judgement_date" class="form-control" disabled value="{{@$data->judgement_date}}">
                    </div>
            </div>

            <div class="col-sm-6">
                    <div class="form-group">
                        <label>Judgment No.</label>
                        <input type="text" name="judgement_no" disabled value="{{@$data->judgement_no}}" class="form-control">
                    </div>
            </div>

            <div class="col-sm-6">
                    <div class="form-group">
                        <label>Court</label>
                        <select class="form-control" name="court" disabled>
                            <option value="">Select</option>
                            <option value="court 1" @if(@$data->court=="court 1") selected @endif>court 1</option>
                            <option value="court 2" @if(@$data->court=="court 2") selected @endif>court 2</option>
                        </select>
                    </div>
            </div>

            

            <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date of Closing</label>
                        <input type="date" name="date_of_closing" value="{{@$data->date_of_closing}}" disabled class="form-control">
                    </div>
            </div>

            @if(@$data->court_verdict!="")
            <div class="col-sm-6">
                    <div class="form-group">
                        <a class="btn btn-info" href="{{URL::to('attachment/case_followup')}}/{{$data->court_verdict}}" target="_blank"><i class="fa fa-eye"></i> View Attachment </a>
                    </div>
            </div>
            @endif


            </div>
        </form>
    </div>



        <div class="col-sm-12">

                           <div class="card-body">
                           
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