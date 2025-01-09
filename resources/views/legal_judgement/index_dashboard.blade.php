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
                               Judgment Review
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
                                        <th>Judgment Date</th>
                                        <th>Court</th>
                                        
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
                                        <td>{{@$att->judge_date}}</td>
                                        <td>{{@$att->court_name}} ({{@$att->judge_court}})</td>
                                        
                                        

                                        
                                        <td>
                                                <a href="{{route('get.assign.judgement.legal.list.judgement.details',$att->id)}}" class="btn btn-warning"><i class="fa fa-eye"></i></a>

                                                <a href="{{route('get.assign.judgement.legal.review.legal.page',$att->id)}}" class="btn btn-info">Review</a>

                                                <a href="{{route('get.assign.judgement.legal.appraisal.page',$att->id)}}" class="btn btn-danger">Appraisal</a>

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