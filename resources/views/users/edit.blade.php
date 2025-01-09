@extends('layouts.admin')

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1></h1>
          </div>
         
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <br><br>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('users.update',$user->id) }}" method="POST">
        @csrf
        @method('PUT')
   
        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <table class="table table-bordered">
           
            <tr>
            
            <th>Name</th>   <td><input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Name"></td>
            <th>Branch</th><td><input type="text" name="branch" value="{{ $user->branch }}" class="form-control" placeholder="Branch"></td>
           </tr>
           <tr>                  
               <th>Email</th><td><input type="text" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email"></td>
               <th>Position</th><td><input type="text" name="position" value="{{ $user->position }}" class="form-control" placeholder="Position"></td>
               </tr>
               <tr>
                <th>Mobile</th><td><input type="text" name="mobile" value="{{ $user->mobile }}" class="form-control" placeholder="Mobile"></td>
                <th>Expected Role</th><td><input type="text" name="expected_role" value="{{ $user->expected_role }}" class="form-control" placeholder="Expected Role"></td>
            <tr>
                <th>Empl Id</th><td><input type="text" name="employee_id" value="{{ $user->employee_id }}" class="form-control" placeholder="Employee Id"></td>
                <th>Status</th><td><input type="text" name="isActive" value="{{ $user->isActive }}" class="form-control" placeholder="Status"></td>    
            </tr>
                <tr>
                <th>Department</th><td>
                <select name="department" id="department"  class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" selected="{{ $user->department }}">
                                  <option value="">--Please choose department--</option>
                                  <option value="Commission1">Commission</option>
                                  <option value="Department of Investigation">Department of Investigation</option>
                                  <option value="Department of Preventation and Education">Department of Preventation and Education</option>
                                  <option value="Department of Professioinal Support">Department of Professioinal Support</option>
                                </select>     
                <!-- <input type="text" name="department" value="{{ $user->department }}" class="form-control" placeholder="Name"></td> -->
                </tr>
                
            </table>
        </div>
    </div>
   
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-info">Submit</button>
            </div>
        </div>
   
    </form>
    </section>
@endsection