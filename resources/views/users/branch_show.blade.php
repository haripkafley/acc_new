@extends('layouts.admin')

@section('content')

<br>


<section class            = "content">
      <div class          = "container-fluid">
        <div class        = "row">
          <div class      = "col-12">
            <div class    = "card">
              <div class  = "card-header">
                <h3 class = "card-title">Branch</h3>
                <button type="button" style="float:right" class="btn btn-primary" onclick="addnewbranch()" name="add" data-toggle="tooltip" data-placement="bottom" title="Add New Role"><i class="fa fa-plus"></i></button>
              </div>
              <!-- /.card-header -->
              <div class  = "card-body">
                
              <table id = "example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                        <th>Sl No</th>
                        <th>Branch</th> 
                        <th>Action</th>                    
                        
                  </tr>
                  </thead>
                  <tbody>
                @foreach ($branches as $branch)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $branch->branch_name }}</td>
                    <td><a class  = "btn btn-warning" href="{{ route('deletebranch',$branch->branch_id) }}" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-minus"></i></a></td>
                </tr>
				@endforeach
            </tbody>
         </table>

                
<!-- Modal -->

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
      <!-- ADD CASE -->
<form method = "POST" action="{{ route('addbranch') }}" enctype="multipart/form-data" >
    @csrf      

    <div class="modal fade" id="modal_addbranch_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <h5 class="modal-title" >Add New Branch</h5>
                    @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Branch Name&nbsp;<font color='red'>*</font></label>
                                        <input type="text" name="branch_add"  class="form-control" id="branch_add">
                                        
                                    </div>
                                    
                                </div>
                                                               
                            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</form>

<!-- FINISH ADD CASE -->
    </section>
    <script>
      function addnewbranch()
        {
           
            $('#modal_addbranch_show').modal('show');
        }
    </script>
@endsection
