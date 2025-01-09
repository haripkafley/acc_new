@extends('layouts.admin')

@section('content')
<link
rel="stylesheet"
type="text/css"
href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"
/>

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">

                      

                    

                </div>
               @if(@$add=="Y") 
               <div class="col-md-6"> <a href="{{route('manage.user.add')}}" style="float: right;" class="btn btn-primary">+ Add User</a> </div>
               @endif
                </div>
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> User List </div>
                        <div class = "card-body">
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>CID</th>
                                        <th>EID</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        {{-- <th>Department</th> --}}
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$data->isNotEmpty())
                                       @foreach(@$data as $value)
                                       <tr>
                                           <td>{{@$value->name}}</td>
                                           <td>{{@$value->cid}}</td>
                                           <td>{{@$value->eid}}</td>
                                           <td>{{@$value->email}}</td>
                                           <td>{{@$value->mobile}}</td>
                                           {{-- <td>{{@$value->department}}</td> --}}
                                           
                                           <td>
                                              @if(@$edit=="Y") 
                                               <a href="{{route('manage.user.edit',['id'=>@$value->id])}}" class="btn btn-info"><i
                                                            class="fa fa-edit"></i></a>
                                              @endif
                                               <a href="{{route('manage.user.delete',['id'=>@$value->id])}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"><i
                                                            class="fa fa-trash"></i></a>
                                               <a href="{{route('manage.user.assign.role',['id'=>@$value->id])}}" class="btn btn-warning"><i
                                                            class="fa fa-users"></i></a>
                                           </td>

                                       </tr>
                                       @endforeach
                                       @endif            
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>
<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
$(function() {
$("#maintable").dataTable();
});
</script>
@endsection