
                @foreach ($Mainarrest as $data)
                   
                        <div class="row">
                            <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Type of Arrest & Detention Requested:</label>
                                    <br>
                                    {{ $data->typeofArrest }}
                                  </div>
                            </div>
                        
                            <div class="col-md-4">
                                  <div class="form-group">
                                    <label> Location:</label>
                                    <br>
                                    {{ $data->location }}
                                  </div>
                            </div>
                        
                            <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Application Date</label>
                                    <br>
                                    {{ $data->applicationdate }}
                                  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                  <div class="form-group">
                                    <label> Probable Offence:</label>
                                    {!! $data->pcause !!}
                                  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                  <div class="form-group">
                                    <label> Status:</label>
                                        @if($data->commissionStatus=='Approved')
                                            <label class="text-success">Approved</label>
                                        @elseif($data->commissionStatus=='Reject')
                                            <label class="text-danger">Rejected</label>
                                        @elseif($data->commissionStatus=='Detained')
                                            <label class="text-danger">Detained</label>
                                        @elseif($data->commissionStatus==0)
                                            <label class="text-warning">Pending</label>
                                        @endif
                                  </div>
                            </div>
                        </div>
                        
                @endforeach
                
                