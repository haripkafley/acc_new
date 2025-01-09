@extends('layouts.admin')

@section('content')
<br>
                                    @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
<section class            = "content">

      <div class          = "container-fluid">
        <div class        = "row">
          <div class      = "col-12">
            <div class    = "card">
              <div class  = "card-header">
                <h3 class = "card-title">User Registration Request</h3>
              </div>
              <!-- /.card-header -->
              <div class  = "card-body">
                <form method="POST" action="{{route('users.approve') }}" enctype="multipart/form-data" >
                @csrf
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
                        <th>Expected Role</th>
                        <th>Role</th>
                        <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($users as $user)
                   <tr>
                   <td>{{ ++$i }}</td>
                    <td><input type="hidden" value="{{ $user->name }}" id="name" name="name">{{ $user->name }}</td>
                    <td><input type="hidden" value="{{ $user->email }}" id="email" name="email">{{ $user->email }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>{{ $user->employee_id }}</td>
                    <td>{{ $user->department }}</td>
                    <td>{{ $user->branch }}</td>
                    <td>{{ $user->position }}</td>
                    <td>{{ $user->expected_role }}</td>
                    <td> 
                          <select class="form-control" name="role" id="role">
                              <option>Select Role</option>
                                    @foreach ($roles as $role)
                                      <option value="{{ $role->role_name }}">{{ $role->role_name }}</option>
                                    @endforeach    
                          </select>
                    </td>
                    <td>
                        <div class = "btn-group flex-wrap">
                              <button class  = "btn btn-info" type="submit" name="approve" data-toggle="tooltip" data-placement="bottom" title="Accept"><i class="fa fa-check"></i></button>
                              <button class  = "btn btn-danger" type="submit" name="reject"  data-toggle="tooltip" data-placement="bottom" title="Reject"><i class="fa fa-times"></i></button> 
                        </div>
                    </td>
                    
                    
                  </tr>
                  @endforeach
                  
                  
                  
                  
                  </tbody>
                  
                </table>
                </form>

                
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
