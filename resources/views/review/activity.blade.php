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

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
       
      </ul>



        
            <div class="row">
              


                <div class="col-sm-12">
                    <div class="card">
                    <p><b>Complaint No:</b> {{@$complaint->complaintRegNo}}</p>

                    <p><b>Complaint TItle:</b> {{@$complaint->complaintTitle}}</p>

                    <p><b>Date Time:</b> {{@$complaint->complaintDateTime}}</p>

                    <p><b>Complaint Brief:</b> {!!@$complaint->complaintDetails!!}</p>
                    <p><b>Allegation:</b> {!!@$eve_offence_details->allegation_name!!}</p>
                    <p><b>Allegation Details:</b> {!!@$eve_offence_details->allegation_description  !!}</p>

                   

                    
               </div>
                   
            </div>




                             <div class="col-sm-12">
                    <div class="card">
                    <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Review Actitives
                                </div>

                                

                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa3" style="float: right;">
                                        + Add Acitivity
                                    </button>
                                   
                                </div>
                            </div>
                    <div class="card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}


                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        
                                        <th>Date</th>
                                        <th>Activity Type</th>
                                        <th>Activity Brief</th>
                                        <th>Attachment</th>
                                        <th>Updated By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$activities->isNotEmpty())
                                        @foreach (@$activities as $att)
                                            <tr>
                                                <td>{{@$att->activity_date}}</td>
                                                <td>{{@$att->activity_type}}</td>
                                                <td>{{@$att->description}}</td>
                                                <td><a href="{{URL::to('attachment/review_activity')}}/{{$att->attachment}}" class="btn btn-primary" target="_blank">View</a></td>
                                                <td>{{@$att->user_details->name}}</td>
                                                

                                                
                                                
                                                <td>
                                                    
                                                            
                                                     
                                                   

                                                   @if(@$att->user_id==auth()->user()->id)
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{route('assign.review.complaint.listing.activity.delete',@$att->id)}}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        
                                                    </a>
                                                    @endif

                                                    
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
    </div>


            

             

                









                <div class="modal fade" id="exampleModa3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Add  Members</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('assign.review.complaint.listing.activity.insert') }}" enctype="multipart/form-data">@csrf
                                <input type="hidden" name="eve_offence_id" value="{{@$eve_offence_id}}">
                                

                                

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Activity Date</label>
                                    <input type="date" name="activity_date" id="activity_date" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Activity Type</label>
                                    <select class="form-control" name="activity_type" required>
                                        <option value="">Select</option>
                                        <option value="Complaint Review">Complaint Review</option>
                                        <option value="Independent Review">Independent Review</option>
                                        <option value="Joint Review">Joint Review</option>
                                        <option value="Field Review">Field Review</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Activity Description</label>
                                    <textarea class="form-control" name="description" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Attachment</label>
                                    <input type="file" name="attachment" id="attachment" class="form-control"  required>
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
                






               
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   






@endsection