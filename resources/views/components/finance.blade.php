        <div class="row">
            
            <div class="col-md-12">
                <div class="card">
                    <p>Financial Implication : {{@$data->financial_implication_amount}}</p>
                </div>
            </div>

            @if(@$finance->land=="Y")
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Land Details </div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Dzongkhag / Thromde</th>
                                        <th>Gewog</th>
                                        <th>Area</th>
                                        <th>Thram No.</th>
                                        <th>Plot No.</th>
                                        <th>Amount Involved</th>
                                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$LandDetails->isNotEmpty())
                                    @foreach(@$LandDetails as $att)
                                    <tr>
                                        <td>{{ $att->dzongkhagrelation->dzoName }}</td>
                                        <td>{{ $att->gewogrelation->gewogName }}</td>
                                        <td>{{ $att->area }}</td>
                                        <td>{{ $att->tham_no }}</td>
                                        <td>{{ $att->plot_no }}</td>
                                        <td>{{ $att->amount }}</td>
                                       
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
            @endif



            @if(@$finance->procurement_work=="Y")
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Procurement Work </div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Dzongkhag / Thromde</th>
                                        <th>Gewog</th>
                                        <th>Goods / Service Description</th>
                                        <th>Contractor</th>
                                        <th>Amount Involved</th>
                                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$ProcurementGoods->isNotEmpty())
                                    @foreach(@$ProcurementGoods as $att)
                                    <tr>
                                        <td>{{ $att->dzongkhagrelation->dzoName }}</td>
                                        <td>{{ $att->gewogrelation->gewogName }}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->contractor }}</td>
                                        <td>{{ $att->amount }}</td>
                                       
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
            @endif



            @if(@$finance->procurement_good=="Y")
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Procurement Goods And Services </div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                       <th>Dzongkhag / Thromde</th>
                                        <th>Gewog</th>
                                        <th>Goods / Service Description</th>
                                        <th>Supplier</th>
                                        <th>Amount Involved</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @if(@$ProcurementGoodService->isNotEmpty())
                                    @foreach(@$ProcurementGoodService as $att)
                                    <tr>
                                       <td>{{ $att->dzongkhagrelation->dzoName }}</td>
                                        <td>{{ $att->gewogrelation->gewogName }}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->supplier }}</td>
                                        <td>{{ $att->amount }}</td>
                                       
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
            @endif




            @if(@$finance->personnel=="Y")
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans">  Personnel Details</div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Agency</th>
                                        <th>Activity</th>
                                        <th>Description</th>
                                        <th>Amount Involved</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @if(@$Personnel->isNotEmpty())
                                    @foreach(@$Personnel as $att)
                                    <tr>
                                        <td>{{ $att->agency }}</td>
                                        <td>{{ $att->activity }}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->amount }}</td>
                                       
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
            @endif




            @if(@$finance->political=="Y")
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans">  Political Details</div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Reason</th>
                                        <th>Description</th>
                                        <th>Amount Involved</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @if(@$Political->isNotEmpty())
                                    @foreach(@$Political as $att)
                                    <tr>
                                        <td>{{ $att->reason }}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->amount }}</td>
                                       
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
            @endif




            @if(@$finance->policy=="Y")
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans">  Policy Details</div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                       <th>Description</th>
                                       <th>Amount Involved</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @if(@$PolicyComplaint->isNotEmpty())
                                    @foreach(@$PolicyComplaint as $att)
                                    <tr>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->amount }}</td>
                                       
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
            @endif



            @if(@$finance->natural_resource=="Y")
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans">  Natural Resource Details</div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Sector</th>
                                        <th>Resource</th>
                                        <th>Description</th>
                                        <th>Amount Involved</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @if(@$NaturalResource->isNotEmpty())
                                    @foreach(@$NaturalResource as $att)
                                    <tr>
                                        <td>{{ $att->sector }}</td>
                                        <td>{{ $att->resource }}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->amount }}</td>
                                       
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
            @endif
        













        </div>