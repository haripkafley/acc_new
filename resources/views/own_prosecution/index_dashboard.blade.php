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
                                Own Prosecution
                            </div>

                            
                           </div>


                    </div>

                    


                        <div class = "card-body">
                            
                              
                            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name of Accused</th>
                                        <th>CID</th>
                                        <th>Case No</th>
                                        <th>Case Title</th>
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th>Action</th>         
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$data->isNotEmpty())
                                    
                                    @foreach(@$data as $key=> $att)
                                    <tr>
                                        <td>{{@$att->case_withdrawn_details->accused_name}}</td>
                                        <td>{{@$att->case_withdrawn_details->cid}}</td>
                                        <td>{{ @$att->case_withdrawn_details->case_details->case_no}}</td>
                                        <td>{{ @$att->case_withdrawn_details->case_details->case_title}}</td>
                                        <td>
                                            @if(@$att->assign_id_own=="") Not Assigned @else {{@$att->user_details->name}} @endif
                                        </td>
                                        <td>
                                            @if(@$att->own_status=="") Not Updated @else {{@$att->own_status}} @endif
                                        </td>

                                        
                                        <td>
                                                <a href="{{route('own.prosecution.get.assign.official.case.status.update-view-page',$att->id)}}" class="btn btn-warning"><i class="fa fa-eye"></i></a>

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


</script>


@endsection