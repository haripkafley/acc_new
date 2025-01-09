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
                                Legal Service Requests
                            </div>

                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <a  href="{{route('legal.service.request.page.add.request')}}" class="btn btn-primary" >
                                    New Request
                                </a>
                                
                            </div>
                           </div>


                    </div>

                    


                        <div class = "card-body">
                            
                              
                            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        
                                        <th>Service Requested</th>
                                        <th>Brief Description of Service</th>
                                        <th>Date</th>
                                        <th>Duration From</th> 
                                        <th>Duration To</th> 
                                        <th>Purpose</th> 
                                        <th>Reference</th> 
                                        <th>Assign To</th>   
                                        <th>Action</th>         
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$data->isNotEmpty())
                                    
                                    @foreach(@$data as $key=> $att)
                                    <tr>
                                        <td>{{ @$att->service_request}}</td>
                                        <td>{{ $att->description}}</td>
                                        <td>{{ $att->date }}</td>
                                        <td>{{ $att->from_duration }}</td>
                                        <td>{{ $att->to_duration}}</td>
                                        <td>{{ $att->purpose}}</td>
                                        <td>
                                            @if(@$att->attachment=="") No Attachment @else 
                                            <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/legal_request')}}/{{$att->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                Attachment
                                            </a>
                                            @endif
                                        </td>
                                        <td>@if($att->assign_official_id=="") Not Assigned @else {{@$att->user_details->name}} @endif</td>
                                        
                                        
                                        
                                        <td>
                                           
                                                <a href="{{route('legal.service.request.page.asign.user.request',$att->id)}}" class="btn btn-info">@if($att->assign_official_id=="")  <i class="fa fa-user" title="Assign"></i> @else <i class="fa fa-user" title="Reassign"></i> @endif</a>
                                                <a href="{{route('legal.service.request.page.edit.request',$att->id)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                                <a href="{{route('legal.service.request.page.delete.request',$att->id)}}" onclick="return confirm('Are you sure want to delete this request ?')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                

                                            

                                        </td>
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
<script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});

$(".radio_option:radio").on('change',function(){
   
    $('.id_value').val($(this).data('id'));
    $('.optradio_value').val($(this).val());
    
    $('#form_submit').submit();
});
</script>


@endsection