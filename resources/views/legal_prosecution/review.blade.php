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

       @include('legal_prosecution.common')



        
            <div class="row">
              
                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                  </div>
            </div>




    {{-- table-showing --}}
    <div class="col-sm-12">

                           <div class="card-body">
                            
                            <table id="maintableGewog" class="table">
                                <thead>
                                    <tr>
                                        <th>Case/Accused</th>
                                        <th>CID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Attachment</th>
                                        <th>Reasons Cited by OAG</th>
                                        <th>Decision</th>
                                        <th>Update</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$lists)
                                        {{-- {{$data}} --}}
                                        @foreach (@$lists as $att)
                                            <tr>

                                                <td>{{ $att->with_drawn_details->case_or_accused}}</td>
                                                <td>{{ $att->with_drawn_details->cid }}</td>
                                                <td>{{ $att->with_drawn_details->accused_name }}</td>

                                                <td>{{ $att->status }}</td>
                                                <td>{{ $att->date }}</td>
                                                <td>@if($att->attachment!="")<a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/legal_prosecution')}}/{{$att->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                Attachment
                                                            </a> @else -- @endif</td>

                                                <td>{{$att->reason}}</td>
                                                @php
                                                $check = DB::table('legal_review_update')->where('case_withdrawn_id',$att->case_withdrawn_id)->where('pros_status_id',$att->id)->first();
                                                @endphp

                                                <td>@if(@$check->decision!=""){{@$check->decision}} @else Awaiting @endif</td>
                                                

                                                <td><a href="javascript:void(0)" data-case_withdrawn_id="{{@$att->case_withdrawn_id}}"  data-pros_status_id="{{@$att->id}}" data-attachment="{{URL::to('attachment/legal_prosecution')}}/{{@$check->attachment}}" data-attach="{{@$check->attachment}}" data-investigation_finding="{{@$check->investigation_finding}}" data-analysis="{{@$check->analysis}}" data-recomendation="{{@$check->recomendation}}" data-decision="{{@$check->decision}}" class="btn btn-primary status_button">Update/View</a></td>


                                                   
                                                
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

                            <div class="modal fade" id="status_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('prosecution.legal.list.my-dashboard.view.decision-update')}}">@csrf
                        
                         <input type="hidden" name="case_withdrawn_id" id="case_withdrawn_id">
                         <input type="hidden" name="pros_status_id" id="pros_status_id">
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Investigation Findings</label>
                          <textarea class="form-control" name="investigation_finding" disabled id="investigation_finding"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Analysis by Legal Division</label>
                          <textarea class="form-control" name="analysis" disabled id="analysis"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Recommendations</label>
                          <textarea class="form-control" name="recomendation" disabled id="recomendation"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Commission's Decision</label>
                          <select class="form-control" name="decision" disabled id="decision">
                              <option value="">Select</option>
                              <option value="Close">Close</option>
                              <option value="Own Prosecution">Own Prosecution</option>
                              <option value="Others">Others</option>
                          </select>
                         </div>

                         <div class="form-group attachment_view" style="display:none">
                          <a href="" class="btn btn-primary" id="attachment_view" target="_blank">View Attachment</a>
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

<script type="text/javascript">
    $('.status_button').on('click',function(){
            $('#case_withdrawn_id').val($(this).data('case_withdrawn_id'));
            $('#pros_status_id').val($(this).data('pros_status_id'));
            $('#decision').val($(this).data('decision')).change();
            $('#investigation_finding').val($(this).data('investigation_finding'));
            $('#analysis').val($(this).data('analysis'));
            $('#recomendation').val($(this).data('recomendation'));

            if($(this).data('attach')!="")
            {
                // alert($(this).data('attachment'));
                $('.attachment_view').show();
                $('#attachment_view').attr('href',$(this).data('attachment')); 
            }
            $('#status_model').modal('show');
        })
</script>

@endsection