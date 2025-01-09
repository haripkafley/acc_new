@extends('layouts.admin')
@section('content') 
<br>
<div class="col-md-8 offset-md-2 mt-4">
    <div class="card">
        <br>
        <center>
            <img class="rounded-circle avatar-xl" src="{{ (!empty($adminData->profile_image))? url('upload/admin_images/'.$adminData->profile_image):url('upload/no_image.jpg') }}" alt="Card image cap">
        </center>
        <br>
    
        <div class="col-md-10 offset-md-1 mt-.66">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-invplan-tab" data-toggle="pill" href="#custom-tabs-four-invplan" role="tab" aria-controls="custom-tabs-four-invplan" aria-selected="true">My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-interviewsummon-tab" data-toggle="pill" href="#custom-tabs-four-interviewsummon" role="tab" aria-controls="custom-tabs-four-interviewsummon" aria-selected="true">Change Password</a>
                        </li>
                    
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-invrek-tab" data-toggle="pill" href="#custom-tabs-four-invrek" role="tab" aria-controls="custom-tabs-four-invrek-tab" aria-selected="true">My Task</a>
                        </li>                                                          
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-four-invplan" role="tabpanel" aria-labelledby="custom-tabs-four-invplan-tab">
                            <div class="card card-info">
                                <div class="card-header">
                                        <h3 class="card-title">Your Details</h3>
                                </div>                               
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label>Name</label>
                                            <input id="name" type="text" disabled="disabled" class="form-control" value="{{ $adminData->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label>Employee Id</label>
                                            <input id="employeeid" disabled="disabled" type="text" class="form-control" value="{{ $adminData->employee_id }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label>User Name</label>
                                            <input id="username" disabled="disabled"  type="text" class="form-control" value="{{ $adminData->username }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label>Email</label>
                                            <input id="email" disabled="disabled" type="text" class="form-control" value="{{ $adminData->email }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label>Designation</label>
                                                <input id="designation" disabled="disabled"  type="text" class="form-control" value="{{ $adminData->position }}">
                    
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
                                                <input id="department" disabled="disabled" type="text" class="form-control" value="{{ $adminData->department }}">
                    
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
                                                <input id="branch" disabled="disabled"  type="text" class="form-control" value="{{ $adminData->branch }}">
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
                                                <input id="mobile" disabled="disabled"  type="text" class="form-control" value="{{ $adminData->mobile }}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label>Role in CIMS</label>
                                                <input id="role" disabled="disabled" type="text" class="form-control" value="{{ $adminData->role }}">                             
                    
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
                                                    <div class="input-group">                          
                                                        <img src="{{ $adminData->signature }}" class="img-thumbnail" style="width: 100px; height: 100px;" />                         
                                                    </div>
                                            </div>    
                                        </div>
                                    </div>
                                    <a href="{{ route('edit.profile') }}" class="btn btn-info btn-rounded waves-effect waves-light" > Edit Profile</a>
                                </div>
                                
                            </div>
                        </div>
                        <div class="tab-pane fade show " id="custom-tabs-four-interviewsummon" role="tabpanel" aria-labelledby="custom-tabs-four-interviewsummon-tab"> 

                            @if(count($errors))
                                @foreach($errors->all() as $error)
                                <P class="alart alert alert-danger alert-dismissible fade show"> {{ $error }} </P>
                                @endforeach
                            @endif  

                            <form method="post" action="{{ route('update.password') }}" >
                                @csrf
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Old Password</label>
                                    <div class="col-sm-10">
                                        <input name="oldpassword" class="form-control" type="password"   id="oldpassword">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-10">
                                    <input name="newpassword" class="form-control" type="password"  id="newpassword">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                        <input name="confirm_password" class="form-control" type="password"   id="confirm_password">
                                    </div>
                                </div>
                                <!-- end row -->
                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Change Password">
                            </form>  
                        </div>
                        <div class="tab-pane fade show " id="custom-tabs-four-invrek" role="tabpanel" aria-labelledby="custom-tabs-four-invrek-tab">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection