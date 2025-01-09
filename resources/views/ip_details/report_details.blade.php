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
                              
                                
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('ip_details.head_navbar')
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