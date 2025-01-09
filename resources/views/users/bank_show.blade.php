@extends('layouts.admin')

@section('content')

<br>


<section class            = "content">
      <div class          = "container-fluid">
        <div class        = "row">
          <div class      = "col-12">
            <div class    = "card">
              <div class  = "card-header">
                <h3 class = "card-title">Banks</h3>
                <button type="button" style="float:right" class="btn btn-primary" onclick="addnewbank()" name="add" data-toggle="tooltip" data-placement="bottom" title="Add New Bank"><i class="fa fa-plus"></i></button>
              </div>
              <!-- /.card-header -->
              <div class  = "card-body">
                
              <table id = "example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                        <th>Sl No</th>
                        <th>Bank</th> 
                        <th>Action</th>                    
                        
                  </tr>
                  </thead>
                  <tbody>
                @foreach ($banks as $bank)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $bank->bank }}</td>
                    <td><a class  = "btn btn-warning" href="{{ route('deletebank',$bank->b_id) }}" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-minus"></i></a></td>
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
<form method = "POST" action="{{ route('addbank') }}" enctype="multipart/form-data" >
    @csrf      

    <div class="modal fade" id="modal_addbank_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <h5 class="modal-title" >Add New Bank</h5>
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
                                        <label>Bank Name&nbsp;<font color='red'>*</font></label>
                                        <input type="text" name="bank_add"  class="form-control" id="bank_add">
                                        
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
      function addnewbank()
        {
           
            $('#modal_addbank_show').modal('show');
        }
    </script>
@endsection
