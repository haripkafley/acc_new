@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

                    <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Suspect List </div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>CID</th>
                                        <th>CID Attachment</th>
                                        <th>Name / DOB</th>
                                        <th>Parmanent Address</th>
                                        <th>Present Address</th>
                                        <th>Contact</th>
                                        <th>Attachment</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{@$att->cid}}</td>
                                        <td><a class="btn btn-xs btn-warning" href="{{URL::to('attachment/ti')}}/{{$att->cid_photo}}" target="_blank"><i class="fa fa-eye"></i>View 
                                        </a></td>
                                        <td>{{ $att->name }} / {{@$att->dob}}</td>
                                        <td>{{ $att->dzonkhag }} / {{ $att->gewog }} / {{ $att->village }}</td>
                                        <td>{{ $att->presnet_address }}</td>
                                        <td>{{ $att->contact }}</td>
                                        <td><a class="btn btn-xs btn-warning" href="{{URL::to('attachment/ti')}}/{{$att->attachment}}" target="_blank"><i class="fa fa-eye"></i>View 
                                        </a></td>
                                        <td>
                                                        
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('tacktical.inteligence.autorization.delete.suspect',['id'=>@$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
                                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Suspect Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>




<form method="post" action="{{route('tacktical.inteligence.autorization.add.suspect.insert.suspect')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="ti_id" value="{{@$id}}">
            <div class="row">
                

                <div class="clearfix"> </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>CID<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="cid" class="form-control" required>
                    </div>
                </div>


                <div class="col-sm-6 cid_div">
                    <div class="form-group">
                        <label>CID Attachment</label>
                            <input type="file" name="cid_photo" class="form-control">
                    </div>
                </div>

                


                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Name<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="name" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>DOB<span style="font-weight: bold; color: red;"></span></label>
                            <input type="date" name="dob" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Dzongkhag<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="dzonkhag" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Gewog<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="gewog" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Village<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="village" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Present Address<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="presnet_address" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Contact No<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="contact" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Attachment</label>
                            <input type="file" name="attachment" class="form-control" required>
                    </div>
                </div>


                


                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
            </div>
        </form>
    </div>
</section>

<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>




@endsection
