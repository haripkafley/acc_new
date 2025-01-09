@extends('layouts.app')


@section('content')
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <table class="table table-bordered">
        <tr>
            
            <th>Name</th>                     
            <th>Email</th>
            <th>Mobile</th>
            <th>Empl Id</th>
            <th>Department</th>
            <th>Branch</th>
            <th>Position</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
                <tr>
            
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->mobile }}</td>
            <td>{{ $user->employee_id }}</td>
            <td>{{ $user->department }}</td>
            <td>{{ $user->branch }}</td>
            <td>{{ $user->position }}</td>
            <td>{{ $user->status }}</td>

                </tr>
            </table>
        </div>
    </div>
@endsection