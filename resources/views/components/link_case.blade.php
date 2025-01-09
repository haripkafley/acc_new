        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Linked Case List </div>

                        <div class = "card-body">
                         
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Date</th>
                                        <th>Complaint Reg. No.</th>
                                        <th>Complaint Title</th>
                                        <th>Mode</th>
                                        <th>Type</th>
                                        <th>Link Status</th>  
                                                 
                                    </tr>
                                </thead>
                                <tbody>

                                    


                                    @if(@$person_involved->isNotEmpty())
                                    @foreach(@$person_involved as $value)
                                    <tr>
                                    {{-- <td>{{@$value->repeatedID}}</td> --}}
                                    <td>{{@$value->repeatedComplaint_registrationRelation->updated_at}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintRegNo}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintTitle}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintmoderelation->modeName}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintTyperelation->complainttypeName}}</td>
                                    <td> Linked</td>
                                    
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