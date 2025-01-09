@extends('layouts.admin')

@section('content')

    <br>
    <section class="content">
        <div id="casedetailscard" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        
                        <div class="card-body">
                        Welcome {{auth()->user()->name}}
                       </div>

                       <div class="row">

                        <div class="col-md-6">

                            <div class="card-body">
                                <form method="POST" action="{{route('welcome.dashboard.view')}}">
                                    @csrf
                                    <div class="form-group">
                                        <select class="form-control" name="year_filter" onchange="form.submit()">
                                            @foreach(@$years as $value)
                                             <option value="{{@$value}}" @if(request('year_filter')==@$value) selected @endif>{{@$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                                <table id="maintableDz" class="table table-striped">
                                    <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Month</th>
                                        <th>No. of Complaints</th>
                                     </tr>
                                   </thead>

                                   <tbody>
                                        <tr>
                                            <td>January</td>
                                            <td>{{@$january}}</td>
                                        </tr>

                                        <tr>
                                            <td>February</td>
                                            <td>{{@$february}}</td>
                                        </tr>


                                        <tr>
                                            <td>March</td>
                                            <td>{{@$march}}</td>
                                        </tr>


                                        <tr>
                                            <td>April</td>
                                            <td>{{@$april}}</td>
                                        </tr>

                                        <tr>
                                            <td>May</td>
                                            <td>{{@$may}}</td>
                                        </tr>


                                        <tr>
                                            <td>June</td>
                                            <td>{{@$june}}</td>
                                        </tr>


                                        <tr>
                                            <td>July</td>
                                            <td>{{@$july}}</td>
                                        </tr>


                                        <tr>
                                            <td>August</td>
                                            <td>{{@$august}}</td>
                                        </tr>

                                        <tr>
                                            <td>September</td>
                                            <td>{{@$september}}</td>
                                        </tr>


                                        <tr>
                                            <td>October</td>
                                            <td>{{@$october}}</td>
                                        </tr>


                                        <tr>
                                            <td>November</td>
                                            <td>{{@$november}}</td>
                                        </tr>

                                        <tr>
                                            <td>December</td>
                                            <td>{{@$december}}</td>
                                        </tr>
                                   




                                   </tbody>



                                </table>

                            </div>

                        </div>


                         <div class="col-md-6">

                            <div class="card-body">
                                <h4>Complaint Evaluation Statistics</h4>

                                <table id  = "maintable" class="table table-striped " >
                                
                                    <tr>
                                        <td>Complaints Pending CEC</td> 
                                        <td>{{@$pending_cec}}</td>           
                                    </tr>

                                    <tr>
                                        <td>Complaints Pending CM</td> 
                                        <td>{{@$pending_com}}</td>           
                                    </tr>


                                    <tr>
                                        <td>ATR Pending CEC</td> 
                                        <td>{{@$atr_pending_cec}}</td>           
                                    </tr>

                                    <tr>
                                        <td>ATR Pending CM</td> 
                                        <td>{{@$atr_pending_com}}</td>           
                                    </tr>


                                    
                                </table>
                               
                            </div>


                            <div class="card-body">
                                <h4>ATR Statistics</h4>

                                <table id  = "maintable" class="table table-striped " >
                                
                                    <tr>
                                        <td>Total Shared for Action</td> 
                                        <td>{{@$for_action}}</td>           
                                    </tr>

                                    <tr>
                                        <td>Total Shared for Sensitization</td> 
                                        <td>{{@$sensitization}}</td>           
                                    </tr>


                                    

                                   

                                </table>
                               
                            </div>
                        </div>



                        <div class="col-md-12">

                            <div class="card-body">
                                <h4>Appraisal Statistics</h4>

                                <table id  = "maintable" class="table table-striped " >
                                    <thead class="thead-dark">
                                        <th>Office</th>
                                        <th>Complaint</th>
                                        <th>ATR</th>
                                     </thead>

                                    <tbody>
                                        <tr>
                                            <td>Head Office</td>
                                            <td>{{@$head_office_complaint}}</td>
                                            <td>{{@$total_head_office_atr}}</td>
                                            
                                        </tr>

                                        <tr>
                                            <td>RO Tashigang</td>
                                            <td>{{@$tashigangcomplaint}}</td>
                                            <td>0</td>
                                            
                                        </tr>


                                        <tr>
                                            <td>RO Paro</td>
                                            <td>{{@$parocomplaint}}</td>
                                            <td>1</td>
                                            
                                        </tr>

                                        <tr>
                                            <td>RO Paro</td>
                                            <td>{{@$phuncomplaint}}</td>
                                            <td>0</td>
                                            
                                        </tr>
                                    </tbody>
                                    
                                </table>
                               
                            </div>

                       </div>


                        
                    </div>
                </div>
            </div>


           




        </div>
    </section>


    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>





@endsection
