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
                @if(@$add=="Y")
                <a href="{{route('manage.person.add.view')}}" class="btn btn-primary">Add Person</a>
                @endif
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Person List </div>
                        <div class = "card-body">
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <td></td>
                                        <th>Name</th>
                                        <th>CID</th>
                                        <th>Other ID</th>
                                        <th>Nationality</th>
                                        <th>Religion</th>
                                        <th>Gender</th>                            
                                        <th>View</th> 
                                        <th>Edit</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$data->isNotEmpty())
                                       @foreach(@$data as $person)
                                       <tr>
                                           <td>
                                            @if(isset($person->userPic))
                                                <img src="{{URL::to('storage/app/public/person')}}/{{@$person->userPic}}" class="user-image" alt="" style="height:50px;width:50px">
                                            @else
                                                <img class="user-image"
                                                     src="{{asset('user.png')}}"
                                                     alt="..." style="height:50px;width:50px">
                                            @endif
                                        </td>
                                        <td>{{$person->fname}} {{$person->mname}} {{$person->lname}} </td>
                                        <td>{{$person->cid}}</td>
                                        <td>{{$person->otherIdentificationNo}}</td>
                                        <td>{{$person->nationality}}</td>
                                        <td>{{$person->religion}}</td>
                                        <td>{{$person->genderRelation->name}}</td>
                                        <td>
                                               <a href="{{route('manage.person.view.details',['id'=>@$person->personID])}}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                        </td>

                                        <td>
                                               @if(@$edit=="Y") 
                                               <a href="{{route('manage.person.edit.view',['id'=>@$person->personID])}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                               @endif
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