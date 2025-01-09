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

        



    {{-- table-showing --}}
    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Storage - Properties
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Item Code</th>
                                        <th>Room No</th>
                                        <th>Rack No</th>
                                        <th>Column No</th>
                                                  
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$storage->isNotEmpty())
                                    @foreach(@$storage as $att)
                                    <tr>
                                        <td>{{ $att->item }}</td>
                                        <td>{{ $att->item_code }}</td>
                                        <td>{{ $att->room_no }}</td>
                                        <td>{{ $att->rack_no }}</td>
                                        <td>{{ $att->column_no }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>


                        <div class = "card-body">
                            <h5>
                              Storage - Cash
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Amount</th>
                                        <th>Received On</th>
                                        <th>Time of Receipt</th>
                                        <th>Source</th>
                                        <th>Location of the amount</th>
                                              
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$cash->isNotEmpty())
                                    @foreach(@$cash as $att)
                                    <tr>
                                        <td>{{ $att->amount }}</td>
                                        <td>{{ $att->date_receipt }}</td>
                                        <td>{{ $att->time_receipt }}</td>
                                        <td>{{ $att->source }}</td>
                                        <td>{{ $att->location_amount}}</td>
                                        
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>


                        <div class = "card-body">
                            <h5>
                              Maintenance Log
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Location</th>
                                        <th>Maintenance Carried by</th>
                                        <th>Expenditure Amount</th>
                                        <th>Document Evidence</th>
                                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$maintain->isNotEmpty())
                                    @foreach(@$maintain as $att)
                                    <tr>
                                        <td>{{ $att->item_details->item }}</td>
                                        <td>{{ $att->date }}</td>
                                        <td>{{ $att->maintenance_type }}</td>
                                        <td>{{ $att->location }}</td>
                                        <td>{{ $att->carried_by}}</td>
                                        <td>{{ $att->amount}}</td>
                                        <td><a class="btn btn-xs btn-info" href="{{URL::to('custody/evidence')}}/{{$att->evidence}}" target="_blank">
                                       <i class="fa fa-eye"></i>Attachment </a></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>


                        <div class = "card-body">
                            <h5>
                              Chain of Custody
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Issued To</th>
                                        <th>Issued by</th>
                                        <th>Date & Time of Issueance</th>
                                        <th>Returned by</th>
                                        <th>Returned date & time</th>
                                        <th>Received by</th>
                                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$chain->isNotEmpty())
                                    @foreach(@$chain as $att)
                                    <tr>
                                        <td>{{ $att->item_details->item }}</td>
                                        <td>{{ $att->issued_to }}</td>
                                        <td>{{ $att->issued_by }}</td>
                                        <td>{{ $att->issue_date }} - {{@$att->issue_time}}</td>
                                        <td>@if(@$att->return_by=="") -- @else {{ $att->return_by}} @endif</td>
                                        <td>@if(@$att->return_date=="") -- @else {{ $att->return_date}} - {{$att->return_time}} @endif</td>

                                        <td>@if(@$att->received_by=="") -- @else {{ $att->received_by}} @endif</td>

                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>


                        <div class = "card-body">
                            <h5>
                              Valuation
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Date of Valuation</th>
                                        <th>Value / Worth</th>
                                        <th>Competent Authorit</th>
                                        <th>Report</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @if(@$valuation->isNotEmpty())
                                    @foreach(@$valuation as $att)
                                    <tr>
                                        <td>{{ $att->item_details->item }}</td>
                                        <td>{{ $att->date }}</td>
                                        <td>{{ $att->worth }}</td>
                                        <td>{{ $att->competen }}</td>
                                        <td><a class="btn btn-xs btn-info" href="{{URL::to('custody/report')}}/{{$att->report}}" target="_blank">
                                       <i class="fa fa-eye"></i>Attachment </a></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>



                        <div class = "card-body">
                            <h5>
                              Lease & Hiring
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Action Type</th>
                                        <th>Leased To</th>
                                        <th>Name</th>
                                        <th>CID/License No</th>
                                        <th>Date Range</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @if(@$lease->isNotEmpty())
                                    @foreach(@$lease as $att)
                                    <tr>
                                        <td>{{ $att->item_details->item }}</td>
                                        <td>@if(@$att->action_type=="L") Lease @else Hiring @endif</td>
                                        <td>@if(@$att->leased_to=="B") Business @else Individual @endif</td>
                                        <td>{{ $att->name }}</td>
                                        <td>@if(@$att->leased_to=="B") {{@$att->license}} @else {{@$att->cid}} @endif</td>
                                        <td>{{@$att->start_date}} - {{@$att->end_date}}</td>
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

     
</section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   




@endsection