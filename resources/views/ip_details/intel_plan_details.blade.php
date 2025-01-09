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
                              Intel Plan
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            
                            @include('ip_details.head_navbar')
                            <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.hypothesis')) active btn btn-success @endif"  href="{{route('manage.ip.lists.head.chief.details.hypothesis',['id'=>@$id])}}"> Hypothesis</a>
                                </li>

                                
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.plan.intel')) active btn btn-success @endif"  href="{{route('manage.ip.lists.head.chief.details.plan.intel',['id'=>@$id])}}">Task Details</a>
                                </li>

                                
                            </ul>
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}

                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" action="{{route('manage.ip.lists.head.chief.details.plan.intel',@$id)}}">
                                        @csrf
                                        <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Hypothesis</label>
                                          <select class="form-control" name="hypo_id" required>
                                              <option value="">Select</option>
                                              @foreach(@$hypo as $value)
                                              <option value="{{@$value->id}}" @if(request('hypo_id')==@$value->id) selected @endif>{{@$value->hypo_sl_number}}</option>
                                              @endforeach
                                          </select>
                                         </div>
                                         </div>
                                         <div class="col-md-6"><button type="submit" class="btn btn-primary mt-4">Search</button></div>
                                     </div>
                                    </form>
                                </div>
                            </div>


                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Hypothesis</th>
                                        <th>Task</th>
                                        <th>Collected From</th>
                                        <th>Type Of Source</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Collection Officer</th>
                                        <th>Status</th>
                                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$plan->isNotEmpty())
                                    @foreach(@$plan as $att)
                                    <tr>
                                        <td>{{ @$att->hypo_details->hypo_sl_number}}</td>
                                        <td>{{ $att->task}}</td>
                                        <td>{{ $att->collected_from }}</td>
                                        <td>{{ $att->source_name->name }} (Type - {{@$att->source_type}} )</td>
                                        <td>{{ $att->start_date }}</td>
                                        <td>{{ $att->end_date }}</td>
                                        <td>
                                            @php
                                                $explode = explode(',',$att->officer_assign_id);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}},
                                            @endforeach

                                        </td>
                                        <td>{{ @$att->status_details->name }}</td>
                                        
                                        
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