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
                                Assigned List of Cases with Seized Properties
                            </div>

                            
                           </div>


                    </div>

                    


                        <div class = "card-body">
                            
                              
                            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        
                                        <th>Case No</th>
                                        <th>Case Title</th>
                                        <th>Registration Date</th>
                                        <th>Action</th>         
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$data->isNotEmpty())
                                    
                                    @foreach(@$data as $key=> $att)
                                    <tr>
                                        @php
                                        $case_details = DB::table('tbl_registered_cases')->where('id',@$att->case_id)->first();
                                        @endphp
                                        <td>{{ @$case_details->case_no}}</td>
                                        <td>{{ $case_details->case_title}}</td>
                                        <td>{{ $case_details->creation_date}}</td>
                                        
                                        <td>
                                           
                                                <a href="{{route('manage.get-assign-official-seized-properties-list.receipt.details',$att->id)}}" class="btn btn-warning">Receipt Of Properties</a>

                                                <a href="{{route('manage.get-assign-official-seized-properties-list.escrow.account',$att->id)}}" class="btn btn-primary">ESCROW Account</a>

                                                <a href="{{route('manage.get-assign-official-seized-properties.custody.details',$att->id)}}" class="btn btn-success">Custody</a>

                                                <a href="{{route('manage.get-assign-official-seized-properties.disposal.auction.details',$att->id)}}" class="btn btn-success">Disposal</a>
                                                

                                            

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