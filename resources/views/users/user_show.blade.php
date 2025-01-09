@extends('layouts.admin')

@section('content')

<br>



<section class            = "content">
      <div class          = "container-fluid">
        <div class        = "row">
          <div class      = "col-12">
            <div class    = "card">
              <div class  = "card-header">
                <h3 class = "card-title">All Users</h3>
              </div>
              <!-- /.card-header -->
              <div class  = "card-body">
                <table id = "example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                        <th>No</th>
                        <th>Name</th>                     
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Empl Id</th>
                        <th>Department</th>
                        <th>Branch</th>
                        <th>Position</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Active Status</th>
                  </tr>
                  </thead>
                  <tbody>
                @foreach ($uu as $user)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>{{ $user->employee_id }}</td>
                    <td>{{ $user->department }}</td>
                    <td>{{ $user->branch }}</td>
                    <td>{{ $user->position }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->accept_status }}</td>
                    @if ($user->status==1)
                    <td>Active</td>
                    @elseif($user->status==0)
                    <td>In Active</td>
                    @endif
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
    </section>
@endsection
