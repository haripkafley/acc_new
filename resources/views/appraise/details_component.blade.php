                <div class="col-sm-12">
                    <div class="card">
                    <p><b>Complaint No:</b> {{@$data->eve_offence_details->complaint_details->complaintRegNo}}</p>

                    <p><b>Complaint TItle:</b> {{@$data->eve_offence_details->complaint_details->complaintTitle}}</p>

                    <p><b>Date Time:</b> {{@$data->eve_offence_details->complaint_details->complaintDateTime}}</p>

                    <p><b>Complaint Decription:</b> {!!@$data->eve_offence_details->complaint_details->complaintDetails!!}</p>

                    <p><b>Allegation:</b> {!!@$data->eve_offence_details->allegation_name!!}</p>
                    <p><b>Allegation Details:</b> {!!@$data->eve_offence_details->allegation_description    !!}</p>

                   

                    
               </div>
                   
            </div>


            <div class="col-sm-12">
                    <div class="card">
                    
                         <div class="card-body">
                            <h5>
                              <small>List Of Reviews</small>
                            </h5>


                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        
                                        <th>Date</th>
                                        <th>Activity Type</th>
                                        <th>Activity Brief</th>
                                        <th>Attachment</th>
                                        <th>Updated By</th>
                                        
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