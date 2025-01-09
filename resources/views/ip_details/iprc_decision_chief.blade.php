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
                              IPRC DECISION
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('ip_details.head_navbar')
                            
                           
                                <input type="hidden" name="ip_id" value="{{@$id}}">
                                <div class="form-group">
                                    <label>Decision</label>
                                    <select class="form-control" disabled name="decision" id="decision">
                                        <option value="AA" @if(@$decision->decision=="AA") selected @endif>Awating</option>
                                        <option value="Y" @if(@$decision->decision=="Y") selected @endif>Yes</option>
                                        <option value="N" @if(@$decision->decision=="N") selected @endif>No</option>
                                    </select>
                                </div>

                                <div class="form-group information" @if(@$decision->decision=="N") style="display:block" @else style="display:none" @endif>
                                    <label>Additional Information</label>
                                    <textarea class="form-control" disabled name="information">{{@$decision->information}}</textarea>
                                </div>

                                
                            
                            

                            
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



@endsection