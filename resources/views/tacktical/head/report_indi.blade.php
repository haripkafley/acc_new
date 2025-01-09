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
                              Report
                            </div>
                            
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('tacktical.head.navbar')
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>TI Number</th>
                                        <th>Request Type</th>
                                        <th>Relation To</th>
                                        <th>Request Date</th>
                                        <th>Chief Status</th>
                                        <th>Action</th>           
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        
                                        <td>{{ @$data->si_ig_no}}</td>
                                        <td>{{ @$data->request_type_details->name }}</td>
                                        <td>{{ @$data->relation_to }}</td>
                                        <td>{{ @$data->request_date }}</td>
                                        <td>@if(@$data->report_status=="AA") Awaiting @elseif(@$data->report_status=="A") Accept @else Reject @endif</td>
                                        <td>
                                             @if(@$data->completation_date!="")
                                                            <a href="{{route('tacktical.inteligence.autorization.individual.ti-report.information.page.download.report',@$data->id)}}"
                                                                class="btn btn-xs btn-success "
                                                              >PDF </a>
                                            @endif

                                            @if(@$data->report_status!="A" && @$data->submitted_by!="")

                                                            <a type="button"
                                                                class="btn btn-xs btn-primary decision_button"
                                                                data-id="{{$data->id}}"
                                                                data-report_status="{{$data->report_status}}"
                                                                data-report_remarks="{{$data->report_remarks}}"
                                                                data-review_date="{{$data->review_date}}"
                                                                data-toggle="modal"
                                                                >
                                                                Decision
                                                            </a>

                                            @endif
                                                           
                                                            
                                                            
                                        </td>
                                    </tr>
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="exampleModaEdit1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Decision</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('tacktical.inteligence.autorization.tacktical.details.head.report.information.individual.page.review.chief.decision')}}">@csrf

                             <input type="hidden" name="id" id="id_status">   
                                

                            <div class="form-group">
                              <label for="exampleInputEmail1">Review Decision</label>
                              <select class="form-control" name="report_status" id="chief_decision_status">
                                  <option value="">Select</option>
                                  <option value="AA">Awaiting</option>
                                  <option value="A">Accept</option>
                                  <option value="R">Reject</option>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputEmail1">Review Remarks</label>
                              <textarea type="text" class="form-control" name="report_remarks"  id="chief_remark_status"  aria-describedby="emailHelp"></textarea>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputEmail1">Review Date</label>
                              <input type="date" class="form-control" name="review_date"  id="review_date"  aria-describedby="emailHelp">
                            </div>
                               
                               <div class="col-md-12">
                               <button type="submit" class="btn btn-primary">Save</button>  
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


<script type="text/javascript">
    $('.decision_button').on('click',function(){
         if($(this).data('report_status')=="AA")
            {
                $('#chief_decision_status').val('AA').change();
            }else if($(this).data('report_status')=="A")
            {
                $('#chief_decision_status').val('A').change();
            }else{
                $('#chief_decision_status').val('R').change();
            }
            $('#chief_remark_status').val($(this).data('report_remarks'));
            $('#id_status').val($(this).data('id'));
            $('#review_date').val($(this).data('review_date'));
            $('#exampleModaEdit1').modal('show');
    });
</script>

@endsection