@extends('layouts.admin')

@section('content')
<br>
@include('investigator/mainheader')
    <!------------------------ end top part ---------------->
<div class="col-sm-13" style="margin-top:-9px;">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                @include('tabs/investigator_tab')
            </div>
            <div class="card-body">
                
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    @if(Auth::user()->role == "Investigator")
                    <form id="my-form" action="{{ route('updateinvplanstatus') }}" method="POST">
                            @csrf
                                @if($invcount != 0 && $hypothesiscount != 0 && $actionplancount != 0 && $invstatus == 0)
                                    <input type="hidden" id="casenoidinvstatusupdate" name="casenoidinvstatusupdate" value="{{ $casenoid }}">
                                    <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" onclick="sendforevaluation('{{ $casenoid }}')">
                                            <span style="font:face:Product Sans">Send for Review</span>
                                    </button>
                                @endif
                        </form>
                        @include('tabs/investigationplan_tab')
                        <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" onclick="addnewhypo('{{ $casenoid }}')">
                            <span><i class="fa fa-plus"></i></span>    
                            <span style="font:face:Product Sans">Add Hypothesis</span>
                        </button>
                     @endif
                    <br><br>
                      <div class="header" style="height:40px; border-radius:5px; margin-top:10px;">&nbsp;&nbsp;<font color='#000000' size="5.2" face="Product Sans"> Hypothesis</font></div>
                      <br>
                        <table class="table t2" id="hypothesistable">
                            <tr>
                                <th class="sorting sorting_asc">Hypothesis</th>
                                <th>Evidence</th>
                                <th>Evaluation Status</th>
                                <th>Evaluated On</th>
                                <th>Action</th>
                            </tr>
                                @if($hypothesis->count())
                                @foreach ($hypothesis as $hypo)
                                    <tr>
                                        <td>{{ $hypo->hypotheses}}</td>
                                        <td>
                                           <ul>
                                                @foreach ($hypoevidence->where('hypothesis_id', $hypo->id) as $hypoevi)
                                                    <li>{{ $hypoevi->evidences }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            @if($hypo->evaluation_status == "Not Evaluated")
                                                Not Evaluated
                                            @else
                                                <?php echo $key=DB::table('tbl_assessment_types_lookup')->where('id',$hypo->evaluation_status)->value('name') ?>
                                            @endif
                                        </td>
                                        <td>
                                            @if($hypo->evaluated_on == "")
                                                NA
                                            @else
                                                {{ \Carbon\Carbon::parse($hypo->evaluated_on)->format('d/m/Y')}}
                                            @endif
                                        </td>

                                        <td>
                                            @if(Auth::user()->role == "Investigator")
                                                @if($hypo->evaluation_status == "Not Evaluated")
                                                    <i class="fa fa-pencil"  onclick="showevaluateevidence('{{ $hypo->id }}')"></i>&nbsp; &nbsp;
                                                @endif
                                                <a  href="{{ route('deletehypothesis', $hypo->id) }}" style="color:grey" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='grey';" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Are you sure you want to delete this record?') || event.preventDefault();"><i class="fa fa-trash"></i></a>&nbsp; 
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="5"> No record found </td>
                            </tr>
                            @endif
                        </table> 
                        
                                <a href="{{route('viewactionplan', $casenoid)}}" style="float:right; color:grey"><i class='fa fa-arrow-circle-right'  data-toggle="tooltip" data-placement="bottom" title="Next"></i> Next</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('viewinvestigationplan', $casenoid)}}" style="float:right; color:grey">Previous &nbsp;<i class='fa fa-arrow-circle-left'  data-toggle="tooltip" data-placement="bottom" title="Previous"></i> &nbsp;</a>&nbsp;&nbsp;&nbsp;
                                &nbsp;
                       </div>         
                </div>
            </div>
            <!-- /.card -->
    </div>
</div>


<!-- add modal -->
  <form method="POST" id="addhypoform" action="{{ route('add_hypothesis') }}" enctype="multipart/form-data">
                            @csrf
    <div class="modal fade" id="addhypothesis">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Hypothesis</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="casenoidaddhypo" id="casenoidaddhypo" value="{{ $casenoid }}">
                    <table class="table" id="addevidencetable">
                        <thead>
                        <th><font face="Product Sans" color="Grey">Hypothesis</font></th>
                        <th><font face="Product Sans" color="Grey">Evidence</font></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><br>
                                <input class="form-control" type="text" name="case_hypo" id="case_hypo" > 
                                </td>
                                <td>
                                    <table class="table no-border" >
                                        <tbody id="tablebody">
                                            <tr>
                                                <td><input type="text" name="case_evidence[]" id="case_evidence[]" class='form-control'></td>
                                                <td><i class="fa fa-plus" style="color:green" onclick="test()"></i></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </td> 
                            </tr>
                        </tbody>
                    </table>      

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    </form>

<!-- end add modal -->


<!--add modal -->
<form method = "POST" action="{{ route('updatehypothesisstatus') }}"  enctype="multipart/form-data" >
      @csrf    
<div class="modal fade" id="hypothesisevaluemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Evaluation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <input type="hidden" name="hypothesisid" id="hypothesisid" >
                       <div id="showhypodetailsdiv"></div> 
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end add modal -->
<script>
    function addnewhypo() {
        $('#addhypoform')[0].reset();
        $('#addhypothesis').modal('show');  
    }

    function test() {
        
        var html = "<tr><td><input type='text' class='form-control' name='case_evidence[]'></td><td><i class='fa fa-minus' style='color:red' onclick='remove()'></i></td></tr>";
        $('#tablebody').append(html);
    }
    
    function remove() {
        var $tableBody = $('#addevidencetable').find("tbody"),
        $trLast = $tableBody.find("tr:last"),
        $trNew = $trLast.remove();
    }

    function showevaluateevidence(id)
    {
        $('#hypothesisevaluemodal').modal('show');
        $('#hypothesisid').val(id);
    
        var url = '{{ route("showhypoevidencedetails", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#assetid').val()},
                success: function(result) {
                    
                    $("#showhypodetailsdiv").html(result);
                    $("#showhypodetailsdiv").show();
                    
                }
            });
        
    }


</script>
<style>
    .modal-header {
    background: linear-gradient(to top, #BFABA2, #ffffff);
    color: #000;
    font-family: Product Sans;
    border-radius: 5px 5px 0 0;
    }
    
.t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
}
</style>
@endsection