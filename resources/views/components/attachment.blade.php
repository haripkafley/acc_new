        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Attachment List </div>

                        <div class = "card-body">
                            <h5>
                              <small>Attachments related to the complaint (Only PDF files are allowed)</small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Attachment Name</th>
                                        <th>Detail</th>
                                        {{-- <th>File Size</th> --}}
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->CRattachmentID }}</td>
                                        <td>{{ $att->created_at }}</td>
                                        <td>{{ $att->CRattachmentName }}</td>
                                        <td>{{ $att->CRattachmentDetails }}</td>
                                        <td>
                                                        <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/complaintRegistration')}}/{{$att->AttachmentPath}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a>
                                                            
                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Attachment Found Againt This Complaint</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>