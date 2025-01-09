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
                                Legal Prosecution
                            </div>

                            
                           </div>


                    </div>

                    


                        <div class = "card-body">
                            
                              
                            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        
                                        <th>Case No</th>
                                        <th>Case Title</th>
                                        <th>Date of Referral</th>
                                        <th>Assign To</th>
                                        <th>Action</th>         
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$data->isNotEmpty())
                                    
                                    @foreach(@$data as $key=> $att)
                                    <tr>
                                        @php
                                        $check = \App\Models\Legal\ProsecutionAssign::with('user_details')->where('case_id',$att->id)->first();
                                        @endphp
                                        <td>{{ @$att->case_no}}</td>
                                        <td>{{ $att->case_title}}</td>
                                        <td></td>
                                        <td>@if($check=="") Not Assigned @else {{@$check->user_details->name}} @endif</td>
                                        <td>
                                                <a href="{{route('prosecution.legal.chief.list.view.details',$att->id)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>

                                                <a href="{{route('prosecution.legal.chief.assign.official',$att->id)}}" class="btn btn-warning">@if($check=="")<i class="fa fa-user" title="Assign"></i> @else <i class="fa fa-user" title="Reassign"></i> @endif</a>

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