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
                              ESCROW - Accused
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>CID</th>
                                        <th>Name of the Accused</th>
                                        <th>Date & Time of Return</th>
                                        <th>Amount</th>
                                        <th>Reference</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$accused->isNotEmpty())
                                    @foreach(@$accused as $att)
                                    <tr>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->date }} - {{ $att->time }}</td>
                                        <td>{{ $att->amount }}</td>
                                        <td><a class="btn btn-xs btn-info" href="{{URL::to('disposal/reference')}}/{{$att->reference}}" target="_blank">
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
                              ESCROW - Agency
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name of the Agency</th>
                                        <th>Date & Time of Return</th>
                                        <th>Handed Over To</th>
                                        <th>Amount</th>
                                        <th>Reference</th>
                                             
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$agency->isNotEmpty())
                                    @foreach(@$agency as $att)
                                    <tr>
                                        @php
                                        $ageny = DB::table('pl_tblagency')->where('agencyID',$att->agency)->first();
                                        @endphp
                                        <td>{{ $ageny->agencyName }}</td>
                                        <td>{{ $att->date }} - {{ $att->time }}</td>
                                        <td>{{ $att->handed_over_to }}</td>
                                        <td>{{ $att->amount }}</td>
                                        <td><a class="btn btn-xs btn-info" href="{{URL::to('disposal/reference')}}/{{$att->reference}}" target="_blank">
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
                              Auction
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Date</th>
                                        <th>Venue</th>
                                        <th>Auction Committee</th>
                                        <th>Name of Winning bidder</th>
                                        <th>CID of Winning Bidder</th>
                                                 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$auction->isNotEmpty())
                                    @foreach(@$auction as $att)
                                    <tr>
                                        <td>{{ @$att->item_details->item }}</td>
                                        <td>{{ $att->date }}</td>
                                        <td>{{ $att->venue }}</td>
                                        <td>{{ $att->auction_com }}</td>
                                        <td>{{ $att->win_bidder }}</td>
                                        <td>{{ $att->cid_bidder }}</td>
                                       
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
                              Return / Handing Over of seized Item
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Date</th>
                                        <th>Handed Over By</th>
                                        <th>Handed Over To</th>
                                        <th>Handing Taking Over Form</th>
                                        <th>Documentary Attrachment</th>
                                                 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$return->isNotEmpty())
                                    @foreach(@$return as $att)
                                    <tr>
                                        <td>{{ @$att->item_details->item }}</td>
                                        <td>{{ $att->date }}</td>
                                        <td>{{ $att->handed_over_by }}</td>
                                        <td>{{ $att->handed_over_to }}</td>
                                        <td>
                                        <a class="btn btn-xs btn-info" href="{{URL::to('disposal/handling_file')}}/{{$att->handling_file}}" target="_blank">
                                        <i class="fa fa-eye"></i>Attachment </a>
                                       </td>

                                        <td>
                                        <a class="btn btn-xs btn-info" href="{{URL::to('disposal/evidence')}}/{{$att->evidence}}" target="_blank">
                                        <i class="fa fa-eye"></i>Attachment </a>
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

     
</section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   




@endsection