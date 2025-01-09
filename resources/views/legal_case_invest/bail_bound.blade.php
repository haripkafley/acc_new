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
                                 Bail and Bond
                            </div>

                            
                           </div>


                    </div>

                    


                        <div class = "card-body">
                            
                              @include('legal_case_invest.navbar')
                            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        
                                        <th>Sl. No</th>
                                        <th>Name</th>
                                        <th>CID</th>    
                                        <th>Type</th>         
                                        <th>Details of Sureties (Name, CID & Contact No.)</th>    
                                        <th>Bond Details</th>    
                                        <th>Return Date</th>  
                                        <th>Agreement</th>    
                                    <tr>
                                </thead>
                                <tbody>
                                    <tr><td>No Data Found</td></tr>
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