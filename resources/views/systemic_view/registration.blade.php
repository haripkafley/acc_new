@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> 
                        {{-- Embassy List --}}
                        <div class="row" style="font-family:Product Sans">
                            <div class="col-sm">
                                 Registrations
                            </div>

                            <div class="col-sm-12 mt-3">
                                <div class="card">
                                <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                                <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                              </div>
                        </div>
                            
                           </div>


                    </div>

                    


                        <div class = "card-body">
                            
                            
                              
                            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        
                                        <th>Agency Type</th>
                                        <th>Agency Name</th>
                                        <th>Systemic Recommendation</th>
                                        <th>Reference Letter</th>
                                        <th> Letter Date</th>
                                        <th>Status</th>     
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$data->isNotEmpty())
                                    
                                    @foreach(@$data as $key=> $att)
                                    <tr>
                                        <td>{{ @$att->agency_type}}</td>
                                        <td>{{ $att->agency_name}}</td>
                                        @php
                                        $recoms = DB::table('system_registration_recommendation')->where('register_id',$att->id)->get();
                                        @endphp
                                        <td>
                                            @foreach(@$recoms as $value)
                                            <a href="javascript:void(0)" class="view_more" style="color:black" data-recom="{{@$value->recommendation}}">{{substr(@$value->recommendation,0,35)}}.. <i class="fa fa-eye"></i></a>
                                            @endforeach
                                        </td>
                                        <td><a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/case_followup')}}/{{$att->letter}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View/Download
                                                            </a></td>
                                        <td>{{ $att->letter_date}}</td>
                                        
                                        <td>
                                            {{@$att->status}}
                                            <a class="btn btn-success status" href="javascript:void(0)" data-status="{{@$att->status}}" data-id="{{@$att->id}}" data-status_remark="{{@$att->status_remark}}"> View Status</a>
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


                    {{-- status --}}
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
                            <form method="post" enctype="multipart/form-data" action="{{route('systemic.recommendations.registration.add.view.update.status')}}">@csrf
                        <input type="hidden" name="id" id="id_appraise">
                        
                         
                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <select class="form-control" readonly disabled name="status" id="status_edit">
                              <option value="">Select</option>
                              <option value="Under Agency Review">Under Agency Review</option>
                              <option value="Action Taken">Action Taken</option>
                              <option value="Futher Action">Futher Action</option>
                              <option value="Closed">Closed</option>
                          </select>
                         </div>

                         
                        <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="status_remark" readonly id="status_remark"></textarea>
                         </div>

                         


        
                        
                      </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>


            {{-- view-more --}}
                        <div class="modal fade" id="recom_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">View Recommendation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('systemic.recommendations.registration.add.view.update.status')}}">@csrf
                        

                         
                        <div class="form-group">
                          <label for="exampleInputEmail1">Recommendation</label>
                          <textarea class="form-control" name="recom_val" readonly id="recom_val"></textarea>
                         </div>

                         


        
                        
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


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});


</script>

{{-- status --}}
<script type="text/javascript">
    $('.status').on('click',function(){
            $('#id_appraise').val($(this).data('id'));
            $('#status_edit').val($(this).data('status')).change();
            $('#status_remark').val($(this).data('status_remark'));
            $('#status_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.view_more').on('click',function(e){
        $('#recom_val').val($(this).data('recom'));
        $('#recom_model').modal('show');
    });
</script>


@endsection