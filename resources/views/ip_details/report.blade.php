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
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Report
                                </button> --}}
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('ip_details.member_navbar')
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>IP No</th>
                                        <th>IP Title</th>
                                        <th>Report Date</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr>
                                        <td>{{ $data->ir_no}}</td>
                                        <td>{{ $data->title }}</td>
                                        <td>@if(@$data->ir_report->report_date=="") Report Not Updated @else {{@$data->ir_report->report_date}} @endif</td>
                                        
                                        <td>
                                         <a href="{{route('member.get.information.report.assignment.intel.project.report.page.prepare.report',@$data->id)}}"class="btn btn-xs btn-primary " target="_blank"> @if(@$data->ir_report->report_date=="") Prepare Report @else Update Report @endif
                                         </a>

                                         @if(@$data->ir_report->report_date!="")
                                         <a href="{{route('member.get.information.report.assignment.intel.project.report.page.prepare.report.view-report',@$data->id)}}"class="btn btn-xs btn-warning " target="_blank">View</a>

                                         <a href="{{route('member.get.information.report.assignment.intel.project.report.page.prepare.report.pdf-report',@$data->id)}}"class="btn btn-xs btn-warning " target="_blank">PDF</a>
                                         @endif
                                        </td>
                                    </tr>
                                   
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
<div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Report</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('member.get.information.report.assignment.intel.project.report.page.insert.data')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ip_id" value="{{@$id}}">
                <div class="form-group">
                  <label for="exampleInputEmail1">Recommendation</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="recomendation" aria-describedby="emailHelp" placeholder="Recommendation Name">
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">Conduct On</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="condut_on" aria-describedby="emailHelp">
                 </div>

                 

                 <div class="form-group">
                  <label for="exampleInputEmail1">Attachment</label>
                  <input type="file" class="form-control" id="exampleInputEmail1" name="attachment" aria-describedby="emailHelp">
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Report</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('member.get.information.report.assignment.intel.project.report.page.update.data')}}">@csrf
                                
                               <div class="form-group">
                                  <label for="exampleInputEmail1">Recommendation</label>
                                  <input type="text" class="form-control" id="recomendation" name="recomendation" aria-describedby="emailHelp" placeholder="Recommendation Name">
                                 </div>


                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Conduct On</label>
                                  <input type="date" class="form-control" id="condut_on" name="condut_on" aria-describedby="emailHelp">
                                 </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Attachment</label>
                              <input type="file" class="form-control" id="exampleInputEmail1" name="attachment" aria-describedby="emailHelp">
                             </div>

                                 
                             <input type="hidden" name="id" id="id">
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
<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#recomendation').val($(this).data('recomendation'));
            $('#condut_on').val($(this).data('condut_on'));
            $('#id').val($(this).data('id'));
            $('#exampleModaEdit').modal('show');
        })
</script>


@endsection