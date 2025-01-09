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
                                Complaints Evaluation Decisions
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              @if(@$add=="Y")
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModaevalCompDecision">
                                    Add
                                </button>
                                @endif
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Decision</th>
                                        <th>Remarks</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->compEvaDecisionID}}</td>
                                        <td>{{ $att->compEvaDecisionName }}</td>
                                        <td>{{ $att->compEvaDecisionRemarks }}</td>
                                        
                                        <td>
                                                      
                                                            
                                                        @if(@$edit=="Y")
                                                        <a type="button"
                                                        class="btn btn-xs btn-primary row-class-{{ @$att->compEvaDecisionID }}"
                                                        data-row-data='{{ @$att->compEvaDecisionName }}' data-toggle="modal"
                                                        onclick="openEditModalEditCompEvalDecision({{ @$att->compEvaDecisionID }},`{{ @$att->compEvaDecisionRemarks }}`)">
                                                        Edit
                                                    </a>
                                                    @endif


                                                    @if(@$delete=="Y")
                                                            <a class="btn btn-xs btn-danger" href="{{route('complaint-evaluation-decision.delete',['id'=>$att->compEvaDecisionID])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
                                                            </a>
                                                   @endif
                                                            
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


        <!-- Modal -->
<div class="modal fade" id="exampleModaevalCompDecision" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ADD New Complaints Evaluation Decision</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('complain-evaluation-decision.store')}}">@csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Decision</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="compEvaDecisionName" aria-describedby="emailHelp" placeholder="Complaints Evaluation Decision">
                 </div>
                
                 <div class="form-group">
                  <label for="exampleInputEmail1">Remarks</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="compEvaDecisionRemarks" aria-describedby="emailHelp" placeholder="Remarks">
                 </div>

                 
        
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>


<!--Edit Modal -->
            <div class="modal fade" id="exampleModaEditCompEvalDec" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Complaints Evaluation Decision</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('compevaldec.edit.update')}}">@csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Decision</label>
                                    <input type="text" class="form-control" id="compEvaDecisionName" name="compEvaDecisionName" aria-describedby="emailHelp" placeholder="Complaints Evaluation Decision">
                                   </div>
                                  
                                   <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <input type="text" class="form-control" id="compEvaDecisionRemarks" name="compEvaDecisionRemarks" aria-describedby="emailHelp" placeholder="Remarks">
                                   </div>
                                 
                             <input type="hidden" name="id" id="id">
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
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
    // $(function() {
    //     $("#maintableDz").dataTable();
    // });

    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],
    });
});

function openEditModalEditCompEvalDecision(id, remark) {
    console.log(7777);
    console.log(id);
    console.log(remark);
    let data = $(`.row-class-${id}`).attr('data-row-data');
    console.log(data);
    $('#exampleModaEditCompEvalDec').modal('show')
    document.getElementById("compEvaDecisionName").value = data;
    document.getElementById("id").value = id;
    document.getElementById("compEvaDecisionRemarks").value = remark;

}
</script>



@endsection