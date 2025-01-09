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
                                List Of Assigned Cases
                            </div>
                           </div>
                    </div>

                    


                        <div class = "card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <form method="post" id="form_submit" action="{{route('ces.cases.listing.availability.update')}}">
                                @csrf  
                                <input type="hidden"  class="id_value" name="id_value">
                                        <input type="hidden" name="optradio_value" class="optradio_value" >  
                            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Complaint Registration No.</th>
                                        <th>Complaint Registration Date</th>
                                        <th>Complaint Title</th>
                                        <th>Complaint Brief</th>
                                        <th>Allegation Name</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$data->isNotEmpty())
                                    
                                    @foreach(@$data as $key=> $att)
                                    <tr @if($att->appraise_direcor_status=="IN") style="background-color:red;color:white" @endif>
                                        <td>{{ @$att->appraise_details->eve_offence_details->complaint_details->complaintID}}</td>
                                        <td>{{ @$att->appraise_details->eve_offence_details->complaint_details->complaintRegNo}}</td>

                                        <td>{{ @$att->appraise_details->eve_offence_details->complaint_details->complaintDateTime }}</td>
                                        <td>{{ @$att->appraise_details->eve_offence_details->complaint_details->complaintTitle}}</td>
                                        <td>{!! substr(@$att->appraise_details->eve_offence_details->complaint_details->complaintDetails,0,350) !!}</td>
                                        <td>{{ @$att->appraise_details->eve_offence_details->allegation_name}}</td>
                                        
                                        <td>
                                            
                                                @if(@$att->coi_status!="AA")
                                                <a href="{{route('administrative.inquiry.plan.official.get.list.view.details',$att->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                                @else
                                                <a href="{{route('administrative.inquiry.plan.official.get.list.coi.page',$att->id)}}" class="btn btn-warning">COI</a>
                                                @endif

                                                
                                                

                                            

                                        </td>
                                    </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>
                            </form>        
                        </div>
                </div>
            </div>
        </div>


        
    </div>
</section>



<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" charset="utf8"
    src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});


</script>


@endsection