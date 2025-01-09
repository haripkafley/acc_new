@extends('layouts.admin')


@section('content')



<body>
  <br>
  @foreach ($users as $user)
  <div class="container-fluid">
      <div class="col-md-10 offset-md-1 mt-4">
          <div class="card card-info">
              <div class="card-header">
                      <h3 class="card-title">Your Details</h3>
              </div>
              
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-3">
                          <div class="form-group">
                          <label>Name</label>
                            <input id="name" type="text" disabled="disabled" class="form-control" value="{{ $user->name }}">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                          <label>Employee Id</label>
                            <input id="employeeid" disabled="disabled" type="text" class="form-control" value="{{ $user->employee_id }}">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                          <label>User Name</label>
                            <input id="username" disabled="disabled"  type="text" class="form-control" value="{{ $user->username }}">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                          <label>Email</label>
                            <input id="email" disabled="disabled" type="text" class="form-control" value="{{ $user->email }}">
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                        <label>Designation</label>
                            <input id="designation" disabled="disabled"  type="text" class="form-control" value="{{ $user->position }}">

                            @error('position')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <label>Department</label>
                            <input id="department" disabled="disabled" type="text" class="form-control" value="{{ $user->department }}">

                            @error('department')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <label>Branch</label>
                            <input id="branch" disabled="disabled"  type="text" class="form-control" value="{{ $user->branch }}">
                            @error('branch')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                        <label>Mobile No</label>
                            <input id="mobile" disabled="disabled"  type="text" class="form-control" value="{{ $user->mobile }}">
                        </div>
                    </div>
                </div>
                    
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                        <label>Role in CIMS</label>
                            <input id="role" disabled="disabled" type="text" class="form-control" value="{{ $user->role }}">                             

                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                        <label>Signature</label>
                        @foreach($signature_img as $sign)
                            <div class="input-group">                          
                                <img src="{{asset($sign->path)}}" class="img-thumbnail" style="width: 100px; height: 100px;" />                         
                            </div>
                            @endforeach
                    </div>
                    
                </div>

                    
            </div>
              </div>
              
          </div>
      </div>
  </div>
  @endforeach
  <form method="POST" action="{{ route('change.password') }}">
                        @csrf 
  <div class="container-fluid">
      <div class="col-md-10 offset-md-1 mt-4">
          <div class="card card-info">
              <div class="card-header">
                      <h3 class="card-title">Change Password</h3>
              </div>
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                          <label>Old Password</label>
                          <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                          <label>New Password</label>
                          <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                          </div>
                      </div>        
                      <div class="col-md-4">
                          <div class="form-group">
                          <label>Confirm Password</label>
                          <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                          </div>
                      </div>
                      
                  </div>
                  
                    
                </div>

                <div class="card-footer ">
                  <button type="submit" class="btn btn-info" >Update</button>                
              </div>
            </div>
              </div>
             
          </div>
      </div>
  </div>
  </form>
</body>
@endsection