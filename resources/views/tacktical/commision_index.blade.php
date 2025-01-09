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
                              Tactical Intelligence Request
                            </div>
                            
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>TI Type</th>
                                        <th>Request Type</th>
                                        <th>Suspect Details</th>
                                        <th>In Relation To</th>
                                        <th>Requesting Officer</th>
                                        <th>Request Date</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Running Days</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>@if(@$att->type_ti=="IG") Information Gathering @else Surveillance @endif </td>
                                        <td>{{ @$att->request_type_details->name }}</td>
                                        <td>{{ $att->suspect_details }}</td>
                                        <td>{{ $att->relation_to }}</td>
                                        <td>{{ $att->officer_details->name }}</td>
                                        <td>{{ $att->request_date }}</td>
                                        <td>{{ $att->start_date }}</td>
                                        <td>{{ $att->end_date }}</td>
                                        <td>
                                            @php
                                            $from = Carbon\Carbon::parse(@$att->request_date);
                                            $to = Carbon\Carbon::now();
                                            $days =  $from->diffInDays($to);
                                            @endphp

                                            {{@$days}} Days

                                           </td>
                                        <td>
                                                        
                                                            
                                                             
                                                            
                                                            
                                                            
                                                            <a class="btn btn-xs btn-warning" href="{{route('view.tactical-inteligence.authorization.complete.details',['id'=>$att->id])}}" ><i class="fa fa-eye"></i>
                                                                View
                                                            </a>


                                                            @if($att->team_assign=="N")
                                                            <a class="btn btn-xs btn-success mt-2" href="{{route('tacktical.inteligence.autorization.form.commission-decision',['id'=>$att->id])}}" ><i class="fa fa-edit"></i>
                                                                Update Decision 
                                                            </a>
                                                            @endif
                                                           
                                                            
                                                            
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




    </div>
</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



@endsection