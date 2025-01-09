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
                              Intel Event
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
                                        <th>Event Name</th>
                                        <th>Event Date</th>
                                        <th>Event Time</th>
                                        <th>Event Description</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    @if(@$event->isNotEmpty())
                                    @foreach(@$event as $att)
                                    <tr>
                                        <td>{{ $att->name}}</td>
                                        <td>{{ $att->event_date }}</td>
                                        <td>@if($att->event_time!="" ){{ $att->event_time }} @else -- @endif</td>
                                        <td>{{ $att->description }}</td>
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


        <!-- Modal -->


    </div>
</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>



@endsection